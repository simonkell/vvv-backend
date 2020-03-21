<?php
use controllers\MasterController;
use tools\HttpError;
use tools\Validator;

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

$master->user = $master->userController->getUserByEmail($data->email);
if ($master->userController->loginUserWithPassCheck($master->user, $data->pass)) {
	http_response_code(200);
    $master->returnObjectAsJson($master->user);
} else {
    http_response_code(401);
    return;
}
?>