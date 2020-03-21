<?php

use controllers\MasterController;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");

spl_autoload_register(function ($class) {
    $file = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});


$master = new MasterController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $master->userController->logout();
    http_response_code(200);
    return;
}