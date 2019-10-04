<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ciudad
 *
 * @author ihuapaya
 */
class Ciudad extends Model {
    private $table = "CIUDAD";

    private $database = DB_NAME;

    public function __construct() {
        parent::__construct($this->database);
    }
   

    public function getAll() {
        $sql_ciudad = "SELECT * from ".$this->table." where CIU_estado=1 ORDER BY CIU_id ASC";
        $rs_ciudad = $this->Consultar($sql_ciudad);
        $array_data = array();
        foreach ($rs_ciudad as $ciudad) {
            $array_data[]=$ciudad;
        }
        return $array_data;
    }
    
    public function minutosEntreCiudad($data){
        $sql_minutos = "SELECT RUT_duracion as tiempo "
                    . "FROM RUTA "
                    . "WHERE ciudadOrigen = ? and ciudadDestino = ?";
        $rs_minutos_ciudad = $this->Consultar($sql_minutos,$data);
        return $rs_minutos_ciudad;
        
    }
    
    public  function tiempoEmbarque($origen){
        $sql_tiempembarque = "SELECT ciu_Embarque "
                    . "FROM CIUDAD "
                    . "WHERE CIU_id = '".$origen."'";
        //echo $sql_tiempembarque;
        $rs_tiempo_embarque = $this->Consultar($sql_tiempembarque);
        return $rs_tiempo_embarque;
    }

}
