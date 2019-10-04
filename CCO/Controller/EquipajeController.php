<?php

/**
 * Description of EquipajeController
 *
 * @author ihuapaya
 */
class EquipajeController extends Controller {

    public $permisos;
    public function __construct(){
        parent::__construct();
        
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        } else {
            if ($this->isAccessProgram("CCO_SEG_VUELOS_EQUI", 1)) {
                $this->permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_EQUI", 1);
                $this->_view->assign("permiso_equi", $this->permisos);
            }
        }
    }

    public function indexAction() {
        if ($this->isPost()) {
            if ($this->isAccessProgram("CCO_SEG_VUELOS_EQUI", 1)) {
                $this->_view->maintpl = "mainx";
                $obj_ciudad = new Ciudad();
                $listCiudad = $obj_ciudad->getAll();

                $id_vuelo_detalle = $_POST['id_vuelo_detalle'];

                $obj_vuelo_detalle = new VueloDetalle();
                $row_detalle = $obj_vuelo_detalle->getRowById($id_vuelo_detalle);

                $rpt = 0;
                $html_hora = "";
                $msg_error = "";
                if (count($row_detalle) > 0) {
                    $obj_vuelo_pasajero = new VueloPasajero();
                    $row_equipaje = $obj_vuelo_pasajero->getRowByFlight($id_vuelo_detalle);
                    $txtTTL = $txtBAGPZS = $txtBAGKGS = $txtBAGBIN = $txtCARPZS = $txtCARKGS = $txtCARBIN = 0;
                    if (count($row_equipaje)) {
                        $txtTTL = trim($row_equipaje[0]->nro_toneladas_ttl);
                        $txtBAGPZS = trim($row_equipaje[0]->nro_piezas);
                        $txtBAGKGS = trim($row_equipaje[0]->nro_klos);
                        $txtBAGBIN = trim($row_equipaje[0]->nro_bin);
                        $txtCARPZS = trim($row_equipaje[0]->nro_piezas_carga);
                        $txtCARKGS = trim($row_equipaje[0]->nro_kilos_carga);
                        $txtCARBIN = trim($row_equipaje[0]->nro_bin_carga);
                    }


                    if ($txtTTL === "") {
                        $txtTTL = "0";
                    }
                    if ($txtBAGPZS === "") {
                        $txtBAGPZS = "0";
                    }
                    if ($txtBAGKGS === "") {
                        $txtBAGKGS = "0";
                    }
                    if ($txtBAGBIN === "") {
                        $txtBAGBIN = "0";
                    }
                    if ($txtCARPZS === "") {
                        $txtCARPZS = "0";
                    }
                    if ($txtCARKGS === "") {
                        $txtCARKGS = "0";
                    }
                    if ($txtCARBIN === "") {
                        $txtCARBIN = "0";
                    }
                    /*                 * ******** cabecera******************************* */
                    $this->_view->assign("fecha", $_POST["fecha_vuelo"]);
                    $this->_view->assign("matricula", $_POST["matricula"]);
                    $this->_view->assign("nro_vuelo", $_POST["nro_vuelo"]);
                    $this->_view->assign("ruta", $_POST["ruta"]);
                    $this->_view->assign("id_vuelo_cabecera", $_POST["id_vuelo_cabecera"]);
                    $this->_view->assign("id_vuelo_detalle", $id_vuelo_detalle);
                    $this->_view->assign("listCiudad", $listCiudad);
                    $this->_view->assign("edit_ruta", 1);
                    /*                 * *************************************************** */


                    $this->_view->assign("txt_ttl", $txtTTL);
                    $this->_view->assign("txt_BAGPZS", $txtBAGPZS);
                    $this->_view->assign("txt_BAGKGS", $txtBAGKGS);
                    $this->_view->assign("txt_BAGBIN", $txtBAGBIN);
                    $this->_view->assign("txt_CARPZS", $txtCARPZS);
                    $this->_view->assign("txt_CARKGS", $txtCARKGS);
                    $this->_view->assign("txt_CARBIN", $txtCARBIN);
                    $txtReadonly = "";
                    $view_component = 1;
                    if ($row_detalle[0]["estado_vuelo"] == 6) {
                        $txtReadonly = "readonly";
                        $view_component = 0;
                    }
                    $this->_view->assign("view_component", $view_component);
                    $this->_view->assign("txtReadonly", $txtReadonly);
                    $rpt = 1;
                    $html_hora = $this->_view->fetch('equipaje.tpl');
                } else {
                    $rpt = 0;
                    $msg_error = "No existe el Id =>" . $id_vuelo_detalle;
                }
            }else{
                $rpt = 0;
                $html_hora = "";
                $msg_error = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
            }
            echo json_encode(array(
                "rpt" => $rpt,
                "html_hora" => $html_hora,
                "msg_error" => $msg_error
                    )
            );
            
        } else {
            $this->_view->assign("error_text", "HTTP Status 405 – HTTP method GET is not supported by this URL");
            $this->_view->show_page("405.tpl");
            exit;
        }

    }

    public function saveAction() {
        if ($this->isPost()) {
            if($this->permisos[0]["Agregar"] == 1){
                if (count($this->validForm($_POST)) == 0) {
                    $id_vuelo_detalle = $_POST["id_vuelo_detalle"];
                    $nro_piezas = $_POST["txt_BAGPZS"];
                    $txt_BAGKGS = $_POST["txt_BAGKGS"];
                    $txt_BAGBIN = trim($_POST["txt_BAGBIN"], '-');
                    $txt_CARPZS = $_POST["txt_CARPZS"];
                    $txt_CARKGS = $_POST["txt_CARKGS"];
                    $txt_CARBIN = trim($_POST["txt_CARBIN"], '-');
                    $obj_vuelo_pasajero = new VueloPasajero();
                    $row_vuelo_pasajero = $obj_vuelo_pasajero->getRowByFlight($id_vuelo_detalle);
                    $rpt = 0;
                    $msg = "";
                    $error = array();

                    if (count($row_vuelo_pasajero) > 0) {
                        $array_data = array(
                            "nro_toneladas_ttl" => "",
                            "nro_piezas" => $nro_piezas,
                            "nro_klos" => $txt_BAGKGS,
                            "nro_bin" => $txt_BAGBIN,
                            "nro_piezas_carga" => $txt_CARPZS,
                            "nro_kilos_carga" => $txt_CARKGS,
                            "nro_bin_carga" => $txt_CARBIN,
                            "UsuarioMod" => $_SESSION[NAME_SESS_USER]["id_usuario"],
                            "FechaMod" => date("Y-m-d H:i:s")
                        );

                        $where = array("id_vuelo_detalle" => $id_vuelo_detalle);
                        if ($obj_vuelo_pasajero->update($array_data, $where)) {
                            $rpt = 1;
                        } else {
                            $rpt = 0;
                            $msg = "Hubo un error al actualizar los datos!";
                        }
                    } else {
                        $array_data = array(
                            "id_vuelo_detalle" => $id_vuelo_detalle,
                            "nro_toneladas_ttl" => "",
                            "nro_piezas" => $nro_piezas,
                            "nro_klos" => $txt_BAGKGS,
                            "nro_bin" => $txt_BAGBIN,
                            "nro_piezas_carga" => $txt_CARPZS,
                            "nro_kilos_carga" => $txt_CARKGS,
                            "nro_bin_carga" => $txt_CARBIN,
                            "UsuarioReg" => $_SESSION[NAME_SESS_USER]["id_usuario"],
                            "FechaReg" => date("Y-m-d H:i:s")   
                        );

                        if ($obj_vuelo_pasajero->insert($array_data)) {
                            $rpt = 1;
                        } else {
                            $rpt = 0;
                            $msg = "Hubo un error al insertar los datos!";
                        }
                    }
                } else {
                    $rpt = 0;
                    $msg = "Hubo un error al insertar los datos!. (Los campos deben ser solo Números).";
                    $error = $this->validForm($_POST);
                }
            }else{
                $rpt = 0;
                $msg = "Error => No tienes permiso para agregar Equipaje";
                $error=array();
            }
        } else {
            $rpt = 0;
            $msg = "Metodo no valido";
            $error = array();
        }

        echo json_encode(array("rpt" => $rpt, "msj" => $msg, "error" => $error));
    }

    function validForm($vars) {
        $array_error = array();
        $a = 0;
        foreach ($vars as $key => $value) {
            if ($key != "txt_BAGBIN" && $key != "txt_CARBIN") {
                if (!$this->validNumero($value)) {
                    $pos = strpos($key, "BAG");
                    if ($pos !== false) {
                        $array_error[$a]["input"] = "Equipaje => " . substr($key, 7);
                    }

                    $posca = strpos($key, "CAR");
                    if ($posca !== false) {
                        $array_error[$a]["input"] = "Carga => " . substr($key, 7);
                    }

                    $array_error[$a]["msg_error"] = "No es Numero";
                    $a++;
                }
            } else {
                if ($value != "") {
                    if (!preg_match("/^[0-9-]+$/", trim($value, '-'))) { //check for a pattern of 1-9
                        $pos = strpos($key, "BAG");
                        if ($pos !== false) {
                            $array_error[$a]["input"] = "Equipaje => " . substr($key, 7);
                        }

                        $posca = strpos($key, "CAR");
                        if ($posca !== false) {
                            $array_error[$a]["input"] = "Carga => " . substr($key, 7);
                        }
                        $array_error[$a]["msg_error"] = "Formato Incorrecto";
                        $a++;
                    }
                }
            }
        }
        return $array_error;
    }

}
