<?php

namespace model;

// Can be used to add more rules at a later time.
class Password {

    private $password;

    public function __construct(string $password) {
        $errorMessages = "";
        if (!(strlen($password) >= 6)) {
            throw new PasswordTooShortException("Error creating password");    
        }
        $this->password = $password;
    }

    public function get() : string {
        return $this->password;
    }
}