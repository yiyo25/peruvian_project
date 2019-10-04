<?php
if( !isset($_SESSION)){
	session_start();
}

	
class itinerario extends Controller {
	function __construct(){
		parent::__construct();
        if(!$this->isAccessProgram("SPV_PROG_ITI", 1)){
        
            $this->view->error_text = "El usuario <b>". $_SESSION[NAME_SESS_USER]["id_usuario"]."</b> no tiene permisos para accedar a esta Página.";
            $this->view->render('403');
            exit;
        }else {

            $this->view->objBotton          = $this->PermisosporPaginas("SPV_PROG_ITI", 1);
            $this->view->permisos_ver       = $this->PermisosporPaginas("SPV_ITINERARIO_VER", 1);
            $this->view->permisos_agregar   = $this->PermisosporPaginas("SPV_ITINERARIO_AGRE", 1);
            $this->view->permisos_modificar = $this->PermisosporPaginas("SPV_ITINERARIO_MOD" ,1);
        }
        
	}
	
    /*--------------------------------- Listar Resumen Itinerario ---------------------------------*/
    public function listarResumenItinerario(){
        try{
            unset($_SESSION["ITI_fchini"]);
            unset($_SESSION["ITI_fchfin"]);
            
            $itinerario = new Itinerario_model();
            $this->view->objResumenItinerario = $itinerario->listarResumenItinerario();
            
            $detalle = new Detalle_model();
            $this->view->objRuta = $detalle->listarRuta(date("Y-m-d"),'orden');
            
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            
            $this->view->render('itinerario');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Itinerario ---------------------------------*/
    public function insertItinerario(){
        try{
            $itinerario = new Itinerario_model();
            
            $parts = explode('/',$_POST["ITI_fchini"]);
            $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["ITI_fchfin"]);
            $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $cantidad = $_POST["cantidad"];
            
            for($j=$ITI_fchini;$j<=$ITI_fchfin;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){
                for($i = 1; $i <= $cantidad;$i++){
                    $RUT_num_vuelo = $_POST["RUT_num_vuelo".$i];
                    $AVI_id = $_POST["AVI_id".$i];
                    
                    if($RUT_num_vuelo != ''){
                        $ITI_id = $itinerario->insertItinerario($RUT_num_vuelo,$AVI_id,$j,'PROCESO','','');
                        if(is_array($ITI_id)){
                            $this->view->objItinerario = $ITI_id;
                            $this->view->objItinerario = $this->array_utf8_encode($this->view->objItinerario);
                            header('Content-Type: application/json');
                            echo json_encode($this->view->objItinerario);
                            die();
                        }
                    }
                    
                }
                
            }
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar ItinerarioxAVImanto ---------------------------------*/
    public function insertItinerarioManto(){
        try{
            $cantidad = $_POST["cantidadManto"];
            for($i = 1; $i <= $cantidad;$i++){
                $parts = explode('/',$_POST["MANTAVI_fchini".$i]);
                $MANTAVI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

                $parts = explode('/',$_POST["MANTAVI_fchfin".$i]);
                $MANTAVI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                
                for($j=$MANTAVI_fchini;$j<=$MANTAVI_fchfin;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){
                    
                    $RUT_num_vuelo = $_POST["RUT_num_vuelo_m".$i];
                    $AVI_id = $_POST["AVI_id_m".$i];
                    
                    if($RUT_num_vuelo != ''){
                        $itinerario = new Itinerario_model();
                        $ITI_id = $itinerario->insertItinerario($RUT_num_vuelo,$AVI_id,$j,'PROCESO','','');
                    }
                }
            }
            echo $ITI_id;
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Det. Itinerario (JSON) ---------------------------------*/
    public function listarDetItinerario(){
        try{
            $itinerario = new Itinerario_model();
            $ITI_fchini = $_POST["ITI_fchini"];
            $ITI_fchfin = $_POST["ITI_fchfin"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            
            $this->view->objDetItinerario = $itinerario->listarItinerario($ITI_fchini,$ITI_fchfin,$RUT_num_vuelo);
            $this->view->objDetItinerario = $this->array_utf8_encode($this->view->objDetItinerario);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetItinerario);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Det. Itinerario (JSON) ---------------------------------*/
    public function completarRuta(){
        try{
            $detalle = new Detalle_model();
            
            
            $RUT_orden_i = $_POST["RUT_orden"];
            $RUT_relacion = $_POST["RUT_relacion"];
            
            $parts = explode('/',$_POST["ITI_fchini"]);
            $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

            $objProgramacion = $detalle->listarRuta($ITI_fchini,'orden');
            
            $RUT_num_vuelo = array();

            for($j = 0; $j < count($objProgramacion); $j++){
                if( $RUT_relacion == $objProgramacion[$j]["RUT_relacion"] and $RUT_orden_i < $objProgramacion[$j]["RUT_orden"] ){
                    $RUT_num_vuelo = array_merge($RUT_num_vuelo,array($objProgramacion[$j]["RUT_num_vuelo"]));
                    break;
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode($RUT_num_vuelo);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar RutaxDia (JSON) ---------------------------------*/
    public function listarRutaxDia(){
        try{            
            $parts = explode('/',$_POST["ITI_fchini"]);
            $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            /*$parts = explode('/',$_POST["ITI_fchfin"]);
            $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];*/
            
            $detalle = new Detalle_model();
            $objRutaxDia = $detalle->listarRuta($ITI_fchini,'Orden');
            $objRutaxDia = $this->array_utf8_encode($objRutaxDia);
            
            header('Content-Type: application/json');
            echo json_encode($objRutaxDia);            
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Itinerario ---------------------------------*/
    public function updateItinerario(){
        try{
            $itinerario = new Itinerario_model();
            $parts = explode('/',$_POST["ITI_fchini"]);
            $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["ITI_fchfin"]);
            $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $ITI_fchini_e = $_POST["ITI_fchini"];
            $ITI_fchfin_e = $_POST["ITI_fchfin"];
            $cantidad = $_POST["cantidad"];
            
            $objDetItinerario = $itinerario->listarItinerario($ITI_fchini_e,$ITI_fchfin_e,'');
            $AUD_usu_mod = $objDetItinerario[0]["AUD_usu_cre"];
            $AUD_fch_mod = $objDetItinerario[0]["AUD_fch_cre"];
            
            $itinerario->deleteItinerario($ITI_fchini_e,$ITI_fchfin_e);
            //echo "demo";die();
            for($j=$ITI_fchini;$j<=$ITI_fchfin;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){
                for($i = 1; $i <= $cantidad;$i++){
                    $RUT_num_vuelo = $_POST["RUT_num_vuelo".$i];
                    $AVI_id = $_POST["AVI_id".$i];
                    
                    if($RUT_num_vuelo != ''){
                        $ITI_id = $itinerario->insertItinerario($RUT_num_vuelo,$AVI_id,$j,'PROCESO',$AUD_usu_mod,$AUD_fch_mod);
                    }
                }
                
            }
            echo $ITI_id;
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Estado Itinerario ---------------------------------*/
    public function enviarAprobItinerario(){
        try{
            $itinerario = new Itinerario_model();
            $ITI_fchini = $_POST["ITI_fchini"];
            $ITI_fchfin = $_POST["ITI_fchfin"];
            
            //$itinerario->updateItinerario('ENVIADO',$ITI_fchini,$ITI_fchfin);
            $itinerario->updateItinerario('','','','ENVIADO','',$ITI_fchini,$ITI_fchfin);
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_ITINERARIO]','1');
            
            /* inicio envio de correo */
            $listaDestino = "";
            $objCorreos = $detalle->listarCorreoItinerario();
            foreach($objCorreos as $listaCorreos){
                $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
            }
            $listaDestino = substr($listaDestino, 1);
            
            $email = new Email();
            $txt = "<p>Estimados: Adjunto la programación correspondiente a ".$ITI_fchini." al ".$ITI_fchfin."</p>";
            $txt .= "<p>Existen veces en la que hay que agregar informacion diferente por día de envio como cancelaciones a ultima hora y/o carga.</p>";
            $txt .= "<p>Saludos cordiales.</p>";
                        
            $parts = explode('/',$_POST["ITI_fchini"]);
            $ITI_fchini2 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["ITI_fchfin"]);
            $ITI_fchfin2 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $ITI_fchini3 = $fecha=strftime('"%d/%m/%Y"',strtotime($ITI_fchini2));
            $ITI_fchfin3 = $fecha=strftime('"%d/%m/%Y"',strtotime($ITI_fchfin2));
            
            $asunto = "PROGRAMACIÓN DEL ITINERARIO DEL ".mb_strtoupper($ITI_fchini3)." AL ".mb_strtoupper($ITI_fchfin3);
            
            $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",$ITI_fchini2,$ITI_fchfin2,"itinerario");
            /* fin envio de correo */
            
            
            
            // --------------------------------- Registrar Información al Motor de Itinerarios Registrados --------------------------------- //
            require_once ("motor_controller.php");
            $motor = new motor();
            
            
            $programacion = new Programacion_model();
            $objProgramado = $programacion->listarProgramacionMensual($ITI_fchini2,$ITI_fchfin2);
            
            if( count($objProgramado) > 0 ){
                $objItinerario = $itinerario->listarItinerario($ITI_fechaini,$ITI_fechafin,'');
                foreach( $objItinerario as $listaItinerario ){
                    $ITI_id = $listaItinerario["ITI_id"];
                    $RUT_num_vuelo = $listaItinerario["RUT_num_vuelo"];
                    $ITI_fch = $listaItinerario["ITI_fch2"];

                    foreach( $objProgramado as $listaProgramado ){
                        $TIPAVI_serie = $listaProgramado["TIPAVI_serie"];
                        $RUT_num_vuelo_Prog = $listaProgramado["RUT_num_vuelo"];
                        $ITI_fch_Prog = $listaProgramado["ITI_fch"];

                        if( $ITI_fch == $ITI_fch_Prog ){
                            if( $RUT_num_vuelo == $RUT_num_vuelo_Prog ){
                                $programacion->updateProgramacion_xITI($ITI_id,$RUT_num_vuelo,$ITI_fch);
                            }
                        }
                    }
                }

                /* Enviar correo de Rutas que no se darán en el día debido al Itinerario registrado (cambiar lista de destinatarios [crear tabla con nuevos correos]) ---------------*/
                $objRutasNoProg = $programacion->listarRutasNoProg($ITI_fchini2,$ITI_fchfin2);
                if( count($objRutasNoProg) > 0 ){
                    /* inicio envio de correo */
                    $listaDestino = "";
                    $objCorreos = $detalle->listarCorreoItinerario();
                    foreach($objCorreos as $listaCorreos){
                        $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
                    }
                    $listaDestino = substr($listaDestino, 1);

                    $email = new Email();
                    $txt = "<p>Estimados:</p>";
                    $txt .= "<p>Respecto al Itinerario de Fecha ".$ITI_fchini." al ".$ITI_fchfin."</p>";
                    $txt .= "<p>Existen Rutas que estaban programadas, pero debido al registro del itinerario estas no serán realizadas, siendo las siguientes:</p>";

                    foreach( $objRutasNoProg as $listaRutasNoProg ){
                        $RUT_num_vuelo = $listaRutasNoProg["RUT_num_vuelo"];
                        $txt .= "<p><b>Ruta:</b> ".$listaRutasNoProg["RUT_num_vuelo"]."</p>";

                        $objTripxRutaxFch = $programacion->listarTripxRutaxFch($RUT_num_vuelo,$ITI_fchini2,$ITI_fchfin2);
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "Piloto" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Piloto: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "Copiloto" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Copiloto: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "JefeCabina" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Jefe de Cabina: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "TripCabina1" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Trip. Cabina 1: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "TripCabina2" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Trip. Cabina 2: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }

                        //Eliminar movimientos de tripulantes de la Ruta según fecha de itinerario enviado
                        $programacion->deleteMovTripxFch($RUT_num_vuelo,$ITI_fchini2,$ITI_fchfin2);
                    }

                    $txt .= "<p>Saludos cordiales.</p>";

                    $asunto = "CAMBIOS EN LA PROGRAMACIÓN POR ITINERARIO DEL ".mb_strtoupper($ITI_fchini3)." AL ".mb_strtoupper($ITI_fchfin3);

                    //$email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",$ITI_fchini2,$ITI_fchfin2,"programacionXitinerario");
                    /* fin envio de correo */
                }

                /* Enviar correo de Rutas adicionales que se darán en el día debido al Itinerario registrado (cambiar lista de destinatarios [crear tabla con nuevos correos]) -------*/
                $objRutasAdicionales = $programacion->listarRutasAdiconales($ITI_fchini2,$ITI_fchfin2);
                if( count($objRutasAdicionales) > 0 ){
                    /* inicio envio de correo */
                    $listaDestino = "";
                    $objCorreos = $detalle->listarCorreoItinerario();
                    foreach($objCorreos as $listaCorreos){
                        $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
                    }
                    $listaDestino = substr($listaDestino, 1);

                    $email = new Email();
                    $txt = "<p>Estimados:</p>";
                    $txt .= "<p>Respecto al Itinerario de Fecha ".$ITI_fchini." al ".$ITI_fchfin."</p>";
                    $txt .= "<p>Existen Rutas adicionales que no estaban programadas, debido al registro del itinerario, siendo las siguientes:</p>";

                    foreach( $objRutasAdicionales as $listaRutasAdicionales ){
                        $ITI_id = $listaRutasAdicionales["ITI_id"];
                        $RUT_num_vuelo = $listaRutasAdicionales["RUT_num_vuelo"];

                        $RUT_num_vuelo_1 = array();
                        $RUT_num_vuelo_2 = $listaRutasAdicionales["RUT_num_vuelo"]."/";
                        $parts = explode('/',$RUT_num_vuelo_2);
                        $RUT_num_vuelo_1 = array($parts[0]);

                        $txt .= "<p><b>Ruta:</b> ".$listaRutasAdicionales["RUT_num_vuelo"]."</p>";

                        /* Registrar Tripulantes a los nuevos vuelos */
                        $motor->recorrerMotorAutomatico($RUT_num_vuelo_1,'',$ITI_fchini2,$ITI_id);

                        $objTripxRutaxFch = $programacion->listarTripxRutaxFch($RUT_num_vuelo,$ITI_fchini2,$ITI_fchfin2);
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "Piloto" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Piloto: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "Copiloto" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Copiloto: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "JefeCabina" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Jefe de Cabina: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "TripCabina1" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Trip. Cabina 1: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                        foreach( $objTripxRutaxFch as $listaTripxRutaxFch ){
                            if( $listaTripxRutaxFch["ITI_TRIP_tipo"] == "TripCabina2" ){
                                $txt .= "<p>&nbsp;&nbsp;&nbsp; Trip. Cabina 2: ".$listaTripxRutaxFch["TRIP_nombre"]." ".$listaTripxRutaxFch["TRIP_apellido"]."</p>";
                            }
                        }
                    }

                    $txt .= "<p>Saludos cordiales.</p>";

                    $asunto = "CAMBIOS EN LA PROGRAMACIÓN POR ITINERARIO DEL ".mb_strtoupper($ITI_fchini3)." AL ".mb_strtoupper($ITI_fchfin3);

                    $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",$ITI_fchini2,$ITI_fchfin2,"programacionXitinerario");
                    /* fin envio de correo */
                }
                
                /* Adicionar tripulantes cuando se trate de un avión Tipo 400 -------*/
                $objRutasxTipoAvion = $programacion->listarRutaxTipAvion($ITI_fchini2,$ITI_fchfin2);
                foreach( $objRutasxTipoAvion as $listaRutasxTipoAvion ){
                    $TIPAVI_serie = $listaRutasxTipoAvion["TIPAVI_serie"];

                    $RUT_num_vuelo_1 = array();
                    $RUT_num_vuelo_2 = $listaRutasxTipoAvion["RUT_num_vuelo"]."/";
                    $parts = explode('/',$RUT_num_vuelo_2);
                    $RUT_num_vuelo_1 = array($parts[0]);

                    if( $TIPAVI_serie == "400" ){
                        $motor->insertarTripxRutaxFch($RUT_num_vuelo_1,$ITI_fchini2,$ITI_id);
                    }

                }
            
            }
            echo "exito";
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Itinerario ---------------------------------*/
    public function buscarItinerario(){
        try{
            $ITI_fchini = $_POST["bITI_fchini"];
            $ITI_fchfin = $_POST["bITI_fchfin"];
            
            $_SESSION["ITI_fchini"] = $ITI_fchini;
            $_SESSION["ITI_fchfin"] = $ITI_fchfin;
            
            $itinerario = new Itinerario_model();
            
            if($ITI_fchini == '' and $ITI_fchfin == ''){
                $this->model->Redirect(URLLOGICA."itinerario/listarResumenItinerario/");
            } else {
                $this->view->objResumenItinerario = $itinerario->buscarItinerario($ITI_fchini,$ITI_fchfin);
                
                $detalle = new Detalle_model();
                $this->view->objRuta = $detalle->listarRuta(date("Y-m-d"),'orden');
            
                $avion = new Avion_model();
                $this->view->objAvion = $avion->listarAvion();
                $this->view->render('itinerario');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Itinerario ---------------------------------*/
    public function updateAvionItinerario(){
        try{
            $itinerario = new Itinerario_model();
            $detalle = new Detalle_model();
            $programacion = new Programacion_model();
            
            $ITI_id = $_POST["ITI_id"];
            $AVI_id = $_POST["AVI_id"];
            $ITI_fch = $_POST["ITI_fch"];
            $AVI_num_cola = $_POST["AVI_num_cola"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            
            //$itinerario->updateItinerario('','','','ENVIADO','',$ITI_fchini,$ITI_fchfin);
            $itinerario->updateItinerario('',$AVI_id,'','',$ITI_id,'','');
            
            $listaDestino = "";
            $objCorreos = $detalle->listarCorreoInfoAvionItinerario();
            foreach($objCorreos as $listaCorreos){
                $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
            }
            $listaDestino = substr($listaDestino, 1);
            
            $objAvionItinerario = $programacion->listarProgramacionResumenMatriz($ITI_fch,'',$RUT_num_vuelo);
            
            
            $email = new Email();
            $txt = "<p>Señores:<p>";
            $txt .= "<p>El presente es para informarles que se ha modificado el Avión de la Ruta: ".$objAvionItinerario[0]["RUT_num_vuelo"]." del día: ".$ITI_fch."<p>";
            $txt .= "<p>El avión que estaba asignado era el: ".$AVI_num_cola."<p>";
            $txt .= "<p>El avión nuevo asignado es el : ".$objAvionItinerario[0]["AVI_num_cola"]."<p>";
                        
            $txt .= "<p>Se sugiere revisar la nueva la Ruta modificada así ver si existieron cambios.</p>";
            $txt .= "<p>Saludos cordiales.</p>";
            
            $asunto = "CAMBIO DE AVIÓN EN RUTA";
            $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",'','',"avionRuta");
            
            echo "exito";
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>