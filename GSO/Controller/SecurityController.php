<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SecurityController
 *
 * @author ihuapaya
 */

class SecurityController extends Controller {

    public function indexAction() {

        if (isset($_REQUEST["token"]) && $_REQUEST['token'] != "") {
            $obj_JWT = new JWTLibs();
            $datatoken  = $obj_JWT->GetData($_REQUEST['token']);
            //print_r($datatoken);exit;
            $Usuario    = $datatoken->Usuario;
            $IdSistema  = $datatoken->IdSistema;
            $_SESSION[NAME_SESS_USER]["id_usuario"] =  $Usuario;
            $_SESSION[NAME_SESS_USER]["IdSistema"]  =  $IdSistema;
            $this->redireccionar("mantenimiento/subProcesos");
        } else {
            $this->_view->assign("error_text","No tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
        }
        exit;
               
    }

}
