<?php


class Tuua_applicationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->isAccesoApp()) {
            header('location:'.URL_LOGIN_APP);
            exit;
        }
    }

    public function createManifiestoAction(){
        if ($this->isPost()) {
            $this->_view->maintpl = "mainx";
            $this->_view->assign("JS","listadoVuelo");
            $this->_view->assign("typeForm","create");
            $this->_view->display("create_manifiesto.tpl");
        }
    }


    public function ta_listado_vuelosAction(){
        $fecha_ini = date("Y-m-d");
        $fecha_fin = date("Y-m-d");
        $flag = "";
        if(isset($_GET["fecha_ini"]) && $_GET["fecha_ini"]!=""){
            $fecha = explode("/",$_GET["fecha_ini"]);
            $fecha_mod = $fecha[2]."-".$fecha[1]."-".$fecha[0];
            $fecha_ini = date("Y-m-d",strtotime($fecha_mod));
            $fecha_fin = date("Y-m-d",strtotime($fecha_mod));
            $flag = "loadBack";
        }
        $origen = "";
        if(isset($_GET["aeroEmbarque"]) && $_GET["aeroEmbarque"]!=""){
            $origen = $_GET["aeroEmbarque"];
        }

        $this->_view->assign("fecha_ini",$fecha_ini);
        $this->_view->assign("fecha_fin",$fecha_fin);
        $this->_view->assign("origen",$origen);
        $this->_view->assign("flag", $flag);
        $this->_view->assign("title","Busqueda de Vuelos");
        $this->_view->assign("JS","listadoVuelo");
        $this->_view->show_page("ta_listado_vuelo.tpl");

    }

    public  function ta_listado_vuelos_kiuAction(){

        if($this->isPost()){
            $fe1=$_POST["fecha_ini"];
            $fe2=$_POST["fecha_fin"];
            $origen=$_POST["origen"];

            $modelo = new TuuaAplication();
            $response = $modelo->tuua_cabecera(array("origen"=>$origen,"fe1"=>$fe1,"fe2"=>$fe2));
            $opciones =  $this->listOptions();
            $this->_view->assign("data",$response);
            $this->_view->assign("permisos_opciones",$opciones);
            $html_vuelos = $this->_view->fetch('table_listado_vuelos.tpl');
            echo json_encode(array("rpt"=>1,"html_vuelos"=>$html_vuelos,"msg_error"=>""));
        }else{
            $rpt = 0;
            $html_cierre_vuelo = "";
            $msg_error = "Error Metodo no permitido";
            $this->_view->assign("error_text",$msg_error);
            $this->_view->show_page("403.tpl");
        }

    }

    public function detallePaxAction($id_file){

        $idFileTuua = isset($id_file)?$id_file:"";
        if (!empty($idFileTuua)) {
            $permiso_detalle_pax = $this->PermisosporPaginas("MNF_DETALLE_PAX",1);
            if($permiso_detalle_pax[0]["Ejecutar"]){
                $modelo = new TuuaAplication();
                $cabecera= $modelo->ListarCabeceraTuua($idFileTuua);
                if(count($cabecera)>0){
                    /*$pasajeros= $modelo->ListarPasajero($idFileTuua);
                    $cantidad_pax = $pasajeros;

                    $arr_pax=array();
                    $repeat_pax=array();
                    foreach ($cantidad_pax as $key => $pax) {
                        if (in_array_r($pax["nroTicketPax"], $arr_pax) ) {
                            $pax["color"]="red";
                            $repeat_pax[]=$pax;
                        }else {
                            $pax["color"]="";
                            $arr_pax[]=$pax;
                        }
                    }

                    $apellidoPax = array();
                    foreach ($arr_pax as $pax) {
                        $apellidoPax[] = $pax['apellidoPax'];
                    }

                    //array_multisort($apellidoPax, SORT_ASC, $arr_pax);
                    //array_multisort($apellidoPax, SORT_ASC, $repeat_pax);

                    $cantidad_pax = array_merge($repeat_pax,$arr_pax);*/
                    $cantidad_pax = $this->ListPasajeros($modelo,$idFileTuua);


                    $this->_view->assign("cabecera",$cabecera);
                    $this->_view->assign("pasajeros",$cantidad_pax);
                    $this->_view->assign("cantidad_pax",count($cantidad_pax));
                    $this->_view->assign("id_file",$idFileTuua);
                    $this->_view->assign("permisos",$permiso_detalle_pax);
                    $this->_view->assign("title","Detalle de vuelo");
                    $this->_view->assign("JS","detallePax");
                    $this->_view->show_page("detalle_pax.tpl");
                }else{
                    $this->_view->show_page("404.tpl");
                    exit;
                }
            }else{
                $this->_view->assign("error_text", "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.");
                $this->_view->show_page("403.tpl");
                exit;
            }

        }else{
            $this->_view->show_page("404.tpl");
            exit;
        }
    }

    public function ListPasajeros($modelo,$idFileTuua){
        $pasajeros= $modelo->ListarPasajero($idFileTuua);
        $cantidad_pax = $pasajeros;

        $arr_pax=array();
        $repeat_pax=array();
        foreach ($cantidad_pax as $key => $pax) {
            if (in_array_r($pax["nroTicketPax"], $arr_pax) ) {
                $pax["color"]="red";
                $repeat_pax[]=$pax;
            }else {
                $pax["color"]="";
                $arr_pax[]=$pax;
            }
        }

        $apellidoPax = array();
        foreach ($arr_pax as $pax) {
            $apellidoPax[] = $pax['apellidoPax'];
        }

        //array_multisort($apellidoPax, SORT_ASC, $arr_pax);
        //array_multisort($apellidoPax, SORT_ASC, $repeat_pax);

        $cantidad_pax = array_merge($repeat_pax,$arr_pax);
        return $cantidad_pax;
    }

    public function exportarExcelAction($id_file){
        require_once ROOT . 'library/PHPExcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Peruvian Airlines S.A.C.")
                                    ->setLastModifiedBy("Peruvian Airlines S.A.C.")
                                    ->setTitle("Office 2007 XLSX Test Document")
                                    ->setSubject("Office 2007 XLSX Test Document")
                                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                    ->setKeywords("office 2007 openxml php")
                                    ->setCategory("Test result file");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(8);

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $objPHPExcel->getActiveSheet()->setTitle('Detalle Pasajero');
        /* Estilo Cabecera */
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getAllBorders()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK));
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        $styleColor_porc = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => "C00000")));
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleColor_porc);
        $stylefontcolor = array(
            'font' => array(
                'color' => array('rgb' => 'FFFFFF'),
                'bold' => true
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($stylefontcolor);
        /* Estilo por columnas */
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(17);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(12);

        /* Cabeceras */
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Nro Ticket');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Apellido');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Nombre');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Pax');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Foid');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Destino');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Clase');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Cupon');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Ref');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Asiento');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Nro Doc');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Nac');

        $modelo = new TuuaAplication();
        $pasajeros = $this->ListPasajeros($modelo,$id_file);
        $i = 2;
        foreach ($pasajeros as $pasajero){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i,$pasajero["nroTicketPax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i,$pasajero["apellidoPax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i,$pasajero["nombrePax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i,$pasajero["tipoPax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i,$pasajero["foidPax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i,$pasajero["destinoPax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i,$pasajero["clasePax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i,$pasajero["nroCuponPax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i,$pasajero["nroReferencia"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i,$pasajero["nroAsientoPax"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i,$pasajero["nroDoc"]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i,$pasajero["nacPax"]);
            $i++;
        }

        $A="A2";
        $AA = "L".($i-1);
        $rango = $A.":".$AA;
        $objPHPExcel->getActiveSheet()->getStyle($rango)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle($rango)->getBorders()->getAllBorders()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK));
        $nombre_excel = "Detalle Pasajero";
        // Cambiar el nombre de hoja de cálculo
        $objPHPExcel->getActiveSheet()->setTitle($nombre_excel, 'L');

        // Establecer índice de hoja activa a la primera hoja , por lo que Excel abre esto como la primera hoja
        $objPHPExcel->setActiveSheetIndex(0);

        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        // Redirigir la salida al navegador web de un cliente ( Excel5 )
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$nombre_excel.'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function createPasajeroAction(){
        if ($this->isPost()) {

            $this->_view->maintpl = "mainx";
            $this->_view->assign("typeForm","create");
            $this->_view->display("create_pasajero.tpl");
        }
    }

    public function listOptions(){

        $permisos = $this->PermisosporPaginas("MNF_BUSQUEDA_VUE", 1);
        $permiso_detalle_pax = $this->PermisosporPaginas("MNF_DETALLE_PAX",1);
        $permiso_importar_pax = $this->PermisosporPaginas("MNF_IMPORTAR_PAX",1);
        $array_opciones = array();
        $acceso_detalle_pax = $permiso_detalle_pax[0]["Ejecutar"];
        $acceso_importar_pax = $permiso_importar_pax[0]["Ejecutar"];
        $acceso_reprocesar = 0;
        $acceso_modificar = 0;
        $acceso_eliminar =0;
        if (count($permisos) > 0) {
            foreach ($permisos as $value) {

                switch ($value["IdPrograma"]) {
                    case "MNF_BUSQUEDA_VUE":
                        $acceso_reprocesar = $value["Procesar"];
                        $acceso_modificar = $value["Modificar"];
                        $acceso_eliminar = $value["Eliminar"];
                        break;
                }
            }
            $array_opciones = array(
                array(
                    "id" => "MNF_DETALLE_PAX",
                    "text" => "Ver Detalle Pax",
                    "class" => "detalle_pax",
                    "color" => '',
                    "link" => 'detallePax',
                    "icon" => SERVER_PUBLIC . 'img/pasajero3.png',
                    "acceso" => $acceso_detalle_pax,
                ),
                array(
                    "id" => "MNF_IMPORTAR_PAX",
                    "text" => "Importar Pax",
                    "class" => "importar_pax",
                    "color" => '',
                    "link" => '#',
                    "icon" => SERVER_PUBLIC . 'img/icon_import.png',
                    "acceso" => $acceso_importar_pax,
                ),
                array(
                    "id" => "Reprocesar",
                    "text" => "Reprocesar",
                    "class" => "reprocesar",
                    "color" => '',
                    "link" => '#',
                    "icon" => SERVER_PUBLIC . 'img/icon_reprocesar.png',
                    "acceso" => $acceso_reprocesar,
                ),array(
                    "id" => "Modificar",
                    "text" => "Modificar",
                    "class" => "modificar",
                    "color" => '',
                    "link" => '#',
                    "icon" => SERVER_PUBLIC . 'img/icon_edit.png',
                    "acceso" => $acceso_modificar,
                ),
                array(
                    "id" => "Eliminar",
                    "text" => "Eliminar",
                    "class" => "eliminar",
                    "color" => 'red',
                    "link" => '#',
                    "icon" => SERVER_PUBLIC . 'img/delete_trash.png',
                    "acceso" => $acceso_eliminar,
                )

            );
        }

        return $array_opciones;
    }

    public function AdpControllerAction(){
        $flag = isset($_REQUEST["flag"])?$_REQUEST["flag"]:"";
        if($flag=="Reprocesar"){
            $this->ReprocesarManifiesto();
        }
        if($flag=="CrearManifiesto"){
            $this->CrearManifiesto();
        }
        if($flag=="ImportarPax")
        {
            $this->importarPax();
        }
        if($flag=="EliminarManifiesto"){
            $this->eliminarManifiesto();
        }
        if($flag=="ActualizarManifiesto"){
            $this->Actualizar();
        }
        if($flag=="ConsultarManifiesto"){
            $idFileTuua=$_REQUEST["idFileTuua"];
            $this->ConsultarManifiesto($idFileTuua);
        }

    }

    public function ConsultarManifiesto($idFileTuua){
        $etd=new EnviarTuaDAO();
        $data_manifiesto = $etd->ConsultarManifiesto($idFileTuua);

        $arr = array();
        foreach($data_manifiesto as $row)
        {
            $fecha = explode("/",$row['fecVueloTip']);
            $dia=$fecha[0];
            $mes=$fecha[1];
            $anio=$fecha[2];
            $fecha = $anio."-".$mes."-".$dia;
            $nrovuelo = $row['nroVuelo'];
            $pattern = sprintf( '/%s/ims', preg_quote('P90', '/'));
            $nrovuelo = preg_replace($pattern,"",$nrovuelo);
            $arr = array("nroVuelo"=>$nrovuelo,"fecVueloTip"=>$fecha,"aeroEmbarque"=>$row['aeroEmbarque'],"horaCierrePuerta"=>$row['horaCierrePuerta'],"horaCierreDespegue"=>$row['horaCierreDespegue'],"horaLlegadaDestino"=>$row['horaLlegadaDestino'],"matriculaAvion"=>$row['matriculaAvion']);
        }
        $this->_view->maintpl = "mainx";
        $this->_view->assign("typeForm","edit");
        $html_form = $this->_view->fetch("create_manifiesto.tpl");
        $response = array("data"=>$arr,"html_form"=>$html_form);
        echo  json_encode($response); exit;
    }


    public function CrearManifiesto(){
        $etd=new EnviarTuaDAO();
        $fecha_vuelo=$_REQUEST["fecha_vuelo"];
        $nro_vuelo=$_REQUEST["nro_vuelo"];
        $origen=$_REQUEST["origen"];
        $hora_despegue=$_REQUEST["hora_despegue"];
        $hora_cierra_despegue=$_REQUEST["hora_cierra_despegue"];
        $hora_llegada_destino=$_REQUEST["hora_llegada_destino"];
        $matricula_avion=$_REQUEST["matricula_avion"];
        try {
            $result = $etd->insertarCabecera($fecha_vuelo,$nro_vuelo,$origen,$hora_despegue,$hora_cierra_despegue,$hora_llegada_destino,$matricula_avion);
            if (!$result) {
                echo json_encode(array("rpt"=>0,"result"=>"Error","msg_error"=>"Ha ocurrido un error al insertar los registros","icon"=>"error"));
                 exit;
            }else{
                echo json_encode(array("rpt"=>1,"result"=>"Completado","msg_error"=>"Ha terminado el proceso con éxito","icon"=>"success"));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"result"=>"Error","msg_error"=>$e,"icon"=>"error"));
            exit;
        }

    }
    public function Actualizar(){
        $etd=new EnviarTuaDAO();
        $idFileTuua=$_REQUEST["idFileTuua"];
        $hora_despegue=$_REQUEST["hora_despegue"];
        $hora_cierra_despegue=$_REQUEST["hora_cierra_despegue"];
        $hora_llegada_destino=$_REQUEST["hora_llegada_destino"];
        $matricula_avion=$_REQUEST["matricula_avion"];
        $params = array("hora_despegue"=>$hora_despegue,"hora_cierra_despegue"=>$hora_cierra_despegue,"hora_llegada_destino"=>$hora_llegada_destino,"matricula_avion"=>$matricula_avion);
        try {
            $result = $etd->ActualizarManifiesto($idFileTuua,$params);
            if (!$result) {
                echo json_encode(array("rpt"=>0,"msg_error"=>"Ha ocurrido un error al actualizar el manifiesto, intentelo más tarde."));
               exit;
            }else{

                echo json_encode(array("rpt"=>1,"msg_error"=>"Ha terminado el proceso con éxito"));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"msg_error"=>$e));
            exit;
        }
    }
    public function ReprocesarManifiesto(){
        $etd=new EnviarTuaDAO();
        $etc=new EnviarTuaCORPAC();
        $eta=new EnviarTuaAAP();
        try {
            switch ($_REQUEST["embarque"]) {
                case "CUZ": $etc->ReprocesarCORPAC($_REQUEST["id_file"]); break;
                case "PIU": $etd->Reprocesar($_REQUEST["id_file"]); break;
                case "IQT": $etd->Reprocesar($_REQUEST["id_file"]); break;
                case "PCL": $etd->Reprocesar($_REQUEST["id_file"]); break;
                case "TPP": $etd->Reprocesar($_REQUEST["id_file"]); break;
                case "AQP": $eta->ReprocesarAAP($_REQUEST["id_file"]); break;
                case "TCQ": $eta->ReprocesarAAP($_REQUEST["id_file"]); break;
                default:echo json_encode(array("rpt"=>0,"result"=>"Error","msg_error"=>"No se puede Reprocesar este Manifiesto","icon"=>"error"));exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"result"=>"Error","msg_error"=>$e,"icon"=>"error"));
            exit;
        }
        echo json_encode(array("rpt"=>1,"result"=>"Completado","msg_error"=>"Ha terminado el proceso con éxito","icon"=>"success"));
        exit;
    }
    public function importarPax(){
        $etd=new EnviarTuaDAO();
        $idFileTuua=$_REQUEST["idFileTuua"];
        $FechaUso=$_REQUEST["Fecha"];
        $LocOrigen=$_REQUEST["aeroEmbarque"];
        $LocDestino="";
        $NroVuelo=substr($_REQUEST["nroVuelo"], -4);
        try {
            $result = $etd->importarPax($idFileTuua,$FechaUso,$LocOrigen,$LocDestino,(int)$NroVuelo);
            if (!$result) {
                echo json_encode(array("rpt"=>0,"msg_error"=>"La importación no se ha procesado"));
                exit;
            }else{
                echo json_encode(array("rpt"=>1,"msg_error"=>"La importación de pasajeros se ha procesado.","icon"=>"success"));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"msg_error"=>$e));
            exit;
        }

    }
    public function eliminarManifiesto(){
        $etd=new EnviarTuaDAO();
        $idFileTuua=$_REQUEST["idFileTuua"];
        try {
            $result = $etd->EliminarManifiesto($idFileTuua);
            if (!$result) {
                //new Exception("El manifiesto no ha podido ser eliminado");
                echo json_encode(array("rpt"=>0,"msg_error"=>"El manifiesto no ha podido ser eliminado"));
                exit;
            }else{
                echo json_encode(array("rpt"=>1,"msg_error"=>"El manifiesto ha sido eliminado."));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"msg_error"=>$e));
            exit;
        }

    }

    public function editPasajeroAction(){
        $etd=new TuuaAplication();
        $data_manifiesto = $etd->getPasajero($_POST["idItensPax"]);
        $this->_view->maintpl = "mainx";
        $this->_view->assign("typeForm","edit");
        $html_form = $this->_view->fetch("create_pasajero.tpl");
        $response = array("data"=>$data_manifiesto,"html_form"=>$html_form);
        echo  json_encode($response); exit;
    }

    public function ModificarPasajeroAction(){
        $etd=new TuuaAplication();

        $idItensPax=$_REQUEST["idItensPax"];
        $apellidoPax=$_REQUEST["apellidoPax"];
        $nombrePax=$_REQUEST["nombrePax"];
        $tipoPax=$_REQUEST["tipoPax"];
        $foidPax=$_REQUEST["foidPax"];
        $nrofrecPax='';
        $destinoPax=$_REQUEST["destinoPax"];
        $clasePax=$_REQUEST["clasePax"];
        $nroTicketPax=$_REQUEST["nroTicketPax"];
        $nroCuponPax=$_REQUEST["nroCuponPax"];
        $nroReferencia=$_REQUEST["nroReferencia"];
        $nroAsientoPax=$_REQUEST["nroAsientoPax"];
        $nroDoc=$_REQUEST["nroDoc"];
        $nacPax=$_REQUEST["nacPax"];
        $params = array("apellidoPax"=>$apellidoPax,"nombrePax"=>$nombrePax,"tipoPax"=>$tipoPax,"foidPax"=>$foidPax,"nrofrecPax"=>$nrofrecPax,"destinoPax"=>$destinoPax,"clasePax"=>$clasePax,"nroTicketPax"=>$nroTicketPax,"nroCuponPax"=>$nroCuponPax,"nroReferencia"=>$nroReferencia,"nroAsientoPax"=>$nroAsientoPax,"nroDoc"=>$nroDoc,"nacPax"=>$nacPax);
        try {
            $result = $etd->UpdatePasajero($idItensPax,$params);
            if (!$result) {
                echo json_encode(array("rpt"=>0,"msg_error"=>"Ha ocurrido un error al actualizar el pasajero, intentelo más tarde."));
                exit;
            }else{
                echo json_encode(array("rpt"=>1,"msg_error"=>""));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"msg_error"=>$e));
            exit;
        }

    }
    public function EliminarPasajeroAction(){
        $etd=new TuuaAplication();
        $idItensPax=$_REQUEST["idItensPax"];
        try {
            $result = $etd->EliminarPasajero($idItensPax);
            if (!$result) {
                echo json_encode(array("rpt"=>0,"msg_error"=>"El pasajero no ha podido ser eliminado"));
                exit;
            }else{
                echo json_encode(array("rpt"=>1,"msg_error"=>"El pasajero ha sido eliminado.","icon"=>"success"));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"msg_error"=>$e,"icon"=>"error"));
            exit;
        }

    }
    public function storePasajeroAction(){
        $etd=new TuuaAplication();

        $apellidoPax=$_REQUEST["apellidoPax"];
        $nombrePax=$_REQUEST["nombrePax"];
        $tipoPax=$_REQUEST["tipoPax"];
        $foidPax=$_REQUEST["foidPax"];
        $nrofrecPax='';
        $destinoPax=$_REQUEST["destinoPax"];
        $clasePax=$_REQUEST["clasePax"];
        $nroTicketPax=$_REQUEST["nroTicketPax"];
        $nroCuponPax=$_REQUEST["nroCuponPax"];
        $nroReferencia=$_REQUEST["nroReferencia"];
        $nroAsientoPax=$_REQUEST["nroAsientoPax"];
        $nroDoc=$_REQUEST["nroDoc"];
        $nacPax=$_REQUEST["nacPax"];
        $idFileTuua=$_REQUEST["idFileTuua"];
        $params = array("apellidoPax"=>$apellidoPax,"nombrePax"=>$nombrePax,"tipoPax"=>$tipoPax,"foidPax"=>$foidPax,"nrofrecPax"=>$nrofrecPax,"destinoPax"=>$destinoPax,"clasePax"=>$clasePax,"nroTicketPax"=>$nroTicketPax,"nroCuponPax"=>$nroCuponPax,"nroReferencia"=>$nroReferencia,"nroAsientoPax"=>$nroAsientoPax,"nroDoc"=>$nroDoc,"nacPax"=>$nacPax,"idFileTuua"=>$idFileTuua);
        try {
            $result = $etd->CrearPasajero($params);
            if (!$result) {
                echo json_encode(array("rpt"=>0,"msg_error"=>"Ha ocurrido un error al crear el pasajero, intentelo más tarde."));
                exit;
            }else{
                echo json_encode(array("rpt"=>1,"msg_error"=>""));
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(array("rpt"=>0,"msg_error"=>$e));
            exit;
        }

    }

}