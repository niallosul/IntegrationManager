<?php
namespace IntegrationManager;
/**
 * Abstract class to represent a task
 */
abstract class A_task
{
    private $role;
    private $description;
    private $status;

	function __construct ($description, $role, $status);

}
?>