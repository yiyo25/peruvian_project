<?php
if( !isset($_SESSION)){
	session_start();
}

class avion extends Controller {
	
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar AvionView  ---------------------------------*/
    public function listarAvion(){
        try{
            unset($_SESSION["TIPAVI_id"]);
            unset($_SESSION["AVI_num_cola"]);
            
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoAvion = $detalle->listarTipoAvion();
            
            $this->view->render('avion');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Detalle Avi贸n (xId) JSON  ---------------------------------*/
    public function listarDetAvion(){
        try{
            $AVI_id = $_POST["AVI_id"];
            $avion = new Avion_model();
            $this->view->objDetAvion = $avion->listarAvion($AVI_id,'');
            $this->view->objDetAvion = $this->array_utf8_encode($this->view->objDetAvion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetAvion);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar AvionMantoView  ---------------------------------*/
    public function listarResumenMantoAvion(){
        try{
            unset($_SESSION["TIPAVI_id"]);
            unset($_SESSION["AVI_id"]);
            unset($_SESSION["AVI_fch_Mes"]);
            unset($_SESSION["AVI_fch_Anio"]);
            
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','','');
            $this->view->objMantoAvion = $avion->listarResumenMantoAvion();
            
            $detalle = new Detalle_model();
            $this->view->objTipoAvion = $detalle->listarTipoAvion();
            $this->view->objMes = $detalle->listarMes();
            $this->view->objAnio = $detalle->listarAnio();
            
            $this->view->render('avionManto');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Detalle de Avion en Manto (xMes xAnio) JSON  ---------------------------------*/
    public function listarMantoAvion(){
        try{
            $MANTAVI_fchiniMes = $_POST["MANTAVI_fchiniMes"];
            $MANTAVI_fchiniAnio = $_POST["MANTAVI_fchiniAnio"];
            $MANTAVI_fchfinMes = $_POST["MANTAVI_fchfinMes"];
            $MANTAVI_fchfinAnio = $_POST["MANTAVI_fchfinAnio"];
            $MANTAVI_id = $_POST["MANTAVI_id"];
            
            if($_POST["ITI_fchini"] != ''){
                $parts = explode('/',$_POST["ITI_fchini"]);
                $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            
            if($_POST["ITI_fchfin"] != ''){
                $parts = explode('/',$_POST["ITI_fchfin"]);
                $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            
            $avion = new Avion_model();
            $this->view->objDetMantoAvion = $avion->listarMantoAvion($MANTAVI_fchiniMes,$MANTAVI_fchiniAnio,$MANTAVI_fchfinMes,$MANTAVI_fchfinAnio,$MANTAVI_id,$ITI_fchini,$ITI_fchfin,'');
            $this->view->objDetMantoAvion = $this->array_utf8_encode($this->view->objDetMantoAvion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetMantoAvion);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Aviones disponibles por fechas determinadas JSON  ---------------------------------*/
    public function listarAvionDisponiblesxFecha(){
        try{
            $variable = $_POST["variable"];
            if($_POST["ITI_fchini"] != ''){
                $parts = explode('/',$_POST["ITI_fchini"]);
                $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            
            if($_POST["ITI_fchfin"] != ''){
                $parts = explode('/',$_POST["ITI_fchfin"]);
                $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            
            $avion = new Avion_model();
            if( $variable == "xfecha" ){
                $this->view->objDetAvionxFecha = $avion->listarAvionDisponiblexFecha($ITI_fchini,$ITI_fchfin);  
            } else if ($variable == "todo") {
                $this->view->objDetAvionxFecha = $avion->listarAvion('','');    
            }
            
            $this->view->objDetAvionxFecha = $this->array_utf8_encode($this->view->objDetAvionxFecha);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetAvionxFecha);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Avion en Manto por fecha de Itinerario JSON  ---------------------------------*/
    public function listarAvionNoDisponiblexItinerario(){
        try{
            $parts = explode('/',$_POST["ITI_fch"]);
            $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $avion = new Avion_model();
            
            $objAvionItinerario = $avion->listarAvionNoDisponiblexItinerario($AVI_id,$ITI_fchini,$ITI_fchfin);
            $objAvionItinerario = $this->array_utf8_encode($objAvionItinerario);
            
            header('Content-Type: application/json');
            echo json_encode($objAvionItinerario);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Avi髇  ---------------------------------*/
    public function insertAvion(){
        try{
            $TIPAVI_id = $_POST["TIPAVI_id"];
            $AVI_num_cola = trim(mb_strtoupper($_POST["AVI_num_cola"],'UTF-8'));
            $AVI_cant_pasajeros = $_POST["AVI_cant_pasajeros"];
            $AVI_cap_carga_max = $_POST["AVI_cap_carga_max"];
            $AVI_estado = $_POST["AVI_estado"];
            
            if($AVI_cap_carga_max == ""){
                $AVI_cap_carga_max = 0;
            }
            
            $avion = new Avion_model();
            $AVI_id = $avion->insertAvion($TIPAVI_id,$AVI_num_cola,$AVI_cant_pasajeros,$AVI_cap_carga_max,$AVI_estado);
            
            $this->view->objAvion = $AVI_id;
            $this->view->objAvion = $this->array_utf8_encode($this->view->objAvion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objAvion);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Avi贸n en Manto  ---------------------------------*/
    public function insertMantoAvion(){
        try{
            $AVI_id = $_POST["AVI_id"];
            $MANTAVI_tipoChequeo = $_POST["MANTAVI_tipoChequeo"];
            $MANTAVI_ordenTrabajo = $_POST["MANTAVI_ordenTrabajo"];
            $MANTAVI_observacion = $_POST["MANTAVI_observacion"];
            
            $parts = explode('/',$_POST["MANTAVI_fchini"]);
            $MANTAVI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["MANTAVI_fchfin"]);
            $MANTAVI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $avion = new Avion_model();
            $MANTAVI_id = $avion->insertMantoAvion($AVI_id,$MANTAVI_fchini,$MANTAVI_fchfin,$MANTAVI_tipoChequeo,$MANTAVI_ordenTrabajo,$MANTAVI_observacion);
            
            $objAvionItinerario = $avion->listarAvionNoDisponiblexItinerario($AVI_id,'','');
            
            if( count($objAvionItinerario) > 0 ){
                //Enviar correo a interesados que han puesto un Avion en Manto cuando ya estaba programado en un Itinerario.
                $this->enviarCorreoAvionItinerario($objAvionItinerario);
            }
            
            $this->view->objMantoAvion = $MANTAVI_id;
            $this->view->objMantoAvion = $this->array_utf8_encode($this->view->objMantoAvion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objMantoAvion);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Avi贸n  ---------------------------------*/
    public function updateAvion(){
        try{
            $AVI_id = $_POST["AVI_id"];
            $TIPAVI_id = $_POST["TIPAVI_id"];
            $AVI_num_cola = trim(mb_strtoupper($_POST["AVI_num_cola"],'UTF-8'));
            $AVI_cant_pasajeros = $_POST["AVI_cant_pasajeros"];
            $AVI_estado = $_POST["AVI_estado"];
            $AVI_cap_carga_max = $_POST["AVI_cap_carga_max"];
            
            if($AVI_cap_carga_max == ""){
                $AVI_cap_carga_max = 0;
            }
            
            $avion = new Avion_model();
            $DetAvion = $avion->listarAvion($AVI_id,'');
            
            $Log = new Log_model();
            if($DetAvion[0]["TIPAVI_id"] != $TIPAVI_id){
                $Log->insertarLog("[SPV_AVION]","[TIPAVI_id]","UPDATE",utf8_encode($DetAvion[0]["AVI_id"]),$TIPAVI_id,'',$AVI_id);
            }
            if($DetAvion[0]["AVI_num_cola"] != $AVI_num_cola){
                $Log->insertarLog("[SPV_AVION]","[AVI_num_cola]","UPDATE",utf8_encode($DetAvion[0]["AVI_num_cola"]),$AVI_num_cola,'',$AVI_id);
            }
            if($DetAvion[0]["AVI_cant_pasajeros"] != $AVI_cant_pasajeros){
                $Log->insertarLog("[SPV_AVION]","[AVI_cant_pasajeros]","UPDATE",utf8_encode($DetAvion[0]["AVI_cant_pasajeros"]),$AVI_cant_pasajeros,'',$AVI_id);
            }
            if($DetAvion[0]["AVI_cap_carga_max"] != $AVI_cap_carga_max){
                $Log->insertarLog("[SPV_AVION]","[AVI_cap_carga_max]","UPDATE",utf8_encode($DetAvion[0]["AVI_cap_carga_max"]),$AVI_cap_carga_max,'',$AVI_id);
            }
            if($DetAvion[0]["AVI_estado"] != $AVI_estado){
                $Log->insertarLog("[SPV_AVION]","[AVI_estado]","UPDATE",utf8_encode($DetAvion[0]["AVI_estado"]),$AVI_estado,'',$AVI_id);
            }
            
            $avion->updateAvion($AVI_id,$TIPAVI_id,$AVI_num_cola,$AVI_cant_pasajeros,$AVI_cap_carga_max,$AVI_estado);
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Avi贸n en Manto  ---------------------------------*/
    public function updateMantoAvion(){
        try{
            $MANTAVI_id = $_POST["MANTAVI_id"];
            $AVI_id = $_POST["AVI_id"];
            $MANTAVI_tipoChequeo = $_POST["MANTAVI_tipoChequeo"];
            $MANTAVI_ordenTrabajo = $_POST["MANTAVI_ordenTrabajo"];
            $MANTAVI_observacion = $_POST["MANTAVI_observacion"];
            
            $parts = explode('/',$_POST["MANTAVI_fchini"]);
            $MANTAVI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["MANTAVI_fchfin"]);
            $MANTAVI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $avion = new Avion_model();
            $DetMantoAvion = $avion->listarMantoAvion('','','','',$MANTAVI_id,'','','');
            
            $Log = new Log_model();
            if($DetMantoAvion[0]["AVI_id"] != $AVI_id){
                $Log->insertarLog("[SPV_MANTAVION]","[AVI_id]","UPDATE",$DetMantoAvion[0]["AVI_id"],$AVI_id,'',$MANTAVI_id);
            }
            if($DetMantoAvion[0]["MANTAVI_fchini"] != $MANTAVI_fchini){
                $Log->insertarLog("[SPV_MANTAVION]","[MANTAVI_fchini]","UPDATE",$DetMantoAvion[0]["MANTAVI_fchini"],$MANTAVI_fchini,'',$MANTAVI_id);
            }
            if($DetMantoAvion[0]["MANTAVI_fchfin"] != $MANTAVI_fchfin){
                $Log->insertarLog("[SPV_MANTAVION]","[MANTAVI_fchini]","UPDATE",$DetMantoAvion[0]["MANTAVI_fchfin"],$MANTAVI_fchfin,'',$MANTAVI_id);
            }
            if($DetMantoAvion[0]["MANTAVI_tipoChequeo"] != $MANTAVI_tipoChequeo){
                $Log->insertarLog("[SPV_MANTAVION]","[MANTAVI_tipoChequeo]","UPDATE",$DetMantoAvion[0]["MANTAVI_tipoChequeo"],$MANTAVI_tipoChequeo,'',$MANTAVI_id);
            }
            if($DetMantoAvion[0]["MANTAVI_ordenTrabajo"] != $MANTAVI_ordenTrabajo){
                $Log->insertarLog("[SPV_MANTAVION]","[MANTAVI_ordenTrabajo]","UPDATE",$DetMantoAvion[0]["MANTAVI_ordenTrabajo"],$MANTAVI_ordenTrabajo,'',$MANTAVI_id);
            }
            if($DetMantoAvion[0]["MANTAVI_observacion"] != $MANTAVI_observacion){
                $Log->insertarLog("[SPV_MANTAVION]","[MANTAVI_observacion]","UPDATE",$DetMantoAvion[0]["MANTAVI_observacion"],$MANTAVI_observacion,'',$MANTAVI_id);
            }
            $avion->updateMantoAvion($AVI_id,$MANTAVI_fchini,$MANTAVI_fchfin,$MANTAVI_tipoChequeo,$MANTAVI_ordenTrabajo,$MANTAVI_observacion,$MANTAVI_id);
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar AvionView  ---------------------------------*/
    public function buscarAvion(){
        try{
            $detalle = new Detalle_model();
            $avion = new Avion_model();
            
            $this->view->objTipoAvion = $detalle->listarTipoAvion();
            
            $TIPAVI_id = $_POST["bTIPAVI_id"];
            $AVI_num_cola = trim(mb_strtoupper($_POST["bAVI_num_cola"],'UTF-8'));
            
            $_SESSION["TIPAVI_id"] = $TIPAVI_id;
            $_SESSION["AVI_num_cola"] = $AVI_num_cola;
            
            if($TIPAVI_id == '' and $AVI_num_cola == ''){
                $this->model->Redirect(URLLOGICA."avion/listarAvion");
            } else {
                $this->view->objAvion = $avion->buscarAvion($TIPAVI_id,$AVI_num_cola);
                $this->view->render('avion');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar AvionMantoView  ---------------------------------*/
    public function buscarMantoAvion(){
        try{
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoAvion = $detalle->listarTipoAvion();
            $this->view->objMes = $detalle->listarMes();
            $this->view->objAnio = $detalle->listarAnio();
                        
            $TIPAVI_id = $_POST["bTIPAVI_id"];
            $AVI_id = $_POST["bAVI_id"];
            $AVI_fch_Mes = $_POST["bAVI_fch_Mes"];
            $AVI_fch_Anio = $_POST["bAVI_fch_Anio"];
            
            $_SESSION["TIPAVI_id"] = $TIPAVI_id;
            $_SESSION["AVI_id"] = $AVI_id;
            $_SESSION["AVI_fch_Mes"] = $AVI_fch_Mes;
            $_SESSION["AVI_fch_Anio"] = $AVI_fch_Anio;
            
            if($TIPAVI_id == '' and $AVI_id == '' and $AVI_fch_Mes == '' and $AVI_fch_Anio == ''){
                $this->model->Redirect(URLLOGICA."avion/listarResumenMantoAvion");
            } else {
                $this->view->objMantoAvion = $avion->buscarMantoAvion($TIPAVI_id,$AVI_id,$AVI_fch_Mes,$AVI_fch_Anio);
                $this->view->render('avionManto');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Enviar Correo de Aviones en MAntenimiento  ---------------------------------*/
    public function enviarCorreoMantoAvion(){
        try{
            $MANTAVI_fchiniMes = $_POST["MANTAVI_fchiniMes"];
            $MANTAVI_fchiniAnio = $_POST["MANTAVI_fchiniAnio"];
            $MANTAVI_fchfinMes = $_POST["MANTAVI_fchfinMes"];
            $MANTAVI_fchfinAnio = $_POST["MANTAVI_fchfinAnio"];
            $MANTAVI_id = $_POST["MANTAVI_id"];
            
            if($_POST["ITI_fchini"] != ''){
                $parts = explode('/',$_POST["ITI_fchini"]);
                $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            
            if($_POST["ITI_fchfin"] != ''){
                $parts = explode('/',$_POST["ITI_fchfin"]);
                $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            
            $avion = new Avion_model();
            $objDetMantoAvion = $avion->listarMantoAvion($MANTAVI_fchiniMes,$MANTAVI_fchiniAnio,$MANTAVI_fchfinMes,$MANTAVI_fchfinAnio,$MANTAVI_id,$ITI_fchini,$ITI_fchfin,'fchActual');
            $objDetMantoAvion = $this->array_utf8_encode($objDetMantoAvion);
            
            $detalle = new Detalle_model();
            $objCorreos = $detalle->listarCorreoMantenimiento();
            foreach($objCorreos as $listaCorreos){
                $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
            }
            $listaDestino = substr($listaDestino, 1);
            
            //echo "<pre>".print_r($objDetMantoAvion,true)."</pre>";die();
            
            $email = new Email();
            $txt = "<p>Se帽ores:<p>";
            $txt .= "<p>El presente es para informarles la programaci贸n de los siguientes chequeos:<p>";
            //echo "<pre>".print_r($objDetMantoAvion,true)."<pre>";die();
            
            $i = 0;
            foreach( $objDetMantoAvion as $listaDetMantoAvion ){
                
                $FchBodyIni = strftime('%A %d de %B del %Y',strtotime($listaDetMantoAvion["MANTAVI_fchAnioi"]."-".$listaDetMantoAvion["MANTAVI_fchMesNi"]."-".$listaDetMantoAvion["MANTAVI_fchDiaNi"]));
                
                $FchBodyFin = strftime('%A %d de %B del %Y',strtotime($listaDetMantoAvion["MANTAVI_fchAniof"]."-".$listaDetMantoAvion["MANTAVI_fchMesNf"]."-".$listaDetMantoAvion["MANTAVI_fchDiaNf"]));
                
                if($FchBodyIni == $FchBodyFin){
                    $txt .= "<p>".utf8_encode(mb_strtoupper($FchBodyIni))." - ".utf8_encode(mb_strtoupper($listaDetMantoAvion["MANTAVI_tipoChequeo"]))." DE LA AERONAVE ".utf8_encode(mb_strtoupper($listaDetMantoAvion["AVI_num_cola"])).":<p>";
                } else {
                    $txt .= "<p>".utf8_encode(mb_strtoupper($FchBodyIni))." AL ".utf8_encode(mb_strtoupper($FchBodyFin))." - ".utf8_encode(mb_strtoupper($listaDetMantoAvion["MANTAVI_tipoChequeo"]))." DE LA AERONAVE ".utf8_encode(mb_strtoupper($listaDetMantoAvion["AVI_num_cola"])).":<p>";
                }
                
                $txt .= "<p>Se cumplir谩n las siguientes ordenes de trabajo:<p>";
                
                $texto = preg_split("/[\s,]+/", $listaDetMantoAvion["MANTAVI_ordenTrabajo"]);
                foreach ($texto as $valor){
                    $txt .= "<p>".$valor."<p>";
                }
                if($listaDetMantoAvion["MANTAVI_observacion"] != ""){
                    $txt .= "<p>Obervaci贸n: ".$listaDetMantoAvion["MANTAVI_observacion"]."<p>";
                }
                $txt .= "<p>----------------------------------------------------------------------------------------------<p>";
                $i++;
            }
            
            $txt .= "<p>Saludos cordiales.</p>";
            
            $fchAsuntoIni = strftime("%B DEL %Y",strtotime($objDetMantoAvion[0]["MANTAVI_fchAnioi"]."-".$objDetMantoAvion[0]["MANTAVI_fchMesi"]));
            $fchAsuntoFin = strftime("%B DEL %Y",strtotime($objDetMantoAvion[0]["MANTAVI_fchAniof"]."-".$objDetMantoAvion[0]["MANTAVI_fchMesf"]));
            
            $asunto = "PROGRAMACI脫N DE CHEQUEOS DEL MES DE ".mb_strtoupper($fchAsuntoIni) ." A ".mb_strtoupper($fchAsuntoFin);
            $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",'','',"avion");
            
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Enviar Correo de Aviones en Itinerario  ---------------------------------*/
    public function enviarCorreoAvionItinerario($objAvionItinerario){
        try{           
            $detalle = new Detalle_model();
            $objCorreos = $detalle->listarCorreoInfoAvionItinerario();
            foreach($objCorreos as $listaCorreos){
                $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
            }
            $listaDestino = substr($listaDestino, 1);
            
            $email = new Email();
            $txt = "<p>Se帽ores:<p>";
            $txt .= "<p>El presente es para informarles que se ha puesto Aviones en Mantenimiento y estos cuentan con los siguientes Itinerarios:<p>";
            
            $i = 0;
            foreach( $objAvionItinerario as $listaAvionItinerario ){
                $txt .= "<p>Avi贸n en Mantenimiento: ".$listaAvionItinerario["AVI_num_cola"]."<p>";
                $txt .= "<p>Fecha de Mantenimiento: ".$listaAvionItinerario["MANTAVI_fchini"]." al ".$listaAvionItinerario["MANTAVI_fchfin"]."<p>";
                $txt .= "<p>Fecha de Itinerario: ".$listaAvionItinerario["ITI_fch"]."<p>";
                $txt .= "<p>N鷐ero de Ruta: ".$listaAvionItinerario["RUT_num_vuelo"]."<p>";
                $txt .= "<p>------------------------------------------------------------<p>";
            }
            
            $txt .= "<p>Deber谩 realizar los cambios correspondientes en la Programaci贸n ya establecida.</p>";
            $txt .= "<p>Saludos cordiales.</p>";
            
            $asunto = "AVIONES EN MANTENIMIENTO CON ITINERARIO";
            $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",'','',"avionItinerario");
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>