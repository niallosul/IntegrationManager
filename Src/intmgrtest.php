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
//$projDAO = new projectDAO($intmgrdb);
        
        
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
  $_SESSION['userid'] = $user['id'];
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
  
  $redirect = 'http://localhost/weblamp442/IntMgr';
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
  return;
}
else {
   $client->authenticate();
}
