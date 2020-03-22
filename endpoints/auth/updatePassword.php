<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['email', 'oldPassword', 'newPassword'];
$master = new MasterController();
/* SETUP */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Be sure the user is logged in!
    if (!$master->isSessionValid()) {
        $master->errorResponse(new HttpError(401, "Bitte melde Dich sich zuerst an."));
        return;
    }

    $dataContent = file_get_contents("php://input");
    if (!$dataContent) {
        http_response_code(400);
        return;
    }

    $data = json_decode($dataContent);

    $validator = new Validator($data, REQUIRED_FIELDS);
    $validationErrors = $validator->validate();
    if (!empty($validationErrors)) {
        $master->errorResponse($validationErrors);
        return;
    }

    // Validate password strength
    $passwordWeaknesses = $validator->validatePassword($data->newPassword);
    if (count($passwordWeaknesses) > 0) {
        $master->errorResponse($passwordWeaknesses);
        return;
    }

    $user = getUserByEmail($data->email);
    if (password_verify($data->oldPassword, $user->pass)) {
        changeUserPassword($user, $data->newPassword);
        http_response_code(200);
        return;
    } else {
        $master->errorResponse(new HttpError(401, 'Das Passwort war nicht korrekt.'));
        return;
    }
}
