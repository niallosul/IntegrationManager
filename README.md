IntegrationManager
==================

Web application to manage staffing and task lists for Integration Projects

Problem: Current tool is targeted towards long term (2+ year) projects and does not easily lend itself to staffing and managing multiple smaller projects at once.  

Solution: Developed a lightweight tool (Integration Manager) that allows managers to easily staff projects and assign tasks.  Team members can now see all their projects in one place, and each task is added to their Google task list

Implementation: 
	- Set up a database and php Database Access Objects to represent each piece of the tool (Team Member, project, etc)
	- Added integration with Google's API for Registration/Sign in and task management (https://developers.google.com/google-apps/tasks/)
	- Added a front end for managers (admin.php) built on top of each DAO
	- Added an API (api/index.php) also built on top of the DAOs
	- Added a front end for users (index.html) built entirely in html, javascript and css that consumes the API
	
Next Steps
	- Add issues management widget
	- Enhance Admin tool and Project object
	
	