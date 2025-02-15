<?php
    class NotFoundController{

        public function __construct(){}

        public function index(){
          require_once __DIR__ . "/../views/error/404.php";
        }
    } 
?>