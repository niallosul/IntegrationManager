<?php
namespace IntegrationManager;
/**
 * Concrete class to represent a task
 */
class task
{
    private $role;
    private $description;
    private $status;

	function __construct ($description, $role, $status);

}
?>