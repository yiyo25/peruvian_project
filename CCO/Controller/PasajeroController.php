<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PasajeroController
 *
 * @author ihuapaya
 */
class PasajeroController extends Controller{
    public $permisos;
    public function __construct(){
        parent::__construct();
        
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        } else {
            //echo "a";exit;
            if ($this->isAccessProgram("CCO_SEG_VUELOS_PAX", 1)) {
                $this->permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_PAX", 1);
                $this->_view->assign("permiso_pax", $this->permisos);  
            }
        }
    }
    
    public function indexAction()
    {
        if ($this->isPost()) {
            
            if ($this->isAccessProgram("CCO_SEG_VUELOS_PAX", 1)) {
                $this->_view->maintpl = "mainx";

                /**********************Listado de cuidad*****************************/

                $obj_ciudad =new Ciudad();
                $listCiudad = $obj_ciudad->getAll();

                $id_vuelo_detalle = $_POST['id_vuelo_detalle'];
                $obj_vuelo_detalle = new VueloDetalle();
                $row_detalle = $obj_vuelo_detalle->getRowById($id_vuelo_detalle);

                $rpt = 0;
                $html_pasajeros = "";
                $msg_error = "";
                if(count($row_detalle)>0){
                    $obj_vuelo_pasajero = new VueloPasajero();
                    $row_vuelo_pasajero = $obj_vuelo_pasajero->getRowByFlight($id_vuelo_detalle);
                    $txtClaseJ      =0;
                    $txtClaseY      =0;
                    $txtAdulto      =0;
                    $txtMenores     =0;
                    $txtInfantes    =0;
                    $txtNR          =0;

                    if(count($row_vuelo_pasajero)>0)
                    {
                        $txtClaseJ   = $row_vuelo_pasajero[0]->clase_j;
                        $txtClaseY   = $row_vuelo_pasajero[0]->clase_y;
                        $txtAdulto   = $row_vuelo_pasajero[0]->nro_adultos;
                        $txtMenores  = $row_vuelo_pasajero[0]->nro_menores;
                        $txtInfantes = $row_vuelo_pasajero[0]->nro_infantes;
                        $txtNR       = $row_vuelo_pasajero[0]->nro_nr;
                    }

                    $txtTotal=$txtAdulto + $txtMenores + $txtInfantes;

                     /********** cabecera******************************* */
                    $this->_view->assign("fecha", $_POST["fecha_vuelo"]);
                    $this->_view->assign("matricula", $_POST["matricula"]);
                    $this->_view->assign("nro_vuelo", $_POST["nro_vuelo"]);
                    $this->_view->assign("ruta", $_POST["ruta"]);
                    $this->_view->assign("id_vuelo_cabecera", $_POST["id_vuelo_cabecera"]);
                    $this->_view->assign("listCiudad",$listCiudad);
                    $this->_view->assign("edit_ruta",1);
                    /******************************************************/


                    /************ Datos Pasajero*****************/
                    $this->_view->assign("id_vuelo_detalle",$id_vuelo_detalle);
                    $this->_view->assign("clase_j",$txtClaseJ);
                    $this->_view->assign("clase_y",$txtClaseY);
                    $this->_view->assign("nro_adulto",$txtAdulto);
                    $this->_view->assign("nro_menores",$txtMenores);
                    $this->_view->assign("nro_infantes",$txtInfantes);
                    $this->_view->assign("nro_nr",$txtNR);
                    $this->_view->assign("total",$txtTotal);
                    $txtReadonly="";
                    $view_component = 1;
                    if($row_detalle[0]["estado_vuelo"]==6){
                        $txtReadonly="readonly";
                        $view_component = 0;
                    }
                    $this->_view->assign("view_component",$view_component);
                    $this->_view->assign("txtReadonly",$txtReadonly);
                    /********************************************/

                    $rpt = 1;
                    $html_pasajeros = $this->_view->fetch('vuelo_pasajeros.tpl');
                }else{
                    $rpt = 0;
                    $html_pasajeros = "";
                    $msg_error = "No existe el Id =>" . $id_vuelo_detalle;
                }
            
            } else {
                $rpt = 0;
                $html_pasajeros = "";
                $msg_error = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página."; 
            }
            echo json_encode(array(
                "rpt" => $rpt,
                "html_hora" => $html_pasajeros,
                "msg_error" => $msg_error
                )
            );

            exit; 
        }else {
            $this->_view->assign("error_text", "HTTP Status 405 – HTTP method GET is not supported by this URL");
            $this->_view->show_page("405.tpl");
            exit;
        }
            
           
            
    }
    
    
    public function savePasajeroAction(){
        if($this->isPost()){
            if($this->permisos[0]["Agregar"] == 1){
                if(count($this->validForm($_POST))==0){

                    $id_vuelo_detalle = $_POST["id_vuelo_detalle"];
                    $txt_nro_adultos    = $_POST["txt_nro_adultos"];
                    $txt_nro_menores    = $_POST["txt_nro_menores"];
                    $txt_nro_infantes   = $_POST["txt_nro_infantes"];
                    $txt_nro_nr = $_POST["txt_nro_nr"];
                    $txt_total = $_POST["txt_total"];
                    $obj_vuelo_pasajero = new VueloPasajero();
                    $row_vuelo_pasajero = $obj_vuelo_pasajero->getRowByFlight($id_vuelo_detalle);

                    $rpt = 0;
                    $msg = "";
                    $error=array();
                    if(count($row_vuelo_pasajero)>0){
                        $array_data = array(
                            "nro_adultos"       => $txt_nro_adultos,
                            "nro_menores"       => $txt_nro_menores,
                            "nro_infantes"      => $txt_nro_infantes,
                            "nro_nr"            => $txt_nro_nr,
                            "clase_y"           => $txt_total,
                            "UsuarioMod" => $_SESSION[NAME_SESS_USER]["id_usuario"],
                            "FechaMod" => date("Y-m-d H:i:s")
                        );

                        $where=array("id_vuelo_detalle"=>$id_vuelo_detalle);
                        if($obj_vuelo_pasajero->update($array_data,$where)){
                            $rpt = 1;
                        }else{
                            $rpt = 0;
                            $msg = "Hubo un error al actualizar los datos!";
                        }
                    }else{
                        $array_data = array(
                            "id_vuelo_detalle"  => $id_vuelo_detalle,
                            "nro_adultos"       => $txt_nro_adultos,
                            "nro_menores"       => $txt_nro_menores,
                            "nro_infantes"      => $txt_nro_infantes,
                            "nro_nr"            => $txt_nro_nr,
                            "clase_y"           => $txt_total,
                            "UsuarioReg" => $_SESSION[NAME_SESS_USER]["id_usuario"],
                            "FechaReg" => date("Y-m-d H:i:s")   
                        );

                        if($obj_vuelo_pasajero->insert($array_data)){
                            $rpt = 1;
                        }else{
                            $rpt = 0;
                            $msg = "Hubo un error al insertar los datos!";
                        }
                    }
                }else{
                    $rpt = 0;
                    $msg = "Hubo un error al insertar los datos!. (Los campos deben ser solo Números).";
                    $error = $this->validForm($_POST);
                }
            }else{
                $rpt = 0;
                $msg = "Error => No tienes permiso para agregar Pasajero";
                $error=array();
            }
        }else{
            
            $rpt = 0;
            $msg = "Metodo no Permitido";
            $error=array();
        }
        
        echo json_encode(array("rpt"=>$rpt,"msj"=>$msg,"error"=>$error));
    }
    
    function validForm($vars){
        $array_error=array();
        $a=0;
        foreach ($vars as $key => $value) {
                
            if(!$this->validNumero($value)){
                if($key!="txt_total"){
                    $array_error[$a]["input"] =substr($key,8);
                    $array_error[$a]["msg_error"] = "No es Numero";
                            
                }else{
                    $array_error[$a]["input"] =substr($key,4);
                    $array_error[$a]["msg_error"] = "No es Numero";
                }
                $a++;
            }
        }
        return $array_error;
    }
    
   
}
