<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoVuelo
 *
 * @author ihuapaya
 */
class TipoVuelo extends Model{
    private $database = DB_NAME;

    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function getAll(){
        $sql_tipovuelo = "SELECT * FROM TipoVuelo where IdTipoVuelo in('OW','RT')";
        $rs_tipovuelo = $this->Consultar($sql_tipovuelo);
        return $rs_tipovuelo;
    }
}
