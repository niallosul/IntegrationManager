<?php
/**
 * Abstract class to represent a System Interface
 */
abstract class A_integrationpoint
{
    private $intpointid;
    private $description;
    private $shortname;

    abstract public function setintpointid($intpointid);
    abstract public function getintpointid();

    abstract public function setdescription($description);
    abstract public function getdescription();

    abstract public function setshortname($shortname);
    abstract public function getshortname();
}
?>