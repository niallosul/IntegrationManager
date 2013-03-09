function createProjectList( dataModel) {

	//***********Initialize Project Viewer***************
	var div$ = dataModel.divId
	
	var leftDiv = $('<div></div>').addClass('contactleft')
	var rightDiv = $('<div></div>').addClass('contactright')
	
	leftDiv.append($('<h3></h3>').text('Search:'))
		.append($('<input></input>').addClass('contactsearch'))
		.append($('<div></div>').addClass('contactlist'))
		.append($('<button></button>').addClass('newContact').text('New Project'))
	
	rightDiv.append($('<h3></h3>').text('Project Details:'))
		.append($('<div><div>').addClass('disparea')
				.append($('<input></input>').addClass('dispname lndisp'))
				.append($('<br/>'))
				.append($('<input></input>').addClass('fndisp')))
		.append($('<div><div>').addClass('interfacearea')
			.append($('<h3></h3>').text('Project Milestones:')))	
		.append($('<div><div>').addClass('contactbuttons')
			.append ($('<button></button>').addClass('editContact').text('Edit'))
			.append ($('<button></button>').addClass('delContact').text('Delete'))
			.append ($('<button></button>').addClass('saveContact').text('Save'))
			.append ($('<button></button>').addClass('addContact').text('Add')))

	rightDiv.find('*').attr('disabled','disabled')
					
	div$.append($('<h2></h2>').text(dataModel.title))
		.append(leftDiv)
		.append(rightDiv)
		//.addClass('contactsbox')
	//******************************************************
	

	
	//************** Attach Event Handlers ****************
	div$.find('.contactsearch').on ('keyup',function() {
	    var searString = this.value.toUpperCase();
		div$.find('.contactlist li').each(function(){
		   if ($(this).text().toUpperCase().indexOf( searString)<0) {
			 $(this).hide();
			}
			else {
			 $(this).show();
		   }
		  });
	});
	
	div$.on('dataModelChanged',function() { 
		updateContactList( dataModel, div$.find('.contactlist'))
	});
	
	leftDiv.on('click','li',function() { 
	    leftDiv.find('.activecontact').removeClass('activecontact')
		var contactId = $(this).data('id')
		var contactDets = dataModel.getContactDetails(contactId)
		showProject(contactId, contactDets, rightDiv)
		$(this).addClass('activecontact')
		
	});
	
	leftDiv.on('click','.newContact',function() { 
		rightDiv.find('input').val('');
		rightDiv.find('*').attr('disabled','disabled')
		rightDiv.find('input').removeAttr('disabled');
		rightDiv.find('.addContact').removeAttr('disabled')
	});
	
	rightDiv.on('click','.delContact',function() { 
	    //could use index to select next list item after the delete
		var curelmidx = leftDiv.find('.activecontact').index()
		dataModel.deleteContact($(this).data('id'))
		rightDiv.find('input').val('')
		rightDiv.find('*').attr('disabled','disabled')
	});

	rightDiv.on('click','.editContact',function() {
		rightDiv.find('input').removeAttr('disabled');
		rightDiv.find('button').attr('disabled','disabled')
		rightDiv.find('.saveContact').removeAttr('disabled')
	});
	
	rightDiv.on('click','.addContact',function() {
		var newId = dataModel.addContact(new Contact( div$.find('.fndisp').val(), div$.find('.lndisp').val(), div$.find('.ctemail').val(), defaultifacelist))
		leftDiv.find('.contactlist').scrollTop(leftDiv.find('.contactlist')[0].scrollHeight);
		leftDiv.find('.contactlist li').last().trigger('click');
		
	});
		
	rightDiv.on('click','.saveContact',function() {
		var curelmidx = leftDiv.find('.activecontact').index()
		var updtContact = new Contact( div$.find('.fndisp').val(), div$.find('.lndisp').val(), div$.find('.ctemail').val() )
		dataModel.updateContact($(this).data('id'),updtContact)
		leftDiv.find('li').eq(curelmidx).trigger('click')
	});
	//***************************************************
	
	
	//*************Load and Display Contacts***************
	updateContactList( dataModel, div$.find('.contactlist'))
	
	//Programmatically click the first element in the list
	leftDiv.find('.contactlist').find('li:eq(0)').trigger('click');
	//*****************************************************
	
}

//****************************************************
function updateContactList( dataModel, list$){
	var contactlist = dataModel.getAllNames()
	
	list$.html('');
 	for (var i=0;i<contactlist.length;i++){
	  if (contactlist[i] !== undefined) {
	    $('<li></li>').append(contactlist[i]).appendTo(list$).data('id',i)
	  }
	}
}
//****************************************************



//****************************************************
function showProject(id, project, location){
	var inthtml=($('<table></table>')
					.append($('<tr></tr>')
	    				.append($('<th></th>').append('Interface')) 
	    				.append($('<th></th>').append('Vendor'))
	    			));
	pointArr = project.ipointList.getAll();	  
	for (var i=0;i<pointArr.length;i++){
		var idisp = interfacelist.getDetails(pointArr[i].ifaceid).name
	    inthtml.append($('<tr></tr>')
	    				.append($('<td></td>').append(idisp)) 
	    				.append($('<td></td>').append('test'))
	    			);
	}
	
	location.find('.fndisp').val(project.fname)
	location.find('.lndisp').val(project.lname)
	location.find('.interfacearea').html(inthtml)
	
	location.find('*').attr('disabled','disabled')
	location.find('.delContact').data('id',id).removeAttr('disabled');
	location.find('.editContact').removeAttr('disabled');
	location.find('.saveContact').data('id',id)
}
//****************************************************