<?php
require '../Vendors/autoload.php';

session_start();

$app = new \Slim\Slim();

//Initialize Google Client  
$client = new \IntMgr\googleConn();
$client->setRedirectUri('http://localhost/weblamp442/IntMgr/api/storeToken');

//Register APIs to Consume
$tasksService = new \Google_TasksService($client);
$oauth2 = new \Google_Oauth2Service($client);

//Setup local DB instance
$intmgrdb = new \IntMgr\IntMgrConn();

//Register local DAOs 
$userDAO = new \IntMgr\memberDAO($intmgrdb);
$projDAO = new \IntMgr\projectDAO($intmgrdb);

$app->get('/session/:val', function ($val) {
	   echo($_SESSION[$val]); 
});

// Get All Users from local db
$app->get('/users', function () use($userDAO) {
  echo (json_encode($userDAO->getall()));      
});

// Get Specific User from local db 
$app->get('/users/:id', function ($id) use($userDAO){
    $mem = new \IntMgr\member;
    $mem = $userDAO->get($id);
    echo (json_encode($mem->getinfo())); 
});

// Get Specific Users Project List from local db 
$app->get('/userprojects/:id', function ($id) use($projDAO){
    $memlist = $projDAO->getbymember($id);
    echo (json_encode($memlist)); 
});

// Display the currently logged in user
$app->get('/user', function () use($client, $oauth2, $app){
   if (isset($_SESSION['token'])) {
	   $client->setAccessToken($_SESSION['token']);
	   echo (json_encode($oauth2->userinfo->get())); 
   }
   else {
   		//Authenticate this user
   		$_SESSION['state'] = "/user";
   	    $authUrl = $client->createAuthUrl();
        $app->redirect($authUrl);  
   }
});

// Get Tasks for Currently logged in User
$app->get('/tasks', function () use($client, $tasksService, $app){
   if (isset($_SESSION['token'])) {
	   $client->setAccessToken($_SESSION['token']);
	   echo (json_encode($tasksService->tasklists->listTasklists())); 
   }
   else {
   		//Authenticate this user
   		$_SESSION['state'] = "/tasks";
   	    $authUrl = $client->createAuthUrl();
        $app->redirect($authUrl);  
   }
});

// Store Token for logged in User
$app->get('/storeToken', function () use ($client, $app){
    $client->authenticate($app->request()->params('code'));  
    $_SESSION['token'] = $client->getAccessToken();
    $req = $app->request();
	$rootUri = $req->getRootUri();
    $app->redirect($rootUri.$_SESSION['state']);
});

// Add new task for logged in User
$app->post('/task', function () use ($app){
  echo ("This is where we post a new task");
  /*
  $bodyobj = json_decode ($app->request()->getBody());
  echo ($bodyobj->blob);
  $tasklist = new Google_TaskList();
  $tasklist->setTitle('New Test Task List');
  $result = $tasksService->tasklists->insert($tasklist);
  */
});

// PUT route
$app->put('/put', function () {
    echo 'This is a PUT route';
});

// DELETE route
$app->delete('/delete', function () {
    echo 'This is a DELETE route';
});

$app->run();
