<?php

/**
 * Description of TripulacionController
 *
 * @author ihuapaya
 */
class VuelotripulacionController extends Controller {
    public $permisos;
    public function __construct() {
        parent::__construct();
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        } else {
            if (!$this->isAccessProgram("CCO_SEG_VUELOS_TRI", 1)) {
                if($this->isPost()){
                    $this->_view->maintpl = "mainx";
                    $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
                    $this->_view->display("403.tpl");
                    exit;
                }else{
                    $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
                    $this->_view->show_page("403.tpl");
                    exit;
                }
            }else{
                $this->permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_TRI", 1);
                $this->_view->assign("permiso_tri", $this->permisos);  
            }
        }
    }

    public function indexAction() {
        if($this->isPost()){

                $this->_view->maintpl = "mainx";

                $obj_tripulacion = new Tripulacion();
                $tripulacion_cabina = $obj_tripulacion->getTripulacionByFunction("cabina");
                $tripulacion_servicios = $obj_tripulacion->getTripulacionByFunction("servicios");
                $tripulacion_practicante = $obj_tripulacion->getTripulacionByFunction("practicante");

                /*****************Listado de tripulacion*************************/

                $list_tripulacion_cabina = $obj_tripulacion->getVueloTripulacion($_POST["id_vuelo_cabecera"],"C");
                $list_tripulacion_servicio = $obj_tripulacion->getVueloTripulacion($_POST["id_vuelo_cabecera"],"S");
                $list_tripulacion_practicante = $obj_tripulacion->getVueloTripulacion($_POST["id_vuelo_cabecera"],"P");

                $estado_inst = array_filter($list_tripulacion_cabina, function ($element) { 
                                    return $element["estado_instructor"]==1;
                                });

                $statusInstructor = 0;
                if(count($estado_inst)>0){
                    $statusInstructor = 1;
                }

                $funciones = $obj_tripulacion->getFunciones("TC");

                $this->_view->assign('list_funciones', $funciones);

                $this->_view->assign("fecha", $_POST["fecha_vuelo"]);
                $this->_view->assign("matricula", $_POST["matricula"]);
                $this->_view->assign("nro_vuelo", $_POST["nro_vuelo"]);
                $this->_view->assign("ruta", $_POST["ruta"]);
                $this->_view->assign("id_vuelo_cabecera", $_POST["id_vuelo_cabecera"]);

                $this->_view->assign("cbo_cabina", $tripulacion_cabina);
                $this->_view->assign("cbo_servicios", $tripulacion_servicios);
                $this->_view->assign("cbo_practicante", $tripulacion_practicante);

                $this->_view->assign("statusInstructor", $statusInstructor);
                $this->_view->assign("list_tripulacion_cabina", $list_tripulacion_cabina);
                $this->_view->assign("list_tripulacion_servicio", $list_tripulacion_servicio);
                $this->_view->assign("list_tripulacion_practicante", $list_tripulacion_practicante);

                $obj_vuelo_detalle = new VueloDetalle();
                $id_vuelo_detalle = $_POST["id_vuelo_detalle"];
                $txtReadonly="";
                $view_component = 1;
                if($obj_vuelo_detalle->verificarEstadoCierreVuelo($id_vuelo_detalle)){
                    $txtReadonly="readonly";
                    $view_component = 0;
                }
            
                $this->_view->assign("view_component",$view_component);
                $this->_view->assign("txtReadonly",$txtReadonly);

                $this->_view->display('tripulacion.tpl');
                exit;
            
        }else{
            $this->_view->assign("error_text", "HTTP Status 405 – HTTP method GET is not supported by this URL");
            $this->_view->show_page("405.tpl");
            exit;
        }
    }

    public function getFuncionesAction() {
        $this->_view->maintpl = "mainx";

        $idTripulacion = $_POST["id_tripulacion"];
        $id_funcion = $_POST['id_funcion'];
        $tipoTripulacion = $_POST['tipoTripulacion'];
        $idTipoTripulacion = $_POST['idTipoTripulacion'];

        $obj_tripulacion = new Tripulacion();
        $funciones = $obj_tripulacion->getFunciones($idTipoTripulacion);

        $this->_view->assign('list_funciones', $funciones);
        $this->_view->assign('id_funcion', $id_funcion);
        $html_funcion_cbo = $this->_view->fetch('Tripulacion/tripulacion_funcion.tpl');
        echo json_encode(array("rpt" => 1, "html_cbo_funciones" => $html_funcion_cbo));
        exit;
    }

    public function addTripulacionAction() {

        if ($this->isPost()) {
            
            if($this->permisos[0]["Agregar"] == 1){
                $id_funcion = $_POST['id_funcion'];
                $id_tripulacion = $_POST['id_tripulacion'];
                $id_vuelo_cabecera = $_POST['id_vuelo_cabecera'];
                $tipo_tripulacion = $_POST['tipo_tripulacion'];
                $rpt = 0;
                $msg_error = "";
                $html_tripulacion = "";
                if ($id_funcion == "" || $id_funcion == 0) {
                    $rpt = 0;
                } else {
                    $obj_tripulacion = new Tripulacion();
                    $sql_exit_pilot_copiloto = "select TRIPFUN_id  from Vuelo_Tripulacion where TRIPFUN_id in (1,2,6) and id_vuelo_cabecera='".$id_vuelo_cabecera."'";
                    $rs_exit_pilot_copiloto = $obj_tripulacion->Consultar($sql_exit_pilot_copiloto);
                    $array_piloto_or_copiloto = array_filter($rs_exit_pilot_copiloto, function ($element) use ($id_funcion){         
                                        return $element["TRIPFUN_id"]==$id_funcion;
                                    });

                    if(count($array_piloto_or_copiloto)==0){
                        if ($obj_tripulacion->existeTripulacion($id_vuelo_cabecera, $id_tripulacion, $id_funcion,$tipo_tripulacion)) {
                            $array_columns = array(
                                'id_vuelo_cabecera' => $id_vuelo_cabecera,
                                'TRIP_id' => $id_tripulacion,
                                'TRIPFUN_id' => $id_funcion,
                                'dia_vuelo' => date("l"),
                                'estado_programado' => 1,
                                'UsuarioReg' => $_SESSION[NAME_SESS_USER]["id_usuario"],
                                'FechaReg' => date("Y-m-d")
                            );
                            if ($obj_tripulacion->insertData('Vuelo_Tripulacion', $array_columns)) {
                                $html_tripulacion = $this->listVueloTripulacion($id_vuelo_cabecera, $obj_tripulacion,$tipo_tripulacion);
                                $rpt = 1;
                            }
                        } else {
                            /*                     * error* */
                            $rpt = 0;
                            $msg_error = "Tripulante ya Ingresado en este vuelo";
                        }
                    } else {
                            /*                     * error* */
                            $rpt = 0;
                            switch ($id_funcion) {
                                case 1:
                                    $msg_error = "Ya existe un Piloto";
                                    break;
                                case 2:
                                    $msg_error = "Ya existe unCopiloto";
                                    break;
                                case 6:
                                    $msg_error = "Ya existe un Jefe de Cabina";
                                    break;
                                default:
                                    break;
                            }

                    }
                }
            }else{
                $rpt = 0;
                $msg_error = "Error => No tienes permiso para agregar Tripulacion";
                $html_tripulacion = "";
            }
            
        } else {
            /*             * error* */
            $rpt = 0;
            $msg_error = "Metodo Incorrecto";
        }

        echo json_encode(array("rpt" => $rpt, "html_vuelo_tripulacion" => $html_tripulacion, "msg_error" => $msg_error));
        exit;
    }

    function listVueloTripulacion($id_vuelo_cabecera, $obj_tripulacion,$tipo_tripulacion="") {
        $vuelo_tripulacion = $obj_tripulacion->getVueloTripulacion($id_vuelo_cabecera,$tipo_tripulacion);
        $html_head_instructo="";
        if($tipo_tripulacion=='C'){
            $html_head_instructo .= "<th scope='col' class='text-center' width='100px'>Instructo</th>";
        }
        $html_tripulacion = "<table  class='table table-striped table-hover table-bordered' style='font-size: 12px;margin-bottom: 0px;'>"
                . "<thead>"
                . "<tr>"
                . "<th scope='col' width='250px' >Nombre</th>"
                . "<th scope='col'  width='150px'>Función</th>"
                . $html_head_instructo
                . "<th scope='col' width='100px' class='text-center'>Accion</th>"
                . "</tr>"
                . "</thead>"
                . "<tbody style='font-size: 10px; color: #566787;'>";
        
        $estado_inst = array_filter($vuelo_tripulacion, function ($element) { 
                            return $element["estado_instructor"]==1;
                        }); 
        $statusInstructor = 0;
        if(count($estado_inst)>0){
            $statusInstructor = 1;
        }
        foreach ($vuelo_tripulacion as $key => $value) {
            $html_tripulacion .= "<tr>";
            $html_tripulacion .= "<td>" . $value["nombres"] . "</td>";
            $html_tripulacion .= "<td>" . $value["descripcion_funcion"] . "</td>";
            if($tipo_tripulacion=='C'){
                
                $html_status_instructor='';
                if($statusInstructor==0){
                    $html_status_instructor .= "<input type='checkbox' "
                            . "name='chk_insctructor' "
                            . "class='chkInstructor' "
                            . "data-id-vt='".$value['id_vuelo_tripulacion']."' "
                            . "data-nombre='".$value['nombres']."' "
                            . "data-id-vuelo-cabecera='".$value['id_vuelo_cabecera']."'>";
                }else{
                    if($value['estado_instructor']==1){
                        $html_status_instructor .= "<font color='red'>Instructor</font>";
                    }
                }
                 $html_tripulacion .= "<td align='center'>".$html_status_instructor."</td>";
                
            }
            if($this->permisos[0]["Eliminar"] == 1){
                $html_tripulacion .= "<td align='center'>"
                        . "<a href='#' class='deleteTripulacion' id='tripulacion' data-id='" . $value["id_vuelo_tripulacion"] . "' data-tipoTripulacion='".$tipo_tripulacion."'>"
                        . "<img src='" . SERVER_PUBLIC . "img/delete_cicle.png' width='20px' />"
                        . "</a>"
                        . "</td>";
            }
            $html_tripulacion .= "</tr>";
        }

        $html_tripulacion .= "</tbody></table>";
        return $html_tripulacion;
    }

    public function deleteVueloTripulacionAction() {
        if ($this->isPost()) {
            if($this->permisos[0]["Eliminar"] == 1){
                $id_vuelo_tripulacion = $_POST["id_vuelo_tripulacion"];
                $id_vuelo_cabecera = $_POST['id_vuelo_cabecera'];
                $tipo_tripulacion = $_POST["tipo_tripulacion"];
                $obj_tripulacion = new Tripulacion();
                $rpt = 0;
                $msg_error = "";
                $html_tripulacion="";
                if ($obj_tripulacion->deleteVueloTripulacion($id_vuelo_tripulacion)) {
                    $rpt = 1;
                    $html_tripulacion = $this->listVueloTripulacion($id_vuelo_cabecera, $obj_tripulacion,$tipo_tripulacion);
                } else {
                    $rpt = 0;
                    $msg_error = "Error al elimar el ID =>" . $id_vuelo_tripulacion;
                }
            }else{
                $rpt = 0;
                $msg_error = "No Tienes permiso para realizar esta Acción.";
                $html_tripulacion = "";
            }
        } else {
            $rpt = 0;
            $msg_error = "Metodo Incorrecto";
        }
        echo json_encode(array("rpt" => $rpt, "html_vuelo_tripulacion" => $html_tripulacion, "msg_error" => $msg_error));
        exit;
    }
    
    public function asignarInstructorAction(){
        if($this->isPost()){
            $id_vuelo_tripulacion   = $_POST["id_vuelo_tripulacion"];
            $tipo_tripulacion       = $_POST["tipo_tripulacion"];
            $id_vuelo_cabecera      = $_POST['id_vuelo_cabecera'];
            $rpt = 0;
            $msg_error = "";
            $html_tripulacion="";
            $obj_tripulacion = new Tripulacion();
            if($obj_tripulacion->asignarInstuctor($id_vuelo_tripulacion)){
               $rpt = 1;
                $html_tripulacion = $this->listVueloTripulacion($id_vuelo_cabecera, $obj_tripulacion,$tipo_tripulacion);
            } else {
                $rpt = 0;
                $msg_error = "Error al elimar el ID =>" . $id_vuelo_tripulacion;
            }
        }else {
            $rpt = 0;
            $msg_error = "Metodo Incorrecto";
        }
        echo json_encode(array("rpt" => $rpt, "html_vuelo_tripulacion" => $html_tripulacion, "msg_error" => $msg_error));
        exit;
    }

}
