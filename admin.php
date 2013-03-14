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

//var_dump($userlist);
//var_dump($projlist);
  
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
  
?>  
<html>
<head>
  <title>Integration Manager Admin Page</title>
  <link rel="stylesheet" type="text/css" href="http://sulincdesign.com/ocm/css/ui-lightness.css"/>
  <link rel="stylesheet" type="text/css" href="css/cim.css"/>

</head>
<body>

<div id='header' class="ui-widget-header" style='overflow:auto;'>
	<div id='headerleft' style="width:50%; float:left; margin-left:10px">
			<h1 style="display:inline-block;vertical-align:middle">Integration Manager Admin Tool</h1>
	</div>
</div>

<div id='userscreen' style='height:80%; width:99%'>		
  <div id="left" style='height:100%; width:40%; float:left;'>

   <div id='tools' class='toolholder ui-corner-all'>
     <h2>Database Tools</h2>
     <div style='height:450px; overflow:auto;'>
     <form class="bigform" action="adminposts.php" method="post">
       <p>Add New Project</p>
       <label>Project Mnemonic:</label>
       <input type="text" name="projmnem" maxlength="25" />
       <br/>
       <label>Project Name:</label>
       <input type="text" name="projname" maxlength="25" />
       <br/>
      <button type="submit">Add Project</button>
     </form>

     <form class="bigform" action="adminposts.php" method="post">
       <p>Add New Team Member</p>
       <label>Project Id:</label>
       <input type="text" name="projid" />
       <br/>
       <label>Member Id:</label>
       <input type="text" name="memid"  />
       <br/>
      <button type="submit">Add Member</button>
     </form>
     
     <form class="bigform" action="adminposts.php" method="post">
       <p>Assign Task to Member</p>
       <label>Member Id:</label>
       <input type="text" name="memid" />
       <br/>
       <label>Task:</label>
       <input type="text" name="task"  />
       <br/>
      <button type="submit">Assign Task</button>
     </form>
     
     </div>
    </div>  

  </div>
  
  <div id='right' style='height:100%; width:55%; float:right'>
    <div id='top' style='height:50%; width:90%;margin:auto'>

       <div id='users' class='smallholder ui-corner-all'>
        <div><h2>User List:</h2></div>
        <div style='height:190px; overflow:auto;'>
        <?php
        foreach ($userlist as $dbuser) {
         $userdisp = $dbuser->first_name." ". $dbuser->last_name;
         print "<div class='ui-state-default ui-corner-all tasklink'>";
         print "<span><img src='{$dbuser->img}' style='height:30px;width:30px'></span>";
         print "<span style = 'font-size:1.75em; color:grey; margin-left:15px '>{$userdisp}</span>";
         print "<span style = 'font-size:.75em; margin-left:15px '>{$dbuser->id}</span>";
         print "</div>";
        }
        ?>
        </div>   
      </div>	

  
    </div>   

    <div id='bottom' style='height:50%; width:90%;margin:auto'>


    <div id='projects' class='smallholder ui-corner-all'>
        <div><h2>Project List:</h2></div>
        <div style='height:190px; overflow:auto;'>
        <?php
	     foreach ($projlist as $project) {
          $projdisp = $project->id." ".$project->mnemonic." - ". $project->name;
	      print "<div class='ui-state-default ui-corner-all tasklink'>";
	      print "<span style = 'font-size:1.25em;'>{$projdisp}</span>";
	      print "</div>";
        }
       ?>
      </div>   
     </div>
	
    </div>   
</div>	

</body>

</html>