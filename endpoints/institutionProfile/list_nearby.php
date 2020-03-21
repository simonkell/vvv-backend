<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['name', 'street', 'house_number', 'postal_code', 'city', 'description', 'user_id'];
$master = new MasterController();
/* SETUP */

// Be sure the user is logged in!
if(!$master->isSessionValid()) {
    $master->errorResponse(new HttpError(401, "Bitte melden Sie sich zuerst an."));
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

if (true) {
    http_response_code(200);
    //$master->returnObjectAsJson($master->user);
    return;
} else {
    http_response_code(401);
    return;
}