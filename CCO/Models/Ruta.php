<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ruta
 *
 * @author ihuapaya
 */
class Ruta extends Model{
    private $table = "RUTA";

    private $database = DB_NAME;

    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function existRuta($origen,$destino){
        $data=array($origen,$destino);
        $sql_ruta = "SELECT RUT_ID as id "
                    . "FROM RUTA "
                    . "WHERE RUT_estado=1 and ciudadOrigen = ? and ciudadDestino = ?";
        $rs_ruta = $this->Consultar($sql_ruta,$data);
        
        if(count($rs_ruta)>0){
            return true;
        }
        return false;
    }
    
    public function getAll(){
        $sql_rutas  = "SELECT * FROM ".$this->table;
        $rs_ruta = $this->Consultar($sql_rutas);
        return $rs_ruta;
    }
    
    
}
