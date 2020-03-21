<?php

/* SETUP */
use controllers\MasterController;

include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");
/* SETUP */

if(isset($_GET["key"])) {
    $keyKey = $_GET["key"];

    $master = new MasterController();

    if($master->keyController->isExisting($keyKey)) {
        $key = $master->keyController->getConfirmationKeyByKey($keyKey);
        $user = $master->userController->getUserById($key->user_id);

        if($user && (int) $user->active == 0) {
            $user->active = 1;

            if($master->userController->changeUser($user)) {
                // Hurra! Key wurde erfolgreich eingelöst. Benutzer aktiviert.
                $master->keyController->removeKey($key);
            } else {
                // :-(
            }
        }
    }
}

header("Location: http://volunteervsvirus.de/");
die();