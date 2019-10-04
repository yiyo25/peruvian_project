<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VueloIncidencia
 *
 * @author ihuapaya
 */
class VueloIncidencia extends Model{
    protected  $table = "Vuelo_Incidencia";
    protected $database = DB_NAME;
    
    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function save($values){
        
        return $this->insertData($this->table, $values);
    }
    
    public  function getByIdDetalle($id_vuelo_detalle=""){
        
        $sql = "SELECT b.Id_incidencia as codigo, a.id_vuelo_incidencias, a.id_vuelo_detalle,b.Descripcion, a.observacion, b.Detalle as detalle
                FROM Vuelo_Incidencia a 
                inner join TipoIncidencia b on(a.id_incidencia=b.Id_incidencia)
                inner join Vuelo_Detalle c on (a.id_vuelo_detalle = c.id_vuelo_detalle)
                where 
                c.id_vuelo_detalle = '".$id_vuelo_detalle."'";
        
        $incidencias =  $this->Consultar($sql);
        $data = array();
        foreach ($incidencias as $key => $value) {
             $data[$key]["codigo"]= $value["codigo"];
            $data[$key]["id_vuelo_incidencias"]= $value["id_vuelo_incidencias"];
            $data[$key]["id_vuelo_detalle"]= $value["id_vuelo_detalle"];
            $data[$key]["Descripcion"]= htmlentities(($value["Descripcion"]));
             $data[$key]["detalle"]= htmlentities($value["detalle"]);
            $data[$key]["observacion"]= htmlentities($value["observacion"]);
                    
        }
        /*echo "<pre>";
        print_r($incidencias);
        echo "</pre>";exit;*/
        return $data;
    }
    
    
    
    public  function getAll($limit=""){
        
        $top="";
        if($limit!=""){
            $top = "TOP ". $limit;
        }
        $sql = "SELECT ".$top." a.id_vuelo_incidencias,b.Id_incidencia, a.id_vuelo_detalle,b.Descripcion, a.observacion
                FROM Vuelo_Incidencia a 
                inner join TipoIncidencia b on(a.id_incidencia=b.Id_incidencia)
                inner join Vuelo_Detalle c on (a.id_vuelo_detalle = c.id_vuelo_detalle)";
        
        return $this->Consultar($sql);
    }
    
    
    public function deleteVueloIncidencia($id_vuelo_incidencia)
    {
        $delete_vuelo_tripulacion = "delete from Vuelo_Incidencia where id_vuelo_incidencias='".$id_vuelo_incidencia."'";
        
        $count=$this->exec($delete_vuelo_tripulacion);
        //echo $count;
        if($count>0){
            return true;
        }
        return false;
    }
}
