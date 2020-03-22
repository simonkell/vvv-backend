<?php


namespace controllers;

use models\InstitutionProfile;
use models\User;
use models\GeoLocation;
use tools\HttpError;

class ProfileRadiusController extends Controller
{
    /*
     * $QUERY_VOLUNTEER_GEOLOCATIONS_BY_USERID
     SELECT
        SUBSTRING(`geopoint`, 1, POSITION(',' IN `geopoint`)-1) as  LAT,
        SUBSTRING(`geopoint`, POSITION(',' IN `geopoint`)+1, LENGTH(`geopoint`)) as LON, v.user_id
        FROM volunteer_profile AS v INNER JOIN postalcodes AS p ON v.postal_code = p.postal_code
    WHERE user_id=?;
     */

    /*
    SELECT *,
    SUBSTRING(`geopoint`, 1, POSITION(',' IN `geopoint`)-1) as LAT,
    SUBSTRING(`geopoint`, POSITION(',' IN `geopoint`)+1, LENGTH(`geopoint`)) as LON
    FROM institution_profile AS i INNER JOIN postalcodes AS p ON i.postal_code = p.postal_code
    HAVING ST_Distance_Sphere(point(LAT, LON), point(51.444108347, 7.31537780144)) * .0001 < 15;
     */

    private $QUERY_VOLUNTEER_GEOLOCATIONS_BY_USERID = "SELECT SUBSTRING(`geopoint`, 1, POSITION(',' IN `geopoint`)-1) as  LAT, SUBSTRING(`geopoint`, POSITION(',' IN `geopoint`)+1, LENGTH(`geopoint`)) as LON, v.user_id FROM volunteer_profile AS v INNER JOIN postalcodes AS p ON v.postal_code = p.postal_code WHERE user_id=?;";
    private $QUERY_IN_RADIUS_BY_GEOLOCATIONS = "SELECT *, SUBSTRING(`geopoint`, 1, POSITION(',' IN `geopoint`)-1) as LAT, SUBSTRING(`geopoint`, POSITION(',' IN `geopoint`)+1, LENGTH(`geopoint`)) as LON FROM institution_profile AS i INNER JOIN postalcodes AS p ON i.postal_code = p.postal_code HAVING ST_Distance_Sphere(point(LAT, LON), point(?, ?)) * .0001 < ?;";

    public function getInstitutionProfilesByRadiusAndGeo($radiusInKilometer, GeoLocation $geo) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_IN_RADIUS_BY_GEOLOCATIONS);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .") " . $con->error));
            return null;
        }
        $radiusInKilometerSql = (int) $radiusInKilometer;
        $stmt->bind_param("ddi", $geo->lat, $geo->lon, $radiusInKilometerSql);

        $stmt->execute();
        $result = $stmt->get_result();

        $nearbyInstitutions = array();
        if($result) {
            while ($row = $result->fetch_assoc()) {
                $nearbyInstitutions[] = new InstitutionProfile($row);
            }
            $stmt->free_result();
            $stmt->close();
            return $nearbyInstitutions;
        }

        return $nearbyInstitutions;
    }

    public function getGeoCodeForVolunteerUser(User $user) {
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