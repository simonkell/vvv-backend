<?php


namespace controllers;

use models\User;
use models\VolunteerProfile;
use tools\HttpError;

class ProfileRadiusController extends Controller
{
    private $QUERY_IN_RADIUS_BY_POSTCODE = "SELECT * FROM instiution_profile WHERE `user_id`=? LIMIT 1";

    public function getInstitutionProfilesByRadiusAndPostcode($radiusInKilometer, $postcodeOfCenter) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_IN_RADIUS_BY_POSTCODE);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $radiusInKilometerSql = (int) $radiusInKilometer;
        $postcodeOfCenterSql = (int) $postcodeOfCenter;
        $stmt->bind_param("ii", $radiusInKilometerSql, $postcodeOfCenterSql);

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
}