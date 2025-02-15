<?php
    global $output;    
    
    /* Incluir archivos CSS y Title de la pagina */
    $css_stylesheet = [ array('url_css' => "app/public/css/custom-base.css") ]; //Ruta estilos CSS propios $path_base."/css/path/test.css"
    $css_stylesheet_vendor = [ 
      array('url_css' => "app/public/assets/extensions/choices/styles/choices.css"), 
      array('url_css' => "app/public/assets/extensions/toastify/toastify.css"), 
      array('url_css' => "app/public/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css"), 
    ]; //Ruta estilos CSS del Vendor  $path_base."/css/path/test.css"
    $name_page = "Listado de empleados"; //Nombre de pagina
    $breadcrumb =  array( "page"=>"Empleados", "subpage"=>$name_page); //Miga de Pan (data/false)

    $params_metadata = [ 'title_page' => $name_page, 'css_stylesheet' => $css_stylesheet, 'css_stylesheet_vendor' => $css_stylesheet_vendor];
    $params_wrapper =['name_page' => $name_page, 'has_breadcrumb' => true, 'breadcrumb' => $breadcrumb];

    echo $output->render('head-page', $params_metadata); 
    echo $output->render('body-start-page', $params_wrapper);
?>

<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"> Datatable Empleados </h5>
                <button type="button" class="btn btn-primary" onclick="empleadosClass.clearForm('new')" data-bs-toggle="modal" data-bs-target="#newusermodal">Agregar</button>
            </div>
        </div>
        <div class="card-body pt-2">
            <div class="table-responsive">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Genero</th>
                            <th>Area</th>
                            <th>Boletin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="toast-container position-absolute p-3 top-0 end-0" >
        <div class="toast align-items-center alert-success border-0" id="successMessages" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="successMessages_text"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center alert-warning border-0" id="failedMessages" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="failedMessages_text"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</section>

<!-- New User Modal -->
<div class="modal modal-lg fade text-left" id="newusermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form row g-3" action="" id="form-empleado">
                    <div class="col-md-6 col-12">
                      <div class="form-group mandatory">
                        <label for="nombre" class="form-label" >Nombre completo</label >
                        <input type="text" id="nombre" class="form-control" maxlength="50" placeholder="Nombre completo" name="field-nombre" autocomplete="off" data-parsley-required="true" data-parsley-pattern="^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$"/>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group mandatory">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="field-email" placeholder="Email" data-parsley-required="true" data-parsley-type-message="Ingresa un email valido"/>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group mandatory">
                        <fieldset>
                          <label class="form-label">Genero</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="field-genero" id="genero1" data-parsley-required="true"/>
                            <label class="form-check-label form-label" for="genero1">Masculino</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="field-genero" id="genero2"/>
                            <label class="form-check-label form-label" for="genero2">Femenino</label>
                          </div>
                        </fieldset>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group" >
                        <label for="areas" class="form-label">Area</label>
                        <select class="choices form-select" id="areas" name="areas" data-parsley-required="true">
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group mandatory">
                        <label for="descripcion" class="form-label">Experiencia laboral</label>
                        <textarea id="descripcion" class="form-control" name="field-descripcion" rows="3" placeholder="Descripción de experiencia laboral." data-parsley-required="true" data-parsley-maxlength="100" data-parsley-maxlength-message="Excediste el limite de 100 caracters"></textarea>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group mandatory">
                        <fieldset class="list-checkbox"></fieldset>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <div class="form-check">
                          <input type="checkbox" id="boletin" class="form-check-input" checked />
                          <label for="boletin" class="form-check-label form-label">Deseo recibir boletin informativo.</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                      <input type="hidden" name="id">
                      <input type="hidden" name="action">
                      <button type="submit" id="save_data" class="btn btn-primary me-1 mb-1">
                        <span class="indicator-label">Guardar</span>
                        <span class="indicator-progress"><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Cargando...</span>
                      </button>
                      <button type="reset"class="btn btn-light-secondary me-1 mb-1">Reset</button>
                    </div>
                </form>
                <div class="alert alert-light-danger color-danger mt-3 d-none" id="errorMessages"></div>
            </div>     
        </div>
    </div>
</div>

<?php
    /* Incluir datos JS de la pagina */
    $js_scripts = [ array('url_js' => "app/public/js/empleados/index.js") ]; //Ruta scripts JS propios $path_base."/js/path/test.js"
    $js_scripts_vendor = [ 
      array('url_js' => "app/public/assets/extensions/choices/scripts/choices.js"), 
      array('url_js' => "app/public/assets/extensions/toastify/toastify.js"), 
      array('url_js' => "app/public/assets/extensions/parsleyjs/parsley.min.js"), 
      array('url_js' => "app/public/assets/extensions/datatables.net/js/jquery.dataTables.min.js"), 
      array('url_js' => "app/public/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"), 
    ]; //Ruta scripts JS del Vendor $path_base."/js/path/test.js"
    $params_scriptsJs = [ 'test' => '$js_scripts', 'js_scripts' => $js_scripts, 'js_scripts_vendor' => $js_scripts_vendor];
    echo $output->render('body-end-page', $params_scriptsJs); 
?>