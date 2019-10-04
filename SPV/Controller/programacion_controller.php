<?php
if( !isset($_SESSION)){
	session_start();
}
	
class programacion extends Controller {
	function __construct(){
        /*$this->view->fechaActual = date('Y-m-d');
        echo $this->view->fechaActual;
        die();*/
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar ViewProgramación ---------------------------------
    public function listarProgramacion(){
        try{
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            $detalle = new Detalle_model();
            $this->view->objTripulacion = $detalle->listarTripulacion();
            
            $this->view->render('programacion');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }*/
    
    /*--------------------------------- Listar ProgramaciónxFecha (JSON) ---------------------------------
    public function listarProgramacionFch(){
        try{
            $programacion = new Programacion_model();
            
            $ITI_fch = $_POST["ITI_fch"];
            $AVI_id = $_POST["AVI_id"];
            $_SESSION["ITI_fch"] = $ITI_fch;
            
            $this->view->objProgramacion = $programacion->listarProgramacion($ITI_fch,$AVI_id);
            $this->view->objProgramacion = $this->array_utf8_encode($this->view->objProgramacion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objProgramacion);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }*/
    
    /*--------------------------------- Listar ViewResumenProgramación ---------------------------------*/
    public function resumenProgramacion(){
        try{
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            
            $detalle = new Detalle_model();
            $this->view->objTripulacion = $detalle->listarTripulacion();
            
            $motor = new Motor_model();
            $this->view->objModoTrabajo = $motor->verificarEstadoFlag();
            
            $tripulante = new Tripulante_model();
            $this->view->objTripVuelo = $tripulante->listarTripulante('','1','','');
            $this->view->objTripCabina = $tripulante->listarTripulante('','2','','');
            
            $objModulo = false;
            $objListaModulo = $detalle->listarModulo();
            foreach($objListaModulo as $listaListaModulo){
                if($listaListaModulo["MOD_estado"] == '1'){
                    $objModulo = true;
                    break;
                }
            }            
            if($objModulo){
                $this->view->objCambio = "divCambio";
            }
            
            $this->view->render('programacionResumen');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Programación ---------------------------------*/
    public function insertProgramacion(){
        try{
            $programacion = new Programacion_model();
            $ITI_id = $_POST["ITI_id"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            $TIPTRIPU_id = $_POST["TIPTRIPU_id"];
            
            if( $ITI_id == "[object HTMLInputElement]" ){
                $ITI_id = 'NULL';
            }
            
            $parts = explode('/',$_POST["ITI_fch"]);
            $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            if($_POST["accion"] == "update"){
                $programacion->deleteProgramacion($RUT_num_vuelo,$ITI_fch);
                
                $detalle = new Detalle_model();
                //$detalle->updateModulo('[SPV_REPROGRAMACION]','1');
            }
            
            if($_POST["TRIP_id_Instructor"] != ''){
                $TRIP_id_Instructor = $_POST["TRIP_id_Instructor"];
                $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch,$TRIP_id_Instructor,'1','Instructor');
                
                if($TRIP_instructor != "InstructorInstructor"){
                    $programacion->insertMovimientoTrip($TRIP_id_Instructor,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO');
                }
            }
            
            if($_POST["TRIP_id_Piloto"] != ''){
                $TRIP_id_Piloto = $_POST["TRIP_id_Piloto"];
                $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch,$TRIP_id_Piloto,'1','Piloto');
                $programacion->insertMovimientoTrip($TRIP_id_Piloto,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO');
            }
            
            if($_POST["TRIP_id_Copiloto"] != ''){
                $TRIP_id_Copiloto = $_POST["TRIP_id_Copiloto"];
                $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch,$TRIP_id_Copiloto,'1','Copiloto');
                $programacion->insertMovimientoTrip($TRIP_id_Copiloto,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO');
            }
            
            if($_POST["TRIP_id_JejeCabina"] != ''){
                $TRIP_id_JejeCabina = $_POST["TRIP_id_JejeCabina"];
                $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch,$TRIP_id_JejeCabina,$TIPTRIPU_id,'JefeCabina');
                $programacion->insertMovimientoTrip($TRIP_id_JejeCabina,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO');
            }
            
            $num_TripCabina = $_POST["num_TripCabina"];
            for($i = 1; $i <= $num_TripCabina;$i++){
                if($_POST["TRIP_id_TripCabina".$i] != ''){
                    $TRIP_id_TripCabina = $_POST["TRIP_id_TripCabina".$i];
                    $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch,$TRIP_id_TripCabina,$TIPTRIPU_id,'TripCabina'.$i);
                    $programacion->insertMovimientoTrip($TRIP_id_TripCabina,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO');
                }
            }
            
            if($_POST["TRIP_id_ApoyoVuelo"] != ''){
                $TRIP_id_ApoyoVuelo = $_POST["TRIP_id_ApoyoVuelo"];
                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->listarTripulante($TRIP_id_ApoyoVuelo,'','','');
                if($this->view->objTripulante[0]["TIPTRIP_id"] == '1'){
                    $TIPTRIPU_id = '1';
                } else {
                    $TIPTRIPU_id = '2';
                }
                $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch,$TRIP_id_ApoyoVuelo,$TIPTRIPU_id,'ApoyoVuelo');
                $programacion->insertMovimientoTrip($TRIP_id_ApoyoVuelo,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO');
            }
            
            $objCTFT = $detalle->listarCTFT();
            foreach($objCTFT as $listaCTFT){
                $CT_FT_id = $listaCTFT["CT_FT_id"];
                if($objProgramacion[$r]["RUT_hora_salida"] >= $listaCTFT["CT_FT_hora_ini"] && $objProgramacion[$r]["RUT_hora_salida"] <= $listaCTFT["CT_FT_hora_fin"]){
                    $programacion->insertCoTeFiTaTrip($TRIP_id_Piloto,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                    $programacion->insertCoTeFiTaTrip($TRIP_id_Copiloto,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                    $programacion->insertCoTeFiTaTrip($TRIP_id_JefeCabina,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                    $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina1,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                    $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina2,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                    if($TIPAVI_serie == '400'){
                        $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina3,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                    }
                }
            }
            
            echo "EXITO";
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Detalle Tripulación x Itinerario (JSON)) ---------------------------------*/
    public function listarDetProgramacion(){
        try{
            $programacion = new Programacion_model();
            $ITI_fch = $_POST["ITI_fch"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            
            $parts = explode('/',$ITI_fch);
            $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $this->view->objDetProgramacion = $programacion->listarProgramacionxTripulante($RUT_num_vuelo,$ITI_fch);
            $this->view->objDetProgramacion = $this->array_utf8_encode($this->view->objDetProgramacion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetProgramacion);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Resumen Matriz Programacion (JSON) ---------------------------------*/
    public function listarProgramacionFchResumenMatriz(){
        try{
            $programacion = new Programacion_model();
            
            $ITI_fch = $_POST["ITI_fch"];
            $AVI_id = $_POST["AVI_id"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            $_SESSION["ITI_fch"] = $ITI_fch;
            
            $this->view->objProgramacionResumenMatriz = $programacion->listarProgramacionResumenMatriz($ITI_fch,$AVI_id,$RUT_num_vuelo);
            $this->view->objProgramacionResumenMatriz = $this->array_utf8_encode($this->view->objProgramacionResumenMatriz);
            header('Content-Type: application/json');
            echo json_encode($this->view->objProgramacionResumenMatriz);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Resumen Programacion (JSON) ---------------------------------*/
    public function listarProgramacionFchResumen(){
        try{
            $programacion = new Programacion_model();
            
            $ITI_fch = $_POST["ITI_fch"];
            $AVI_id = $_POST["AVI_id"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            $_SESSION["ITI_fch"] = $ITI_fch;
            
            $this->view->objProgramacionResumen = $programacion->listarProgramacionResumen($ITI_fch,$AVI_id,$RUT_num_vuelo);
            $this->view->objProgramacionResumen = $this->array_utf8_encode($this->view->objProgramacionResumen);
            header('Content-Type: application/json');
            echo json_encode($this->view->objProgramacionResumen);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Cancelar VueloxItinerario (JSON) ---------------------------------*/
    public function cancelarVueloRuta(){
        try{
            $programacion = new Programacion_model();
            $itinerario = new Itinerario_model();
            
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            $ITI_id = $_POST["ITI_id"];
            $ITI_fch = $_POST["ITI_fch"];
            
            $programacion->cancelarProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch);
            $itinerario->updateItinerario($RUT_num_vuelo,'','','CANCELADO','',$ITI_fch,$ITI_fch);
            
            echo "Vuelo Cancelado"; 
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Retornar VueloxItinerario (JSON) ---------------------------------*/
    public function retornarVueloRuta(){
        try{
            $programacion = new Programacion_model();
            $itinerario = new Itinerario_model();
            $detalle = new Detalle_model();
            
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            $ITI_id = $_POST["ITI_id"];
            $ITI_fch = $_POST["ITI_fch"];
            
            $itinerario->updateItinerario($RUT_num_vuelo,'','','ENVIADO','',$ITI_fch,$ITI_fch);
            
            $objProgramacion = $programacion->listarProgramacionxTripulante($ITI_id);
            $objProgramacionRuta = $programacion->listarProgramacion($ITI_fch,'',$RUT_num_vuelo);
            
            $objCTFT = $detalle->listarCTFT();
            
            foreach( $objProgramacion as $listaProgramacion ){
                $TRIP_id = $listaProgramacion["TRIP_id"];
                if( $listaProgramacion["ITI_TRIP_tipo"] == "Piloto" ){
                    $programacion->insertMovimientoTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO');
                }
                if( $listaProgramacion["ITI_TRIP_tipo"] == "Copiloto" ){
                    $programacion->insertMovimientoTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO'); 
                }
                if( $listaProgramacion["ITI_TRIP_tipo"] == "JefeCabina" ){
                    $programacion->insertMovimientoTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO'); 
                }
                if( $listaProgramacion["ITI_TRIP_tipo"] == "TripCabina1" ){
                    $programacion->insertMovimientoTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO'); 
                }
                if( $listaProgramacion["ITI_TRIP_tipo"] == "TripCabina2" ){
                    $programacion->insertMovimientoTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO'); 
                }
                if( $listaProgramacion["ITI_TRIP_tipo"] == "TripCabina3" ){
                    $programacion->insertMovimientoTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,'','','','MINUTO','','','','MINUTO'); 
                }
                
                
                foreach($objCTFT as $listaCTFT){
                    $CT_FT_id = $listaCTFT["CT_FT_id"];
                    if($objProgramacionRuta[0]["RUT_hora_salida"] >= $listaCTFT["CT_FT_hora_ini"] && $objProgramacionRuta[0]["RUT_hora_salida"] <= $listaCTFT["CT_FT_hora_fin"]){
                        $programacion->insertCoTeFiTaTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,$CT_FT_id);
                    }
                }
            }
            
            echo "Vuelo Retornado"; 
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Trip x Día ---------------------------------*/
    public function resumenProgrTrip(){
        try{
            $tripulante = new Tripulante_model();
            
            $this->view->objPiloto = $tripulante->listarTripulante('','','1','');
            $this->view->objCopiloto = $tripulante->listarTripulante('','','2','');
            $this->view->objJefeCabina = $tripulante->listarTripulante('','','8','');
            $this->view->objTripCabina = $tripulante->listarTripulante('','','5','');
            
            $programacion = new Programacion_model();
            $objRuta = $programacion->listarRutaCompleta('');
            
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTrip();
            $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
            $this->view->objRuta = $detalle->listarRuta(date("Y-m-d"),'orden');
            $this->view->objMes = $detalle->listarMes();
            $this->view->objAnio = $detalle->listarAnio();
            
            $PROG_fch_Mes = $_POST["bPROG_fch_Mes"];
            $PROG_fch_Anio = $_POST["bPROG_fch_Anio"];
            
            $this->view->fechaActual = date('Y-m-d');
            if( $PROG_fch_Mes == "" && $PROG_fch_Anio == "" ){
                //$this->view->fechaInicio = date('Y-m-01');
                $this->view->fechaInicio = '2018-10-01';
                unset($_SESSION["PROG_fch_Mes"]);
                unset($_SESSION["PROG_fch_Anio"]);
            } else {
                $this->view->fechaInicio = $PROG_fch_Anio.'-'.$PROG_fch_Mes.'-01';
                $_SESSION["PROG_fch_Mes"] = $PROG_fch_Mes;
                $_SESSION["PROG_fch_Anio"] = $PROG_fch_Anio;
            }
            $fecha_antes = strtotime ( '-0 day' , strtotime ( $this->view->fechaInicio ) ) ;
            $this->view->fecha_antes = date ( 'Y-m-d' , $fecha_antes );
            $fecha_despues = strtotime ( '-1 day' , strtotime (  '+1 month' , strtotime ( $this->view->fechaInicio ) ) )  ;
            $this->view->fecha_despues = date ( 'Y-m-d' , $fecha_despues );
            
            $motor = new Motor_model();
            $this->view->objModoTrabajo = $motor->verificarEstadoFlag();
            
            $this->view->render('progTrip');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Trip x Día ---------------------------------*/
    public function buscarTripxDia(){
        try{
            $tripulante = new Tripulante_model();
            $programacion = new Programacion_model();
            
            $TRIP_apellido = $_POST["bTRIP_apellido"];
            $TRIP_numlicencia = $_POST["bTRIP_numlicencia"];
            
            $this->view->objTripBuscado = $tripulante->buscarTripulante($TRIP_apellido,'',$TRIP_numlicencia,'');
            
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            
            $detalle = new Detalle_model();
            $this->view->objTripulacion = $detalle->listarTripulacion();
            
            $motor = new Motor_model();
            $this->view->objModoTrabajo = $motor->verificarEstadoFlag();
            
            $objModulo = false;
            $objListaModulo = $detalle->listarModulo();
            foreach($objListaModulo as $listaListaModulo){
                if($listaListaModulo["MOD_estado"] == '1'){
                    $objModulo = true;
                    break;
                }
            }
            
            if($objModulo){
                $this->view->objCambio = "divCambio";
            }
            
            $this->view->render('progTrip');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
        
    /*--------------------------------- Listar Tripulante por Día (JSON) ---------------------------------*/
    public function listarTripxDia(){
        try{
            $tripulante = new Tripulante_model();
            $programacion = new Programacion_model();
            
            $TRIP_id = $_POST["TRIP_id"];
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $fch_ini = $_POST["fch_ini"];
            $fch_fin = $_POST["fch_fin"];
            
            $parts = explode('-',$fch_fin);
            $mesProgramar = $parts[1];
            $fch_ini2 = $programacion->data_first_month_day($mesProgramar);
            $fch_fin2 = $programacion->data_last_month_day($mesProgramar);
            
            //echo $fch_fin2;die();
            
            if( $TIPTRIPDET_id != "0" ){
                $objTripxDia = $programacion->listarTripxDia('',$TIPTRIPDET_id,$fch_ini,$fch_fin,$fch_ini2,$fch_fin2 );
            } if( $TRIP_id != "" ){
                $objTripxDia = $programacion->listarTripxDia($TRIP_id,'',$fch_ini,$fch_fin,$fch_ini2,$fch_fin2 );
            }
            
            //echo "<pre>".print_r($objTripxDia,true)."</pre>";die();
            
            $objTripxDia = $this->array_utf8_encode($objTripxDia);
            header('Content-Type: application/json');
            echo json_encode($objTripxDia);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
        
    /*--------------------------------- Listar Rutas Faltantes x Dia (JSON) ---------------------------------*/
    public function listarRutasFaltantesxDia(){
        try{
            $tripulante = new Tripulante_model();
            $programacion = new Programacion_model();
            
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $fch_ini = $_POST["fch_ini"];
            $fch_fin = $_POST["fch_fin"];
            
            $objRutaFxDia = $programacion->listarRutasFaltantesxDia($fch_ini,$TIPTRIPDET_id);
            //echo "<pre>".print_r($objRutaFxDia,true)."</pre>";die();
            
            $objRutaFxDia = $this->array_utf8_encode($objRutaFxDia);
            header('Content-Type: application/json');
            echo json_encode($objRutaFxDia);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Historial del Tripulante por Día (JSON) ---------------------------------*/
    public function listarHistorialTripxDia(){
        try{
            $tripulante = new Tripulante_model();
            $programacion = new Programacion_model();
            
            $TRIP_id = $_POST["TRIP_id"];
            $fchLista = $_POST["fchLista"];
            
            $objTripHistorialxDia = $programacion->listarHistorialTripxDia($TRIP_id,$fchLista);
            $objTripHistorialxDia = $this->array_utf8_encode($objTripHistorialxDia);
            header('Content-Type: application/json');
            echo json_encode($objTripHistorialxDia);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Update Tripulante por Día (JSON) ---------------------------------*/
    public function updateTripxDia(){
        try{
            $tripulante = new Tripulante_model();
            $programacion = new Programacion_model();
            $motor = new Motor_model();
            
            $numCondicional = $_POST["numCondicional"];
            $tipCondicional = $_POST["tipCondicional"];
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $TRIP_id1 = $_POST["TRIP_id1"];
            $TRIP_id2 = $_POST["TRIP_id2"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            
            $parts = explode('/',$_POST["fch_prog"]);
            $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            //$motor->insertMotorCambio($TRIP_id,$MOTCAMB_tipoCambio,$MOTCAMB_original,$MOTCAMB_modificado,$ITI_fch);
            
            if( $tipCondicional == "Rutas" ){
                //echo "DEMO";die();
                for($i = 1; $i <= $numCondicional; $i++){
                    $textCondicional = $_POST["textCondicional".$i];
                    $checkCondicional = $_POST["checkCondicional".$i];
                    $parts = explode('-',$textCondicional);
                    
                    if( $checkCondicional == 'Si' ){
                        for($j = 0; $j < count($parts); $j++){
                            $RUT_num_vuelo = $parts[$j];
                            
                            $programacion->updateProgramacion_xTrip($TRIP_id2,$TRIP_id1,$ITI_fch,$RUT_num_vuelo);
                            $programacion->updateMovimientoTrip($TRIP_id2,$TRIP_id1,$ITI_fch,$RUT_num_vuelo);
                            
                            $motor->insertMotorCambio($TRIP_id1,'RUTA',$RUT_num_vuelo,'LIBRE',$ITI_fch);
                            $motor->insertMotorCambio($TRIP_id2,'RUTA','LIBRE',$RUT_num_vuelo,$ITI_fch);
                        }   
                    }
                }   
            }
            if( $tipCondicional == "Vacio" ){
                
                for($j = 0; $j < count($RUT_num_vuelo);$j++){
                    $RUT_num_vuelo2 = $RUT_num_vuelo[$j];
                    $ObjTrip = $programacion->listarTripxVuelo($RUT_num_vuelo2,$ITI_fch,$TIPTRIPDET_id);                    
                    $TRIP_id_old = $ObjTrip[0]["TRIP_id"];
                    
                    if( $TRIP_id_old != "" ){
                        $programacion->updateProgramacion_xTrip($TRIP_id1,$TRIP_id_old,$ITI_fch,$RUT_num_vuelo2);
                        $programacion->updateMovimientoTrip($TRIP_id1,$TRIP_id_old,$ITI_fch,$RUT_num_vuelo2);
                    } else {
                        if( $TIPTRIPDET_id = '1'){
                            $TIPTRIPDET_tipo = 'Piloto';
                        }
                        $ITI_id = 'NULL';                        
                        $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo2,$ITI_fch,$TRIP_id1,$TIPTRIPDET_id,$TIPTRIPDET_tipo);
                        $programacion->insertMovimientoTrip($TRIP_id1,$ITI_fch,$RUT_num_vuelo2,'','','','MINUTO','','','','MINUTO');
                        $programacion->deleteLibre($ITI_fch,$TRIP_id1);
                    }
                    
                    $motor->insertMotorCambio($TRIP_id1,'RUTA','LIBRE',$RUT_num_vuelo2,$ITI_fch);
                }
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Enviar Correo de Aviones en MAntenimiento  ---------------------------------*/
    public function enviarCorreoProgramacionMes(){
        try{
            $detalle = new Detalle_model();
            $email = new Email();
            $programacion = new Programacion_model();
            
            $fchProg = $_POST["fchProg"];
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $TRIP_id = $_POST["TRIP_id"];
            
            $parts = explode('-',$fchProg);
            $fch_anio = $parts[0];
            $fch_mes = $parts[1];
            
            $mesProgramar = $fch_mes;
            
            $firtDay = $programacion->data_first_month_day($mesProgramar);
            $lastDay = $programacion->data_last_month_day($mesProgramar);
            
            $nomMesAnio = strtoupper(strftime('%B del %Y',strtotime($fchProg)));
            
            $tripulante = new Tripulante_model();
            if( $TIPTRIPDET_id != "" ){
                $objTripulante = $tripulante->listarTripulante('','',$TIPTRIPDET_id,'');
            } else if ( $TRIP_id != "" ) {
                $objTripulante = $tripulante->listarTripulante($TRIP_id,'','','');
            }
            
            $objTripulante = $this->array_utf8_encode($objTripulante);
            
            $asunto = "PROGRAMACIÓN DEL MES DE ".mb_strtoupper($nomMesAnio);
            
            foreach($objTripulante as $listaTripulante){
                $txt = "<p>Señores:<p>";
                $txt .= "<p>El presente es para informarles su programación de Vuelos del Mes de :".$nomMesAnio."<p>";
                
                $txt .= "<p><p>";
                $txt .= "<p>TRIPULANTE: ".$listaTripulante["TRIP_nombre"]." ".$listaTripulante["TRIP_apellido"]."<p>";
                
                $TRIP_id = $listaTripulante["TRIP_id"];
                
                $txt .= "<table border='2'>";
                $txt .= "<tr>";
                for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
                    $txt .= "<td>".$q."</td>";
                }
                $txt .= "</tr>";
                $txt .= "<tr>";
                for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){                    
                    $fechaProg = $q;
                    $objTripxDia = $programacion->listarTripxDia($TRIP_id,'',$fechaProg,$fechaProg,$firtDay,$lastDay);
                    
                    foreach( $objTripxDia as $listaTripxDia ) {
                        if( $listaTripxDia["AptoMedico"] != "" ){
                            $valor = $listaTripxDia["AptoMedico"];
                            $color = "#f6695a";
                        } 
                        else if( $listaTripxDia["Curso"] != "" ){
                            $valor = $listaTripxDia["Curso"];
                            $color = "#ef9e6c";
                        } 
                        else if( $listaTripxDia["Chequeo"] != "" ){
                            $valor = $listaTripxDia["Chequeo"];
                            $color = "#5ab348";
                        }
                        else if( $listaTripxDia["Simulador"] != "" ){
                            $valor = $listaTripxDia["Simulador"]; 
                            $color = "#6789f2";
                        }
                        else if( $listaTripxDia["Ausencia"] != "" ){
                            $valor = $listaTripxDia["Ausencia"];
                            $color = "";
                        }
                        else if( $listaTripxDia["Libre"] != "" ){
                            $valor = $listaTripxDia["Libre"];
                            $color = "#b4f090";
                        }
                        else if( $listaTripxDia["Rutas"] != "" ){
                            $valor = $listaTripxDia["Rutas"];
                            $color = "";
                            /*$rutaArray = explode('-',$rutas);
                            $cantRutas = count($rutaArray);
                            for ($n = 1; $n <= $cantRutas; $n++) {
                                $valor = $valor."".$rutaArray[($n-1)]."-".$rutaArray[($n)]."/n";
                                $valor = substr($valor,0, -1);
                                $n++;
                            }*/
                        } else {
                            $valor = 'TD';
                            $color = "#7ffaf8";
                        }
                        $TimeBT = $this->conversorSegundosHoras( ($listaTripxDia["TimeBT"]*60) );
                    }
                    
                    //if( $valor != "" ){
                        //$txt .= "<p><b>Fecha: </b>".$fechaProg."</p>";
                        //$xt .= "<p><b>Programación: </b>".$valor."</p>";
                        
                        $txt .= "<td bgcolor='".$color."'>".$valor."</td>";
                    //}
                }
                $txt .= "</tr>";
                $txt .= "</table>";
                
                $txt .= "<p>Saludos cordiales.</p>";
                $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaTripulante["TRIP_correo"]),"",'','',"progxDia");
            }
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>