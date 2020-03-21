<?php
use controllers\MasterController;

include("..\..\config.php");
spl_autoload_register(function ($class) {
    $file = '..\\..\\' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

$master = new MasterController();

/* LOGIN REQUEST */
$dataContent = file_get_contents("php://input");
if (!$dataContent) {
    http_response_code(400);
    return;
}

$data = json_decode($dataContent);
$jsonEmail = $data->email;
$jsonPassword = $data->password;

if (empty($jsonEmail) || empty($jsonPassword)) {
    http_response_code(400);
    echo json_encode(array("message" => "Die Daten des Logins wurden nicht korrekt übermittelt. (email, password)"));
    return;
}
if (!$master->userController->isExisting($jsonEmail)) {
    http_response_code(401);
    echo json_encode(array("message" => "Es konnte kein Benutzer zu dieser Email-Adresse gefunden werden."));
    return;
}

$user = $master->userController->getUserByEmail($jsonEmail);
if (!$user) { // Should not happen if isExisting returns true
    http_response_code(500);
    echo json_encode(array("message" => "Fehler beim Laden des Benutzers. Das hätte nicht passieren dürfen, versuchen Sie es erneut :-("));
    return;
}

if ($master->userController->loginUserWithPassCheck($user, $jsonPassword)) {
    http_response_code(200);
    echo json_encode($user);
    return;
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Die Anmeldedaten stimmen nicht überein."));
    return;
}
?>