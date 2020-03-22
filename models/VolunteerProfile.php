<?php
namespace models;

class VolunteerProfile
{
    public $id, $name, $time_from, $time_to, $radius, $drivinglicense, $medical_experience, $user_id, $bio, $phone;

    public function __construct($data)
    {
        $this->id = $data["id"];
        $this->time_from = $data["time_from"];
        $this->time_to = $data["time_to"];
        $this->radius = $data["radius"];
        $this->drivinglicense = $data["drivinglicense"];
        $this->medical_experience = $data["medical_experience"];
        $this->postal_code = $data["postal_code"];
        $this->user_id = $data["user_id"];
        $this->bio = $data["bio"];
        $this->phone = $data["phone"];
    }
}