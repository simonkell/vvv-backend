<?php


namespace controllers;



use models\InstitutionProfile;

class InstitutionController extends Controller
{
    private $QUERY_CREATE = "INSERT INTO volunteer_profile (`name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())";
    private $QUERY_UPDATE = "UPDATE volunteer_profile SET `name`=?, `street`=?, `house_number`=?, `postal_code`=?, `city`=?, `description`=?, `user_id`=?, `updated_at`=CURRENT_TIMESTAMP() WHERE `id`=?";
    private $QUERY_BY_USERID = "SELECT `id`, `name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at` FROM volunteer_profile WHERE `email`=? LIMIT 1";
    private $QUERY_BY_ID = "SELECT `id`, `name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at` FROM volunteer_profile WHERE `id`=? LIMIT 1";

    public function createInstitutionProfile($name, $street, $house_number, $postal_code, $city, $description, $user_id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_CREATE);
        $stmt->bind_param("ssiissi", $name, $street, $house_number, $postal_code, $city, $description, $user_id);
        if($stmt)
            return false;

        return $stmt->execute();
    }

    public function updateInstitutionProfile($name, $street, $house_number, $postal_code, $city, $description, $user_id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_UPDATE);
        $stmt->bind_param("ssiissi", $name, $street, $house_number, $postal_code, $city, $description, $user_id);
        if(!$stmt)
            return false;

        return $stmt->execute();
    }

    public function getInstitutionProfileById($id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_BY_ID);
        $stmt->bind_param("i", (int) $id);

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

    public function getInstitutionProfileByUserId(User $user) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_BY_USERID);
        $idSql = (int) $user->id;
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
}