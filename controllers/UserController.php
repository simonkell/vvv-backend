<?php

namespace controllers;

use models\User;
use tools\HttpError;

class UserController extends Controller
{
    public $ROLE_DEFAULT = 1;
    private $QUERY_REGISTER = "INSERT INTO users (`email`, `forename`, `surname`, `pass`, `role`, `active`) VALUES (LOWER(?), ?, ?, ?, ?, ?)";
    private $QUERY_UPDATE_USER = "UPDATE users SET `email`=LOWER(?), `forename`=?, `surname`=?, `pass`=?, `role`=?, `active`=? WHERE `id`=?";
    private $QUERY_UPDATE_USER_PASSWORD = "UPDATE users SET `pass`=? WHERE `id`=?";
    private $QUERY_USER_BY_EMAIL = "SELECT `id`, `email`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE `email`=? LIMIT 1";
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
        $activeSql = (int) $active;
        $stmt->bind_param("ssssii", $email, $forename, $surname, $password_hashed, $roleSql, $activeSql);
        $stmt->execute();
        if (!$stmt->error) {
            $this->master->user = $this->getUserByEmail($email);

            // Send confirmation
            $key = $this->master->confirmationKeyController->addNewKeyForUser($this->master->user);
            if($this->master->mailerController->sendMail($key, $this->master->user->email))
                return $this->loginUserWithPassCheck($this->master->user, $pass);
            else
                return false;
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
        $activeSql = (int) $user->active;
        $idSql = (int) $user->id;
        $stmt->bind_param("ssssiii", $user->email, $user->forename, $user->surname, $user->pass, $roleIdSql, $activeSql, $idSql);

        $stmt->execute();
        if(!$stmt->error) {
            if($activeSql == 0) {
                // Send confirmation
                $key = $this->master->confirmationKeyController->addNewKeyForUser($user);
                if($this->master->mailerController->sendMail($key, $user->email))
                    return true;
                else
                    return false;
            }
            return true;
        }

        return false;
    }

    public function changeUserPassword(User $user, $passNew)
    {
        $con = $this->master->db->getConn();

        $password_hashed = $this->hashPassword($passNew);

        $stmt = $con->prepare($this->QUERY_UPDATE_USER_PASSWORD);
        if(!$stmt) {
            $this->master->errorResponse(new HttpError(500, "There was something wrong with that statement: (" . $con->errno .")" . $con->error));
            return false;
        }
        $idSql = (int) $user->id;
        $stmt->bind_param("si", $password_hashed, $idSql);

        $stmt->execute();
        if(!$stmt->error)
            return true;

        return false;
    }

    public function sendUserEmail(User $user)
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
