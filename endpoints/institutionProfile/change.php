<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

const REQUIRED_FIELDS = ['institution_profile_id', 'name', 'street', 'house_number', 'postal_code', 'city', 'description'];
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

    // Try to update profile. Timestamp for update will be set inside update function
    if ($master->institutionController->updateInstitutionProfile($data->institution_profile_id, $data->name, $data->street, $data->house_number, $data->postal_code, $data->city, $data->description, $master->user->id)) {
        $institutionProfile = $master->institutionController->getInstitutionProfileById($data->institution_profile_id);
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