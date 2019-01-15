<?php

namespace model;

class Truck {
    
    private $regnr;
    private $model;
    private $min_weight;
    private $axels;
    private $max_weight;
    private $trailer;
    private $equipment;
    private $build_year;
    private $warranty;
    private $last_tested;
    private $last_service;
    private $last_lubrication;
    private $unavailable_period;
    private $rental_period;

    public function __construct($regnr, $model, $min_weight,  $max_weight, $axels,
     $trailer, $equipment, $build_year, $warranty, $last_tested, $last_service, $last_lubrication, $unavailable_period, $rental_period ) {
        $this->regnr = $regnr;
        $this->model = $model;
        $this->min_weight = $min_weight;
        $this->max_weight = $max_weight;
        $this->axels = $axels;
        $this->trailer = $trailer;
        $this->equipment = $equipment;
        $this->build_year = $build_year;
        $this->warranty = $warranty;
        $this->last_tested = $last_tested;
        $this->last_service = $last_service;
        $this->last_lubrication = $last_lubrication;
        $this->unavailable_period = $unavailable_period;
        $this->rental_period = $rental_period;
    }

    public function getRegnr() {
        return $this->regnr;
    }
    public function getModel() {
        return $this->model;
    }
    public function getMin_weight() {
        return $this->min_weight;
    }
    public function getMax_weight() {
        return $this->max_weight;
    }
    public function getAxels() {
        return $this->axels;
    }
    public function getTrailer() {
        return $this->trailer;
    }
    public function getEquipment() {
        return $this->equipment;
    }
    public function getBuildYear() {
        return $this->build_year;
    }
    public function getWarranty() {
        return $this->warranty;
    }
    public function getService() {
        return $this->last_service;
    }
    public function getLubrication() {
        return $this->last_lubrication;
    }
    public function getUnavailable() {
        return $this->unavailable_period;
    }
    public function getRental() {
        return $this->rental_period;
    }

}