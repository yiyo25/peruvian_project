<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoIncidencia
 *
 * @author ihuapaya
 */
class TipoIncidencia extends Model {
    protected $table = "TipoIncidencia";
    
    public function __construct() {
        parent::__construct(DB_NAME);
    }
    
    public function getAll(){
        
        $query = "SELECT * FROM TipoIncidencia where  Id_incidencia not in(66,65) order by Id_incidencia asc ";
        
        $rs_query = $this->consultar($query);
        $data = array();
                
        foreach ($rs_query as  $value) {
            $dataobj = new stdClass();
            $dataobj->id_incidencia = $value["Id_incidencia"];
            $dataobj->descripcion = htmlentities(($value["Id_incidencia"] . " - " . $value["Descripcion"]));
            $dataobj->detalle_incidencia = htmlentities($value["Detalle"]);
            $data["datainc"][] = $dataobj;
        }
        return $data;
    }
}
