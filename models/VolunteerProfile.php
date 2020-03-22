<?php
namespace models;

class VolunteerProfile
{
    public $id, $name, $ganztaegig, $date_from, $date_to, $time_from, $time_to, $radius, $drivinglicense, $medical_experience;

    public function __construct($data)
    {
        $this->id = $data["id"];
        $this->ganztaegig = $data["ganztaegig"];
        $this->date_from = $data["date_from"];
        $this->date_to = $data["date_to"];
        $this->time_from = $data["time_from"];
        $this->time_to = $data["time_to"];
        $this->radius = $data["radius"];
        $this->drivinglicense = $data["drivinglicense"];
        $this->medical_experience = $data["medical_experience"];
    }
}

?>