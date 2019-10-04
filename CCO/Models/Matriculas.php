<?php


class Matriculas extends Model{
    
    private $table = "Matriculas";
    private $database = DB_NAME;

    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function getAll(){
        $sql_matriculas = "SELECT IdMatricula as id, nombre as matricula,CodigoAvion,nro_pasajeros,nro_pasajeros_permitido,capacidad_carga FROM Matriculas";
        $rs_matricula = $this->Consultar($sql_matriculas);
        return $rs_matricula;
    }
    
    public function getRowById($id){
        $sql_fligth = $this->selectData($this->table, array("id_vuelo_detalle"=> $id ));
        return $sql_fligth;
    }
}
