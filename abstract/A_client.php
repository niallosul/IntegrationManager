<?php
/**
 * Abstract class to represent a Client
 */
abstract class A_client
{
    private $clientid;
    private $clientName;
    private $clientMnemonic;

    abstract public function setclientid($clientid);
    abstract public function getclientid();

    abstract public function setClientName($clientname);
    abstract public function getClientName();

    abstract public function setClientMnemonic($clientMnemonic);
    abstract public function getClientMnemonic();
}
?>