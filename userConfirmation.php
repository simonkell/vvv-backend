<?php

/* SETUP */
use controllers\MasterController;

include("config.php");
include("autoload.php");
/* SETUP */

if(isset($_GET["key"])) {
    $keyKey = $_GET["key"];

    $master = new MasterController();

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

if(isset($_GET["adminCommand"]) && $_GET["adminCommand"] == "WeVsVolunteers_Mail" && isset($_GET["userId"])) {
    $user = $master->userController->getUserById($_GET["userId"]);

    if($user) {
        $key = $this->master->confirmationKeyController->addNewKeyForUser($user);
        $this->master->mailerController->sendMail($key, $user->email);
        echo "Email an " . $user->email . " neu versendet.";
        die;
    }
}

// DEV
echo "redirect";
die;
// DEV
header("Location: http://volunteervsvirus.de/");
die();