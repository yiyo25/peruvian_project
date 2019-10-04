<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VueloController
 *
 * @author ihuapaya
 */
class VueloController extends Controller {
    public $permisos;
    public function __construct() {
        parent::__construct();
        $this->_view->assign("JS", "lista_vuelo");
        if(!$this->isAccesoApp()){
             header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            $this->permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS", 1);
            
        }
    }
    public function indexAction() {
        $this->redireccionar('vuelo/create');
    }
    
    
    public function createAction(){
        if($this->permisos[0]["Agregar"] == 1){
            $objTipoVuelo = new TipoVuelo();
            $tipovuelo = $objTipoVuelo->getAll();

            $obj_tipo_operacion = new TipoOperacion();
            $list_tipo_operacion = $obj_tipo_operacion->getAll();

            $obj_matricula = new Matriculas();
            $list_matriculas = $obj_matricula->getAll();

            $obj_ciudad = new Ciudad();
            $list_ciudad = $obj_ciudad->getAll();
            $fecha = date("Y-m-d");
            if($this->isGet()){
                if(isset($_GET["fecha"]) && $_GET["fecha"]!=''){
                   $fecha = $_GET["fecha"]; 
                }
            }


            $this->_view->assign('list_ciudad',$list_ciudad);
            $this->_view->assign('list_matriculas',$list_matriculas);
            $this->_view->assign('tipo_operacion',$list_tipo_operacion);
            $this->_view->assign('tipo_vuelo', $tipovuelo);
            $this->_view->assign('fecha',$fecha);
            $this->_view->assign('title', "Crear Vuelos");
            $this->_view->show_page("crear_vuelo.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }

}
