<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TripulacionController
 *
 * @author ihuapaya
 */
class TripulacionController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {

        if ($this->isGet()) {
            $txt_search = "";
            $tripulacion = new Tripulacion();
            if (isset($_GET["search"]) && $_GET["search"]) {
                $txt_search = $_GET["search"];
            }

            $lisTripulacion = $tripulacion->getAll($txt_search);
            $this->_view->assign("search", $txt_search);
            $this->_view->assign("tipo_funcion", "");
            $this->_view->assign('title', "Listado de Tripulación");
            $this->_view->assign("lisTripulacion", $lisTripulacion);
            $this->_view->assign("JS", "tripulacion");
            $this->_view->show_page('Tripulacion/listado_vue.tpl');
        }
    }

    public function listaAction() {
        if ($this->isGet()) {
            $vars = $this->_request->getArgs();
            //print_r($vars);
            $txt_search = "";
            $lisTripulacion = array();
            $tripulacion = new Tripulacion();
            if (isset($_GET["search"]) && $_GET["search"]) {
                $txt_search = $_GET["search"];
            }
            $tipo_funcion = "";
            if (count($vars)) {
                $tipo_funcion = $vars[0];
                if ($vars[0] == "TV") {
                    $lisTripulacion = $tripulacion->getAll($txt_search, 'TV');
                } elseif ($vars[0] == "TC") {
                    $lisTripulacion = $tripulacion->getAll($txt_search, 'TC');
                }
            }

            $this->_view->assign("tipo_funcion", $tipo_funcion);
            $this->_view->assign("search", $txt_search);
            $this->_view->assign('title', "Listado de Tripulación");
            $this->_view->assign("lisTripulacion", $lisTripulacion);
            $this->_view->assign("JS", "tripulacion");
            $this->_view->show_page('Tripulacion/listado.tpl');
        }
    }
    
    public function listAction(){
        $tripulacion = new Tripulacion();
        $txt_search = "";
        if (isset($_GET["search"]) && $_GET["search"]) {
            $txt_search = $_GET["search"];
        }

        $lisTripulacion = $tripulacion->getAll($txt_search);
        echo json_encode($lisTripulacion);
        exit;
    }

    public function createAction() {
        if ($this->isPost()) {
            $this->_view->maintpl = "mainx";
            if (isset($_POST["tipo_funcion"]) && $_POST["tipo_funcion"] != "") {
                $trip_funcion = new Tripulacion();
                $list_tripfun = $trip_funcion->getFunciones($_POST["tipo_funcion"]);
            } else {
                $trip_funcion = new TripulanteFuncion();
                $list_tripfun = $trip_funcion->getAll();
            }

            $this->_view->assign("list_tripfuncion", $list_tripfun);
            $this->_view->display("Tripulacion/create.tpl");
        }
    }

    public function editAction() {


        if ($this->isPost()) {
            $this->_view->maintpl = "mainx";
            $obj_tripulacion = new Tripulacion();
            $tripulante = $obj_tripulacion->getRowById($_POST["id_tripulante"]);

            if (isset($_POST["tipo_funcion"]) && $_POST["tipo_funcion"] != "") {
                $trip_funcion = new Tripulacion();
                $list_tripfun = $trip_funcion->getFunciones($_POST["tipo_funcion"]);
            } else {
                $trip_funcion = new TripulanteFuncion();
                $list_tripfun = $trip_funcion->getAll();
            }
            $this->_view->assign("list_tripfuncion", $list_tripfun);

            $id_funcion = $tripulante[0]["TRIPFUN_id"];
            $licencia = $tripulante[0]["TRIP_numLicencia"];
            $num_doc = $tripulante[0]["TRIP_numdoc"];
            $nombre = $tripulante[0]["TRIP_nombre"];
            $apellido = $tripulante[0]["TRIP_apellido"];

            $telefono = $tripulante[0]["TRIP_telefono"];
            $celular = $tripulante[0]["TRIP_celular"];
            $email = $tripulante[0]["TRIP_correo"];

            $this->_view->assign("id_tripulante", $_POST["id_tripulante"]);
            $this->_view->assign("licencia", $licencia);
            $this->_view->assign("num_doc", $num_doc);
            $this->_view->assign("nombre", $nombre);
            $this->_view->assign("apellido", $apellido);
            $this->_view->assign("telefono", $telefono);
            $this->_view->assign("celular", $celular);
            $this->_view->assign("email", $email);
            $this->_view->assign("id_funcion", $id_funcion);

            $this->_view->display("Tripulacion/edit.tpl");
        }
    }

    public function storeAction() {

        if ($this->isPost()) {

            $id_funcion = $_POST["id_funcion"];
            $licencia = $_POST["licencia"];
            $num_documento = $_POST["num_documento"];
            $nombre = $_POST["nombre"];
            $apellidos = $_POST["apellidos"];
            $telefono = $_POST["telefono"];
            $celular = $_POST["numcelular"];
            $email = $_POST["email"];

            $array_data = array(
                "TRIPFUN_id" => $id_funcion,
                "TRIP_numdoc" => $num_documento,
                "TRIP_nombre" => $nombre,
                "TRIP_apellido" => $apellidos,
                "TRIP_telefono" => $telefono,
                "TRIP_celular" => $celular,
                "TRIP_correo" => $email,
                "TRIP_numLicencia" => $licencia
            );
            $rpt = 0;
            $msg = "";
            $obj_Tripulacion = new Tripulacion();
            if ($obj_Tripulacion->insert($array_data)) {
                $rpt = 1;
                $msg = "";
            } else {
                $rpt = 0;
                $msg = "Error al insertar Tripulante";
            }
        } else {
            $rpt = 0;
            $msg = "Methodo no permitido";
        }


        echo json_encode(array("rpt" => $rpt, "msg" => $msg));
        exit;
    }

    function updateAction() {
        if ($this->isPost()) {

            $id_funcion = $_POST["id_funcion"];
            $licencia = $_POST["licencia"];
            $num_documento = $_POST["num_documento"];
            $nombre = $_POST["nombre"];
            $apellidos = $_POST["apellidos"];
            $telefono = $_POST["telefono"];
            $celular = $_POST["numcelular"];
            $email = $_POST["email"];

            $array_data = array(
                "TRIPFUN_id" => $id_funcion,
                "TRIP_numdoc" => $num_documento,
                "TRIP_nombre" => $nombre,
                "TRIP_apellido" => $apellidos,
                "TRIP_telefono" => $telefono,
                "TRIP_celular" => $celular,
                "TRIP_correo" => $email,
                "TRIP_numLicencia" => $licencia
            );
            $rpt = 0;
            $msg = "";
            $where = array("TRIP_id" => $_POST["id_tripulante"]);
            $obj_Tripulacion = new Tripulacion();
            if ($obj_Tripulacion->update($array_data, $where)) {
                $rpt = 1;
                $msg = "";
            } else {
                $rpt = 0;
                $msg = "Error al insertar Tripulante";
            }
        } else {
            $rpt = 0;
            $msg = "Methodo no permitido";
        }

        echo json_encode(array("rpt" => $rpt, "msg" => $msg));
        exit;
    }

    function desactivarAction() {
        if ($this->isPost()) {
            $obj_tripulacion = new Tripulacion();
            $rpt = 0;
            $msg = "";
            if ($obj_tripulacion->updateStatus($_POST["id_tripulante"], 0)) {
                $rpt = 1;
                $msg = "Tripulante ha sido desactivado";
            } else {
                $rpt = 0;
                $msg = "Error al desactivar tripulante";
            }
        } else {
            $rpt = 0;
            $msg = "Methodo no permitido";
        }
        echo json_encode(array("rpt" => $rpt, "msg" => $msg));
        exit;
    }

    function activarAction() {
        if ($this->isPost()) {
            $obj_tripulacion = new Tripulacion();
            $rpt = 0;
            $msg = "";
            if ($obj_tripulacion->updateStatus($_POST["id_tripulante"], 1)) {
                $rpt = 1;
                $msg = "Tripulante ha sido dactivado";
            } else {
                $rpt = 0;
                $msg = "Error al activar tripulante";
            }
        } else {
            $rpt = 0;
            $msg = "Methodo no permitido";
        }
        echo json_encode(array("rpt" => $rpt, "msg" => $msg));
        exit;
    }

    function deleteAction() {
        if ($this->isPost()) {
            $obj_tripulacion = new Tripulacion();
            $rpt = 0;
            $msg = "";
            if ($obj_tripulacion->delete($_POST["id_tripulante"])) {
                $rpt = 1;
                $msg = "Tripulante ha sido eliminado";
            } else {
                $rpt = 0;
                $msg = "Error al eliminar tripulante";
            }
        } else {
            $rpt = 0;
            $msg = "Methodo no permitido";
        }
        echo json_encode(array("rpt" => $rpt, "msg" => $msg));
        exit;
    }

}
