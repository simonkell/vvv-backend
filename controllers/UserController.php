<?php

namespace controllers;

use models\User;

class UserController extends Controller
{
    public $ROLE_DEFAULT = 1;
    private $QUERY_REGISTER = "INSERT INTO users (`email`, `forename`, `surname`, `pass`, `role`, `active`) VALUES (?,?,?,?,?,?)";
    private $QUERY_UPDATE_PASSWORD = "UPDATE `users` SET `email`=?, `forename`=?, `surname`=?, `pass`=?, `role`=?, `active`=? WHERE `ID`=?";
    private $QUERY_USER_BY_EMAIL = "SELECT `id`, `email`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE `email`=? LIMIT 1";
    private $QUERY_USER_BY_ID = "SELECT `id`, `email`, `forename`, `surname`, `pass`, `role`, `active` FROM users WHERE `id`=? LIMIT 1";


    private function hashPassword($password)
    {
        //default is 12, the higher the better
        $options = ['cost' => 12];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function registerUser($email, $forename, $surname, $pass, $role, $active = 0)
    {
        $con = $this->master->db->getConn();

        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
            //die("Connection failed: ".$con->connect_error);
        }

        $password_hashed = $this->hashPassword($pass);

        try {
            $sprep = $con->prepare($this->QUERY_REGISTER);
            $sprep->bindParam('ssssdi', $email, $forename, $surname, $password_hashed, $role, $active);
            $sprep->execute();
            $sprep->close();
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        }

        $this->master->user = $this->getUserByEmail($email);

        return $this->loginUserWithPassCheck($this->master->user, $pass);
    }

    public function changeUserPassword(User $user, $passNew)
    {
        $con = $this->master->db->getConn();

        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
        }

        $password_hashed = $this->hashPassword($passNew);

        $status = false;
        try {
            $sprep = $con->prepare($this->QUERY_UPDATE_PASSWORD);
            $sprep->bindParam('ssssdid', $user->email, $user->forename, $user->surname, $password_hashed, $user->role, $user->active, $user->id);
            $status = $sprep->execute();
            $sprep->close();
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        }

        return $status;
    }

    public function sendUserPasswordEmail(User $user)
    {
        // Ciao
    }

    public function getUserByEmail($email)
    {
        $con = $this->master->db->getConn();

        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
        }

        $result = false;
        try {
            $sprep = $con->prepare($this->QUERY_USER_BY_EMAIL);
            $sprep->bindParam('s', $email);
            $sprep->execute();
            $result = $sprep->get_result();
            $sprep->close();
        }catch(PDOException $e){
            error_log("Error: " . $e->getMessage());
        }

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

        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
        }

        $result = false;

        try {
            $sprep = $con->prepare($this->QUERY_USER_BY_ID);
            $sprep->bindParam('d', $id);
            $result = $sprep->get_result();
            $sprep->close();
        }catch(PDOException $e){
            error_log("Error: " . $e->getMessage());
        }

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