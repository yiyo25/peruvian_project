<?php


class ReporteController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        }
    }

    public function bandejaAction(){
        if($this->isAccessProgram("GSO_REP_BAND",1)) {
            $this->_view->assign("title", "Bandeja de Reportes");
            $this->_view->assign("ruta", URL . "app/gso");
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function noAtendidosAction(){
        if($this->isAccessProgram("GSO_REP_NOATEN",1)) {
            $this->_view->assign("title", "REPORTES SMS NO ATENDIDOS");
            $this->_view->assign("ruta", URL . "app/gso/reportesNoAtendidos");
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function seguimientoAction(){
        if($this->isAccessProgram("GSO_REP_SEG",1)) {
            $this->_view->assign("title", "REPORTES SMS - SEGUIMIENTO");
            $this->_view->assign("ruta", URL . "app/gso/reportesSeguimiento");
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }
    public function terminadosAction(){
        if($this->isAccessProgram("GSO_REP_TERM",1)) {
            $this->_view->assign("title", "REPORTES SMS - TERMINADOS");
            $this->_view->assign("ruta", URL . "app/gso/reportesTerminados");
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }

    public function responsableAction(){
        if($this->isAccessProgram("GSO_REP_ASIG",1)) {
            $this->_view->assign("title", "Responsable SMS");
            $this->_view->assign("ruta", URL . "app/gso/reporteResponsables");
            $this->_view->show_page("iframe.tpl");
        }else{
            $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
    }

}