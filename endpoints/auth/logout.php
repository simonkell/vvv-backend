<?php

use controllers\MasterController;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");



$master = new MasterController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $master->userController->logout();
    http_response_code(200);
    return;
}
