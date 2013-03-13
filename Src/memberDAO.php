<?php
namespace IntMgr;
/**
 * DAO Implementation of the member table
 */
 class memberDAO
 {
 	private $db;
 	
 	public function __construct($dbobj) {
 	   $this->db = $dbobj;
    }
    
   	//Returns all members 
    public function getall() {
    	$this->db->connect();
		$querysql = "SELECT * FROM `member` WHERE id >0";
		return($this->db->select($querysql));
    }

	//Returns member by id
    public function get($id) {
        $this->db->connect();
		$querysql = "SELECT * FROM `member` WHERE id =".$id;
		//return ($this->db->select($querysql));
				
		$memarr = $this->db->select($querysql);
		$newMember = new member(); 
        $newMember->setid($memarr[0]->id);
        $newMember->setlastname($memarr[0]->last_name);
        $newMember->setfirstname($memarr[0]->first_name);
        $newMember->settoken($memarr[0]->token);
		return ($newMember);
    }

    // Add a new member to the db 
    public function add($member) {
      $ln = filter_var($member->getlastname(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $this->db->connect();
      $insertSql = "INSERT INTO member (id, last_name, first_name, token) "
      			."VALUES ('".$member->getid()."','".$ln."','".$member->getfirstname()."','".$member->gettoken()."')";
      echo ("INSERT:".$insertSql);
	  return ($this->db->insert($insertSql));
    }

    //Delete member by id
    public function delete($id) {
        $this->db->connect();
		$deletesql = "DELETE FROM `member` WHERE id =".$id;		
		return ($this->db->delete($querysql));
    }
    
    //Update Member Access Token
    public function updtToken($locuser) {
    	$newtoken = $locuser->gettoken();
    	$memid = $locuser->getid();
        $this->db->connect();
        $updatesql = "UPDATE `member` SET token ='".$newtoken."' WHERE id=".$memid;
		return ($this->db->update($updatesql));
    }

    
 }    
?>