<?php

/* SETUP */
use controllers\MasterController;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['user_id'];
$master = new MasterController();
/* SETUP */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!$master->isSessionValid()) {
        $master->errorResponse(new HttpError(401, "Bitte melde Dich sich zuerst an."));
        return;
    }

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

    // The user that should be linked does not exist
    $user = $master->userController->getUserById($data->user_id);
    if (!$user) {
        $master->errorResponse(new HttpError(204, 'Der angefragte Benutzer existiert nicht.'));
        return;
    }

    $master->institutionController->isInstitutionProfile($user);
}
