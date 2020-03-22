<?php


namespace controllers;


abstract class Controller
{
    protected $master;

    public function __construct(MasterController $master)
    {
        $this->master = $master;
    }
}