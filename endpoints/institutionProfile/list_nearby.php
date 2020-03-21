<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

$master = new MasterController();
/* SETUP */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Be sure the user is logged in!
    if(!$master->isSessionValid()) {
        $master->errorResponse(new HttpError(401, "Bitte melden Sie sich zuerst an."));
        return;
    }

    $user = $master->userController->getUserById($_SESSION[SESSION_NAME_USERID]);

    if (true) {
        http_response_code(200);
        //$master->returnObjectAsJson($master->user);
        return;
    } else {
        http_response_code(401);
        return;
    }
}