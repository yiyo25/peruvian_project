<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AVIONTIPO
 *
 * @author ihuapaya
 */
class AvionTipo extends Model{
    private $database = DB_NAME;
    protected $table = 'AVIONTIPO';

    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function getAll(){
        $sql_matriculas = "SELECT * FROM ".$this->table;
        $rs_matricula = $this->Consultar($sql_matriculas);
        return $rs_matricula;
    }
    
    public function getRowById($id){
        $sql_fligth = $this->selectData($this->table, array("AVITIP_id"=> $id ));
        return $sql_fligth;
    }
}
