<?php

namespace controllers;

use tools\HttpError;

session_start();

define("SESSION_NAME_USERID", "userId");

// CONTROLLERS
// TODO: ResponseController? Invalid permission response, session expired response, no session response

class MasterController
{
    public $db, $userController, $user;

    public $institutionController;

    public function __construct()
    {
        $this->db = new DbController($this);
        $this->userController = $userController = new UserController($this);
        $this->institutionController = new InstitutionController($this);
        $this->db->connect();
    }

    public function isSessionValid()
    {
        if (isset($_SESSION[SESSION_NAME_USERID])) {
                $user = $this->userController->getUserById($_SESSION[SESSION_NAME_USERID]);

                if ($user != null) {
                    if (true) {
                        return true;
                    } else {
                        // No further user information validation
                        // ... <useless else>
                    }
                }
        }

        return false;
    }

    /**
     * @param $httpError HttpError|HttpError[]
     */
    public function errorResponse($httpError)
    {
        $messages = null;
        if (is_array($httpError)) {
            http_response_code($httpError[0]->getCode());
            $messages = array_map(function ($httpError) {
                return $httpError->getMessage();
            }, $httpError);
        } else {
            http_response_code($httpError->getCode());
            $messages = [$httpError->getMessage()];
        }

        $this->returnObjectAsJson((object)["error" => true, "messages" => $messages]);
    }

    public function returnObjectAsJson($obj) {
        header('Content-Type: application/json');
        echo json_encode($obj);
    }
}

?>