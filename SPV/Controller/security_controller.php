<?php 

class Security extends Controller {

    public function index() {
        if (isset($_REQUEST["token"]) && $_REQUEST['token'] != "") {
            $apilogin = new ApiLogin();
            $datatoken  = $apilogin->GetDataToken($_REQUEST['token']);
            $Usuario    = $datatoken->Usuario;
            $IdSistema  = $datatoken->IdSistema;
            $_SESSION[NAME_SESS_USER]["id_usuario"] =  $Usuario;
            $_SESSION[NAME_SESS_USER]["IdSistema"]  =  $IdSistema;
            //echo "sdf";exit;
            $this->redireccionar("index");
        } else {
            $this->view->error_text = "El usuario <b>". $_SESSION[NAME_SESS_USER]["id_usuario"]."</b> no tiene permisos para accedar a esta Página.";
            $this->view->render('403');
        }
        exit;
               
    }

}


?>