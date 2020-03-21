<?php

namespace controllers;

use models\User;

class UserController extends Controller
{
    public $ROLE_DEFAULT = 1;
    private $QUERY_REGISTER = "INSERT INTO users (`email`, `forename`, `surname`, `pass`, `role`, `active`) VALUES (?, ?, ?, ?, ?, ?)";
    private $QUERY_UPDATE_USER = "UPDATE users SET `email`=?, `forename`=?, `surname`=?, `pass`=?, `role`=?, `active`=? WHERE `ID`=?";
    private $QUERY_USER_BY_EMAIL = "SELECT `id`, `email`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE `email`='?' LIMIT 1";
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

        $stmt = $con->prepare(QUERY_REGISTER);
        $stmt->bind_param("sss", $forename, $surname, $email);
        if($con->query( $stmt)) {

            $this->master->user = $this->getUserByEmail($email);

            return $this->loginUserWithPassCheck($this->master->user, $pass);
        }else{ return false;}
    }

    public function changeUserPassword($db, User $user, $passNew)
    {
        $con = $this->master->db->getConn();

        $password_hashed = $this->hashPassword($passNew);

        $stmt = $con->prepare(QUERY_UPDATE_USER);
        $stmt->bind_param("ssssibi", $user->email, $user->forename, $user->surname, $password_hashed, $user->role, $user->active, $user->id);
        return $con->query( $stmt);
    }

    public function sendUserPasswordEmail(User $user)
    {
        // Ciao
    }

    public function getUserByEmail($email)
    {
        $con = $this->master->db->getConn();

        $stmt = $con->prepare(QUERY_USER_BY_EMAIL);
        $stmt->bind_param("s", $email);
        $result = $con->query( $stmt);
        if ($result && $result->num_rows > 0) {
            $result = $result->fetch_object();

            $this->master->user = new User($result);
            return $this->master->user;
        } else {
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


        $stmt = $con->prepare(QUERY_USER_BY_ID);
        $stmt->bind_param("i", $id);
        $result =  $con->query( $stmt);

        if ($result && $result->num_rows > 0) {
            $result = $result->fetch_object();

            $this->master->user = new User($result);
            return $this->master->user;
        } else {
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