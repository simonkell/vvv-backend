<?php
namespace models;

class ConfirmationKey
{
    public $id, $key, $user_id;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->key = $data['key'];
        $this->user_id = $data['user_id'];
    }
}