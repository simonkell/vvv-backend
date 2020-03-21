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

// Be sure the user is logged in!
if(!$master->isSessionValid()) {
    $master->errorResponse(new HttpError(401, "Bitte melden Sie sich zuerst an."));
    return;
}

const REQUIRED_FIELDS = ['email', 'forename', 'surname'];
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
$passwordWeaknesses = $validator->validatePassword($data->pass_new);
if(count($passwordWeaknesses) > 0) {
    $master->errorResponse($passwordWeaknesses);
    return;
}

// Change everything of user except password! see updatePassword.php
$user = getUserByEmail($data->email_old);
if($_SESSION[SESSION_NAME_USERID] == $user->id) {
    $user->email = $data->email;
    $user->forename = $data->forename;
    $user->surname = $data->surname;

    if ($master->userController->changeUser($user)) {
        http_response_code(200);
        return;
    } else {
        http_response_code(400);
        return;
    }
} else {
    $master->errorResponse(new HttpError(401, 'Das Passwort war nicht korrekt.'));
    return;
}

?>