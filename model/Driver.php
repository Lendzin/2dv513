<?php

namespace model;

class Driver {
    
    private $persnr;
    private $name;
    private $address;
    private $phone;
    private $email;
    private $contract_start;
    private $contract_end;
    private $ce_license;
    private $exp_ykb;
    private $fuel_card;
    private $unavailable;

    public function __construct($persnr, $name, $address,  $email, $phone,
     $contract_start, $contract_end, $ce_license, $exp_ykb, $fuel_card, $unavailable ) {
        $this->persnr = $persnr;
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
        $this->contract_start = $contract_start;
        $this->contract_end = $contract_end;
        $this->ce_license = $ce_license;
        $this->exp_ykb = $exp_ykb;
        $this->fuel_card = $fuel_card;
        $this->unavailable = $unavailable;
    }

    public function getPersnr() {
        return $this->persnr;
    }
    public function getName() {
        return $this->name;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function getContractStart() {
        return $this->contract_start;
    }
    public function getContractEnd() {
        return $this->contract_end;
    }
    public function getDLicense() {
        return $this->ce_license;
    }
    public function getYkb() {
        return $this->exp_ykb;
    }
    public function getUnavailable() {
        return $this->unavailable;
    }

}
