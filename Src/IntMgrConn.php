<?php
  namespace IntMgr;
  class IntMgrConn extends \db\PDOConnection {
   function __construct() {
   	   $conarr = array(
  	    'dsn'     => 'mysql:dbname=integration_mgr;host=127.0.0.1',
        'username' => 'guest',
        'password' => 'guest',
        );
       parent::__construct($conarr);

   }

}