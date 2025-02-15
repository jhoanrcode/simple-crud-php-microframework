
<?php
    require_once (dirname( __DIR__ ).'/../core/Layout.php');
    global $output;    
    
    /* Incluir archivos CSS y Title de la pagina */
    $css_stylesheet = [ array('url_css' => "") ]; //Ruta estilos CSS propios $path_base."/css/path/test.css"
    $css_stylesheet_vendor = [ array('url_css' => "") ]; //Ruta estilos CSS del Vendor  $path_base."/css/path/test.css"
    $name_page = "Página no encontrada"; //Nombre de pagina
    $breadcrumb =  array( "page"=>"Dashboard", "subpage"=>$name_page); //Miga de Pan (data/false)

    $params_metadata = [ 'title_page' => $name_page, 'css_stylesheet' => $css_stylesheet, 'css_stylesheet_vendor' => $css_stylesheet_vendor];
    $params_wrapper =['name_page' => $name_page, 'has_breadcrumb' => true, 'breadcrumb' => $breadcrumb];

    echo $output->render('head-page', $params_metadata); 
    echo $output->render('body-start-page', $params_wrapper);
?>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Page 404</h4>
        </div>
        <div class="card-body">
            <div class="text-center">
                <img class="img-error" style="max-height: 200px;" src="app/public/assets/compiled/svg/error-404.svg" alt="Not Found">
                <p class="fs-4 text-gray-600 mt-2 mb-0">Page not found.</p>
                <a href="index.php" class="btn btn-outline-primary mt-3">Go Home</a>
            </div>
        </div>
    </div>
</section>

<?php

    /* Incluir datos JS de la pagina */
    $js_scripts = [ array('url_js' => "") ]; //Ruta scripts JS propios $path_base."/js/path/test.js"
    $js_scripts_vendor = [ array('url_js' => "") ]; //Ruta scripts JS del Vendor $path_base."/js/path/test.js"
    $params_scriptsJs = [ 'test' => '$js_scripts', 'js_scripts' => $js_scripts, 'js_scripts_vendor' => $js_scripts_vendor];
    echo $output->render('body-end-page', $params_scriptsJs); 
?>