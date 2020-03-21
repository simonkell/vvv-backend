<?php
namespace models;

class InstitutionProfile
{
    public $id, $name, $street, $house_number, $postal_code, $city, $description, $user_id, $created_at, $updated_at;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->street = $data->street;
        $this->house_number = $data->house_number;
        $this->postal_code = $data->postal_code;
        $this->city = $data->city;
        $this->description = $data->description;
        $this->user_id = $data->user_id;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
    }


}

?>