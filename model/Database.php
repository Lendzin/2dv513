<?php
namespace model;

class Database {

    public $settings;

    public function __construct() {
        $this->settings = new \AppSettings();
    }

    public function startMySQLi() {
        $mysqli = new \mysqli($this->settings->localhost, $this->settings->user,
         $this->settings->password, $this->settings->database);
        if ($mysqli->connect_errno) {
            throw new \Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);        
        } else {
            return $mysqli;
        }
    }
    public function killMySQLi($mysqli) : void {
        $thread = $mysqli->thread_id;
        $mysqli->kill($thread);
        $mysqli->close();
    }
}