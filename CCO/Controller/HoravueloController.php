<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HoravueloController
 *
 * @author ihuapaya
 */
class HoravueloController extends Controller {
    public $permisos;
    public function __construct() {
        parent::__construct();
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        } else {

            if (!$this->isAccessProgram("CCO_SEG_VUELOS_HORAS", 1)) {
                
                if($this->isPost()){
                    $this->_view->maintpl = "mainx";
                    $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar <br> a esta Página.");
                    $html_hora = $this->_view->fetch('403.tpl');
                    echo json_encode(array(
                        "rpt" => 1,
                        "html_hora" => $html_hora,
                        "msg_error" => "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página."
                            )
                    );

                    exit;
                }else{
                    $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
                    $this->_view->show_page("403.tpl");
                    exit;
                }
                
            }else{
                $this->permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_HORAS", 1);
                $this->_view->assign("permiso_hora", $this->permisos);  
            }
        }
    }

    public function indexAction() {

        if ($this->isPost()) {
            $this->_view->maintpl = "mainx";
            $obj_ciudad =new Ciudad();
            $listCiudad = $obj_ciudad->getAll();
            
            $id_vuelo_detalle = $_POST['id_vuelo_detalle'];
            $flag_horas_block = $_POST['flag_horas_block'];
            $obj_vuelo_detalle = new VueloDetalle();
            $row_detalle = $obj_vuelo_detalle->getRowById($id_vuelo_detalle);

            $rpt = 0;
            $html_hora = "";
            $msg_error = "";
            if (count($row_detalle) > 0) {

                $hora_cierre_puerta_iti = str_replace(":", "", trim($row_detalle[0]["hora_cierre_puerta_itin"]));
                $hora_cierra_puerta = str_replace(":", "", trim($row_detalle[0]["hora_cierre_puerta"]));
                $puerta_PB = str_replace(":", "", trim($row_detalle[0]["puerta_PB"]));
                $ENG_ON = str_replace(":", "", trim($row_detalle[0]["ENG_ON_hora_embarque"]));
                $TAKE_OFF = str_replace(":", "", trim($row_detalle[0]["take_out_hora_despegue"]));
                $TiempoVuelo = str_replace(":", "", trim($row_detalle[0]["tiempo_vuelo"]));
                $HoraAirr = str_replace(":", "", trim($row_detalle[0]["arr_in_hora_arribo"]));
                $ETA = str_replace(":", "", trim($row_detalle[0]["eta"]));
                $Stop = str_replace(":", "", trim($row_detalle[0]["hora_parada"]));
                $apertura_puerta = str_replace(":", "", trim($row_detalle[0]["hora_apertura_puerta"]));
                $APItin = str_replace(":", "", trim($row_detalle[0]["hora_apertura_puerta_itin"]));

                $HorasBlock = str_replace(":", "", trim($row_detalle[0]["horas_block"]));
                $HorasBlock_m = str_replace(":", "", trim($row_detalle[0]["horas_block_m"]));

                if ($hora_cierre_puerta_iti === "" || $hora_cierre_puerta_iti === "0000") {
                    $hora_cierre_puerta_iti = "";
                }
                if ($hora_cierra_puerta === "" || $hora_cierra_puerta === "0000") {
                    $hora_cierra_puerta = "";
                }
                if ($puerta_PB === "" || $puerta_PB === "0000") {
                    $puerta_PB = "";
                }
                if ($ENG_ON === "" || $ENG_ON === "0000") {
                    $ENG_ON = "";
                }
                if ($TAKE_OFF === "" || $TAKE_OFF === "0000") {
                    $TAKE_OFF = "";
                }
                if ($TiempoVuelo === "" || $TiempoVuelo === "0000") {
                    $TiempoVuelo = "";
                }
                if ($HoraAirr === "" || $HoraAirr === "0000") {
                    $HoraAirr = "";
                }
                if ($Stop === "" || $Stop === "0000") {
                    $Stop = "";
                }
                if ($apertura_puerta === "" || $apertura_puerta === "0000") {
                    $apertura_puerta = "";
                }
                if ($APItin === "" || $APItin === "0000") {
                    $APItin = "";
                }

                /*                 * ******** cabecera******************************* */
                $this->_view->assign("fecha", $_POST["fecha_vuelo"]);
                $this->_view->assign("matricula", $_POST["matricula"]);
                $this->_view->assign("nro_vuelo", $_POST["nro_vuelo"]);
                $this->_view->assign("ruta", $_POST["ruta"]);
                $this->_view->assign("id_vuelo_cabecera", $_POST["id_vuelo_cabecera"]);
                $this->_view->assign("listCiudad",$listCiudad);
                $this->_view->assign("edit_ruta",1);
                /*                 * *************************************************** */
                
                $this->_view->assign("id_vuelo_detalle",$id_vuelo_detalle);
                $this->_view->assign("hora_cierre_puerta_iti", $hora_cierre_puerta_iti);
                $this->_view->assign("hora_cierra_puerta", $hora_cierra_puerta);
                $this->_view->assign("puerta_PB", $puerta_PB);
                $this->_view->assign("ENG_ON", $ENG_ON);
                $this->_view->assign("TAKE_OFF", $TAKE_OFF);
                $this->_view->assign("TiempoVuelo", $TiempoVuelo);
                $this->_view->assign("HoraAirr", $HoraAirr);
                $this->_view->assign("ETA", $ETA);
                $this->_view->assign("Stop", $Stop);
                $this->_view->assign("apertura_puerta", $apertura_puerta);
                $this->_view->assign("APItin", $APItin);
                $this->_view->assign("HorasBlock", $HorasBlock);
                $this->_view->assign("HorasBlock_m", $HorasBlock_m);
                $this->_view->assign("flag_horas_block",$flag_horas_block);
                $txtReadonly="";
                $view_component = 1;
                if($row_detalle[0]["estado_vuelo"]==6){
                    $txtReadonly="readonly";
                    $view_component = 0;
                }
                $this->_view->assign("view_component",$view_component);
                $this->_view->assign("txtReadonly",$txtReadonly);
                $rpt = 1;
                $html_hora = $this->_view->fetch('hora_vuelo.tpl');
            } else {
                $rpt = 0;
                $msg_error = "No existe el Id =>" . $id_vuelo_detalle;
            }
            echo json_encode(array(
            "rpt" => $rpt,
            "html_hora" => $html_hora,
            "msg_error" => $msg_error
                )
        );

        exit;
        } else {
           $this->_view->assign("error_text", "HTTP Status 405 – HTTP method GET is not supported by this URL");
            $this->_view->show_page("405.tpl");
            exit;
        }

        
    }

    public function saveHoraAction() {

        if ($this->isPost()) {
            if($this->permisos[0]["Agregar"] == 1){
                $idVueloDetalle = $_REQUEST["idVueloDetalle"];

                $txtCPITIN = $_REQUEST["txtCPITIN"];
                $txtCP = $_REQUEST["txtCP"];
                $txtPB = $_REQUEST["txtPB"];
                $txtENG_ON = $_REQUEST["txtENG_ON"];
                $txtTAKE_OFF = $_REQUEST["txtTAKE_OFF"];
                $txtHoraAirr = $_REQUEST["txtHoraAirr"];
                $txtETA = $_REQUEST["txtETA"];

                $txtStop = $_REQUEST["txtStop"];
                $txtAP = $_REQUEST["txtAP"];
                $txtAPItin = $_REQUEST["txtAPItin"];

                $txtTiempoVuelo = $_REQUEST["txtTiempoVuelo"];

                $txthorasBlock = $_REQUEST["txtTiempoHorasBlock"];

                if (strlen($txtCPITIN) > 0 && strlen($txtCPITIN) < 5) {
                    $txtCPITIN = substr($txtCPITIN, 0, 2) . ":" . substr($txtCPITIN, 2, 4);
                }
                if (strlen($txtCP) > 0 && strlen($txtCP) < 5) {
                    $txtCP = substr($txtCP, 0, 2) . ":" . substr($txtCP, 2, 4);
                }
                if (strlen($txtPB) > 0 && strlen($txtPB) < 5) {
                    $txtPB = substr($txtPB, 0, 2) . ":" . substr($txtPB, 2, 4);
                }
                if (strlen($txtENG_ON) > 0 && strlen($txtENG_ON) < 5) {
                    $txtENG_ON = substr($txtENG_ON, 0, 2) . ":" . substr($txtENG_ON, 2, 4);
                }
                if (strlen($txtTAKE_OFF) > 0 && strlen($txtTAKE_OFF) < 5) {
                    $txtTAKE_OFF = substr($txtTAKE_OFF, 0, 2) . ":" . substr($txtTAKE_OFF, 2, 4);
                }
                if (strlen($txtHoraAirr) > 0 && strlen($txtHoraAirr) < 5) {
                    $txtHoraAirr = substr($txtHoraAirr, 0, 2) . ":" . substr($txtHoraAirr, 2, 4);
                }
                if (strlen($txtETA) > 0 && strlen($txtETA) < 5) {
                    $txtETA = substr($txtETA, 0, 2) . ":" . substr($txtETA, 2, 4);
                }

                if (strlen($txtStop) > 0 && strlen($txtStop) < 5) {
                    $txtStop = substr($txtStop, 0, 2) . ":" . substr($txtStop, 2, 4);
                }
                if (strlen($txtAP) > 0 && strlen($txtAP) < 5) {
                    $txtAP = substr($txtAP, 0, 2) . ":" . substr($txtAP, 2, 4);
                }
                if (strlen($txtAPItin) > 0 && strlen($txtAPItin) < 5) {
                    $txtAPItin = substr($txtAPItin, 0, 2) . ":" . substr($txtAPItin, 2, 4);
                }

                if (strlen($txtTiempoVuelo) > 0 && strlen($txtTiempoVuelo) < 5) {
                    $txtTiempoVuelo = substr($txtTiempoVuelo, 0, 2) . ":" . substr($txtTiempoVuelo, 2, 4);
                }

                if (strlen($txthorasBlock) > 0 && strlen($txthorasBlock) < 5) {
                    $txthorasBlock = substr($txthorasBlock, 0, 2) . ":" . substr($txthorasBlock, 2, 4);
                }
            

                if (trim($txtCPITIN) == "") {
                    $txtCPITIN = "00:00";
                }
                if (trim($txtCP) == "") {
                    $txtCP = "00:00";
                }
                if (trim($txtPB) == "") {
                    $txtPB = "00:00";
                }
                if (trim($txtENG_ON) == "") {
                    $txtENG_ON = "00:00";
                }
                if (trim($txtTAKE_OFF) == "") {
                    $txtTAKE_OFF = "00:00";
                }
                if (trim($txtTiempoVuelo) == "") {
                    $txtTiempoVuelo = "00:00";
                }
                if (trim($txtHoraAirr) == "") {
                    $txtHoraAirr = "00:00";
                }
                if (trim($txtETA) == "") {
                    $txtETA = "00:00";
                }

                if (trim($txtStop) == "") {
                    $txtStop = "00:00";
                }
                if (trim($txtAP) == "") {
                    $txtAP = "00:00";
                }
                if (trim($txtAPItin) == "") {
                    $txtAPItin = "00:00";
                }
                if (trim($txthorasBlock) == "") {
                    $txthorasBlock = "00:00";
                }
            
                /**********calcular horas block***********/
                $time_hora_block=0;
                $hora_fin_dia = "24:00";
                if(strtotime($txtPB)>strtotime($txtStop)){
                    $hora_diff = strtotime($hora_fin_dia)-strtotime($txtPB);
                    $hora_format = $this->conversorSegundosHoras($hora_diff);
                    $time_hora_block = $this->diferencia_entre_minutos($txtStop, $hora_format,"suma");
                }else{
                    $time_hora_block = $this->diferencia_entre_minutos($txtPB,$txtStop,"resta" );
                }

                /**********calcular horas flight ***************/
                $time_horas_flight = 0;
                if(strtotime($txtTAKE_OFF)>strtotime($txtHoraAirr)){
                    $hora_diff = strtotime($hora_fin_dia)-strtotime($txtTAKE_OFF);
                    $hora_format = $this->conversorSegundosHoras($hora_diff);
                    $time_horas_flight = $this->diferencia_entre_minutos($txtHoraAirr, $hora_format,"suma");
                }else{
                    $time_horas_flight = $this->diferencia_entre_minutos($txtTAKE_OFF,$txtHoraAirr,"resta" );
                }

                $sql = "Exec cco_proc_GrabaHoraVueloDetalle ".$idVueloDetalle.", '".$txtCPITIN."', '".$txtCP."','".$txtPB."','".$txtENG_ON."','".$txtTAKE_OFF."','".$txtHoraAirr."','".$txtStop."','".$txtAP."','".$txtTiempoVuelo."','".$txtAPItin."','".$_SESSION[NAME_SESS_USER]["id_usuario"]."','".$txtETA."','".$txthorasBlock."','".$time_hora_block."','".$time_horas_flight."'";

                $obj_vuelo_detalle = new VueloDetalle();
                if($obj_vuelo_detalle->Ejecutar($sql)){
                    echo json_encode(array("rpt"=>1));
                }else{
                    echo json_encode(array("rpt"=>0));
                }
                exit;
            
            }else{
                $rpt = 0;
                $msg = "Error => No tienes permiso para agregar Pasajero";
                
                echo json_encode(array("rpt"=>0,"msj"=>$msg));
                exit;
            }
            
        }
    }

}
