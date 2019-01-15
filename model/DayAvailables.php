<?php
namespace model;
class DayAvailables {
    private $day;
    private $drivers;
    private $trucks;


    public function __construct($day) {
        $this->day = $day;
        $this->drivers = array();
        $this->trucks = array();
    }

    public function addDriver($driver) {
        array_push($this->drivers, $driver);
    }
    public function addTruck($truck)  {
        array_push($this->trucks, $truck);
    }
    public function getDate() {
        return $this->day;
    }
    public function getDrivers() {
        return $this->drivers;
    }
    public function getTrucks () {
        return $this->trucks;
    }
    public function searchDriver($persnr) {
        foreach ($this->drivers as $driver) {
            if ($driver->getPersnr() == $persnr) {
                return true;
            }
        }
        return false;
    }
    public function searchTruck($regnr) {
        foreach ($this->trucks as $truck) {
            if ($truck->getRegnr() == $regnr) {
                return true;
            }
        }
        return false;
    }
}