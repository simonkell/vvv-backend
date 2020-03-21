<?php

namespace controllers;

class UserConfirmation extends Controller
{
    private $QUERY_UPDATE_USER = "UPDATE users SET `active`=? WHERE `ID`=?";

    public function changeUser($userid)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_UPDATE_USER);
        $stmt->bind_param("si", 'true', $userid);
        return $con->query($stmt);
    }
}

(new UserConfirmation()).changeUser($_GET['userid']);