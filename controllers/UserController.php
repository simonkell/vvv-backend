<?php

namespace controllers;

use models\User;
use tools\HttpError;

class UserController extends Controller
{
    public $ROLE_DEFAULT = 1;
    private $QUERY_REGISTER = "INSERT INTO users (`email`, `forename`, `surname`, `pass`, `role`, `active`) VALUES (?, ?, ?, ?, ?, ?)";
    private $QUERY_UPDATE_USER = "UPDATE users SET `email`=?, `forename`=?, `surname`=?, `pass`=?, `role`=?, `active`=? WHERE `ID`=?";
    private $QUERY_USER_BY_EMAIL = "SELECT `id`, `email`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE LOWER(`email`)=? LIMIT 1";
    private $QUERY_USER_BY_ID = "SELECT `id`, `email`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE `id`=? LIMIT 1";

    private function hashPassword($password)
    {
        $options = ['cost' => 11];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function registerUser($email, $forename, $surname, $pass, $role, $active = 0)
    {
        $con = $this->master->db->getConn();

        $password_hashed = $this->hashPassword($pass);

        $stmt = $con->prepare($this->QUERY_REGISTER);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $roleSql = (int) $role;
        $activeSql = ($active == 1 ? true : false);
        $stmt->bind_param("ssssib", $email, $forename, $surname, $password_hashed, $roleSql, $activeSql);
        $stmt->execute();
        if (!$stmt->error) {
            $this->master->user = $this->getUserByEmail($email);

            // Send confirmation! TODO @Jocy!?
             $key = $this->master->confirmationKeyController->addNewKeyForUser($this->master->user);
            $this->master->mailerController->sendMail($key, $this->master->user->email);

            return $this->loginUserWithPassCheck($this->master->user, $pass);
        }

        return false;
    }

    public function changeUser(User $user)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_UPDATE_USER);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $roleIdSql = (int) $user->role;
        $activeSql = ($user->active == 1 ? true : false);
        $idSql = (int) $user->id;
        $stmt->bind_param("ssssiib", $user->email, $user->forename, $user->surname, $user->pass, $roleIdSql, $idSql, $activeSql);

        return $stmt->execute();
    }

    public function changeUserPassword(User $user, $passNew)
    {
        //$user->pass= $passNew;
        //this->changeUser( $user);
        $con = $this->master->db->getConn();

        $password_hashed = $this->hashPassword($passNew);

        $stmt = $con->prepare($this->QUERY_UPDATE_USER);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $roleIdSql = (int) $user->role;
        $activeSql = ($user->active == 1 ? true : false);
        $idSql = (int) $user->id;
        $stmt->bind_param("ssssiib", $user->email, $user->forename, $user->surname, $password_hashed, $roleIdSql, $idSql, $activeSql);

        return $stmt->execute();
    }

    public function sendUserPasswordEmail(User $user)
    {
        // Ciao
    }

    public function getUserByEmail($email)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_USER_BY_EMAIL);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $stmt->bind_param("s", $email);

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!empty($row)) {
            $user = new User($row);
            $stmt->free_result();
            $stmt->close();
            return $user;

        } else {
            $stmt->free_result();
            $stmt->close();
            return null;
        }
    }

    public function isExisting($email)
    {
        return ($this->getUserByEmail($email) != null);
    }

    public function getUserById($id)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare($this->QUERY_USER_BY_ID);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return null;
        }
        $idSql = (int) $id;
        $stmt->bind_param("i", $idSql);

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!empty($row)) {
            $user = new User($row);
            $stmt->free_result();
            $stmt->close();
            return $user;

        } else {
            $stmt->free_result();
            $stmt->close();
            return null;
        }
    }

    public function loginUserWithPassCheck(User $user, $password)
    {
        if (password_verify($password, $user->pass)) {
            $_SESSION[SESSION_NAME_USERID] = $user->id;
            return true;
        }

        // Log session login?

        return false;
    }

    public function logout()
    {
        session_destroy();
    }
}

?>
