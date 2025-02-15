<?php
    class EmpleadoController{

        public function __construct(){}

        public function index(){
          require_once __DIR__ . "/../views/empleados/index.php";
        }
    } 
?>