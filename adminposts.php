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
$projDAO = new projectDAO($intmgrdb);
        
$userlist = $userDAO->getall();
$projlist = $projDAO->getall();

if (isset ($_POST['projname']) AND isset ($_POST['projmnem'])) {
    $projDAO->add($_POST['projmnem'], $_POST['projname']);
    unset($_POST);
    header('Location: admin.php');
}  
  

if (isset ($_POST['memid']) AND isset ($_POST['projid'])) {
    $projDAO->addmember($_POST['projid'], $_POST['memid']);
    unset($_POST);
    header('Location: admin.php');
}    


if (isset ($_POST['memid']) AND isset ($_POST['task'])) {
    echo ($_POST['memid']);
    $dbuser = new member();
    $dbuser = $userDAO->get($_POST['memid']);
    $client->setAccessToken($dbuser->gettoken());   
    $tasklist = new \Google_TaskList();
    $tasklist->setTitle($_POST['task']);
    $result = $tasksService->tasklists->insert($tasklist);

    unset($_POST);
    header('Location: admin.php');

}    

  
?>  
