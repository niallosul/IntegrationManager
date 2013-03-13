<?php
  namespace IntMgr;
/**
 * Concrete Implementation of a member class
 */
 class member 
 {
    private $memInfo = array(); 
	
    public function setid($id) {
       $this->memInfo['id']= $id;
    }

    public function getid() {
       return ($this->memInfo['id']);
    }    

    public function setfirstname($fn) {
       $this->memInfo['firstname']= $fn;
    }  
    
    public function getfirstname() {
       return ($this->memInfo['firstname']);
    }

    public function setlastname($ln) {
       $this->memInfo['lastname']= $ln;
    }  
    
    public function getlastname() {
       return ($this->memInfo['lastname']);
    }
    
    public function settoken($token) {
       $this->memInfo['token']= $token;
    }  
    
    public function gettoken() {
       return ($this->memInfo['token']);
    }

    public function setimg($link) {
       $this->memInfo['img']= $link;
    }  
    
    public function getimg() {
       return ($this->memInfo['img']);
    }	
    
    public function getinfo() {
       return ($this->memInfo);
    }	
 }    
?>