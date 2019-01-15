<?php
namespace controller;

class MainController {
    private $startView;

    public function __construct() {

        $this->startView = new \view\StartView();
    }
    
    public function run() {
        $this->startView->render();
     }
}