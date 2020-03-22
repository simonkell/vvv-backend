<?php

namespace controllers;

use models\ConfirmationKey;
use models\User;
use tools\HttpError;

class ConfirmationKeyController extends Controller
{
    private $QUERY_ADD = "INSERT INTO confirmation (`key`, `user_id`) VALUES (hashKey(uuid()), ?)";
    private $QUERY_SELECT_BY_KEY = "SELECT `id`, `key`, `user_id` FROM confirmation WHERE `key`=? LIMIT 1";
    private $QUERY_SELECT_BY_USER_ID = "SELECT `id`, `key`, `user_id` FROM confirmation WHERE `user_id`=? LIMIT 1";
    private $QUERY_REMOVE = "DELETE FROM confirmation WHERE `key`=?";

    public function addNewKeyForUser(User $user)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_ADD);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }

        $idSql = $user->id;
        $stmt->bind_param("i", $idSql);

        $stmt->execute();
        if (!$stmt->error) {
            return $this->getConfirmationKeyByUser($user);
        }

        return false;
    }

    public function removeKey(ConfirmationKey $key)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_REMOVE);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $stmt->bind_param("s", $key->key);
        return $stmt->execute();
    }

    public function getConfirmationKeyByKey($keyKey)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_SELECT_BY_KEY);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
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
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
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
