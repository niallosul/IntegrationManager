function IntMgr(divId, title) {
	this.divId = divId;
	this.title = title;
   // array index will be contact id, entries are Contact instances
    var contacts = [];
	
	this.addContact=function( contact ) { 
		contacts.push (contact)
		//$('body').trigger('dataModelChanged');
		divId.trigger('dataModelChanged');
		return ((contacts.length)-1)
	};
   // remove from contacts list
    this.deleteContact=function( id ) {
		delete contacts[id];
		//$('body').trigger('dataModelChanged');
		divId.trigger('dataModelChanged');
	};
	
	this.updateContact=function( id,contact ) {
		contacts[id] = contact ;
		//$('body').trigger('dataModelChanged');
		divId.trigger('dataModelChanged');
	};
   // hand back contact at id
	this.getContactDetails=function( id ) {
		return (contacts[id])
	};
   // hand back new array of short names with correct ids for idx
	this.getAllNames=function() {
	  var contactList=[]
	  for (var i=0;i<contacts.length; i++) {
	    if (i in contacts) {
		  contactList[i]=contacts[i].fname;
		}
	  }
	  return contactList;
	};
}



function ipoint (ifaceid,vendorid){
	this.ifaceid=ifaceid
	this.vendorid=vendorid
	
	this.getifaceDesc=function() {
	  return pointsList;
	};
	
}


function integrationPointList() {
    var ipoints = [];
	this.addipoint=function( ipoint ) { 
		ipoints.push (ipoint)
		return ((ipoints.length)-1)
	};
	
	this.getAll=function() {
	  return ipoints;
	};
}

function Contact( fn, ln, em, il ) {
	this.fname = fn;
	this.lname = ln;
	this.email = em;
	this.ipointList = il;
}


//Represent a list of interfaces
function ifaceList (){
	var ifaces = [];
	this.addiface=function( iface ) { 
		ifaces[iface.id] =iface
		return (iface.id)
	};
	
  	this.getDetails=function( id ) {
		return (ifaces[id])
	};
	
	this.getAll=function( ) {
	  return ifaces;
	};
}


function iface (id, name,shortname){
    this.id = id
	this.name=name
	this.shortname=shortname
}