<?php
  namespace db;
  use \PDO as PDO;
  
  /**
  * Class to represent a pdo driver 
  */
  class PDOConnection
  {
	/**
	* Initialize Connection details 
	*/
	private $_dbh;
	private $_dsn;
	private $_user;
	private $_password;
	
  	function __construct($connectArray) {
       $this->_dsn = $connectArray['dsn'];
	   $this->_user =$connectArray['username'];
       $this->_password = $connectArray['password'];
    }

	/**
	* Validate users have called Connect before using other functions 
	*/  	
    private function validateConnection() {
       if (is_object ($this->_dbh)) {
         return true;
       }  
	   else {
		throw new \Exception("Not Connected to a database - use Connect before attempting other functions");	 
	  } 
    }
    
    
	/**
	* Connect to the database 
	*/  	
  	public function connect()  {
	  try {
    	$this->_dbh = new PDO($this->_dsn, $this->_user, $this->_password);
    	$this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
    		throw new \Exception('Could not connect to database: '.$e);
		}
	}

	/**
	* Shuts down established database connection 
	*/
	public function disconnect() {
	   $this->_dbh = null;
	} 

	/**
	* Return the result of a select query as an array of rows 
	*/
	public function select($sql) {
      $this->validateConnection();
	  $returnarr = Array();
	  try {
	    $resultarr= $this->_dbh->query($sql);
		while($row = $resultarr->fetch(PDO::FETCH_OBJ)) {
		  $returnarr[] = $row;
		}
	      return ($returnarr);
	   } 
	    catch (\PDOException $e) {
		throw new \Exception($e->getMessage());
	    }
	}
	
	
	/**
	* Execute the Update statement
	* Throw an exception if the query fails to execute.
	*/
	public function update($sql) {
      $this->validateConnection();
	  try{
		$updtcnt = $this->_dbh->exec($sql);
		return ($updtcnt);
	  } catch (\PDOException $e) {
  		throw new \Exception($e->getMessage());
	  }	
	}

	/**
	* Execute the Delete statement
	* Throw an exception if the query fails to execute.
	*/
	public function delete($sql)  {
      $this->validateConnection();
	  try{
		$delcnt = $this->_dbh->exec($sql);
		return($delcnt);
	  } catch (\PDOException $e) {
  		throw new \Exception($e->getMessage());
	  }	
	}

	/**
	* Execute insert sql statement
	* It should return last insert id if operation is successful, 
	* Throw an exception if the operation fails. 
	*/

	public function insert($sql){
      $this->validateConnection();
	  try{
		$this->_dbh->exec($sql);
		return ($this->_dbh->lastInsertId());
	  } catch (\PDOException $e) {
  		throw new \Exception($e->getMessage());
	  }
	}

 }
?>