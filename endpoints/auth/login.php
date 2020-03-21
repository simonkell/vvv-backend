<?php
use controllers\MasterController;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");


const REQUIRED_FIELDS = ['email', 'pass'];
$master = new MasterController();

/* LOGIN REQUEST */
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

if (!$master->userController->isExisting($data->email)) {
    http_response_code(401);
	$master->errorResponse(new HttpError(401, 'Es konnte kein Benutzer zu dieser Email-Adresse gefunden werden.'));
    return;
}

if ($master->userController->loginUserWithPassCheck($user, $jsonPassword)) {
	http_response_code(200);
    echo json_encode($master->user);
} else {
    http_response_code(401);
    return;
}
?>
