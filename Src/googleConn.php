<?php
  namespace IntMgr;
  class googleConn extends \Google_Client {
   function __construct() {
       parent::__construct();
       
       $this->setClientId('1054206380730.apps.googleusercontent.com');
       $this->setClientSecret('pxsqpQXfENCQAqmvAw4IJa63');
       $this->setRedirectUri('http://localhost/weblamp442/IntMgr/Src/intmgrtest.php');
       $this->setApplicationName("Integration Manager");
   }
}
