<?php
    $path_base = '';
    global $output;    
    
    /* Incluir archivos CSS y Title de la pagina */
    $css_stylesheet = [ array('url_css' => "") ]; //Ruta estilos CSS propios $path_base."/css/path/test.css"
    $css_stylesheet_vendor = [ array('url_css' => "") ]; //Ruta estilos CSS del Vendor  $path_base."/css/path/test.css"
    $name_page = "Dashboard"; //Nombre de pagina
    $breadcrumb =  array( "page"=>"Dashboard", "subpage"=>$name_page); //Miga de Pan (data/false)

    $params_metadata = [ 'title_page' => $name_page, 'css_stylesheet' => $css_stylesheet, 'css_stylesheet_vendor' => $css_stylesheet_vendor];
    $params_wrapper =['name_page' => $name_page, 'has_breadcrumb' => true, 'breadcrumb' => $breadcrumb];

    echo $output->render('head-page', $params_metadata); 
    echo $output->render('body-start-page', $params_wrapper); 
?>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Gestor de Empleados</h4>
        </div>
        <div class="card-body">
            <p>Prueba tecnica desarrollada en PHP v8 construida en un microFramework personalizado bajo MVC con POO, almacenando información en base de datos MySQL y renderizando por medio de Mustache.</p>
            <p>Este pequeño administrador te permitira realizar un CRUD para la gestion de empleados.</p>
            <p><small><i>Desarrollado por Jhoan Avila / <a href="mailto:joria94@hotmail.com">joria94@hotmail.com</a> / <a href="https://api.whatsapp.com/send?phone=573203645490&text=Hola%20Jhoan!" target="_blank">(+57)3203645490</a> / <a href="https://github.com/jhoanrcode" target="_blank">@jhoanrcode</a></i></small></p>
        </div>
    </div>
</section>

<?php
    /* Incluir datos JS de la pagina */
    $js_scripts = [ array('url_js' => "") ]; //Ruta scripts JS propios $path_base."/js/path/test.js"
    $js_scripts_vendor = [ array('url_js' => "") ]; //Ruta scripts JS del Vendor $path_base."/js/path/test.js"
    $params_scriptsJs = [ 'test' => '$js_scripts', 'js_scripts' => $js_scripts, 'js_scripts_vendor' => $js_scripts_vendor, "path_base"=>$path_base];
    echo $output->render('body-end-page', $params_scriptsJs); 
?>