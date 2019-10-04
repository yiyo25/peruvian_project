<?php


class MantenimientoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        }

    }

    public function indexAction(){

    }

    public function procesosAction(){
        if($this->isAccessProgram("GSO_MANT_PROC",1)){
            $this->_view->assign("title","Procesos");
            $this->_view->assign("ruta",URL."app/gso/procesos?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }

    }
    public function subProcesosAction(){
        if($this->isAccessProgram("GSO_MANT_SUBP",1)){
            $this->_view->assign("title","Sub Procesos");
            $this->_view->assign("ruta",URL."app/gso/subProcesos?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }

    }

    public function responsableAction(){
        if($this->isAccessProgram("GSO_MANT_RESP",1)){
            $this->_view->assign("title","Resposables");
            $this->_view->assign("ruta",URL."app/gso/responsables?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function codigosAction(){
        if($this->isAccessProgram("GSO_MANT_COD",1)) {
            $this->_view->assign("title", "Códigos");
            $this->_view->assign("ruta", URL . "app/gso/codigos?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function seccionesAction(){
        if($this->isAccessProgram("GSO_MANT_SEC",1)) {
            $this->_view->assign("title", "Secciones");
            $this->_view->assign("ruta", URL . "app/gso/secciones?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function aspectoAction(){
        if($this->isAccessProgram("GSO_MANT_ASPE",1)) {
            $this->_view->assign("title", "Aspectos");
            $this->_view->assign("ruta", URL . "app/gso/aspectos?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function tipoReporteAction(){
        if($this->isAccessProgram("GSO_MANT_TIREP",1)) {
            $this->_view->assign("title", "Tipo Reporte");
            $this->_view->assign("ruta", URL . "app/gso/tipoReporte?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function estadisticaAction(){
        if($this->isAccessProgram("GSO_MANT_ESTA",1)) {
            $this->_view->assign("title", "Estadistica");
            $this->_view->assign("ruta", URL . "app/gso/estadistica?id_usuario=".$_SESSION[NAME_SESS_USER]["id_usuario"]);
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }


}