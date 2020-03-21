<?php
include("controllers/MasterController.php"); // init, settings, etc
$master = new MasterController($db, $userController);

$dataContent = file_get_contents("php://input");
if (!$dataContent) {
    http_response_code(400);
    return;
}

$data = json_decode($dataContent);

if ($userController->registerUser($data->email, $data->forename, $data->surname, $data->pass, $userController->ROLE_DEFAULT)) {
    http_response_code(200);
    echo json_encode($user);
    return;
} else {
    http_response_code(401);
    return;
}