<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['user_id'];
$master = new MasterController();
/* SETUP */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!$master->isSessionValid()) {
        $master->errorResponse(new HttpError(401, "Bitte melde dich sich zuerst an."));
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

    // Validation? $data->user_id == $sessionUser->id?
    // TODO? @Backend-Team @general

    // The user that should be linked does not exist
    $master->user = $master->userController->getUserById($data->user_id);
    if (!$master->user) {
        $master->errorResponse(new HttpError(400, 'Die Sucher-Profile des angeforderten Nutzers konnten nicht gefunden werden, weil dieser nicht existieren.'));
        return;
    }

    // Try to update profile. Timestamp for update will be set inside update function
    $institutionProfiles = $master->institutionController->getInstitutionProfilesByUser($master->user);
    if (count($institutionProfiles) > 0) {
        http_response_code(200);
        $master->returnObjectAsJson($institutionProfiles);
        return;
    } else {
        http_response_code(204);
        return;
    }
}