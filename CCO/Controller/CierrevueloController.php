<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CierrevueloController
 *
 * @author ihuapaya
 */
class CierrevueloController extends Controller{
    
    public function __construct() {
        parent::__construct();
        if(!$this->isAccesoApp()){
             header('location:'.URL_LOGIN_APP);
            exit;
        }
        
    }
    
    public function indexAction(){
        
        if($this->isPost()){
            $this->_view->maintpl = "mainx";
        
            $data = array();
            $fecha = $_POST["fecha_cierre"];
            $obj_vuelo_cabecera = new VueloCabecera();
            $data_vuelo_cabecera = $obj_vuelo_cabecera->getFligthByDate($fecha);
            $obj_vuelo_detalle = new VueloDetalle();
            $arrayError = array("nroError" => 0, "mensaje" => "");
            $obj_vuelo_pasajero = new VueloPasajero();
            
            $obj_tripulacion = new Tripulacion();
            
            foreach ($data_vuelo_cabecera as $key => $cabecera) {
                $data_detalle = $obj_vuelo_detalle->getFligthDetail($cabecera["id_vuelo_cabecera"]);
                foreach ($data_detalle as $detalle) {
                    $arrayError = $obj_vuelo_pasajero->verificaPasajerosEquipajeDetalle($detalle["id_vuelo_detalle_ori"], $arrayError);
                    if($detalle["vuelo_operativo"]=="O"){
                        $arrayError = $obj_vuelo_detalle->verificaHorasVuelo($detalle["id_vuelo_detalle_ori"], $arrayError);
                        if($detalle["orden"]==1 && $detalle["vuelo_direccion"]=="IDA"){
                            $arrayError = $obj_tripulacion->verificarCantTripulacion($fecha, $cabecera["id_vuelo_cabecera"], $arrayError);
                        }
                    }
                    if($arrayError["nroError"]>0){
                        $data_cierre = new stdClass();
                        $data_cierre->id_vuelo_detalle = $detalle["id_vuelo_detalle_ori"];
                        $data_cierre->id_vuelo_cabecera = $detalle["id_vuelo_cabecera"];
                        $data_cierre->fecha_vuelo = $cabecera['fecha_vuelo'];
                        $data_cierre->id_matricula = $detalle['IdMatricula'];
                        $data_cierre->nro_vuelo = $detalle['NroVuelo'];
                        $data_cierre->ruta = $detalle['ciudad_origen'] . " - " . $detalle['ciudad_destino'];
                        $data_cierre->error = $arrayError;
                        $arrayError = array("nroError" => 0, "mensaje" => "");
                        $data["data"][] = $data_cierre;
                    }
                }
            }

            $this->_view->assign("verificar_cierre",$obj_vuelo_detalle->verificarPreCierreVuelo($fecha));
            $this->_view->assign("fecha_cierre",$fecha);
            $this->_view->assign("array_data",$data);
            $rpt = 0;
            $msg_error = "";
            $html_cierre_vuelo ="";
            if(count($data)>0){
                $rpt = 1;
                $msg_error = "";
                $html_cierre_vuelo = $this->_view->fetch("cierre_vuelo.tpl");
            }else{
                if($obj_vuelo_detalle->verificarPreCierreVuelo($fecha)>0){
                    $rpt = 2;
                    $msg_error = "Todos los vuelos fueron llenados de forma comforme.¿desea realizar el cierre respectivo del dia ".$fecha."? , despues de realizar dicho cierre ya no podra modificar.";
                }else{
                    $rpt = 3;
                    $msg_error = "Los vuelos del dia ".$fecha." ya fueron cerrados, si falta cerrar algun vuelo contactar con el administrador.";
                }
            }
        }else {
            $rpt = 0;
            $html_cierre_vuelo = "";
            $msg_error = "Error Metodo no permitido";
            //$this->_view->assign("error_name","")
            $this->_view->show404page();exit;
        }
        echo json_encode(array(
            "rpt" => $rpt,
            "html_cierre_vuelo" => $html_cierre_vuelo,
            "msg_error" => $msg_error
            )
        );

        exit;
        
    }
    
    public function procesarCierreVueloDiaAction(){
        
        if($this->isPost()){
            try {
                $obj_vuelo_detalle = new VueloDetalle();
                $fecha = $_POST["fecha_cierre"];

                $sql_vuelo = "select vd.id_vuelo_detalle, vd.estado_vuelo "
                        . "from Vuelo_Cabecera vc, Vuelo_Detalle vd "
                        . "where  vc.id_vuelo_cabecera = vd.id_vuelo_cabecera and "
                        . "vc.fecha_vuelo='".$fecha."' and estado_vuelo in(1,2,3,4)";

                $rs_vuelos = $obj_vuelo_detalle->Consultar($sql_vuelo);
                $obj_vuelo_detalle->exec('BEGIN TRANSACTION;');
                $rpt = 0;
                foreach ($rs_vuelos as $value) {
                    $array_value=array('estado_vuelo'=>6);
                    $array_where = array("id_vuelo_detalle"=>$value["id_vuelo_detalle"]);

                    if(!$obj_vuelo_detalle->updateData("Vuelo_Detalle",$array_value,$array_where)){
                        $rpt ++;
                    }
                }
                if ($rpt > 0) {
                    $obj_vuelo_detalle->exec('ROLLBACK; ');
                    echo json_encode(array("rpt" => 0, "msg"=>"Error al cerror los vuelo, !Vuelve a interntarlo!"));
                    exit;
                } else {
                    $obj_vuelo_detalle->exec('COMMIT; ');
                    echo json_encode(array("rpt" => 1,"msg"=>"Vuelos Cerrados Correctamente"));
                    exit;
                }
             } catch (Exception $e) {
                $obj_vuelo_detalle->exec('ROLLBACK; ');
                echo "Error!: " . $e->getMessage() . "</br>";
                exit;
            }
        }else{
            echo json_encode(array("rpt" => 0,"msg"=>"Metodo incorrecto"));
            exit;
        }
       
        
    }
    
    
}
