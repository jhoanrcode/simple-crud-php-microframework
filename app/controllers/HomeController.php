<?php
    class HomeController{

        public function __construct(){}

        public function index(){
          require_once __DIR__ . "/../views/home/index.php";
        }
    }
?>