<?php

/* SETUP */
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

use controllers\MasterController;

$master = new MasterController();
/* SETUP */

if(isset($_GET["key"])) {
    $keyKey = $_GET["key"];

    if($master->confirmationKeyController->isExisting($keyKey)) {
        $key = $master->confirmationKeyController->getConfirmationKeyByKey($keyKey);
        $user = $master->userController->getUserById($key->user_id);

        if($user && (int) $user->active == 0) {
            $user->active = 1;

            if($master->userController->changeUser($user)) {
                // Hurra! Key wurde erfolgreich eingelöst. Benutzer aktiviert.
                $master->confirmationKeyController->removeKey($key);
            } else {
                // :-(
            }
        }
    }
}

if(isset($_GET["adminCommand"]) && strcmp($_GET["adminCommand"], "WeVsVolunteers_Mail") == 0 && isset($_GET["user_id"])) {
    $user = $master->userController->getUserById($_GET["user_id"]);
    if($user) {
        $key = $master->confirmationKeyController->addNewKeyForUser($user);
        $master->mailerController->sendMail($key, $user->email);
        echo "Email an " . $user->email . " neu versendet.";
        die;
    }
}

header("Location: http://volunteervsvirus.de/");
die();