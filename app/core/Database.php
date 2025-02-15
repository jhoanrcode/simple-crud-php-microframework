<?php
	require_once __DIR__ .'/Database/db.class.php';
	require_once dirname( __DIR__ ).'/../config.php'; 

	//Configuracion conexion Database
	$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME; $user = DB_USER; $password = DB_PASSWORD;
	$DB = new MeekroDB($dsn, $user, $password);

?>