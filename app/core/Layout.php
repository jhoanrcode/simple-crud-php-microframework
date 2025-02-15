<?php
	require_once __DIR__ .'/Mustache/Autoloader.php';
	
	//Configuracion archivos Mustache
	Mustache_Autoloader::register();
	$output = new Mustache_Engine(
		array(
			'loader' => new Mustache_Loader_FilesystemLoader(dirname( __DIR__ ) . '/templates'),
			'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname( __DIR__ ) . '/templates/partials')
		)
	);
?>