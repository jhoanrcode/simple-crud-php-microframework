<?php

require_once __DIR__."/../../core/Database.php";

class EmpleadoModel {

    public static function run() {
        $obj = new self();
        $data_ajax = $_POST;
        switch ($data_ajax["opcn"]) {
            case 'get_empleados':
                $result = $obj->get_empleados();
                break;
            case 'get_areas':
                $result = $obj->get_areas();
                break;
            case 'get_roles':
                $result = $obj->get_roles();
                break;
            case 'get_empleado_by_id':
                $result = $obj->get_empleado_by_id($data_ajax);
                break;
            case 'create_empleados':
                $result = $obj->create_empleados($data_ajax);
                break;
            case 'update_empleados':
                $result = $obj->update_empleados($data_ajax);
                break;
            case 'delete_empleados':
                $result = $obj->remove_empleados($data_ajax);
                break;
            default:
                $result = false;
                break;
        }
        echo json_encode($result);
    }

    /**
      * Consultamos Empleados existentes.
     */
    public function get_empleados() {
        global $DB;

        $data_items = array();
        $data_items = $DB->query("SELECT empleados.id, empleados.nombre, empleados.email, empleados.genero, areas.nombre AS area, empleados.boletin 
            FROM empleados INNER JOIN areas ON empleados.area_id = areas.id");
        //Si se obtuvo registro 
        if ( !empty($data_items) ) { return array("state"=>true, "data_empleados"=>$data_items); } 
        else { return array("state"=>false); }
    }

    /**
      * Consultamos Empleado especifico.
     */
    public function get_empleado_by_id($datos) {
        global $DB;

        $data_items = array();
        $data_items = $DB->queryFirstRow("SELECT * FROM empleados WHERE id = %i", $datos["id"]);
        $data_items_rol = $DB->queryFirstColumn("SELECT rol_id FROM empleado_rol WHERE empleado_id = %i", $datos["id"]);
        $data_items["roles"] = implode(",", $data_items_rol);

        //Si se obtuvo registro 
        if ( !empty($data_items) ) { return array("state"=>true, "data_empleado"=>$data_items); } 
        else { return array("state"=>false); }
    }

    /**
      * Consultamos Empleado especifico.
     */
    public function get_empleado_by_email($email, $idempleado = "") {
        global $DB;
        $data_items = array();
        $data_items = $DB->query("SELECT * FROM empleados WHERE email = %s AND id <> %s", $email, $idempleado);
        //Si se obtuvo registro 
        if ( !empty($data_items) ) { return true; } 
        else { return false; }
    }

    /**
      * Consultamos Areas existentes.
     */
    public function get_areas() {
        global $DB;

        $data_items = array();
        $data_items = $DB->query("SELECT * FROM areas");
        //Si se obtuvo registro 
        if ( !empty($data_items) ) {
            foreach ($data_items as $key => $value) {
                $new_data_items[] = array(
                    "value" => $value['id'],
                    "label" => $value['nombre'],
                    "selected" => ($key==0) ? true : false,
                    "disabled" => false,
                );
            }
            return array("state"=>true, "data_items"=>$new_data_items);
        } else {
            return array("state"=>false);
        }
    }

    /**
      * Consultamos Roles existentes.
     */
    public function get_roles() {
        global $DB;

        $data_items = array();
        $data_items = $DB->query("SELECT * FROM roles");
        //Si se obtuvo registro 
        if ( !empty($data_items) ) { return array("state"=>true, "data_roles"=>$data_items); } 
        else { return array("state"=>false); }
    }

    /**
      * Creamos datos Empleado.
      * @param    array    $datos   Datos.
     */
    public function create_empleados($datos) {
        global $DB;
        $record = array(
            "nombre" => $datos["nombre"],
            "email" => $datos["email"],
            "genero" => $datos["genero"],
            "area_id" => $datos["area_id"],
            "boletin" => $datos["boletin"],
            "descripcion" => $datos["descripcion"]
        );

        if( !$this->get_empleado_by_email($datos["email"]) ){
            try {
                if( $DB->insert('empleados', $record) ) { 
                    $newEmpleado_id = $DB->insertId(); 

                    if( $this->create_empleado_rol($newEmpleado_id,$datos["roles"]) ) { return array("state"=>true, "message"=>"Empleado ha sido creado con éxito."); }
                    else { return array("state"=>false, "message"=>"Ups! Empleado no fue asociado a rol, por favor inténtalo de nuevo.");  }
                } else { 
                    return array("state"=>false, "message"=>"Ups! Empleado no fue creado, por favor inténtalo de nuevo."); 
                }
            } catch (\Throwable $th) {
                return array("state"=>false, "message"=>"Ups! Algo salio mal."); //throw $th;
            }
        } else {
            return array("state"=>false, "message"=>"Este email ya se encuentra registrado."); //throw $th;
        }
    }

    /**
      * Creamos datos Empleado-Rol.
      * @param    array    $datos   Datos.
     */
    public function create_empleado_rol($idempleado, $idroles) {
        global $DB;
        $records = [];
        $arrayRoles = explode(",", $idroles);

        foreach ($arrayRoles as $value) { 
            $records[] = ['empleado_id' => $idempleado, 'rol_id' => $value];
        }

        if( $DB->insert('empleado_rol', $records) ) { return true; }
        else { return false;  }        
    }

    /**
      * Actualizamos datos.
      * @param    array    $datos   Datos.
     */
    public function update_empleados($datos) {
        global $DB;
        $record = array(
            "nombre" => $datos["nombre"],
            "email" => $datos["email"],
            "genero" => $datos["genero"],
            "area_id" => $datos["area_id"],
            "boletin" => $datos["boletin"],
            "descripcion" => $datos["descripcion"]
        );

        if( !$this->get_empleado_by_email($datos["email"], $datos["id"]) ){
            $where = array( "id" => $datos["id"] );
            try {
                if( $this->remove_empleado_rol($datos["id"]) ){
                    $DB->update('empleados', $record, $where);
                    if( $this->create_empleado_rol($datos["id"],$datos["roles"]) ) { return array("state"=>true, "message"=>"Empleado ha sido actualizado con éxito."); }
                    else { return array("state"=>false, "message"=>"Ups! Empleado no fue actualizado, por favor inténtalo de nuevo."); }    
                }

            } catch (\Throwable $th) {
                return array("state"=>false, "message"=>"Ups! Algo salio mal."); //throw $th;
            }
        } else {
            return array("state"=>false, "message"=>"Este email ya se encuentra registrado."); //throw $th;
        }
    }

    /**
      * Eliminamos dato Empleado.
      * @param    array    $datos   Datos.
     */
    public function remove_empleados($datos) {
        global $DB;
        $where = array( "id" => $datos["id"] );
        try {
            if( $this->remove_empleado_rol($datos["id"]) ){
                $DB->delete('empleados', $where);
                if( $DB->affectedRows() ) { return array("state"=>true, "message"=>"Empleado ha sido eliminado con éxito."); }
                else { return array("state"=>false, "message"=>"Ups! Empleado no fue eliminado, por favor inténtalo de nuevo."); }   
            }
        } catch (\Throwable $th) {
            return array("state"=>false, "message"=>"Ups! Algo salio mal."); //throw $th;
        } 
    }
    
    /**
      * Eliminamos dato Empleado-Rol.
      * @param    array    $datos   Datos.
     */
    public function remove_empleado_rol($idempleado) {
        global $DB;
        $where = array( "empleado_id" => $idempleado );
        try {
            $DB->delete('empleado_rol', $where);
            if( $DB->affectedRows() ) { return true; }
            else { return false; }
        } catch (\Throwable $th) {
            return false; //throw $th;
        } 
    }

} EmpleadoModel::run();
