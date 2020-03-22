<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['id'];
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

    // The user that should be linked does not exist
    $volunteerProfile = $master->volunteerController->getVolunteerProfileById($data->id);
    if ($volunteerProfile) {
        http_response_code(200);
        $master->returnObjectAsJson($volunteerProfile);
        return;
    } else {
        http_response_code(204);
        return;
    }
}