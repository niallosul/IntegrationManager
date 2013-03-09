<?php
namespace IntMgr;
require '../Vendors/autoload.php';

session_start();

//Initialize Google Client  
$client = new googleConn();

//Register APIs to Consume
$tasksService = new \Google_TasksService($client);
$oauth2 = new \Google_Oauth2Service($client);

//Set up local DB instance
$intmgrdb = new IntMgrConn();
$userDAO = new memberDAO($intmgrdb);
        
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  //$client->revokeToken();
}

//Check if this is the reply from Google with the auth code
//If so, exchange it for a user token
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  $user = $oauth2->userinfo->get();
  $locuser = $userDAO->get($user['id']);
  
  if ($locuser->getid() != NULL) {
    //User has authenticated previously, but token was revoked - update the token 
    $locuser->settoken($client->getAccessToken());
    $userDAO->updtToken($locuser);
  }
  else{
     //This is the first time we've seen this user - add them to the db
     $newMember = new member(); 
     $newMember->setid($user['id']);
     $newMember->setlastname($user['family_name']);
     $newMember->setfirstname($user['given_name']);
     $newMember->settoken($client->getAccessToken());

     $userDAO->add($newMember);
   }   
  
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
  return;
}

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $user = $oauth2->userinfo->get();
  $locuser = $userDAO->get($user['id']);
  
  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
  $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
  $personMarkup = "$email<div><img src='$img?sz=50'></div>";

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
  } 
else {
  $authUrl = $client->createAuthUrl();
}

?>
<!doctype html>
<html>
<head><meta charset="utf-8"></head>
<body>
<header><h1>Integration Manager User Application</h1></header>
<?php if(isset($personMarkup)): ?>
<?php print $personMarkup ?>
<?php endif ?>
<?php
  if(isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
  } else {
   print "<a class='logout' href='?logout'>Logout</a>";
  }
?>
</body></html>