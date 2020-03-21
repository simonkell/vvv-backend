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
			$master->errorResponse(new HttpError(500, 'Connection to server could not be established.'));
        }
    }

    public function getConn()
    {
        return $this->CONNECTION;
    }
}

?>