<?php
/**
 * Abstract class to represent an Integration Project
 */
abstract class A_intProject
{
    private $clientid;
    private $projectName;
    private $milestones = array();
    private $teamMembers = array();
    private $integrationpoints = array();

    abstract public function setclientid($clientid);
    abstract public function getclientid();

    abstract public function setProjectName($projname);
    abstract public function getProjectName();

    abstract public function addTeamMember($memberid, $memberrole);
    abstract public function getTeamMembers();

    abstract public function addMilestone($mstype, $msdate);
    abstract public function getMilestones();

    abstract public function addintegrationpoint($type, $systemid);
    abstract public function getintegrationpoints();
}
?>