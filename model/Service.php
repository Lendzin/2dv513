<?php

namespace model;

class Service {
    
    private $regnr;
    private $past_due;
    private $lubrication;
    private $service;
    private $inspection;

    public function __construct($regnr, $past_due, $lubrication, $service, $inspection ) {
        $this->name = $regnr;
        $this->past_due = $past_due;
        $this->lubrication = $lubrication;
        $this->service = $service;
        $this->inspection = $inspection;
    }

    public function getRegnr() {
        return $this->name;
    }
    public function getService()  {
        return $this->service;
    }
    public function getLubrication() {
        return $this->lubrication;
    }
    public function getPastDue() {
        return $this->past_due;
    }
    public function getInspection() {
        return $this->inspection;
    }
}
