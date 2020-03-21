<?php


namespace controllers;


abstract class Controller
{
    protected $master;

    public function __construct($master)
    {
        $this->master = $master;
    }
}