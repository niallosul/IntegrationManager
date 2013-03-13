<?php
namespace IntMgr;

require '../Vendors/autoload.php';
require '../../vendor/autoload.php';

class projectDAOTest extends \PHPUnit_Framework_TestCase
{	
    public function setUp ( ) {
		$this->intmgrdb = new IntMgrConn();
	    $this->projDAO = new projectDAO($this->intmgrdb);
     }
     
    public function tearDown ( ) {
        $this->intmgrdb->disconnect();
     }


    /**
	 * verify that the Insert function returns
	 * a integer of zero or greater matching the new row's id
     */
    public function testadd( ) {
		$this->assertGreaterThan(0,$this->projDAO->add("VRGN_WA", "Virginia Mason"));
	}

    /**
	 * verify that the addMember function returns
	 * a integer of zero or greater matching the new row's id
     */
    public function testaddmember( ) {
		$this->assertGreaterThan(0,$this->projDAO->addmember(6, "109186980871183360078"));
	}	
	
	/**
	 * verify that the getbymember function returns
	 * an array objects greater than size zero, and 
	 * the object has an attribute of member id
     */
    public function testgetbymember( ) {
        $memlist = $this->projDAO->getbymember("109186980871183360078");
        var_dump ($memlist);
		$this->assertArrayHasKey("0",$memlist);
		$this->assertObjectHasAttribute("projectid", $memlist[0]);
	}	
}
?>