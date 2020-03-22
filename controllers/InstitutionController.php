<?php


namespace controllers;

use models\User;
use models\InstitutionProfile;
use tools\HttpError;

class InstitutionController extends Controller
{
    private $QUERY_CREATE = "INSERT INTO institution_profile (`name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    private $QUERY_UPDATE = "UPDATE institution_profile SET `name`=?, `street`=?, `house_number`=?, `postal_code`=?, `city`=?, `description`=?, `user_id`=?, `updated_at`=CURRENT_TIMESTAMP() WHERE `id`=?";
    private $QUERY_BY_USERID = "SELECT `id`, `name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at` FROM institution_profile WHERE `email`=? LIMIT 1";
    private $QUERY_BY_ID = "SELECT `id`, `name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at` FROM institution_profile WHERE `id`=? LIMIT 1";

    public function createInstitutionProfile($name, $street, $house_number, $postal_code, $city, $description, $user_id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_CREATE);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $house_numberSql = (int) $house_number;
        $postal_codeSql = (int) $postal_code;
        $user_idSql = (int) $user_id;
        $stmt->bind_param("ssiissi", $name, $street, $house_numberSql, $postal_codeSql, $city, $description, $user_idSql);

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
        $postal_codeSql = (int) $postal_code;
        $user_idSql = (int) $user_id;
        $institutionProfileIdSql = (int) $institutionProfileId;
        $stmt->bind_param("ssiissii", $name, $street, $house_numberSql, $postal_codeSql, $city, $description, $user_idSql, $institutionProfileIdSql);

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
        $stmt->bindParam(1, $idSql);

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

    public function getInstitutionProfilesByUser(User $user) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_BY_USERID);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $stmt->bind_param("i", (int) $user->id);

        $institutionProfileResults = array();
        if($stmt->execute()) {
            while($row = $stmt->get_result()->fetch_assoc()) {
                $institutionProfileResults[] = new InstitutionProfile($row);
            }

            $stmt->free_result();
            $stmt->close();
        }

        return $institutionProfileResults;
    }
}