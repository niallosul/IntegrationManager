<?php

session_start();
  require_once "src/Google_Client.php";
  require_once "src/contrib/Google_TasksService.php";
  require_once "src/contrib/Google_Oauth2Service.php";
  
$client = new Google_Client();

$client->setClientId('1054206380730.apps.googleusercontent.com');
$client->setClientSecret('pxsqpQXfENCQAqmvAw4IJa63');
$client->setRedirectUri('http://localhost/weblamp442/IntMgr/google/googleapitest.php');
$client->setApplicationName("Integration Manager");

$tasksService = new Google_TasksService($client);
$oauth2 = new Google_Oauth2Service($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->setAccessToken($client->authenticate($_GET['code']));
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
  return;
}

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

if ($client->getAccessToken()) {
  $user = $oauth2->userinfo->get();
  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
  $name = $user['name'];
  $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
  print "<div><span>$name</span><span><img src='$img?sz=50'></span></div>";
  print "<a class='logout' href='?logout'>Logout</a>";
  
  $lists = $tasksService->tasklists->listTasklists();
  } 
else {
  $authUrl = $client->createAuthUrl();
  var_dump($authUrl);
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
/*
 $accessToken = json_decode($client->getAccessToken());

 $url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$accessToken->access_token;
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 $userdets = json_decode($result);
 echo ($result);
 print ($userdets->name);
*/



?>

<!doctype html>
<html>
<head>
  <title>Integration Manager Task List</title>
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Droid+Serif|Droid+Sans:regular,bold' />
  <link rel='stylesheet' href='css/style.css' />
</head>
<body>
<div id='container'>
  <div id='top'><h1>Tasks by Event</h1></div>
  <div id='main'>

<?php
  if ($lists) {
  foreach ($lists['items'] as $list) {
    print "<h3>{$list['title']}</h3>";
    $tasks = $tasksService->tasks->listTasks($list['id']);
    foreach ($tasks['items'] as $task) {
       print "<span class={$task['status']}><h4>{$task['title']}</h4></span>";
    }//var_dump ($tasks);
  }
  }

/*  
  $tasklist = new Google_TaskList();
  $tasklist->setTitle('New Test Task List');
  $result = $tasksService->tasklists->insert($tasklist);
  //echo $result->getTitle();
*/

?>


  </div>
</div>
</body>
</html>