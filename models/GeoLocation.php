<?php
namespace models;

class GeoLocation
{
    public $lat, $lon;

    public function __construct($data)
    {
        $this->lat = $data['LAT'];
        $this->lon = $data['LON'];
    }


}