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
        $this->db = new DbController();;
        $this->userController = $userController = new UserController($this);
        $this->institutionController = new InstitutionController($this);
        $this->db->connect();
    }

    public function isSessionValid($sessionName)
    {
        if (isset($_SESSION[$sessionName])) {
            if (strcmp($sessionName, SESSION_NAME_USERID) == 0) {
                $user = $this->userController->getUserById($_SESSION[$sessionName]);

                if ($user != null) {
                    // TODO: Check if id is legit (???)
                    if (true) {
                        return true;
                    } else {
                        // No further user information validation
                        // ... <useless else>
                    }
                }
            } else {
                // No further validations.
                // NEW VALIDATION METHODS HERE!
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
        echo json_encode((object)["error" => true, "messages" => $messages]);
        header('Content-Type: application/json');
    }
}

?>