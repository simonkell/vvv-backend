<?php

use controllers\MasterController;
use tools\Validator;

include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['email', 'pass'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $master = new MasterController();

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

    // Validate email
    if (!$validator->isValidEmail($data->email)) {
        $master->errorResponse(new HttpError(400, 'Bitte gib eine gültige Email-Adresse an.'));
        return;
    }

    // Already an account with this email?
    if ($master->userController->isExisting($data->email)) {
        $master->errorResponse(new HttpError(400, 'Es existiert bereits ein Benutzer mit dieser Email-Adresse.'));
        return;
    }

    // Validate password strength
    $passwordWeaknesses = $validator->validatePassword($data->pass);
    if (count($passwordWeaknesses) > 0) {
        $master->errorResponse($passwordWeaknesses);
        return;
    }

    if ($master->userController->registerUser($data->email, "", "", $data->pass, $master->userController->ROLE_DEFAULT)) {
        http_response_code(200);
        $master->returnObjectAsJson($master->user);
        return;
    } else {
        http_response_code(401);
        return;
    }
}
