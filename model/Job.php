<?php

namespace model;

class Job {
    
    private $id;
    private $start_time;
    private $end_time;
    private $description;
    private $location;
    private $truck;
    private $contractor;
    private $driver;
    private $contact;

    public function __construct($id, $start_time, $end_time, $location, $description,
     $truck, $contractor, $driver, $contact) {
        $this->id = $id;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->location = $location;
        $this->description = $description;
        $this->truck = $truck;
        $this->contractor = $contractor;
        $this->driver = $driver;
        $this->contact = $contact;
    }

    public function getId() {
        return $this->id;
    }
    public function getStart()  {
        return $this->start_time;
    }
    public function getEnd()  {
        return $this->end_time;
    }
    public function getLocation()  {
        return $this->location;
    }
    public function getDescription()  {
        return $this->description;
    }
    public function getTruck()  {
        return $this->truck;
    }
    public function getContractor()  {
        return $this->contractor;
    }
    public function getDriver()  {
        return $this->driver;
    }
    public function getContact() {
        return $this->contact;
    }

}
