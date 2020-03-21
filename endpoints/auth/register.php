<?php

use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");

spl_autoload_register(function ($class) {
    $file = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

const REQUIRED_FIELDS = ['email', 'pass'];
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
if(!$validator->isValidEmail($data->email)) {
    $master->errorResponse(new HttpError(400, 'Bitte gib eine gültige Email-Adresse an.'));
    return;
}

// Validate password strength
$passwordWeaknesses = $validator->validatePassword($data->pass);
if(count($passwordWeaknesses) > 0) {
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