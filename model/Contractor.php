<?php

namespace model;

class Contractor {
    
    private $name;
    private $description;
    private $address;
    private $phone;
    private $email;

    public function __construct($name, $description, $address, $phone, $email ) {
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function getName() {
        return $this->name;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getEmail() {
        return $this->email;
    }
}
