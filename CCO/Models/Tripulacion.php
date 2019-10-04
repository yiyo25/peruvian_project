<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tripulacion
 *
 * @author ihuapaya
 */
class Tripulacion extends Model{
    
    private $database = DB_NAME;
    protected $table = "Tripulante";
    public function __construct() {
        parent::__construct($this->database);
    }
    
    public function getAll($search="",$function=""){
        $where_search = "";
        if($search != ""){
            if($function==""){
                $where_search= " WHERE TRIP_numdoc like '%".$search."%'";
                $where_search.= " or (TRIP_apellido like '%".$search."%')";
                $where_search.= " or (TRIP_nombre like '%".$search."%')";
                $where_search.= " or (TRIP_apellido like '%".$search."%')";
            }else{
                $where_search= " and TRIP_numdoc like '%".$search."%'";
                $where_search.= " or (TRIP_apellido like '%".$search."%')";
                $where_search.= " or (TRIP_nombre like '%".$search."%')";
                $where_search.= " or (TRIP_apellido like '%".$search."%')";
            }
            
        }
        switch ($function) {
            case "TV":
                
                $sql = "SELECT * FROM  TRIPULANTE tt 
                        INNER JOIN TRIPULANTEFUNCION tf ON (tt.TRIPFUN_id=tf.TRIPFUN_id)
                        WHERE  
                        tf.TIPTRIPU_codigo='TV' ".$where_search."
                        ORDER BY tt.TRIPFUN_id ASC, TRIP_apellido ASC";

                break;
            case "TC":
                $sql = "SELECT * FROM  TRIPULANTE tt 
                        INNER JOIN TRIPULANTEFUNCION tf ON (tt.TRIPFUN_id=tf.TRIPFUN_id)
                        WHERE  
                        tf.TIPTRIPU_codigo='TC' ".$where_search."
                        ORDER BY tt.TRIPFUN_id ASC, TRIP_apellido ASC";

                break;
            default:
                $sql = "SELECT * FROM  TRIPULANTE tt 
                        INNER JOIN TRIPULANTEFUNCION tf ON (tt.TRIPFUN_id=tf.TRIPFUN_id)
                           ".$where_search."
                        ORDER BY tt.TRIPFUN_id ASC, TRIP_apellido ASC";
                break;
        }
        
        $list= $this->Consultar($sql);
        $data = array();
        foreach ($list as $value) {
            $data[] = $value;
        }
        return $data;
    }
    
    public function getRowById($id){
        $list_tripulante = $this->selectData($this->table, array("TRIP_id"=> $id ));
        $data = array();
        foreach ($list_tripulante as $value) {
            $data[] = $value;
        }

        return $data;
    }


    public function getTripulacionByFunction($functionName){
        
        switch ($functionName) {
            case "cabina":
                //$sql_tripulacion = "select * from ".$this->table." where IdTipoTripulacion=1 and activado=1 order by id_funcion asc, apellidos asc";
                $sql_tripulacion = "SELECT 
                                    tt.TRIP_id id_tripulacion,
                                    tt.TRIP_nombre nombres, 
                                    tt.TRIP_apellido apellidos,
                                    tt.TRIP_numdoc,
                                    
                                    tf.TRIPFUN_id id_funcion, 
                                    tf.TRIPFUN_descripcion,
                                    tf.TIPTRIPU_codigo IdTipoTripulacion
                                    FROM TRIPULANTE tt 
                                    INNER JOIN TRIPULANTEFUNCION tf ON (tt.TRIPFUN_id=tf.TRIPFUN_id)
                                    WHERE  
                                    tt.TRIP_estado=1 AND 
                                    tf.TIPTRIPU_codigo='TV' 
                                    ORDER BY tt.TRIPFUN_id ASC, TRIP_apellido ASC";
                break;

            case "servicios":
                //$sql_tripulacion="select * from ".$this->table." where (IdTipoTripulacion=2 or IdTipoTripulacion=3 ) and activado=1 order by id_funcion asc, apellidos asc";
                $sql_tripulacion = "SELECT 
                                    tt.TRIP_id id_tripulacion,
                                    tt.TRIP_nombre nombres, 
                                    tt.TRIP_apellido apellidos, 
                                    tf.TRIPFUN_id id_funcion, 
                                    tf.TRIPFUN_descripcion,
                                    tf.TIPTRIPU_codigo IdTipoTripulacion
                                    FROM TRIPULANTE tt 
                                    INNER JOIN TRIPULANTEFUNCION tf ON (tt.TRIPFUN_id=tf.TRIPFUN_id)
                                    WHERE 
                                    tt.TRIP_estado=1 AND 
                                    (tf.TIPTRIPU_codigo='TC' OR tf.TIPTRIPU_codigo='TT') 
                                    ORDER BY tt.TRIPFUN_id ASC, TRIP_apellido ASC";
                break;
            case "practicante":
               // $sql_tripulacion="select * from ".$this->table." where IdTipoTripulacion=4 and id_funcion=18 order by id_funcion asc, apellidos asc";
                $sql_tripulacion = "SELECT 
                                    tt.TRIP_id id_tripulacion,
                                    tt.TRIP_nombre nombres, 
                                    tt.TRIP_apellido apellidos, 
                                    tf.TRIPFUN_id id_funcion, 
                                    tf.TRIPFUN_descripcion,
                                    tf.TIPTRIPU_codigo IdTipoTripulacion
                                    FROM TRIPULANTE tt 
                                    INNER JOIN TRIPULANTEFUNCION tf ON (tt.TRIPFUN_id=tf.TRIPFUN_id)
                                    WHERE  
                                    tt.TRIP_estado=1 AND 
                                    tf.TIPTRIPU_codigo='PT' 
                                    ORDER BY tt.TRIPFUN_id ASC, TRIP_apellido ASC";
                break;
        }

        $rs_tripulacion = $this->Consultar($sql_tripulacion);
        $data= array();
        if(count($rs_tripulacion)>0){
            foreach ($rs_tripulacion as $key =>$value) {
                $data[$key]['id_tripulacion'] = $value['id_tripulacion'];
                $data[$key]['nombres'] = utf8_encode($value['nombres']);
                $data[$key]['apellidos'] = utf8_encode($value['apellidos']);
                $data[$key]['id_funcion'] = ($value['id_funcion']);
                $data[$key]['idTipoTripulacion'] = $value['IdTipoTripulacion'];
            }
        }
        
        return $data;
    }
    
    public function getFunciones($idTipoTripulacion=""){
        $andtipoTri = "" ;
        if($idTipoTripulacion != ""){
            $andtipoTri = " and TIPTRIPU_codigo='" . $idTipoTripulacion."'" ;
        }
        $sqlfunciones="select * from TRIPULANTEFUNCION where TRIPFUN_estado=1 ".$andtipoTri;
        $rs_funciones = $this->Consultar($sqlfunciones);
        
        return $rs_funciones;
    }
    
    public function existeTripulacion($id_vuelo_cabecera,$id_tripulacion,$id_funcion,$tipo_tripulacion=""){
        $and_tipo_tri="";
        if($tipo_tripulacion==="C"){
            $and_tipo_tri=" and tf.TIPTRIPU_codigo='TV'";
        }elseif($tipo_tripulacion==="S"){
            $and_tipo_tri=" and (tf.TIPTRIPU_codigo='TC' or tf.TIPTRIPU_codigo='TT' ) and tf.TRIPFUN_id='".$id_funcion."'";
        }elseif($tipo_tripulacion==="P"){
            $and_tipo_tri = " and tf.TIPTRIPU_codigo='PT'";
        }
        
        
            $sql_tripulacion_cabina = "SELECT 
                                    vt.id_vuelo_tripulacion
                                    FROM 
                                    Vuelo_Tripulacion vt, 
                                    TRIPULANTE tri, 
                                    TRIPULANTEFUNCION tf, 
                                    Vuelo_Cabecera vc
                                    WHERE
                                    vt.TRIP_id = tri.TRIP_id AND
                                    vt.TRIPFUN_id = tf.TRIPFUN_id AND 
                                    vt.id_vuelo_cabecera = vc.id_vuelo_cabecera AND
                                    vc.id_vuelo_cabecera='".$id_vuelo_cabecera."' and vt.TRIP_id='".$id_tripulacion."'".$and_tipo_tri."";
            //echo $sql_tripulacion_cabina;exit;
            $rs_tripulacion = $this->Consultar($sql_tripulacion_cabina);

            if(count($rs_tripulacion)==0){
                return true;
            } 
                       

        return false;
    }
    

    public function getVueloTripulacion($id_vuelo_cabecera,$tipo_tripulacion="",$fecha_vuelo=""){
        $and_tipo_tri="";
        if($tipo_tripulacion==="C"){
            $and_tipo_tri=" and tf.TIPTRIPU_codigo='TV'";
        }elseif($tipo_tripulacion==="S"){
            $and_tipo_tri=" and (tf.TIPTRIPU_codigo='TC' or tf.TIPTRIPU_codigo='TT' )";
        }elseif($tipo_tripulacion==="P"){
            $and_tipo_tri = " and tf.TIPTRIPU_codigo='PT'";
        }
        $and_vuelo_cabecera="";
        if($id_vuelo_cabecera!=''){
            $and_vuelo_cabecera=" AND vc.id_vuelo_cabecera='".$id_vuelo_cabecera."'";
        }
        
        $and_fecha_vuelo="";
        if($fecha_vuelo!=''){
            $and_fecha_vuelo=" AND vc.fecha_vuelo='".$fecha_vuelo."'";
        }
        $vueloTripulacion = "SELECT 
                            vc.id_vuelo_cabecera,
                            vt.id_vuelo_tripulacion, 
                            vt.TRIP_id, 
                            vt.TRIPFUN_id, 
                            vt.id_vuelo_cabecera, 
                            vt.estado_instructor,
                            tri.TRIP_nombre nombres, 
                            tri.TRIP_apellido apellidos, 
                            tf.TRIPFUN_descripcion descripcion_funcion,
                            vc.dia_semana_vuelo,
                            vc.fecha_vuelo
                            FROM 
                            Vuelo_Tripulacion vt, 
                            TRIPULANTE tri, 
                            TRIPULANTEFUNCION tf, 
                            Vuelo_Cabecera vc
                            WHERE
                            vt.TRIP_id = tri.TRIP_id AND
                            vt.TRIPFUN_id = tf.TRIPFUN_id AND 
                            vt.id_vuelo_cabecera = vc.id_vuelo_cabecera 
                            ".$and_vuelo_cabecera.$and_tipo_tri." ";
        //echo $vueloTripulacion;exit;
        $rs_vuelotripulacion = $this->Consultar($vueloTripulacion); 
        $array_data = array();
        if(count($rs_vuelotripulacion)>0){
            foreach ($rs_vuelotripulacion as $key => $value) {
            
                $array_data[$key]['id_vuelo_tripulacion'] = $value['id_vuelo_tripulacion'];
                $array_data[$key]['id_tripulacion'] = $value['TRIP_id'];
                $array_data[$key]['id_vuelo_cabecera'] = $value['id_vuelo_cabecera'];
                $array_data[$key]['estado_instructor'] = $value['estado_instructor'];
                $array_data[$key]['nombres'] = utf8_encode($value["apellidos"]) . " " . utf8_encode($value["nombres"]);
                $array_apellido = explode(" ", $value["apellidos"]);
                $array_data[$key]['nombre_abreviado'] = substr(utf8_encode($value["nombres"]),0,1).". ".utf8_encode($array_apellido[0]);
                $array_data[$key]['descripcion_funcion'] = $value["descripcion_funcion"];
                $array_data[$key]['tipo_tripulacion'] = $tipo_tripulacion;
            }
        }
        
        
        return $array_data;
                
    }
    
    public  function deleteVueloTripulacion($id_vuelo_tripulacion){
        
        $delete_vuelo_tripulacion = "delete from Vuelo_Tripulacion where id_vuelo_tripulacion='".$id_vuelo_tripulacion."'";
        
        $count=$this->exec($delete_vuelo_tripulacion);
        //echo $count;
        if($count>0){
            return true;
        }
        return false;
        
    }
    
    public function asignarInstuctor($id_vuelo_tripulacion){
        $sqlUpdate="update Vuelo_Tripulacion set estado_instructor=1 where id_vuelo_tripulacion=".$id_vuelo_tripulacion.";";
        
        $count=$this->exec($sqlUpdate);
        //echo $count;
        if($count>0){
            return true;
        }
        return false;
    }
    
    public function insert($array_data){
        return $this->insertData($this->table, $array_data);
    }
    
    public function update($array_data=array(),$where=array()){
        return $this->updateData($this->table,$array_data,$where);
    }
    
    public function updateStatus($id_tripulante,$status){
        $sqlUpdate="update ".$this->table." set TRIP_estado='".$status."' where TRIP_id=".$id_tripulante.";";
        
        $count=$this->exec($sqlUpdate);
        //echo $count;
        if($count>0){
            return true;
        }
        return false;
    }
    
    public  function delete($id_tripulacion){
        
        $delete_tripulacion = "delete from ".$this->table." where TRIP_id='".$id_tripulacion."'";
        
        $count=$this->exec($delete_tripulacion);
        //echo $count;
        if($count>0){
            return true;
        }
        return false;
        
    }
    
    public function verificarCantTripulacion($fecha_vuelo,$id_cabecera,$arrayError){
        $query_piloto = "SELECT
                tf.TRIPFUN_descripcion as Piloto,
                vt.TRIPFUN_id
                FROM 
                Vuelo_Tripulacion vt, TRIPULANTE tri,
                TRIPULANTEFUNCION tf, Vuelo_Cabecera vc
                WHERE vt.TRIP_id = tri.TRIP_id AND 
                vt.TRIPFUN_id = tf.TRIPFUN_id AND 
                vt.id_vuelo_cabecera = vc.id_vuelo_cabecera AND 
                vc.fecha_vuelo='".$fecha_vuelo."' and vc.id_vuelo_cabecera = '".$id_cabecera."' and vt.TRIPFUN_id in (1)
               ";
        
        $rs_piloto = $this->Consultar($query_piloto);
        if(count($rs_piloto) == 0){
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Tripluacion :: Piloto no ingresado. <br>";
        }
        
        $query_copiloto = "SELECT
                tf.TRIPFUN_descripcion as Piloto,
                vt.TRIPFUN_id
                FROM 
                Vuelo_Tripulacion vt, TRIPULANTE tri,
                TRIPULANTEFUNCION tf, Vuelo_Cabecera vc
                WHERE vt.TRIP_id = tri.TRIP_id AND 
                vt.TRIPFUN_id = tf.TRIPFUN_id AND 
                vt.id_vuelo_cabecera = vc.id_vuelo_cabecera AND 
                vc.fecha_vuelo='".$fecha_vuelo."' and vc.id_vuelo_cabecera = '".$id_cabecera."' and vt.TRIPFUN_id in (2)
                 ";
        $rs_copiloto = $this->Consultar($query_copiloto);
        if(count($rs_copiloto) == 0){
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Tripluacion :: Copiloto no ingresado. <br>";
        }
        $query_tripulante_cabina = "SELECT
                tf.TRIPFUN_descripcion as Piloto,
                vt.TRIPFUN_id
                FROM 
                Vuelo_Tripulacion vt, TRIPULANTE tri,
                TRIPULANTEFUNCION tf, Vuelo_Cabecera vc
                WHERE vt.TRIP_id = tri.TRIP_id AND 
                vt.TRIPFUN_id = tf.TRIPFUN_id AND 
                vt.id_vuelo_cabecera = vc.id_vuelo_cabecera AND 
                vc.fecha_vuelo='".$fecha_vuelo."' and vc.id_vuelo_cabecera = '".$id_cabecera."' and vt.TRIPFUN_id in (6,7)
                 ";
        
        
        $rs_tripulante_cabina = $this->Consultar($query_tripulante_cabina); 
        if(count($rs_tripulante_cabina)<3){
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Tripluacion :: Tripulante de cabina no ingresado(Debe ingresar como minuto 3 Ttripulantes de Cabina). <br>";
        }   
        
         return $arrayError;
    }
    
}
