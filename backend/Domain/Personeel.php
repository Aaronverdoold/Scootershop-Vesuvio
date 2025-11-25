<?php

namespace Domain;

class Personeel
{
    public $id;
    public $firstname;
    public $lastname;
    public $address;
    public $city;
    public $username;
    public $password;
    public $role;

    public function __construct($id, $firstname, $lastname, $address, $city, $username, $password, $role)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->city = $city;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }
}