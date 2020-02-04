<?php
class Dbconfig {
    protected $serverName;
    protected $userName;
    protected $passCode;
    protected $dbName;

    function __construct() {
        $this -> serverName = 'localhost';
        $this -> userName = 'masterdtbCliente';
        $this -> passCode = 'ps39#6900';
        $this -> dbName = 'dtbCliente';
    }
}
?>