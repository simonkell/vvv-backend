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

const REQUIRED_FIELDS = ['name', 'street', 'house_number', 'postal_code', 'city', 'description', 'user_id'];
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

// Validation? $data->user_id == $sessionUser->id?
// TODO? @Backend-Team @general

// The user that should be linked does not exist
$master->user = $master->userController->getUserById($data->user_id);
if(!$master->user) {
    $master->errorResponse(new HttpError(400, 'Das Sucher-Profil des angeforderten Nutzers konnte nicht verändert werden, weil dieser nicht existiert.'));
    return;
}

// Try to update profile. Timestamp for update will be set inside update function
if ($master->institutionController->updateInstitutionProfile($data->name, $data->street, $data->house_number, $data->postal_code, $data->city, $data->description, $data->user_id)) {
    http_response_code(200);
    $master->returnObjectAsJson($master->user);
    return;
} else {
    http_response_code(401);
    return;
}