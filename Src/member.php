<?php
  namespace IntMgr;
/**
 * Concrete Implementation of a member class
 */
 class member 
 {
    private $id;
    private $lastname;
    private $firstname;
	private $token;
	private $img;
	
    public function setid($id) {
       $this->id= $id;
    }

    public function getid() {
       return ($this->id);
    }    

    public function setfirstname($fn) {
       $this->firstname= $fn;
    }  
    
    public function getfirstname() {
       return ($this->firstname);
    }

    public function setlastname($ln) {
       $this->lastname= $ln;
    }  
    
    public function getlastname() {
       return ($this->lastname);
    }
    
    public function settoken($token) {
       $this->token= $token;
    }  
    
    public function gettoken() {
       return ($this->token);
    }
	
 }    
?>