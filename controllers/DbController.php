<?php
namespace controllers;

use mysqli;

class DbController
{
    private $CONNECTION;

    function __destruct()
    {
        if ($this->CONNECTION->ping()) {
            $this->CONNECTION->close();
        }
    }

    public function connect()
    {
        global $servername, $username, $password;

        // Create connection
        $this->CONNECTION = new mysqli($servername, $username, $password, "WirVsVirus");

        // Check connection
        if ($this->CONNECTION->connect_error) {
            //$page->addError("Die Datenbank ist zur Zeit nicht erreichbar. Bitte wenden Sie sich an den Systemadministrator");
            // TODO: responseController->returnDbError() (?)
        }
    }

    public function getConn()
    {
        return $this->CONNECTION;
    }
}

?>