<?php


namespace controllers;

use models\User;
use models\VolunteerProfile;
use tools\HttpError;

class VolunteerController extends Controller
{
    private $QUERY_CREATE = "INSERT INTO volunteer_profile (`ganztaegig`, `date_from`, `date_to`, `time_from`, `time_to`, `radius`, `drivinglicense`, `medical_experience`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    private $QUERY_UPDATE = "UPDATE volunteer_profile SET `ganztaegig`=?, `date_from`=?, `date_to`=?, `time_from`=?, `time_to`=?, `radius`=?, `drivinglicense`=?, `medical_experience`=? WHERE `id`=?";
    private $QUERY_BY_USERID = "SELECT * FROM volunteer_profile WHERE `user_id`=? LIMIT 1";
    private $QUERY_BY_ID = "SELECT * FROM volunteer_profile WHERE `id`=? LIMIT 1";

    public function createVolunteerProfile($ganztaegig, $date_from, $date_to, $time_from, $time_to, $radius, $drivinglicense, $medical_experience) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_CREATE);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $ganztaegigSql = (int) $ganztaegig;
        $radiusSql = (int) $radius;
        $drivinglicenseSql = (int) $drivinglicense;
        $medical_experienceSql = (int) $medical_experience;
        $stmt->bind_param("issssiii", $ganztaegigSql, $date_from, $date_to, $time_from, $time_to, $radiusSql, $drivinglicenseSql, $medical_experienceSql);

        if($stmt->execute())
            return $con->insert_id;

        return false;
    }

    public function updateVolunteerProfile($volunteerProfileId, $ganztaegig, $date_from, $date_to, $time_from, $time_to, $radius, $drivinglicense, $medical_experience) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_UPDATE);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $ganztaegigSql = (int) $ganztaegig;
        $radiusSql = (int) $radius;
        $drivinglicenseSql = (int) $drivinglicense;
        $medical_experienceSql = (int) $medical_experience;
        $volunteerProfileIdSql = (int) $volunteerProfileId;
        $stmt->bind_param("issssiii", $ganztaegigSql, $date_from, $date_to, $time_from, $time_to, $radiusSql, $drivinglicenseSql, $medical_experienceSql, $volunteerProfileIdSql);

        return $stmt->execute();
    }

    public function getVolunteerProfileById($id) {
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

    public function getVolunteerProfileByUser(User $user) {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_BY_USERID);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $idSql = (int) $user->id;
        $stmt->bind_param("i", $idSql);

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

    public function isVolunteerProfile(User $user) {
        return $this->getVolunteerProfileByUser($user) != null;
    }
}