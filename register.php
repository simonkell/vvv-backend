<?php
include('tools/Validator.php');

const REQUIRED_FIELDS = ['email', 'forename', 'surname', 'pass'];

include("controllers/MasterController.php"); // init, settings, etc
$master = new MasterController($db, $userController);

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

if ($userController->registerUser($data->email, $data->forename, $data->surname, $data->pass, $userController->ROLE_DEFAULT)) {
    http_response_code(200);
    echo json_encode($user);
    return;
} else {
    http_response_code(401);
    return;
}