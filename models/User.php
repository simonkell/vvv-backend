<?php
namespace models;

class User
{
    public $id, $email, $forename, $surname, $pass, $role, $active;

    public function hasPermission($level)
    {
        return false; // TODO
    }

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->email = $data->email;
        $this->forename = $data->forename;
        $this->surname = $data->surname;
        $this->pass = $data->pass;
        $this->role = $data->role;
        $this->active = $data->active;
    }


}

?>