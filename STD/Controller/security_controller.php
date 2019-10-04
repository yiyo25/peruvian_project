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
            /*echo "<pre>";
            print_r($datatoken);
            echo "</pre>";exit;*/
            $_SESSION['usuario'] = $Usuario;
            $_SESSION['nombre'] =$datatoken->DataUser->UserNom;
            $_SESSION['apellidos'] = $datatoken->DataUser->UserApe;
            $_SESSION['dni'] = "NULL";
            $_SESSION['area_id'] = 1;
            $_SESSION['cargo_id'] = 1;
            $_SESSION['area'] = "NULL";
            $_SESSION['iosa'] = "NULL";
            $_SESSION['correo'] = $datatoken->DataUser->UserEmail;
            $this->redireccionar("index");
        } else {
            $this->view->error_text = "El usuario <b>". $_SESSION[NAME_SESS_USER]["id_usuario"]."</b> no tiene permisos para accedar a esta Página.";
            $this->view->render('403');
        }
        exit;

    }

}
?>