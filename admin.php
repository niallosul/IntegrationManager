<?php
namespace IntMgr;
require 'Vendors/autoload.php';

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

print"<table><th><td><h2>Users</h2></td></th>";
foreach ($userlist as $dbuser) {
  $client->setAccessToken($dbuser->token);
  $userinfo = $oauth2->userinfo->get();
  print "<tr>";
  print "<td><img src='{$userinfo['picture']}' style='height:40px;width:40px'></td>";
  print "<td><span style='vertical-align:middle; font-size:2em; color:grey'>{$userinfo['name']}</span></td>";
  print "</tr>";
  
  /*
  $lists = $tasksService->tasklists->listTasklists();
  foreach ($lists['items'] as $list) {
    print "<h3>{$list['title']}</h3>";
    $tasks = $tasksService->tasks->listTasks($list['id']);
    foreach ($tasks['items'] as $task) {
       print "<span class={$task['status']}><h4>{$task['title']}</h4></span>";
    }
  }
  */
 }
print"</table>"; 
 /*  
  $tasklist = new Google_TaskList();
  $tasklist->setTitle('New Test Task List');
  $result = $tasksService->tasklists->insert($tasklist);
  //echo $result->getTitle();
 */

?>
