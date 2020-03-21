<?php
include("controllers/MasterController.php"); // init, settings, etc
$master = new MasterController($db, $userController);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController->logout();
    http_response_code(200);
    return;
}