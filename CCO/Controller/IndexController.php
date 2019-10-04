<?php

class IndexController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->_view->assign("JS", "lista_vuelo");
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        } else {
            //echo "a";exit;
            if (!$this->isAccessProgram("CCO_SEG_VUELOS", 1)) {
                $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
                $this->_view->show_page("403.tpl");
                exit;
            } else {
                $permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS", 1);
                $this->_view->assign("permiso", $permisos);
            }
        }
    }

    public function indexAction() {

        $fecha = date("Y-m-d");
        $ciudad_origen = "";
        $nro_vuelo = "";
        if ($this->isGet()) {
            if (isset($_GET["fecha"]) && $_GET["fecha"] != "") {
                $fecha = $_GET["fecha"];
            }

            if (isset($_GET["origen"]) && $_GET["origen"] != "") {
                $ciudad_origen = strtoupper($_GET["origen"]);
            }

            if (isset($_GET["nro_vuelo"]) && $_GET["nro_vuelo"] != "") {
                $nro_vuelo = $_GET["nro_vuelo"];
            }
        }
        //echo $fecha;
        $this->_view->assign("fecha", $fecha);
        $this->_view->assign("ciudad_origen", strtoupper($ciudad_origen));
        $this->_view->assign("nro_vuelo", $nro_vuelo);
        $data = array();
        $obj_vuelo_cabecera = new VueloCabecera();
        $data_vuelo_cabecera = $obj_vuelo_cabecera->getFligthByDate($fecha);
        $obj_vuelo_detalle = new VueloDetalle();

        foreach ($data_vuelo_cabecera as $key => $cabecera) {
            $data_detalle = $obj_vuelo_detalle->getFligthDetail($cabecera["id_vuelo_cabecera"], $ciudad_origen, $nro_vuelo);
            foreach ($data_detalle as $detalle) {
                $data_dev = new stdClass();
                $data_dev->id_vuelo_detalle = $detalle["id_vuelo_detalle_ori"];
                $data_dev->id_vuelo_cabecera = $detalle["id_vuelo_cabecera"];
                $data_dev->fecha_vuelo = $cabecera['fecha_vuelo'];
                $data_dev->id_matricula = $detalle['IdMatricula'];
                $data_dev->nro_vuelo = $detalle['NroVuelo'];
                $data_dev->ruta = $detalle['ciudad_origen'] . " - " . $detalle['ciudad_destino'];
                $data_dev->orden = $detalle['orden'];
                $data_dev->vuelo_direccion = $detalle['vuelo_direccion'];
                $data_dev->vuelo_operativo = $detalle['vuelo_operativo'];
                $data_dev->t_off = $detalle['take_out_hora_despegue'];
                $data_dev->nro_adultos = $detalle["nro_adultos"];
                $data_dev->nro_menores = $detalle["nro_menores"];
                $data_dev->nro_infantes = $detalle["nro_infantes"];
                $data_dev->nro_klos = $detalle["nro_klos"];
                $data_dev->nro_piezas = $detalle["nro_piezas"];
                $data_dev->estado_vuelo = $detalle["estado_vuelo"];
                $data_dev->color_arr_in = "";
                $data_dev->class_tr = "";
                if (strlen(trim($detalle["arr_in_hora_arribo"])) > 1 && $detalle["arr_in_hora_arribo"] == '00:00') {
                    $data_dev->color_arr_in = "b61818";
                }

                $data_dev->arr_in = $detalle['arr_in_hora_arribo'];
                $flag_hora = 0;
                if ($data_dev->vuelo_operativo == "O" &&
                        $data_dev->vuelo_direccion == "VUE") {

                    if ($detalle['ciudad_parada'] == "" && $data_dev->orden == 1) {
                        $flag_hora = 1;
                    }
                    if ($detalle['ciudad_parada'] != "" && $data_dev->orden == 2) {
                        $flag_hora = 1;
                    }
                }

                if ($data_dev->vuelo_operativo == "C") {
                    $data_dev->class_tr = "info";
                    if ($data_dev->t_off == "") {
                        $data_dev->t_off = "-";
                    }

                    if ($data_dev->arr_in == "") {
                        $data_dev->arr_in = "-";
                    }
                }
                $data_dev->flag_hora = $flag_hora;
                $data_dev->filas_incompleta = "";
                if ($data_dev->vuelo_operativo == "O") {
                    if (($detalle["nro_adultos"] == "" || $detalle["nro_adultos"] == "0") ||
                            ($detalle["nro_menores"] == "" ) ||
                            ($detalle["nro_infantes"] == "" ) ||
                            ($detalle["nro_klos"] == "" || $detalle["nro_klos"] == "0" ) ||
                            ($detalle["nro_piezas"] == "" || $detalle["nro_piezas"] == "0" ) ||
                            ($detalle['take_out_hora_despegue'] == "" || $detalle['take_out_hora_despegue'] == "00:00") ||
                            ($detalle['arr_in_hora_arribo'] == "" || $detalle['arr_in_hora_arribo'] == "00:00" )) {
                        $data_dev->filas_incompleta = "incompleto";
                    }
                } else {
                    if (($detalle["nro_adultos"] == "" || $detalle["nro_adultos"] == "0") ||
                            ($detalle["nro_menores"] == "" ) ||
                            ($detalle["nro_infantes"] == "" ) ||
                            ($detalle["nro_klos"] == "" || $detalle["nro_klos"] == "0" ) ||
                            ($detalle["nro_piezas"] == "" || $detalle["nro_piezas"] == "0" )) {
                        $data_dev->filas_incompleta = "incompleto";
                    }
                }


                $data["data"][] = $data_dev;
            }
        }
        $this->opciones();
        $this->_view->assign("opciones", $this->opciones());
        $this->_view->assign('array_vuelos', $data);
        $this->_view->assign('title', "Listado de Vuelos");
        
        $this->_view->assign("verificar_cierre",$obj_vuelo_detalle->verificarPreCierreVuelo($fecha));
        
        
        $this->_view->show_page('listadoVuelo.tpl');
    }

    function opciones() {

        $usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];

        $permisos = $this->getAllPermisos($usuario, 1);
        $permiso_incidencia = $this->PermisosporPaginas("CCO_SEG_VUELOS_INC",1);
        $permiso_tripulacion = $this->PermisosporPaginas("CCO_SEG_VUELOS_TRI",1);
        $permiso_pax = $this->PermisosporPaginas("CCO_SEG_VUELOS_PAX",1);
        $permiso_equipaje = $this->PermisosporPaginas("CCO_SEG_VUELOS_EQUI",1);
        $permiso_hora = $this->PermisosporPaginas("CCO_SEG_VUELOS_HORAS",1);
        $array_opciones = array();
        $acceso_indicencia = $permiso_incidencia[0]["Ejecutar"];
        $acceso_trip = $permiso_tripulacion[0]["Ejecutar"];
        $acceso_pasajero = $permiso_pax[0]["Ejecutar"];
        $acceso_equipaje = $permiso_equipaje[0]["Ejecutar"];
        $acceso_horas_vuelo =$permiso_hora[0]["Ejecutar"];
        if (count($permisos) > 0) {
            /*foreach ($permisos as $value) {

                switch ($value["IdPrograma"]) {
                    case "CCO_SEG_VUELOS_INC":
                        $acceso_indicencia = $value["Ejecutar"];
                        break;
                    case "CCO_SEG_VUELOS_TRI":
                        $acceso_trip = $value["Ejecutar"];
                        break;
                    case "CCO_SEG_VUELOS_PAX":
                        $acceso_pasajero = $value["Ejecutar"];
                        break;
                    case "CCO_SEG_VUELOS_EQUI":
                        $acceso_equipaje = $value["Ejecutar"];
                        break;
                    case "CCO_SEG_VUELOS_HORAS":
                        $acceso_horas_vuelo = $value["Ejecutar"];
                        break;
                }
            }*/
            $array_opciones = array(
                array(
                    "id" => "incidenciaVuelo",
                    "clase" => "incidenciaVuelo_modal",
                    "title" => "Incidencia Vuelo",
                    "icon" => SERVER_PUBLIC . 'img/editar.png',
                    "acceso" => $acceso_indicencia,
                ),
                array(
                    "id" => "tripulacion",
                    "clase" => "tripulacion_modal",
                    "title" => "Agregar tripulación",
                    "icon" => SERVER_PUBLIC . 'img/pilot_icon2.png',
                    "acceso" => $acceso_trip,
                ),
                array(
                    "id" => "pasajero",
                    "clase" => "pasajero_modal",
                    "title" => "Agregar Pasajero",
                    "icon" => SERVER_PUBLIC . 'img/pasajero3.png',
                    "acceso" => $acceso_pasajero,
                ),
                array(
                    "id" => "equipaje",
                    "clase" => "equipaje_modal",
                    "title" => "Agrega Equipaje",
                    "icon" => SERVER_PUBLIC . 'img/maleta.png',
                    "acceso" => $acceso_equipaje,
                ),
                array(
                    "id" => "flighttime",
                    "clase" => "flighttime_modal",
                    "title" => "Agrega Horas de Vuelo",
                    "icon" => SERVER_PUBLIC . 'img/reloj.png',
                    "acceso" => $acceso_horas_vuelo,
                )
            );
        }

        return $array_opciones;
    }

    public function incidenciasAction() {
        if ($this->isPost()) {
            if($this->isAccessProgram("CCO_SEG_VUELOS_INC", 1)){
                $this->_view->maintpl = "mainx";

                /*             * ********************Listado de cuidad**************************** */

                $id_vuelo_detalle = $_POST['id_vuelo_detalle'];
                $obj_vuelo_detalle = new VueloDetalle();
                $row_detalle = $obj_vuelo_detalle->getRowById($id_vuelo_detalle);

                $rpt = 0;
                $html_incidencias = "";
                $msg_error = "";
                $html_vueloincidencia = "";
                if (count($row_detalle) > 0) {
                    /*                 * ******** cabecera******************************* */
                    $this->_view->assign("fecha", $_POST["fecha_vuelo"]);
                    $this->_view->assign("matricula", $_POST["matricula"]);
                    $this->_view->assign("nro_vuelo", $_POST["nro_vuelo"]);
                    $this->_view->assign("ruta", $_POST["ruta"]);
                    $this->_view->assign("id_vuelo_cabecera", $_POST["id_vuelo_cabecera"]);
                    $this->_view->assign("edit_ruta", 0);
                    $this->_view->assign("id_vuelo_detalle", $id_vuelo_detalle);
                    /*                 * *************************************************** */

                    $objIncidencia = new TipoIncidencia();
                    $listIncidecia = $objIncidencia->getAll();

                    $this->_view->assign("array_inci", $listIncidecia);

                    $html_vueloincidencia = $this->listIncidencias($id_vuelo_detalle);

                    $txtReadonly = "";
                    $view_component = 1;
                    if ($obj_vuelo_detalle->verificarEstadoCierreVuelo($id_vuelo_detalle)) {
                        $txtReadonly = "readonly";
                        $view_component = 0;
                    }
                    $permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_INC", 1);
                    $this->_view->assign("permiso_inc", $permisos); 
                    $this->_view->assign("view_component", $view_component);
                    $this->_view->assign("txtReadonly", $txtReadonly);
                    $rpt = 1;
                    $html_incidencias = $this->_view->fetch('incidencias.tpl');
                } else {
                    $rpt = 0;
                    $html_incidencias = "";
                    $msg_error = "No existe el Id =>" . $id_vuelo_detalle;
                }
                
            }else{
                $rpt = 0;
                $html_incidencias = "";
                $msg_error = "No tienes Acceso a esta Página";
            }
            
        } else {
            $rpt = 0;
            $html_incidencias = "";
            $msg_error = "Error Metodo POST";
        }

        echo json_encode(
                array(
                    "rpt" => $rpt,
                    "html_incidencia" => $html_incidencias,
                    "html_vuelo_incidencia" => $html_vueloincidencia,
                    "msg_error" => $msg_error
                )
        );

        exit;
    }

    public function saveIncidenciaAction() {
        if ($this->isPost()) {
            $permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_INC", 1);
            if($permisos[0]["Agregar"]==1){
                $id_vuelo_detalle = $_POST["id_vuelo_detalle"];
                $id_incidencia = $_POST["id_incidencia"];
                $observacion = $_POST["observacion"];
                $rpt = 0;
                $msg_error = "";
                $html_vuelo_incidenia = "";
                if ($id_incidencia >= 0) {
                    try {
                        $values = array(
                            "id_vuelo_detalle" => $id_vuelo_detalle,
                            "id_incidencia" => $id_incidencia,
                            "observacion" => string_sanitize($observacion),
                            "UsuarioReg" => $_SESSION[NAME_SESS_USER]["id_usuario"],
                            "FechaReg" => date("Y-m-d H:i:s")
                        );

                        $obj_vueloincidencia = new VueloIncidencia();
                        if ($obj_vueloincidencia->save($values)) {
                            $rpt = 1;
                            $html_vuelo_incidenia = $this->listIncidencias($id_vuelo_detalle);
                        } else {
                            $rpt = 0;
                            $msg_error = "Ocurrio un error al insertar los datos, Intente otra vez.";
                        }
                    } catch (PDOException $ex) {
                        $rpt = 0;
                        $msg_error = $ex->getMessage();
                    }
                } else {
                    $rpt = 0;
                    $msg_error = "Elija un tipo de incidencia";
                }
            }else{
                $rpt = 0;
                $html_vuelo_incidenia = "";
                $msg_error = "No Tienes permiso para guardar un tipo de incidencia";
            }
            
        } else {
            $rpt = 0;
            $html_vuelo_incidenia = "";
            $msg_error = "Error Metodo POST";
        }

        echo json_encode(array("rpt" => $rpt, "html_vuelo_incidencia" => $html_vuelo_incidenia, "msg_error" => $msg_error));
        exit;
    }

    public function listIncidencias($id_vuelo_detalle) {

        $obj_vueloIncidencias = new VueloIncidencia();
        $listVueloIncidencias = $obj_vueloIncidencias->getByIdDetalle($id_vuelo_detalle);
        $this->_view->assign("listVueloIncidencias", $listVueloIncidencias);
        $txtReadonly = "";
        $view_component = 1;
        $obj_vuelo_detalle = new VueloDetalle();
        if ($obj_vuelo_detalle->verificarEstadoCierreVuelo($id_vuelo_detalle)) {
            $txtReadonly = "readonly";
            $view_component = 0;
        }
        $permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_INC", 1);
        $this->_view->assign("permiso_inc", $permisos); 
        $this->_view->assign("view_component", $view_component);
        $this->_view->assign("txtReadonly", $txtReadonly);
        return $this->_view->fetch("listVueloIncidencia.tpl");
    }

    public function deleteVueloIncidenciaAction() {
        if ($this->isPost()) {
            $permisos = $this->PermisosporPaginas("CCO_SEG_VUELOS_INC", 1);
            if($permisos[0]["Eliminar"]==1){
                $id_vuelo_incidencia = $_POST["id_vuelo_incidencia"];
                $id_vuelo_detalle = $_POST["id_vuelo_detalle"];
                $obj_vuelo_incidencia = new VueloIncidencia();
                $rpt = 0;
                $msg_error = "";
                $html_vuelo_incidencias = "";
                if ($obj_vuelo_incidencia->deleteVueloIncidencia($id_vuelo_incidencia)) {
                    $rpt = 1;
                    $html_vuelo_incidencias = $this->listIncidencias($id_vuelo_detalle);
                } else {
                    $rpt = 0;
                    $msg_error = "Error al elimar el ID =>" . $id_vuelo_incidencia;
                }
            } else {
                $rpt = 0;
                $html_vuelo_incidencias = "";
                $msg_error = "Error => No tienes permiso para eliminar una incidencia." ;
            }
            
        } else {
            $rpt = 0;
            $html_vuelo_incidencias = "";
            $msg_error = "Metodo Incorrecto";
        }
        echo json_encode(array("rpt" => $rpt, "html_vuelo_incidencias" => $html_vuelo_incidencias, "msg_error" => $msg_error));
        exit;
    }

    function exportarExceLAction() {
        require_once ROOT . 'library/PHPExcel/Classes/PHPExcel.php';
        setlocale(LC_TIME, "es_ES");
        $fchConsultaArray = explode("-", $_GET["fecha"]);
        $fchConsulta = $fchConsultaArray[2] . "/" . $fchConsultaArray[1] . "/" . $fchConsultaArray[0];
        $fchConsulta2 = $fchConsultaArray[2] . "-" . $fchConsultaArray[1] . "-" . $fchConsultaArray[0];

        $fecha_string = nombreDia($_GET["fecha"], "L") . ", " . date("d", strtotime($_GET["fecha"])) . " DE " . nombreMes($_GET["fecha"]) . " DEL " . date("Y", strtotime($_GET["fecha"]));
        // Crear nuevo objeto PHPExcel
        $objPHPExcel = new PHPExcel();

        $this->imageLogo($objPHPExcel);

        // Propiedades del documento
        $objPHPExcel->getProperties()->setCreator("Ivan Huapaya")
                ->setLastModifiedBy("Ivan Huapaya")
                ->setTitle("Excel Programador Vuelo");

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        // Combino las celdas desde A1 hasta E1
        $sheet->mergeCells('B4:M4');
        $sheet->mergeCells('N4:R4');
        $sheet->mergeCells('D6:E6');
        $sheet->mergeCells('N6:Q6');
        $sheet->setCellValue('B4', 'PROGRAMACION DE VUELO')
                ->setCellValue('Y5', '00:05')
                ->setCellValue('Z5', '00:14')
                ->setCellValue('AA5', '00:29')
                ->setCellValue('A6', '')
                ->setCellValue('B6', 'VUELOS')
                ->setCellValue('C6', 'AVIÓN')
                ->setCellValue('A6', '')
                ->setCellValue('B6', 'VUELOS')
                ->setCellValue('C6', 'AVIÓN')
                ->setCellValue('D6', 'RUTA')
                ->setCellValue('F6', 'ETD')
                ->setCellValue('G6', 'ETA')
                ->setCellValue('H6', 'ATD')
                ->setCellValue('I6', 'ATA')
                ->setCellValue('J6', 'DLY 1')
                ->setCellValue('K6', 'DLY 2')
                ->setCellValue('L6', 'PAX')
                ->setCellValue('M6', 'TIME')
                ->setCellValue('N6', 'TRIPULACION')
                ->setCellValue('R6', 'APOYO EN VLO')
                ->setCellValue('X6', '00:00')
                ->setCellValue('Y6', 'hasta 5 min')
                ->setCellValue('Z6', 'hasta 15 min')
                ->setCellValue('AA6', '>30 min')
                ->setCellValue("N4", strtoupper($fecha_string));


        /* $boldArray = array(
          'font' => array('bold' => true,'size' => 15),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER),
          'borders' => array(
          'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF')),

          )
          ); */
        //$alignment = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $array_style = $this->estilosExcel(true, 15);

        $objPHPExcel->getActiveSheet()->getStyle('B4:M4')->applyFromArray($array_style);

        $objPHPExcel->getActiveSheet()->getStyle('N4:R4')->applyFromArray($array_style);


        /* $default_border = array(
          'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
          'color' => array('argb' => 'FFF')
          ); */

        /* $styleCabecera = array(
          'font' => array('size' => 11),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
          'borders' => array(
          'bottom' => $default_border,
          'left' => $default_border,
          'top' => $default_border,
          'right' => $default_border,
          ),
          ); */
        $styleCabecera = $this->estilosExcel(false, 11);
        $objPHPExcel->getActiveSheet()->getStyle('B6:M6')->applyFromArray($styleCabecera);

        /* $boldTRI = array(
          'font' => array('bold' => true, 'size' => 11),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
          'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF')))
          ); */
        $boldTRI = $this->estilosExcel(true, 11);
        $objPHPExcel->getActiveSheet()->getStyle('X6:AA6')->applyFromArray($boldTRI);
        $objPHPExcel->getActiveSheet()->getStyle('N6:Q6')->applyFromArray($boldTRI);

        $objPHPExcel->getActiveSheet()->getStyle('R6')->applyFromArray(array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF')))
        ));

        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(21.25);
        $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(21.25);

        $this->setAnchoColumnas($objPHPExcel);
        $obj_vuelo_detalle = new VueloDetalle();

        $styleArray_h = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'A2D4E2'),
            )
        );

        $styleArray_J_K = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DCE7C3'),
            )
        );

        $vuelo_tripulacion = new Tripulacion();
        $list_vuelo_tripulacion = $vuelo_tripulacion->getVueloTripulacion("", "", $_GET["fecha"]);
        $array_vuelo_tripulacion = array();
        foreach ($list_vuelo_tripulacion as $value) {
            $array_vuelo_tripulacion[$value['id_vuelo_cabecera']][] = $value;
        }

        $vuelo_incidencias = new VueloIncidencia();
        $lista_vuelo_incidencias = $vuelo_incidencias->getAll();
        $array_incidencias = array();

        foreach ($lista_vuelo_incidencias as $value) {
            $array_incidencias[$value['id_vuelo_detalle']][] = $value;
        }

        $rs_vuelos = $obj_vuelo_detalle->getVuelosOperativos($_GET["fecha"]);

        $cel = 7;
        $cont = 7;
        $sum_vuelos_salidos_itin = 0;
        $sum_vuelos_llegados_itin = 0;
        $tiempo_defecto = "00:00";
        $min14 = "00:14";
        $min29 = "00:29";
        $time_defecto = strtotime("$tiempo_defecto:00");
        $time_min14 = strtotime("$min14:00");
        $time_min29 = strtotime("$min29:00");
        $summin1 = 0;
        $summin2 = 0;
        $summin3 = 0;
        $cel_ini = 7;
        $init_val = 1;

        foreach ($rs_vuelos["data"]["vuelo_cabecera"] as $key1 => $valueDetalle) {
            $cont_cel = 0;
            foreach ($valueDetalle["detalle"] as $key => $value) {

                $objPHPExcel->getActiveSheet()->getRowDimension($cel)->setRowHeight(21.25);
                if ($value["vuelo_direccion"] == "IDA" && $value["orden"] == 1) {
                    if (isset($array_vuelo_tripulacion[$value["id_vuelo_cabecera"]]) && is_array($array_vuelo_tripulacion[$value["id_vuelo_cabecera"]])) {
                        $data_vuelo_tripulacion = $array_vuelo_tripulacion[$value["id_vuelo_cabecera"]];
                        $piloto = "";
                        $copiloto = "";
                        $jefe_cabina = "";
                        $tripulantes_aux = array();
                        foreach ($data_vuelo_tripulacion as $vue_tri) {
                            switch ($vue_tri["descripcion_funcion"]) {
                                case "Piloto":
                                    $piloto = $vue_tri["nombre_abreviado"];
                                    break;
                                case "Copiloto":
                                    $copiloto = $vue_tri["nombre_abreviado"];
                                    break;
                                case "Jefe de Cabina":
                                    $jefe_cabina = $vue_tri["nombre_abreviado"];
                                    break;
                                case "Tripulante de Cabina":
                                    $tripulantes_aux[] = $vue_tri["nombre_abreviado"];
                                    break;
                            }
                        }

                        $sheet->setCellValue("N" . $cel, $piloto);
                        $sheet->setCellValue("P" . $cel, $copiloto);
                        $sheet->setCellValue("N" . ($cel + 1), $jefe_cabina);
                        if (isset($tripulantes_aux[0]) && $tripulantes_aux[0] != "") {
                            $sheet->setCellValue("O" . ($cel + 1), $tripulantes_aux[0]);
                        }
                        if (isset($tripulantes_aux[1]) && $tripulantes_aux[1] != "") {
                            $sheet->setCellValue("P" . ($cel + 1), $tripulantes_aux[1]);
                        }
                        if (isset($tripulantes_aux[2]) && $tripulantes_aux[2] != "") {
                            $sheet->setCellValue("Q" . ($cel + 1), $tripulantes_aux[2]);
                        }
                    }
                }


                $dly1 = "";
                $dly2 = "";
                if (isset($array_incidencias[$value["id_vuelo_detalle"]]) && is_array($array_incidencias[$value["id_vuelo_detalle"]])) {
                    $data_incidencias = $array_incidencias[$value["id_vuelo_detalle"]];
                    if (isset($data_incidencias[0]) && is_array($data_incidencias[0])) {
                        $dly1 = $data_incidencias[0]["Id_incidencia"];
                    }

                    if (isset($data_incidencias[1]) && is_array($data_incidencias[1])) {
                        $dly2 = $data_incidencias[1]["Id_incidencia"];
                    }
                }

                /**
                 * ETD => CIERRE PUERTA ITINIRARIO;
                 * ETA => hora_apertura_puerta;
                 * ATD => puerta_PB;
                 * ATA => hora_parada;
                 * TIME => ETD -ATD;
                 * PAX(clase_y) => ADULTO+MENORES+INFANTES
                 * DLY1 => ID INDICENDIA
                 * DLY2 => ID INDICENDIA
                 * */
                $hora_cierre_puerta = $value["ETD"];
                $hora_apertura_puerta = $value["ETA"];
                $ATD = $value["ATD"];
                $ATA = $value["ATA"];
                $sheet->setCellValue("A" . $cel, $init_val);
                if ($value["vuelo_direccion"] == "IDA" && $value["orden"] == 1) {
                   
                    $sheet->setCellValue("C" . $cel, $value["IdMatricula"]); 
                }else{
                    //$sheet->setCellValue("B" . $cel, '');
                    $sheet->setCellValue("C" . $cel, '');
                }
                 if ($value["orden"] == 1) {
                     $sheet->setCellValue("B" . $cel, $value["NroVuelo"]);
                 }else{
                     $sheet->setCellValue("B" . $cel, '');
                 }
                 
                
                $sheet->setCellValue("D" . $cel, $value["ciudad_origen"]);
                $sheet->setCellValue("E" . $cel, $value["ciudad_destino"]);
                $sheet->setCellValue("F" . $cel, $value["ETD"]);
                $sheet->setCellValue("G" . $cel, $value["ETA"]);
                $sheet->setCellValue("H" . $cel, $value["ATD"]);
                $sheet->setCellValue("I" . $cel, $value["ATA"]);
                $sheet->setCellValue("J" . $cel, $dly1);
                $sheet->setCellValue("K" . $cel, $dly2);
                $sheet->setCellValue("L" . $cel, $value["clase_y"]);
                $sheet->setCellValue("M" . $cel, '');

                if (strtotime($ATD) > strtotime($hora_cierre_puerta)) {
                    $objPHPExcel->getActiveSheet()->getStyle("H" . $cel)->applyFromArray(array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'F4B07B'),
                        )
                    ));
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle("H" . $cel)->applyFromArray(array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '8EA9DB'),
                        )
                    ));
                }

                if (strtotime($value["ATA"]) > strtotime($hora_apertura_puerta)) {
                    $objPHPExcel->getActiveSheet()->getStyle("I" . $cel)->applyFromArray(array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'F4B07B'),
                        )
                    ));
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle("I" . $cel)->applyFromArray(array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '8EA9DB'),
                        )
                    ));
                }



                $objPHPExcel->getActiveSheet()->getStyle("C" . $cel)->applyFromArray(array('font' => array('bold' => true)));
                $objPHPExcel->getActiveSheet()->getStyle("J" . $cel)->applyFromArray($styleArray_J_K);
                $objPHPExcel->getActiveSheet()->getStyle("K" . $cel)->applyFromArray($styleArray_J_K);

                if (($key + 1) % 2 != 0) {

                    $sheet->mergeCells('N' . $cel . ':' . "O" . $cel);
                    $objPHPExcel->getActiveSheet()->getStyle('N' . $cel . ':' . "O" . $cel)->applyFromArray(array('font' => array('bold' => true)));
                    $sheet->mergeCells('P' . $cel . ':' . "Q" . $cel);
                    $objPHPExcel->getActiveSheet()->getStyle('P' . $cel . ':' . "Q" . $cel)->applyFromArray(array('font' => array('bold' => true)));
                }
                if ($value["id_vuelo_detalle"] > 0) {
                    $time_hora_cierre_puerta = strtotime((trim($hora_cierre_puerta) != "" ? $hora_cierre_puerta : "00:00") . ":00");
                    $timeATD = strtotime((trim($ATD) != "" ? $ATD : "00:00") . ":00");
                    $time_hora_apertura_puerta = strtotime((trim($hora_apertura_puerta) != "" ? $hora_apertura_puerta : "00:00") . ":00");
                    $time_hora_llegada = strtotime((trim($ATA) != "" ? $ATA : "00:00") . ":00");

                    $datetime_hora_cierre_puerta = new DateTime((trim($hora_cierre_puerta) != "" ? "$hora_cierre_puerta:00" : "00:00:00"));
                    $datetime_ATD = new DateTime((trim($ATD) != "" ? "$ATD:00" : "00:00:00"));

                    $ETD_ATD = '00:00';
                    if (strtotime($hora_cierre_puerta) >= strtotime($ATD)) {
                        $sheet->setCellValue("M" . $cel, '');
                        $sheet->setCellValue("X" . $cel, '00:00');



                        $min1 = 0;
                        $sheet->setCellValue("Y" . $cel, $min1);

                        $min2 = 0;
                        $sheet->setCellValue("Z" . $cel, $min2);

                        $min3 = 0;
                        $sheet->setCellValue("AA" . $cel, $min3);
                    } else {
                        $ETD_ATD = $datetime_ATD->diff($datetime_hora_cierre_puerta);
                        $sheet->setCellValue("M" . $cel, $ETD_ATD->format('%H:%I'));
                        if (strtotime($ETD_ATD->format('%H:%I')) > strtotime('00:00')) {
                            $stylefontcolor = array(
                                'font' => array(
                                    'color' => array('rgb' => 'FF0000')
                            ));
                            $objPHPExcel->getActiveSheet()->getStyle("M" . $cel)->applyFromArray($stylefontcolor);
                        }
                        $sheet->setCellValue("X" . $cel, $ETD_ATD->format('%H:%I'));
                        $tiempo_restante = $ETD_ATD->format('%H:%I');


                        $min1 = (strtotime($tiempo_restante) > $time_defecto ? 1 : 0);
                        $sheet->setCellValue("Y" . $cel, $min1);

                        $min2 = strtotime($tiempo_restante) >= $time_min14 ? 1 : 0;
                        $sheet->setCellValue("Z" . $cel, $min2);

                        $min3 = strtotime($tiempo_restante) >= $time_min29 ? 1 : 0;
                        $sheet->setCellValue("AA" . $cel, $min3);

                        $summin1 += $min1;
                        $summin2 += $min2;
                        $summin3 += $min3;
                    }


                    $vuelos_salidos_itin = $timeATD <= $time_hora_cierre_puerta ? 1 : 0;
                    $sheet->setCellValue("V" . $cel, $vuelos_salidos_itin);

                    $vuelos_llegados_itin = $time_hora_llegada <= $time_hora_apertura_puerta ? 1 : 0;
                    $sheet->setCellValue("W" . $cel, $vuelos_llegados_itin);
                    $sum_vuelos_salidos_itin += $vuelos_salidos_itin;
                    $sum_vuelos_llegados_itin += $vuelos_llegados_itin;
                }
                $cel += 1;
                $cont_cel++;

                $init_val++;
            }

            $R = "R" . (($cel_ini + $cont_cel) - 1);
            $B = "B" . $cel_ini;
            $rango = $B . ":" . $R;
            $styleArray_data = array(
                'font' => array('size' => 11),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                'borders' => array(
                    'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF')),
                    'outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF'))
                )
            );
            //$style_data = $this->estilosExcel('');
            $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray_data);
            $cel_ini = ($cel_ini + $cont_cel);
        }
        //exit;
        $AA = "AA" . ($cel - 1);
        $V = "V7";
        $rango = $V . ":" . $AA;
        $styleArray_data = array(
            'font' => array('size' => 11),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'borders' => array(
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF')),
                'outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF'))
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray_data);

        $sheet->setCellValue("Y" . $cel, $summin1);
        $sheet->setCellValue("Z" . $cel, $summin2);
        $sheet->setCellValue("AA" . $cel, $summin3);
        $styleArray_sumatoria = $this->estilosExcel(FALSE, 11);
        $rango_sum = "Y" . $cel . ':AA' . $cel;
        $objPHPExcel->getActiveSheet()->getStyle($rango_sum)->applyFromArray($styleArray_sumatoria);
        //$style_data = $this->estilosExcel('');
        //exit;

        /* $styleArray = array(
          'font' => array('size' => 10),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
          'borders' => array(
          'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFF'))
          )
          ); */

        $styleArray = $this->estilosExcel(FALSE, 10);

        /*         * *************** tripulacion de turno************************* */
        $this->tabla_tripulacion_turno($sheet, $objPHPExcel, $cel, $boldTRI, $styleArray, $rs_vuelos["cant"], $sum_vuelos_salidos_itin, $sum_vuelos_llegados_itin, $summin1, $summin2, $summin3);
        /*         * **************************************************************** */


        // Cambiar el nombre de hoja de cálculo
        $objPHPExcel->getActiveSheet()->setTitle(nombreDia($_GET["fecha"], 'L'));

        // Establecer índice de hoja activa a la primera hoja , por lo que Excel abre esto como la primera hoja
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirigir la salida al navegador web de un cliente ( Excel5 )
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=" resumen programacion de vuelo"' . $_GET["fecha"] . '".xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    function tabla_tripulacion_turno($sheet, $objPHPExcel, $cel, $boldTRI, $styleArray, $vuelos_realizado = 0, $sum_vuelos_salidos_itin, $sum_vuelos_llegados_itin, $summin1, $summin2, $summin3) {
        $pos_tri = $cel + 1;
        $sheet->mergeCells('B' . $pos_tri . ':O' . $pos_tri . '');

        $sheet->setCellValue('B' . $pos_tri, 'TRIULACION DE TURNO');
        $sheet->setCellValue('P' . $pos_tri, 'INSTRUCT.');
        $sheet->setCellValue('R' . $pos_tri, 'VLO:');
        $objPHPExcel->getActiveSheet()->getRowDimension($pos_tri)->setRowHeight(21.25);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $pos_tri . ':O' . $pos_tri . '')->applyFromArray($boldTRI);
        /* $boldins = array(
          'font' => array('bold' => true, 'size' => 11),
          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT),
          'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF'))),
          'fill' => array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
          'color' => array('rgb' => 'F2F2F2')
          )
          ); */
        $fill = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'F2F2F2')
        );
        $boldins = $this->estilosExcel(TRUE, 11, PHPExcel_Style_Alignment::HORIZONTAL_LEFT, '', PHPExcel_Style_Border::BORDER_MEDIUM, PHPExcel_Style_Border::BORDER_MEDIUM, 'FFF', $fill);


        $styleArray = $this->estilosExcel(FALSE, 10, PHPExcel_Style_Alignment::HORIZONTAL_CENTER, PHPExcel_Style_Alignment::VERTICAL_CENTER, PHPExcel_Style_Border::BORDER_THIN, PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('P' . $pos_tri . ':R' . $pos_tri . '')->applyFromArray($boldins);
        $a = $pos_tri + 1;
        $hasta = $pos_tri + 8;
        $e = 1;
        $i = 1;
        for ($index = $a; $index <= $hasta; $index++) {

            if ($index < ($hasta - 3)) {
                if (($index % 2) == 0) {
                    $ini_p = 'B' . ($index - 1);
                    $fin_p = 'B' . ($index);
                    $sheet->mergeCells($ini_p . ':' . $fin_p);
                    if ($e == 1) {
                        $sheet->setCellValue($ini_p, 'MAÑANA');
                        $objPHPExcel->getActiveSheet()->getStyle($ini_p . ':' . $fin_p)->applyFromArray($boldTRI);
                        $sheet->mergeCells('J' . ($index - 1) . ':' . 'K' . ($index));
                        $sheet->setCellValue('J' . ($index - 1), 'Tarde');
                        $objPHPExcel->getActiveSheet()->getStyle('J' . ($index - 1) . ':' . 'K' . ($index))->applyFromArray($styleArray);

                        $sheet->setCellValue('C' . ($index - 1), 'TECNICA');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . ($index - 1))->applyFromArray($styleArray);
                        $sheet->setCellValue('C' . ($index), 'CABINA');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . ($index))->applyFromArray($styleArray);
                    } elseif ($e == 2) {
                        $sheet->setCellValue($ini_p, 'TURNO DOMICILIARIO');
                        $objPHPExcel->getActiveSheet()->getStyle($ini_p . ':' . $fin_p)->applyFromArray($boldTRI);
                        $objPHPExcel->getActiveSheet()->getStyle($ini_p . ':' . $fin_p)->getAlignment()->setWrapText(true);
                        $sheet->setCellValue('C' . ($index - 1), 'TECNICA');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . ($index - 1))->applyFromArray($styleArray);
                        $sheet->setCellValue('C' . ($index), 'CABINA');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . ($index))->applyFromArray($styleArray);
                    }

                    $e++;
                }
            } else {
                
                
                if ($index <= ($hasta - 1)) {
                    if (($index % 3) == 0) {
                        $ini_p = 'B' . ($index - 2);
                        $fin_p = 'C' . ($index);
                        //echo $ini_p . ':' . $fin_p;
                        $sheet->mergeCells($ini_p . ':' . $fin_p);
                        $sheet->setCellValue($ini_p, 'PERSONAL DE OPERACIONES');
                        $objPHPExcel->getActiveSheet()->getStyle($ini_p . ':' . $fin_p)->applyFromArray($boldTRI);
                        $objPHPExcel->getActiveSheet()->getStyle($ini_p . ':' . $fin_p)->getAlignment()->setWrapText(true);
                    }
                }
                if ($index == $hasta) {
                    $ini_p = 'B' . ($index);
                    $fin_p = 'C' . ($index);
                    $sheet->mergeCells($ini_p . ':' . $fin_p);
                    $sheet->setCellValue($ini_p, 'Observaciones');
                    $objPHPExcel->getActiveSheet()->getStyle($ini_p . ':' . $fin_p)->applyFromArray($boldTRI);
                    $objPHPExcel->getActiveSheet()->getStyle($ini_p . ':' . $fin_p)->getAlignment()->setWrapText(true);
                }
            }
            
            $D = "D" . $index;
            $E = "E" . $index;
            $F = "F" . $index;
            $G = "G" . $index;
            $H = "H" . $index;
            $I = "I" . $index;
            $J = "J" . $index;
            $K = "K" . $index;
            $L = "L" . $index;
            $M = "M" . $index;
            $N = "N" . $index;
            $O = "O" . $index;
            $P = "P" . $index;
            $Q = "Q" . $index;
            $R = "R" . $index;
            if ($i < 8) {
                $sheet->mergeCells($D . ':' . $E);
                $objPHPExcel->getActiveSheet()->getStyle($D . ':' . $E)->applyFromArray($styleArray);
                $sheet->mergeCells($F . ':' . $G);
                $objPHPExcel->getActiveSheet()->getStyle($F . ':' . $G)->applyFromArray($styleArray);
                $sheet->mergeCells($H . ':' . $I);
                $objPHPExcel->getActiveSheet()->getStyle($H . ':' . $I)->applyFromArray($styleArray);

                $styleArray_per = array(
                    'font' => array('size' => 10),
                    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => 'FFF'))),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'A2D4E2'),
                    )
                );
                if ($i <= 2) {
                    $objPHPExcel->getActiveSheet()->getStyle($N)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle($O)->applyFromArray($styleArray);
                    $sheet->mergeCells($L . ':' . $M);
                    $objPHPExcel->getActiveSheet()->getStyle($L . ':' . $M)->applyFromArray($styleArray);
                    $sheet->setCellValue($P, 'Alumno');
                    $objPHPExcel->getActiveSheet()->getStyle($P)->applyFromArray($boldTRI);
                    $sheet->mergeCells($Q . ':' . $R);
                    $objPHPExcel->getActiveSheet()->getStyle($Q . ':' . $R)->applyFromArray($styleArray);
                } else {
                    $sheet->mergeCells($N . ':' . $O);
                    $objPHPExcel->getActiveSheet()->getStyle($N . ':' . $O)->applyFromArray($styleArray);
                    $sheet->mergeCells($J . ':' . $M);
                    $objPHPExcel->getActiveSheet()->getStyle($J . ':' . $M)->applyFromArray($styleArray);
                    switch ($i) {
                        case 3:
                            $sheet->setCellValue($P, 'Alumno');
                            $objPHPExcel->getActiveSheet()->getStyle($P)->applyFromArray($boldTRI);
                            $sheet->mergeCells($Q . ':' . $R);
                            $objPHPExcel->getActiveSheet()->getStyle($Q . ':' . $R)->applyFromArray($styleArray);
                            break;
                        case 4:
                            $sheet->mergeCells($P . ':' . $Q);
                            $objPHPExcel->getActiveSheet()->getStyle($Q . ':' . $R)->applyFromArray($styleArray);
                            break;
                        case 5:
                            $sheet->setCellValue($D, 'MAÑANA 07:00');
                            $objPHPExcel->getActiveSheet()->getStyle($D . ':' . $R)->applyFromArray($styleArray_per);
                            break;
                        case 6:
                            $sheet->setCellValue($D, 'TARDE 15:00');
                            $objPHPExcel->getActiveSheet()->getStyle($D . ':' . $R)->applyFromArray($styleArray_per);
                            break;
                        case 7:
                            $sheet->setCellValue($D, 'NOCHE 23:00');
                            $objPHPExcel->getActiveSheet()->getStyle($D . ':' . $R)->applyFromArray($styleArray_per);
                            break;
                    }
                }
            } else {
                $sheet->mergeCells($D . ':' . $R);
                $objPHPExcel->getActiveSheet()->getStyle($D . ':' . $R)->applyFromArray($boldTRI);
            }
            $objPHPExcel->getActiveSheet()->getRowDimension($index)->setRowHeight(21.25);
            $a++;
            $i++;
        }

        /*         * *************************************Seccion3*************************************** */
        $porcentaje_puntualidad_1 = (($sum_vuelos_salidos_itin / $vuelos_realizado) * 100);
        $porcentaje_puntualidad_2 = (($sum_vuelos_llegados_itin / $vuelos_realizado) * 100);

        $fila_iti = $hasta + 3;
        $objPHPExcel->getActiveSheet()->getRowDimension($fila_iti)->setRowHeight(21.25);
        $objPHPExcel->getActiveSheet()->getRowDimension($fila_iti + 1)->setRowHeight(21.25);
        $sheet->setCellValue('C' . $fila_iti, 'ATD');
        $sheet->setCellValue('D' . $fila_iti, 'PUSH BACK O REMOLQUE');
        $sheet->mergeCells('D' . $fila_iti . ':G' . $fila_iti . '');
        $sheet->setCellValue('C' . ($fila_iti + 1), 'ATA');
        $sheet->setCellValue('D' . ($fila_iti + 1), 'EN TOMA O CALZOS');
        $sheet->mergeCells('D' . ($fila_iti + 1) . ':G' . ($fila_iti + 1) . '');
        $objPHPExcel->getActiveSheet()->getStyle('C' . ($fila_iti) . ':G' . ($fila_iti + 1) . '')->applyFromArray($styleArray);

        $sheet->setCellValue('I' . $fila_iti, 'ITINERARIO');
        $sheet->mergeCells('I' . $fila_iti . ':N' . $fila_iti . '');
        $styleArray_h = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'A2D4E2')));
        $styleArray_demo = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'E6B8B7')));

        $objPHPExcel->getActiveSheet()->getStyle('I' . $fila_iti . ':N' . $fila_iti)->applyFromArray($styleArray_h);

        $sheet->setCellValue('I' . ($fila_iti + 1), 'DEMORADOS');
        $sheet->mergeCells('I' . ($fila_iti + 1) . ':N' . ($fila_iti + 1));
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($fila_iti) . ':N' . ($fila_iti + 1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('I' . ($fila_iti + 1) . ':N' . ($fila_iti + 1))->applyFromArray($styleArray_demo);

        $sheet->setCellValue('P' . ($fila_iti), 'PUNTUALIDAD');
        $sheet->mergeCells('P' . ($fila_iti) . ':Q' . ($fila_iti + 1));
        $sheet->setCellValue('R' . ($fila_iti), '100%');

        $sheet->setCellValue('R' . ($fila_iti), number_format((($porcentaje_puntualidad_1 + $porcentaje_puntualidad_2) / 2), 2) . '%');
        $sheet->mergeCells('R' . ($fila_iti) . ':R' . ($fila_iti + 1));
        $objPHPExcel->getActiveSheet()->getStyle('P' . ($fila_iti) . ':R' . ($fila_iti + 1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('P' . ($fila_iti) . ':Q' . ($fila_iti + 1))->applyFromArray(array('font' => array('bold' => true)));
        /*         * ********************************************************************************************************************************** */


        /*         * ******************************************Seccion 4************************************************************* */

        $seccion_4 = $fila_iti + 3;
        $hasta_sec4 = $seccion_4 + 4;
        $s_4 = 0;
        $array_text_fila = array(
            array('title' => 'Total de Vuelos Realizados', "value" => $vuelos_realizado, "title2" => "", "valor2" => ''),
            array('title' => 'Vuelos salidos en Itinerario', "value" => $sum_vuelos_salidos_itin, "title2" => "Vuelos Llegadas en Itinerario", "valor2" => $sum_vuelos_llegados_itin),
            array('title' => 'Vuelos salidos Demorados', "value" => ($vuelos_realizado - $sum_vuelos_salidos_itin), "title2" => "Vuelos Llegados Demorados", "valor2" => ($vuelos_realizado - $sum_vuelos_llegados_itin)),
            array('title' => '% de puntualidad', "value" => number_format($porcentaje_puntualidad_1, 2) . '%', "title2" => "% de puntualidad", "valor2" => number_format($porcentaje_puntualidad_2, 2) . '%')
        );
        for ($fila = $seccion_4; $fila < $hasta_sec4; $fila++) {
            $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(21.25);
            $sheet->setCellValue('C' . ($fila), $array_text_fila[$s_4]["title"]);
            $sheet->setCellValue('G' . ($fila), $array_text_fila[$s_4]["value"]);
            if ($s_4 <= 2) {
                $sheet->mergeCells('C' . $fila . ':E' . $fila);
            } else {
                $sheet->mergeCells('C' . $fila . ':F' . $fila);
            }


            $sheet->mergeCells('G' . $fila . ':H' . $fila);


            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila . ':H' . ($hasta_sec4 - 1))->applyFromArray($styleArray);
            if ($s_4 > 0) {
                $sheet->setCellValue('O' . ($fila), $array_text_fila[$s_4]["title2"]);
                $sheet->setCellValue('R' . ($fila), $array_text_fila[$s_4]["valor2"]);
                $sheet->mergeCells('O' . $fila . ':Q' . $fila);
                $objPHPExcel->getActiveSheet()->getStyle('O' . $fila . ':Q' . $fila)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->applyFromArray($styleArray);
            }
            if ($s_4 == 1 || $s_4 == 3) {
                $objPHPExcel->getActiveSheet()->getStyle('G' . $fila . ':H' . $fila)->applyFromArray($styleArray_h);
                $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->applyFromArray($styleArray_h);
            }
            if ($s_4 == 2) {
                $objPHPExcel->getActiveSheet()->getStyle('G' . $fila . ':H' . $fila)->applyFromArray($styleArray_demo);
                $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->applyFromArray($styleArray_demo);
            }

            if ($s_4 == 3) {
                if ($array_text_fila[$s_4]["value"] <= 70) {
                    $color = 'FA0000';
                }

                if ($array_text_fila[$s_4]["value"] > 70 && $array_text_fila[$s_4]["value"] <= 90) {
                    $color = '76933C';
                }

                if ($array_text_fila[$s_4]["value"] > 90 && $array_text_fila[$s_4]["value"] <= 100) {
                    $color = '538DD5';
                }

                $styleColor_porc = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => $color)));
                $objPHPExcel->getActiveSheet()->getStyle('G' . $fila . ':H' . $fila)->applyFromArray($styleColor_porc);
                $color2 = "";
                if ($array_text_fila[$s_4]["valor2"] <= 70) {
                    $color2 = 'FA0000';
                }

                if ($array_text_fila[$s_4]["valor2"] > 70 && $array_text_fila[$s_4]["value"] <= 90) {
                    $color2 = '76933C';
                }

                if ($array_text_fila[$s_4]["valor2"] > 90 && $array_text_fila[$s_4]["value"] <= 100) {
                    $color2 = '538DD5';
                }

                $styleColor_porc = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => $color2)));
                $objPHPExcel->getActiveSheet()->getStyle('R' . $fila)->applyFromArray($styleColor_porc);
            }

            $s_4++;
        }

        /*         * ************************************************************************************************** */

        /*         * ***********************Seccion 5********************************************************* */
        $seccion_5 = $hasta_sec4 + 1;
        $hasta_sec5 = $seccion_5 + 3;
        $array_margen_puntualidad = array(
            array('title' => '% puntualidad 5 min de margen', 'cant' => $summin1, 'porc' => number_format(((($vuelos_realizado - $summin1) / $vuelos_realizado) * 100), 2), 'parametro' => 'OTP<= 70', 'color' => 'FA0000'),
            array('title' => '% puntualidad 15 min de margen', 'cant' => $summin2, 'porc' => number_format(((($vuelos_realizado - $summin2) / $vuelos_realizado) * 100), 2), 'parametro' => '70<OTP<= 90', 'color' => '76933C'),
            array('title' => '% puntualidad 30 min de margen', 'cant' => $summin3, 'porc' => number_format(((($vuelos_realizado - $summin3) / $vuelos_realizado) * 100), 2), 'parametro' => '90<OTP<= 100', 'color' => '538DD5')
        );
        $s_5 = 0;
        for ($fila_sec5 = $seccion_5; $fila_sec5 < $hasta_sec5; $fila_sec5++) {
            $objPHPExcel->getActiveSheet()->getRowDimension($fila_sec5)->setRowHeight(21.25);
            $sheet->setCellValue('C' . ($fila_sec5), $array_margen_puntualidad[$s_5]["title"]);
            $sheet->setCellValue('G' . ($fila_sec5), $array_margen_puntualidad[$s_5]["cant"]);
            $sheet->setCellValue('H' . ($fila_sec5), $array_margen_puntualidad[$s_5]["porc"] . '%');
            $sheet->setCellValue('M' . ($fila_sec5), $array_margen_puntualidad[$s_5]["parametro"]);

            $sheet->mergeCells('C' . $fila_sec5 . ':F' . $fila_sec5);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $fila_sec5 . ':H' . ($hasta_sec5 - 1))->applyFromArray($styleArray);

            $sheet->mergeCells('M' . $fila_sec5 . ':N' . $fila_sec5);
            $objPHPExcel->getActiveSheet()->getStyle('M' . $fila_sec5 . ':O' . ($hasta_sec5 - 1))->applyFromArray($styleArray);
            $styleColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => $array_margen_puntualidad[$s_5]["color"])));
            $objPHPExcel->getActiveSheet()->getStyle('O' . $fila_sec5)->applyFromArray($styleColor);
            $color = "";
            if ($array_margen_puntualidad[$s_5]["porc"] <= 70) {
                $color = 'FA0000';
            }

            if ($array_margen_puntualidad[$s_5]["porc"] > 70 && $array_margen_puntualidad[$s_5]["porc"] <= 90) {
                $color = '76933C';
            }

            if ($array_margen_puntualidad[$s_5]["porc"] > 90 && $array_margen_puntualidad[$s_5]["porc"] <= 100) {
                $color = '538DD5';
            }
            $styleColor_porc = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => $color)));
            $objPHPExcel->getActiveSheet()->getStyle('H' . $fila_sec5)->applyFromArray($styleColor_porc);

            $s_5++;
        }
    }

    public function setAnchoColumnas($objPHPExcel) {
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(11);
    }

    public function imageLogo($objPHPExcel) {
        $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
        $objDrawing->setName('Logo Peruvian');        //set name to image
        $objDrawing->setDescription('Logo Peruvian'); //set description to image
        $signature = ROOT . '/Public/img/logo_peruvian.png';    //Path to signature .jpg file
        $objDrawing->setPath($signature);
        $objDrawing->setOffsetX(25);                       //setOffsetX works properly
        $objDrawing->setOffsetY(10);                       //setOffsetY works properly
        $objDrawing->setCoordinates('P1');        //set image to cell
        $objDrawing->setWidth(32);                 //set width, height
        $objDrawing->setHeight(32);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save
    }

    public function estilosExcel($bold = false, $size = 11, $horizontal_align = PHPExcel_Style_Alignment::HORIZONTAL_CENTER, $vertical_align = PHPExcel_Style_Alignment::VERTICAL_CENTER, $allStyleBorders = PHPExcel_Style_Border::BORDER_THIN, $styleOutline = PHPExcel_Style_Border::BORDER_MEDIUM, $color_border = 'FFF', $fill = array()) {

        $array_style = array(
            'font' => array('bold' => $bold, 'size' => $size),
            'alignment' => array('horizontal' => $horizontal_align, 'vertical' => $vertical_align),
            'borders' => array(
                'allborders' => array('style' => $allStyleBorders, 'color' => array('argb' => $color_border)),
                'outline' => array('style' => $styleOutline, 'color' => array('argb' => $color_border))
            ),
            'fill' => $fill
        );

        return $array_style;
    }

}
