<?php
namespace IntMgr;
/**
 * Interface to specify which actions objects of class member must instantiate 
 */
interface Imember
{
    public function getall();
    public function get($id);
    public function add($member);
}
?>