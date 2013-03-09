<?php
namespace IntMgr;
require '../Vendors/autoload.php';

//Initialize Google Client  
$client = new googleConn();

//Register APIs to Consume
$tasksService = new \Google_TasksService($client);
$oauth2 = new \Google_Oauth2Service($client);

//Setup local DB instance
$intmgrdb = new IntMgrConn();

//Register local DAOs 
$userDAO = new memberDAO($intmgrdb);
        
$userlist = $userDAO->getall();

foreach ($userlist as $dbuser) {
  $client->setAccessToken($dbuser->token);
  echo (json_encode($oauth2->userinfo->get())); 
  $lists = $tasksService->tasklists->listTasklists();
  foreach ($lists['items'] as $list) {
    print "<h3>{$list['title']}</h3>";
    $tasks = $tasksService->tasks->listTasks($list['id']);
    foreach ($tasks['items'] as $task) {
       print "<span class={$task['status']}><h4>{$task['title']}</h4></span>";
    }
  }
 }
 
 /*  
  $tasklist = new Google_TaskList();
  $tasklist->setTitle('New Test Task List');
  $result = $tasksService->tasklists->insert($tasklist);
  //echo $result->getTitle();
 */

?>
