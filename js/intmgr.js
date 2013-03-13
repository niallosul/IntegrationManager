//-------------------------------------------------
$(document).ready(function() {
	$("#dialog:ui-dialog").dialog( "destroy" );
	$.ajaxSetup ({cache: false});

		
	$.get("http://localhost/weblamp442/IntMgr/api/session/userid",
		function(data){
		if (data) {
			loginuser (data);
		}	
		else {
			showLoginPage();
		}
	});

	//------------------- Add Project Dialog -------------------------
	$( "#dialog-proj" ).dialog({
		autoOpen: false,
		height: 400,
		width: 650,
		modal: true
		});
	//----------------------------------------------------------------

});
//-----------------------------------------------------------


//-----------------------------------------------------------
function logoutuser() {
	$.get("http://sulincdesign.com/cim/ws/endsession.php");
	alert ("You're Logged Out");
	showLoginPage();
	$("#admindiv").hide();
}
//-----------------------------------------------------------


//-----------------------------------------------------------
function showLoginPage() {
	$("#userscreen").hide();
	$('#userheaderright').hide();
	
	$("#loginscreen").show();
    $('#loginheaderright').show();
}
//-----------------------------------------------------------




//-----------------------------------------------------------
function loginuser(memid){
	$('#loginscreen').hide();
	$('#loginheaderright').hide();
	
	$('#userscreen').show();
	$('#userheaderright').show();

	displayUserInfo();
	displayTasks();
	displayProjects(memid);

}
//-----------------------------------------------------------
	

//-----------------------------------------------------------
function displayUserInfo(){
    var userHTML = "";
	$.get("http://localhost/weblamp442/IntMgr/api/user",
	function(data){
		console.log (data);
		imglink = "imgs/silhouette96.png"
		$('#membername').html(data.name);
		if (data.picture) {
		  imglink = data.picture;
		}
		$('#memberimg').html('<img style="vertical-align:middle; padding:.6em; height:30px; width:30px" src="'+imglink+'"/>');
	},"json");
}
//-----------------------------------------------------------


//-----------------------------------------------------------
function displayTasks(){
	//alert ("In the displayTasks function ");
	var taskListHTML = $('<div></div>');
	$.get("http://localhost/weblamp442/IntMgr/api/tasks",
    function(data){
       console.log (data);
       for (i=0; i<data.items.length; i++) {
          taskListHTML.append($('<div class="ui-state-default ui-corner-all tasklink"></div>')
								.data('taskDets',data.items[i])
								.append('<span class="ui-icon ui-icon-newwin" style="margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;"></span>')
								.append('<span>'+data.items[i].title+'</span>'));
       }
       $('#taskList').html(taskListHTML);
   }, "json");
   //taskListHTML.on('click', '.tasklink', displayTask);	
}
//-----------------------------------------------------------

//-----------------------------------------------------------
function displayProjects(memid){
	//alert ("In the displayTasks function ");
	var projListHTML = $('<div></div>');
	$.get("http://localhost/weblamp442/IntMgr/api/userprojects/"+memid,
    function(data){
       console.log (data);
       for (i=0; i<data.length; i++) {
          projListHTML.append($('<div class="ui-state-default ui-corner-all tasklink"></div>')
								.data('projId',data[i].projectid)
								.append('<span class="ui-icon ui-icon-newwin" style="margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;"></span>')
								.append('<span>'+data[i].name+'</span>'));
       }
       $('#projList').html(projListHTML);
   }, "json");
   projListHTML.on('click', '.tasklink', displayProjDetails);	
}
//-----------------------------------------------------------


//-----------------------------------------------------------
function displayProjDetails(){
	console.log ($(this).data('projId'));

	$('#dialog-proj').dialog('option', 'title', 'View/Modify Project');
	$('#dialog-proj').dialog( "open" );
/*
	$.get("http://sulincdesign.com/cim/ws/getProjDetails.php?projid="+projID,
   function(data){
	//alert ("Inside Display Issue Function - "+data);
	$(data).find("ROW0").each(function() {
		$(this).children().each (function() {
			$('#'+this.nodeName).val($(this).text());
		});
		$(this).find("ROW1").each(function() {
		    $('#'+$(this).find("role").text()).val($(this).find("member_id").text());	
		});
	});
   }, "xml");
*/
}
//-----------------------------------------------------------
