<?php


namespace controllers;

use models\User;
use models\VolunteerProfile;
use models\GeoLocation;
use tools\HttpError;

class ProfileRadiusController extends Controller
{
    private $QUERY_VOLUNTEER_GEOLOCATIONS_BY_USERID = "";
    private $QUERY_IN_RADIUS_BY_GEOLOCATIONS = "";

    public function getInstitutionProfilesByRadiusAndGeo($radiusInKilometer, $geoLat, $geoLon) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_IN_RADIUS_BY_GEOLOCATIONS);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $radiusInKilometerSql = (int) $radiusInKilometer;
        $stmt->bind_param("iss", $radiusInKilometerSql, $geoLat, $geoLon);

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!empty($row)) {
            $volunteerProfile = new VolunteerProfile($row);
            $stmt->free_result();
            $stmt->close();
            return $volunteerProfile;
        } else {
            $stmt->free_result();
            $stmt->close();
            return null;
        }

        return null;
    }

    public function getGeoCodeOfUserByUser(User $user) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_VOLUNTEER_GEOLOCATIONS_BY_USERID);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $userIdSql = (int) $user->id;
        $stmt->bind_param("i", $userIdSql);

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if(!empty($row)) {
            $geoLocation = new GeoLocation($row);
            $stmt->free_result();
            $stmt->close();
            return $geoLocation;
        } else {
            $stmt->free_result();
            $stmt->close();
            return null;
        }

        return null;
    }
}