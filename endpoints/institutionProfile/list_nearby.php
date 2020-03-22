<?php

/* SETUP */
use controllers\MasterController;
use tools\Validator;
use tools\HttpError;

include(".." . DIRECTORY_SEPARATOR .".." . DIRECTORY_SEPARATOR . "config.php");
include(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "autoload.php");

$master = new MasterController();
/* SETUP */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Be sure the user is logged in!
    if(!$master->isSessionValid()) {
        $master->errorResponse(new HttpError(401, "Bitte melde dich zuerst an."));
        return;
    }

    $user = $master->userController->getUserById($_SESSION[SESSION_NAME_USERID]);

    // Secure that there is a volunteer profile linked to the user
    if($master->volunteerController->isVolunteerProfile($user)) {
        $volunteerProfile = $master->volunteerController->getVolunteerProfileByUser($user);
        $geoCode = $master->profileRadiusController->getGeoCodeForVolunteerUser($user);

        // Could not find a geocode for user!? :o
        if(!$geoCode) {
            http_response_code(400);
            return;
        }

        $nearbyInstitutions = $master->profileRadiusController->getInstitutionProfilesByRadiusAndGeo($volunteerProfile->radius, $geoCode);
        if(count($nearbyInstitutions) > 0) {
            http_response_code(200);
            $master->returnObjectAsJson($nearbyInstitutions);
        } else {
            http_response_code(204);
        }
    } else {
        // Institutions should not get a list of institutions nearby(!)
        http_response_code(400);
    }
}