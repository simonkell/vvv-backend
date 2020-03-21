<?php

namespace controllers;

use models\ConfirmationKey;
use models\User;

class ConfirmationKeyController extends Controller
{
    private $QUERY_ADD = "INSERT INTO confirmation (`key`, `user_id`) VALUES (uuid(), ?)";
    private $QUERY_SELECT_BY_KEY = "SELECT `id`, `key`, `user_id` FROM confirmation WHERE `key`=? LIMIT 1";
    private $QUERY_SELECT_BY_USER_ID = "SELECT `id`, `key`, `user_id` FROM confirmation WHERE `user_id`=? LIMIT 1";
    private $QUERY_REMOVE = "DELETE FROM confirmation WHERE `key`=?";

    public function addNewKeyForUser(User $user)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_ADD);
        $idSql = $user->id;
        $stmt->bind_param("i", $idSql);
        $stmt->execute();
        if (!$stmt->error) {
            return getConfirmationKeyByUser($user);
        }

        return false;
    }

    public function removeKey(ConfirmationKey $key)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_REMOVE);
        $stmt->bind_param("s", $key->key);
        return $stmt->execute();
    }

    public function getConfirmationKeyByKey($keyKey)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_SELECT_BY_KEY);
        $stmt->bind_param("s", $keyKey);

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!empty($row)) {
            $key = new ConfirmationKey($row);
            $stmt->free_result();
            $stmt->close();
            return $key;

        } else {
            $stmt->free_result();
            $stmt->close();
            return null;
        }
    }

    public function isExisting($keyKey)
    {
        return ($this->getConfirmationKeyByKey($keyKey) != null);
    }

    public function getConfirmationKeyByUser(User $user)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_SELECT_BY_USER_ID);
        $idSql = (int) $user->id;
        $stmt->bind_param("i", $idSql);

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!empty($row)) {
            $key = new ConfirmationKey($row);
            $stmt->free_result();
            $stmt->close();
            return $key;

        } else {
            $stmt->free_result();
            $stmt->close();
            return null;
        }
    }
}

?>
