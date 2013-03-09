<?php
/**
 * Abstract class to represent a Project Milestone
 */
abstract class A_milestone
{
    private $milestoneid;
    private $milestoneName;
    private array $milestonetasklist;

	function __construct($id,$name);

    abstract public function getmilestoneid();
    abstract public function getmilestoneName();
    abstract public function addtask($task);
    abstract public function gettasksbyrole($role);
    abstract public function getalltasks();
	
}
?>