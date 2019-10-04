<?php
/**
 * Description of ReportesController
 *
 * @author ihuapaya
 */
class ReportesController extends Controller{
    private $permisos;
    public function __construct() {
        parent::__construct();
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            if(!$this->isAccessProgram("CCO_REPORTE_DGAC", 1)){
                $this->_view->assign("error_text","El usuario <b>". $_SESSION[NAME_SESS_USER]["id_usuario"]."</b> no tiene permisos para accedar a esta Página.");
                $this->_view->show_page("403.tpl");
                exit;
            }else {
                $this->permisos  = $this->PermisosporPaginas("CCO_REPORTE_DGAC", 1);
                $this->_view->assign("permiso", $this->permisos );
            }
        }
    }
    
    public function pasajeroAction(){
        
        if(isset($_GET["no_access"]) && $_GET["no_access"]==1){
            $this->_view->assign("error_text","El usuario <b>". $_SESSION[NAME_SESS_USER]["id_usuario"]."</b> no tiene permisos para accedar a esta Página.");
            $this->_view->show_page("403.tpl");
            exit;
        }
        
        $fecha_ini = date("Y-m-d");
        if(isset($_GET["fecha_inicio"]) && $_GET["fecha_inicio"]!=""){
            $fecha_ini = $_GET["fecha_inicio"];
        }
        $fecha_fin = "";
        if(isset($_GET["fecha_fin"]) && $_GET["fecha_fin"]!=""){
            $fecha_fin = $_GET["fecha_fin"];
        }

        $data = $this->ListadoPasajerosDGAC($fecha_ini,$fecha_fin);
        $this->_view->assign("data",$data["data"]);
        $this->_view->assign("fecha_ini",$fecha_ini);
        $this->_view->assign("fecha_fin",$fecha_fin);
        $this->_view->assign('title', "Reporte Pasajero DGAC");
        $this->_view->assign("JS", "reporte");
        $this->_view->show_page("reporte_pasajero_dgac.tpl");
    }
    
    
    public function ListadoPasajerosDGAC($fecha_ini,$fecha_fin){
        $obj_vuelo_detalle = new VueloDetalle();
        $obj_ciudad = new Ciudad();
        $ciudades = $obj_ciudad->getAll();
        $array_ciudades =  array();
        foreach ($ciudades as $ciudad) {
            $array_ciudades[$ciudad["CIU_id"]] = $ciudad;
        }

        $obj_matricula = new Matriculas();
        $matriculas = $obj_matricula->getAll();
        $array_matricula = array();
        foreach ($matriculas as $matricula) {
            $array_matricula[$matricula["id"]] = $matricula;
        }
        
        $obj_ruta = new Ruta();
        $rutas = $obj_ruta->getAll();
        $array_ruta = array();
        foreach ($rutas as $ruta) {
            $array_ruta[$ruta["ciudadOrigen"]."-".$ruta["ciudadDestino"]] = $ruta;
        }
        
        $obj_avionTipo = new AvionTipo();
        $avionTipo = $obj_avionTipo->getAll();
        $array_avionTipo = array();
        foreach ($avionTipo as $value) {
            $array_avionTipo[$value["AVITIP_id"]] = $value;
        }
        
        $data_vuelos = $obj_vuelo_detalle->data_reporte_pasajeros($fecha_ini,$fecha_fin);
        $array_sin_escala = array();
        $array_con_escala = array();
        $data = array();
        foreach ($data_vuelos as $vuelo) {
            $pasajeroPagoTotal	= $vuelo['clase_y']-$vuelo['nro_infantes'];
            $cargaTotal	 = $vuelo['nro_kilos_carga'];
            if((($vuelo['NroVuelo']=='7170' || $vuelo['NroVuelo']=='7070')&& $vuelo['IdMatricula']=='OB-2089P')||(($vuelo['NroVuelo']=='7171' || $vuelo['NroVuelo']=='7071')&& $vuelo['IdMatricula']=='OB-2089P')){
                $capacidadCarga	= '15950';
                $capacidadAsientos = 0;				
            }else{
                $capacidadCarga	= $array_matricula[$vuelo["IdMatricula"]]["capacidad_carga"];
                $capacidadAsientos = $array_matricula[$vuelo["IdMatricula"]]["nro_pasajeros_permitido"];
            }
            $factorAsiento = $pasajeroPagoTotal/$capacidadAsientos;
            if($factorAsiento>0){
                $factorAsiento =number_format($factorAsiento, 3, '.', '');
            }else{
                $factorAsiento = 0;
            }
            $factorCarga  = $cargaTotal/$capacidadCarga;
            
            if($factorCarga>0){
                $factorCarga =number_format($factorCarga, 3, '.', '');
            }else{
                $factorCarga = 0;
            }
            $matriculaAvion = str_replace("-", "", str_replace("P", "", $array_matricula[$vuelo["IdMatricula"]]["id"]));
            $fabricante = explode(" ", $array_avionTipo[$array_matricula[$vuelo["IdMatricula"]]["CodigoAvion"]]["AVITIP_modelo"]);
            $fabricanteAvion = $fabricante[0];
            $modelo = "B-".$fabricante[1]."-".$array_avionTipo[$array_matricula[$vuelo["IdMatricula"]]["CodigoAvion"]]["AVITIP_serie"];
            if($vuelo["ciudad_parada"]==""){
                $data_sin_escala = new stdClass();
                $data_sin_escala->empresa = "Peruvian Air Line S.A.";
                $data_sin_escala->fecha = date("d/m/Y", strtotime($vuelo["fecha_vuelo"]));
                $data_sin_escala->Origen = $array_ciudades[$vuelo["ciudad_origen"]]["CIU_nombre"];
                $data_sin_escala->departamento_origen = $array_ciudades[$vuelo["ciudad_origen"]]["CIU_departamento"];
                $data_sin_escala->destino = $array_ciudades[$vuelo["ciudad_destino"]]["CIU_nombre"];
                $data_sin_escala->departamento_destino = $array_ciudades[$vuelo["ciudad_destino"]]["CIU_departamento"];
                $data_sin_escala->pasajero_pago_directo = ($vuelo["pasajeroPagoDirecto"] =="" || $vuelo["pasajeroPagoDirecto"]==0) ? 0 : $vuelo["pasajeroPagoDirecto"];
                $data_sin_escala->pasajeros_en_conexion = 0;
                $data_sin_escala->tota_pasajero_nopago = ($vuelo["nro_nr"] =="" || $vuelo["nro_nr"]==0) ? 0 : $vuelo["nro_nr"];
                $data_sin_escala->total_pasajeros = $vuelo['clase_y']-$vuelo['nro_infantes'];
                $data_sin_escala->total_infantes = ($vuelo["nro_infantes"] =="" || $vuelo["nro_infantes"]==0) ? 0 : $vuelo["nro_infantes"];
                $data_sin_escala->carga_pago_directo = ($vuelo["nro_kilos_carga"] =="" || $vuelo["nro_kilos_carga"]==0) ? 0 : $vuelo["nro_kilos_carga"]; 
                $data_sin_escala->cargaPagoConexion = 0;
                $data_sin_escala->cargaPagoTotal = ($vuelo["nro_kilos_carga"] =="" || $vuelo["nro_kilos_carga"]==0) ? 0 : $vuelo["nro_kilos_carga"];
                $data_sin_escala->correoPagoDirecto = 0;
                $data_sin_escala->correoPagoConexion = 0;
                $data_sin_escala->correoPagoTotal = 0;
                $data_sin_escala->vueloRealizados = 1;
                $data_sin_escala->Distancia =  $array_ruta[$vuelo["ciudad_origen"]."-".$vuelo["ciudad_destino"]]["RUT_distancia_km"];;
                $data_sin_escala->asientosOfrecidos = $capacidadAsientos;
                $data_sin_escala->capacidadAsientos = $capacidadAsientos;
                $data_sin_escala->factorAsientos = $factorAsiento;
                $data_sin_escala->capacidadCarga = $capacidadCarga;
                $data_sin_escala->factorCarga = $factorCarga;
                $data_sin_escala->nro_vuelo = $vuelo["NroVuelo"];
                $data_sin_escala->matricula = $matriculaAvion;
                $data_sin_escala->fabricante = $fabricanteAvion;
                $data_sin_escala->modelo = $modelo;
                $array_sin_escala[] = $data_sin_escala;
            }else{
                $data_con_escala = new stdClass();
                $data_con_escala->empresa = "Peruvian Air Line S.A.";
                $data_con_escala->fecha = date("d/m/Y", strtotime($vuelo["fecha_vuelo"]));
                $data_con_escala->Origen = $array_ciudades[$vuelo["ciudad_origen"]]["CIU_nombre"];
                $data_con_escala->departamento_origen = $array_ciudades[$vuelo["ciudad_origen"]]["CIU_departamento"];
                $data_con_escala->destino = $array_ciudades[$vuelo["ciudad_destino"]]["CIU_nombre"];
                $data_con_escala->departamento_destino = $array_ciudades[$vuelo["ciudad_destino"]]["CIU_departamento"];
                $data_con_escala->pasajero_pago_directo = ($vuelo["pasajeroPagoDirecto"] =="" || $vuelo["pasajeroPagoDirecto"]==0) ? 0 : $vuelo["pasajeroPagoDirecto"];
                $data_con_escala->pasajeros_en_conexion = 0;
                $data_con_escala->tota_pasajero_nopago = ($vuelo["nro_nr"] =="" || $vuelo["nro_nr"]==0) ? 0 : $vuelo["nro_nr"];
                $data_con_escala->total_pasajeros = $vuelo['clase_y']-$vuelo['nro_infantes'];
                $data_con_escala->total_infantes = ($vuelo["nro_infantes"] =="" || $vuelo["nro_infantes"]==0) ? 0 : $vuelo["nro_infantes"];
                $data_con_escala->carga_pago_directo = ($vuelo["nro_kilos_carga"] =="" || $vuelo["nro_kilos_carga"]==0) ? 0 : $vuelo["nro_kilos_carga"];
                $data_con_escala->vueloRealizados = 1;
                $data_con_escala->cargaPagoConexion = 0;
                if($vuelo["nro_paradas"]==1){
                    $data_con_escala->carga_pago_directo = 0;
                    $data_con_escala->cargaPagoConexion = ($vuelo["nro_kilos_carga"] =="" || $vuelo["nro_kilos_carga"]==0) ? 0 : $vuelo["nro_kilos_carga"];
                    $data_con_escala->pasajero_pago_directo = 0;
                    $data_con_escala->pasajeros_en_conexion = ($vuelo["pasajeroPagoDirecto"] =="" || $vuelo["pasajeroPagoDirecto"]==0) ? 0 : $vuelo["pasajeroPagoDirecto"];
                    $data_con_escala->vueloRealizados = 0;
                }
                $data_con_escala->total_pasajeros = $vuelo['clase_y']-$vuelo['nro_infantes'];
                $data_con_escala->total_infantes = ($vuelo["nro_infantes"] =="" || $vuelo["nro_infantes"]==0) ? 0 : $vuelo["nro_infantes"];
                $data_con_escala->cargaPagoTotal =($vuelo["nro_kilos_carga"] =="" || $vuelo["nro_kilos_carga"]==0) ? 0 : $vuelo["nro_kilos_carga"];
                $data_con_escala->correoPagoDirecto = 0;
                $data_con_escala->correoPagoConexion = 0;
                $data_con_escala->correoPagoTotal = 0;
                $data_con_escala->Distancia =  $array_ruta[$vuelo["ciudad_origen"]."-".$vuelo["ciudad_destino"]]["RUT_distancia_km"];
                $data_con_escala->asientosOfrecidos = $capacidadAsientos;
                $data_con_escala->capacidadAsientos = $capacidadAsientos;
                $data_con_escala->factorAsientos = $factorAsiento;
                $data_con_escala->capacidadCarga = $capacidadCarga;
                $data_con_escala->factorCarga = $factorCarga;
                $data_con_escala->nro_vuelo = $vuelo["NroVuelo"];
                $data_con_escala->matricula = $matriculaAvion;
                $data_con_escala->fabricante = $fabricanteAvion;
                $data_con_escala->modelo = $modelo;
                $data_con_escala->nro_paradas = $vuelo["nro_paradas"];
                $array_con_escala[] = $data_con_escala;
            }
        }
        
        $data["data"]["escala"] =$array_con_escala;
        $data["data"]["sin_escala"] =$array_sin_escala;
        
        return $data;
    }
    
    
    public function exportarExcelDGACAction(){
        if($this->permisos[0]["Exportar"] == 1){
            require_once ROOT . 'library/PHPExcel/Classes/PHPExcel.php';
            $fecha_ini = "";
            if(isset($_GET["fecha_ini"]) && $_GET["fecha_ini"]!=""){
                $fecha_ini = $_GET["fecha_ini"];
            }
            $fecha_fin = "";
            if(isset($_GET["fecha_fin"]) && $_GET["fecha_fin"]!=""){
                $fecha_fin = $_GET["fecha_fin"];
            }
            $data = $this->ListadoPasajerosDGAC($fecha_ini,$fecha_fin);
            $nombre_excel = "";
            if($_GET["tipo"]=="sin_escala"){
                $vr_sin_escala = $data["data"]["sin_escala"];
                $nombre_excel = "REPORTE_DGAC_VR_SIN_ESCALA";
            }elseif($_GET["tipo"]=="escala"){
                $vr_sin_escala = $data["data"]["escala"];
                $nombre_excel = "REPORTE_DGAC_VR_CON_ESCALA";
            }

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
        
            $objPHPExcel->getActiveSheet()->setTitle('Nac_Vlo_Regular');
            /* Estilo Cabecera */
            $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getBorders()->getAllBorders()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK));
            $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);		
            $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A:AA')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
            $objPHPExcel->getDefaultStyle()->applyFromArray($style);

            $styleColor_porc = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => "C00000")));
            $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($styleColor_porc);
            $stylefontcolor = array(
                'font' => array(
                    'color' => array('rgb' => 'FFFFFF'),
                    'bold' => true
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($stylefontcolor);
        
            /* Estilo por columnas */
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(16);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(17);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(17);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(17);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(12);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(12);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(12);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(12);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(12);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('R')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('S')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('U')->setWidth(17);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('V')->setWidth(17);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('W')->setWidth(17);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('X')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Y')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Z')->setWidth(15);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('AA')->setWidth(15);
        
            /* Cabeceras */
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'EMPRESA');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'FECHA');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'ORIGEN');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'DEPARTAMENTO DONDE QUEDA EL ORIGEN');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'DESTINO');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'DEPARTAMENTO DONDE QUEDA EL DESTINO');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'PASAJEROS PAGO DIRECTO');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'PASAJEROS EN CONEXIÓN');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'TOTAL PASAJEROS NO PAGO');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'TOTAL PASAJEROS');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'TOTAL INFANTES');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'CARGA(KG.) DIRECTO');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'CARGA(KG.) EN CONEXIÓN Y/O TRANSBORDO');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'TOTAL CARGA(KG.)');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'CORREO(KG.) DIRECTO ');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'CORREO(KG.) EN CONEXIÓN');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'TOTAL CORREO(KG.');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'VUELOS REALIZADOS');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'DISTANCIA (KM)');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'CAPACIDAD DE ASIENTOS QUE TIENE LA AERONAVE');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', 'FACTOR DE OCUPACIÓN DE PASAJEROS');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', 'CAPACIDAD DE CARGA(KG.) DISPONIBLE DE LA AERONAVE');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', 'FACTOR DE OCUPACIÓN DE LA CARGA (KG.)');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', 'NÚMERO DE VUELO');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', 'MATRÍCULA DEL AVIÓN');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', 'FABRICANTE');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', 'MODELO');
   
            $i = 2;
            foreach ($vr_sin_escala as $sin_escala) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i,$sin_escala->empresa);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i,$sin_escala->fecha);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i,$sin_escala->Origen);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i,$sin_escala->departamento_origen);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i,$sin_escala->destino);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i,$sin_escala->departamento_destino);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i,$sin_escala->pasajero_pago_directo);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i,$sin_escala->pasajeros_en_conexion);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i,$sin_escala->tota_pasajero_nopago);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i,$sin_escala->total_pasajeros);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i,$sin_escala->total_infantes);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i,$sin_escala->carga_pago_directo);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$i,$sin_escala->cargaPagoConexion);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$i,$sin_escala->cargaPagoTotal);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$i,$sin_escala->correoPagoDirecto);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$i,$sin_escala->correoPagoConexion);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$i,$sin_escala->correoPagoTotal);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$i,$sin_escala->vueloRealizados);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i,$sin_escala->Distancia);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$i,$sin_escala->capacidadAsientos);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i,$sin_escala->factorAsientos);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$i,$sin_escala->capacidadCarga);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i,$sin_escala->factorCarga);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$i,$sin_escala->nro_vuelo);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$i,$sin_escala->matricula);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$i,$sin_escala->fabricante);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$i,$sin_escala->modelo);
                $rango_comercial = "A".$i.":AA".$i;
                if($sin_escala->nro_paradas==1){

                    $styleColor_porc = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => "FF9B9B")));
                    $objPHPExcel->getActiveSheet()->getStyle($rango_comercial)->applyFromArray($styleColor_porc);
                }
                $i++;
            }

            $A="A2";
            $AA = "AA".($i-1);
            $rango = $A.":".$AA;
            $objPHPExcel->getActiveSheet()->getStyle($rango)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle($rango)->getBorders()->getAllBorders()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK));

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
        }else{
            $this->redireccionar("reportes/pasajero?no_access=1");
        }
    }
    
    public function getDataReporteAction(){
        $data = $this->ListadoPasajerosDGAC("2019-07-01", "2019-07-01");
        echo json_encode($data["data"]["escala"]);
        exit;
    }
    
}
