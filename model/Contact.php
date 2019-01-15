<?php

namespace model;

class Contact {
    
    private $name;
    private $address;
    private $phone;
    private $email;
    private $contractor;

    public function __construct($name, $address, $phone, $email, $contractor ) {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
        $this->contractor = $contractor;
    }

    public function getName() {
        return $this->name;
    }
    public function getEmail()  {
        return $this->email;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getContractor() {
        return $this->contractor;
    }
}
