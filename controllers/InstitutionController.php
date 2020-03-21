<?php


namespace controllers;



use models\InstitutionProfile;

class InstitutionController extends Controller
{
    private $QUERY_CREATE = "INSERT INTO volunteer_profile (`name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at`) VALUES ('%s', '%s', '%d', '%d', '%s', '%d', CURRENT_TIMESTAMP())";
    private $QUERY_UPDATE = "UPDATE volunteer_profile SET `name`='%s', `street`='%s', `house_number`='%d', `postal_code`='%d', `city`='%d', `description`='%s', `user_id`='%d', `updated_at`=CURRENT_TIMESTAMP() WHERE `id`='%d'";
    private $QUERY_BY_USERID = "SELECT `id`, `name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at` FROM volunteer_profile WHERE `email`='%s' LIMIT 1";
    private $QUERY_BY_ID = "SELECT `id`, `name`, `street`, `house_number`, `postal_code`, `city`, `description`, `user_id`, `updated_at` FROM volunteer_profile WHERE `id`='%d' LIMIT 1";

    public function createInstitutionProfile($name, $street, $house_number, $postal_code, $city, $description, $user_id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare(sprintf($this->QUERY_CREATE, $name, $street, $house_number, $postal_code, $city, $description, $user_id));
        if($stmt)
            return false;

        return $stmt->execute();
    }

    public function updateInstitutionProfile($name, $street, $house_number, $postal_code, $city, $description, $user_id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare(sprintf($this->QUERY_UPDATE, $name, $street, $house_number, $postal_code, $city, $description, $user_id));
        if(!$stmt)
            return false;

        return $stmt->execute();
    }

    public function getInstitutionProfileById($id) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare(sprintf($this->QUERY_BY_ID, $id));
        if(!$stmt->execute())
            return false;

        $result = $stmt->get_result();
        $result = $result->fetch_object();
        return new InstitutionProfile($result);
    }

    public function getInstitutionProfileByUser(User $user) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare(sprintf($this->QUERY_BY_USERID, $user->id));
        if(!$stmt->execute())
            return false;

        $result = $stmt->get_result();
        $result = $result->fetch_object();
        return new InstitutionProfile($result);
    }
}