<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['name', 'street', 'house_number', 'postal_code', 'city', 'description'];
$master = new MasterController();
/* SETUP */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Be sure the user is logged in!
    if(!$master->isSessionValid()) {
        $master->errorResponse(new HttpError(401, "Bitte melde dich zuerst an."));
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

    $institutionProfileId = $master->institutionController->createInstitutionProfile($data->name, $data->street, $data->house_number, $data->postal_code, $data->city, $data->description, $master->user->id);
    if ($institutionProfileId) {
        $institutionProfile = $master->institutionController->getInstitutionProfileById($institutionProfileId);
        if($institutionProfile) {
            http_response_code(200);
            $master->returnObjectAsJson($institutionProfile);
            return;
        } else {
            $master->errorResponse(new HttpError(500, "Something went wrong :-( Created profile, but could not find it."));
        }
    } else {
        http_response_code(401);
        return;
    }
}