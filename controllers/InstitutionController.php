<?php


namespace controllers;

use models\User;
use models\InstitutionProfile;
use tools\HttpError;

class InstitutionController extends Controller
{
    private $QUERY_CREATE = "INSERT INTO institution_profile (`name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    private $QUERY_UPDATE = "UPDATE institution_profile SET `name`=?, `street`=?, `house_number`=?, `postal_code`=?, `city`=?, `description`=?, `user_id`=?, `updated_at`=CURRENT_TIMESTAMP() WHERE `id`=?";
    private $QUERY_BY_USERID = "SELECT * FROM institution_profile WHERE `user_id`=?";
    private $QUERY_BY_ID = "SELECT * FROM institution_profile WHERE `id`=? LIMIT 1";
    private $QUERY_ALL_BY_PLZ = "";

    public function createInstitutionProfile($name, $street, $house_number, $postal_code, $city, $description, $user_id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_CREATE);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $house_numberSql = (int) $house_number;
        $user_idSql = (int) $user_id;
        $stmt->bind_param("ssiissi", $name, $street, $house_numberSql, $postal_code, $city, $description, $user_idSql);

        if($stmt->execute())
            return $con->insert_id;

        return false;
    }

    public function updateInstitutionProfile($institutionProfileId, $name, $street, $house_number, $postal_code, $city, $description, $user_id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_UPDATE);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $house_numberSql = (int) $house_number;
        $user_idSql = (int) $user_id;
        $institutionProfileIdSql = (int) $institutionProfileId;
        $stmt->bind_param("ssiissii", $name, $street, $house_numberSql, $postal_code, $city, $description, $user_idSql, $institutionProfileIdSql);

        return $stmt->execute();
    }

    public function getInstitutionProfileById($id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_BY_ID);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $idSql = (int) $id;
        $stmt->bind_param("i", $idSql);

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!empty($row)) {
            $institutionProfile = new InstitutionProfile($row);
            $stmt->free_result();
            $stmt->close();
            return $institutionProfile;
        } else {
            $stmt->free_result();
            $stmt->close();
            return null;
        }

        return null;
    }

    // TODO: YEP, 1 user has 1 profile - wrong approach, but working
    public function getInstitutionProfilesByUser(User $user) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_BY_USERID);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $idSql = (int) $user->id;
        $stmt->bind_param("i", $idSql);

        $institutionProfileResults = array();

        $stmt->execute();
        $result = $stmt->get_result();
        if($result) {

            while($row = $result->fetch_assoc()) {
                $institutionProfileResults[] = new InstitutionProfile($row);
            }

            $stmt->free_result();
            $stmt->close();
        }

        return $institutionProfileResults;
    }

    public function isInstitutionProfile(User $user) {
        return count($this->getInstitutionProfilesByUser($user)) > 0;
    }
}