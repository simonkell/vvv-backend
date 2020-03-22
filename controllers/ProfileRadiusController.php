<?php


namespace controllers;

use models\User;
use models\VolunteerProfile;
use models\GeoLocation;
use tools\HttpError;

class ProfileRadiusController extends Controller
{
    private $QUERY_VOLUNTEER_GEOLOCATIONS_BY_USERID = "SELECT Substring(`geopoint`, 1, POSITION(',' IN geopoint)-1) as  LAT, Substring(geopoint, POSITION(',' IN geopoint)+1, LENGHT(geopoint)) as LON,  v.user_id, v.radius FROM volunteer_profile AS v INNER JOIN postalcodes AS p ON v.postal_code = p.postal_code WHERE user_id=?";
    private $QUERY_IN_RADIUS_BY_GEOLOCATIONS = "SELECT Substring(geopoint, 1,POSITION(',' IN geopoint)-1) as  LAT, Substring(geopoint, POSITION(',' IN geopoint)+1, LENGHT(geopoint)) as LON,  * FROM institution_profile AS i INNER JOIN postalcodes AS p ON i.postal_code = p.postal_code WHERE ST_Distance_Sphere(point(LAT, LON),point(?, ?)) * .0001 < ?";

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