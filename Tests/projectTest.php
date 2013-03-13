<?php
namespace IntMgr;

include '../Src/project.php';
include '../../vendor/autoload.php';

class projectTest extends \PHPUnit_Framework_TestCase
{	
    public function setUp ( ) {
        $this->proj = new project();
        $this->proj->addTeamMember("23453");
        $this->proj->addTeamMember("253");
     }
     
    /**
	 * verify that the Insert function returns
	 * a integer of zero or greater matching the new row's id
	 * Had to force the id into the insert to allow for multiple tests
     */
    public function testgetMember( ) {
       $this->assertSame(2,count ($this->proj->getTeamMembers())); 
       var_dump ($this->proj->getTeamMembers());
	}
		
}	

?>