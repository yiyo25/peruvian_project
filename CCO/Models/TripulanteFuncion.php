<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TripulanteFuncion
 *
 * @author ihuapaya
 */
class TripulanteFuncion extends Model{
    private $database = DB_NAME;
    protected $table = "TripulanteFuncion";
    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function getAll(){
        $sql = "SELECT * FROM ".$this->table." where TRIPFUN_estado=1 order by TRIPFUN_descripcion asc";
        $list= $this->Consultar($sql);
        $data = array();
        foreach ($list as $value) {
            $data[] = $value;
        }
        return $data;
    }
}
