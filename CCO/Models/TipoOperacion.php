<?php
/*namespace cco_dev\Models;
use cco_dev\app\Model as Model;*/

class TipoOperacion extends Model{
    
    private $database = DB_NAME;

    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function getAll(){
        $sql_tipovuelo = "SELECT * FROM TipoOperacion";
        $rs_tipovuelo = $this->Consultar($sql_tipovuelo);
        return $rs_tipovuelo;
    }
}
