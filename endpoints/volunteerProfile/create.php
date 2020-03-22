<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['ganztaegig', 'date_from', 'date_to', 'time_from', 'time_to', 'radius', 'drivinglicense', 'medical_experience'];
$master = new MasterController();
/* SETUP */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Be sure the user is logged in!
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

    $master->user = $master->userController->getUserById($_SESSION[SESSION_NAME_USERID]);
    if($master->institutionController->isInstitutionProfile($master->user)) {
        $master->errorResponse(new HttpError(400, "Dieser Benutzer ist bereits als Institution angemeldet."));
        return;
    }
    if($master->volunteerController->isVolunteerProfile($master->user)) {
        $master->errorResponse(new HttpError(400, "Dieser Benutzer ist bereits als Freiwilliger angemeldet."));
        return;
    }

    $volunteerProfileId = $master->volunteerController->createVolunteerProfile($data->ganztaegig, $data->date_from, $data->date_to, $data->time_from, $data->time_to, $data->radius, $data->drivinglicense, $data->medical_experience);
    if ($volunteerProfileId) {
        $volunteerProfile = $master->institutionController->getInstitutionProfileById($volunteerProfileId);
        if($volunteerProfile) {
            http_response_code(200);
            $master->returnObjectAsJson($volunteerProfile);
            return;
        } else {
            $master->errorResponse(new HttpError(500, "Something went wrong :-( Created profile, but could not find it."));
        }
    } else {
        http_response_code(401);
        return;
    }
}