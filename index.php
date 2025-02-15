<?php
    require_once __DIR__."/app/router/routes.php";
    require_once __DIR__."/app/core/init.php";
    require_once __DIR__."/app/core/Layout.php";

    $core = new Core($routes);
    $page = $core->run();
?>
