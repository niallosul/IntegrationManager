<?php
namespace IntMgr;
/**
 * DAO Implementation of the member table
 */
 class projectDAO
 {
 	private $db;
 	
 	public function __construct($dbobj) {
 	   $this->db = $dbobj;
    }

    /**
	* Add a new project to the db 
	*/ 
    public function add($mnem, $name) {
      $this->db->connect();
      $insertSql = "INSERT INTO projects (mnemonic, name) "
      			."VALUES ('".$mnem."','".$name."')";
	  return ($this->db->insert($insertSql));
    }
    
   	/**
	* Returns all projects from the db  
	*/
    public function getall() {
    	$this->db->connect();
		$querysql = "SELECT * FROM `projects` WHERE id >0";
		return($this->db->select($querysql));
    }

	/**
	* Returns project by id  
	*/
    public function get($id) {
        $this->db->connect();
		$querysql = "SELECT * FROM `projects` WHERE id =".$id;
		return ($this->db->select($querysql));
    }

	/**
	* Returns all projects for a given member  
	*/
    public function getbymember($memid) {
        $this->db->connect();

		$querysql="SELECT distinct p.id as 'projectid', p.mnemonic, p.name"
		." FROM project_members pm"
		." JOIN projects p ON (p.id = pm.projectid)"
		." WHERE pm.memberid = '".$memid."'"
	    ." ORDER BY p.mnemonic";
		return ($this->db->select($querysql));
    }
   
   	/**
	* Add a team member to a project  
	*/
    public function addmember($projid, $memid) {
        $this->db->connect();
		$insertSql = "INSERT INTO project_members (projectid, memberid) "
      			."VALUES ('".$projid."','".$memid."')";
		return ($this->db->insert($insertSql));
    } 
 }    
?>