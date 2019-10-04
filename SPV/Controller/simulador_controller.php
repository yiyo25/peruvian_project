<?php
if( !isset($_SESSION)){
	session_start();
}
	
class simulador extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar ResumenApto ---------------------------------*/
    public function listarResumenSimulador(){
        try{
            unset($_SESSION["TIPTRIP_id"]);
            unset($_SESSION["SIMU_fch_Mes"]);
            unset($_SESSION["SIMU_fch_Anio"]);
            unset($_SESSION["SIMU_indicador"]);
            unset($_SESSION["TRIP_apellido"]);
                        
            $simulador = new Simulador_model();
            $this->view->objResumenSimulador = $simulador->listarResumenSimulador();
            $this->view->objResumenSimuladorMatriz = $simulador->listarResumenSimuladorMatriz();
            
            $tripulante = new Tripulante_model();
            $this->view->objTripulante = $tripulante->listarTripulante('','','','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTrip();
            $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
            $this->view->objMes = $detalle->listarMes();
            $this->view->objAnio = $detalle->listarAnio();
            
            $this->view->render('simulador');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Simulador ---------------------------------*/
    public function listarSimulador(){
        try{
            $SIMU_fch_Mes = $_POST["SIMU_fch_Mes"];
            $SIMU_fch_Anio = $_POST["SIMU_fch_Anio"];
            $TIPTRIP_id = $_POST["TIPTRIP_id"];
            
            $simulador = new Simulador_model();
            $this->view->objSimulador = $simulador->listarSimulador($SIMU_fch_Mes,$SIMU_fch_Anio,$TIPTRIP_id);
            $this->view->objSimulador = $this->array_utf8_encode($this->view->objSimulador);
            
            header('Content-Type: application/json');
            echo json_encode($this->view->objSimulador);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Simulador ---------------------------------*/
    public function insertSimulador(){
        try{
            $TRIP_id = $_POST["TRIP_id"];
            $TRIP_id2 = $_POST["TRIP_id2"];
            
            if($TRIP_id2 = ''){
                $TRIP_id2 = '0';
            }
            
            $SIMU_indicador = $_POST["SIMU_indicador"];
            $SIMU_estado = $_POST["SIMU_estado"];
                
            $parts = explode('/',$_POST["SIMU_fchini"]);
            $SIMU_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["SIMU_fchfin"]);
            $SIMU_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $simulador = new Simulador_model();
            $SIMU_id = $simulador->insertSimulador($TRIP_id,$TRIP_id2,$SIMU_fchini,$SIMU_fchfin,$SIMU_indicador,$SIMU_estado);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_SIMULADOR]','1');
            
            $this->view->objSimulador = $SIMU_id;
            $this->view->objSimulador = $this->array_utf8_encode($this->view->objSimulador);
            header('Content-Type: application/json');
            echo json_encode($this->view->objSimulador);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Detalle Simulador (JSON) ---------------------------------*/
    public function listarDetSimulador(){
        try{
            $simulador = new Simulador_model();
            $SIMU_id = $_POST["SIMU_id"];
            
            $this->view->objDetSimulador = $simulador->listarDetSimulador($SIMU_id);
            $this->view->objDetSimulador = $this->array_utf8_encode($this->view->objDetSimulador);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetSimulador);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Simulador ---------------------------------*/
    public function updateSimulador(){
        try{
            $SIMU_id = $_POST["SIMU_id"];
            $TRIP_id = $_POST["TRIP_id"];
            $TRIP_id2 = $_POST["TRIP_id2"];
            if($TRIP_id2 = ''){
                $TRIP_id2 = '0';
            }
            $SIMU_indicador = $_POST["SIMU_indicador"];
            $SIMU_observacion = $_POST["SIMU_observacion"];
            $SIMU_estado = $_POST["SIMU_estado"];
            
            if($_POST["SIMU_fchentrega"] == ""){
                $SIMU_fchentrega = "NULL";
            } else {
                $parts = explode('/',$_POST["SIMU_fchentrega"]);
                $SIMU_fchentrega = "'" . $parts[2] . '-' . $parts[1] . '-' . $parts[0] . "'";
            }
                
            $parts = explode('/',$_POST["SIMU_fchini"]);
            $SIMU_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["SIMU_fchfin"]);
            $SIMU_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $simulador = new Simulador_model();
            $DetSimulador = $simulador->listarSimulador($SIMU_id);
            
            $Log = new Log_model();
            
            if($DetSimulador[0]["TRIP_id"] != $TRIP_id){
                $Log->insertarLog("[SPV_SIMULADOR]","[TRIP_id]","UPDATE",$DetSimulador[0]["TRIP_id"],$TRIP_id,'',$SIMU_id);
            }
            if($DetSimulador[0]["TRIP_id2"] != $TRIP_id2){
                $Log->insertarLog("[SPV_SIMULADOR]","[TRIP_id2]","UPDATE",$DetSimulador[0]["TRIP_id2"],$TRIP_id2,'',$SIMU_id);
            }
            if($DetSimulador[0]["SIMU_indicador"] != $SIMU_indicador){
                $Log->insertarLog("[SPV_SIMULADOR]","[SIMU_indicador]","UPDATE",$DetSimulador[0]["SIMU_indicador"],$SIMU_indicador,'',$SIMU_id);
            }
            if($DetSimulador[0]["SIMU_fchini"] != $SIMU_fchini){
                $Log->insertarLog("[SPV_SIMULADOR]","[SIMU_fchini]","UPDATE",$DetSimulador[0]["SIMU_fchini"],$SIMU_fchini,'',$SIMU_id);
            }
            if($DetSimulador[0]["SIMU_fchfin"] != $SIMU_fchfin){
                $Log->insertarLog("[SPV_SIMULADOR]","[SIMU_fchfin]","UPDATE",$DetSimulador[0]["SIMU_fchfin"],$SIMU_fchfin,'',$SIMU_id);
            }
            if($DetChequeo[0]["SIMU_observacion"] != $SIMU_observacion){
                $Log->insertarLog("[SPV_CHEQUEO]","[SIMU_observacion]","UPDATE",$DetChequeo[0]["SIMU_observacion"],$SIMU_observacion,'',$SIMU_id);
            }
            if($DetChequeo[0]["SIMU_fchentrega"] != $SIMU_observacion){
                $Log->insertarLog("[SPV_CHEQUEO]","[SIMU_fchentrega]","UPDATE",$DetChequeo[0]["SIMU_fchentrega"],$SIMU_fchentrega,'',$SIMU_id);
            }
            if($DetChequeo[0]["SIMU_estado"] != $SIMU_estado){
                $Log->insertarLog("[SPV_CHEQUEO]","[SIMU_estado]","UPDATE",$DetChequeo[0]["SIMU_estado"],$SIMU_estado,'',$SIMU_id);
            }
            
            $simulador->updateSimulador($TRIP_id,$TRIP_id2,$SIMU_fchini,$SIMU_fchfin,$SIMU_indicador,$SIMU_fchentrega,$SIMU_observacion,$SIMU_estado,$SIMU_id);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_SIMULADOR]','1');
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Simulador ---------------------------------*/
    public function buscarSimulador(){
        try{
            $TIPTRIP_id = $_POST["bTIPTRIP_id"];
            $SIMU_fch_Mes = $_POST["bSIMU_fch_Mes"];
            $SIMU_fch_Anio = $_POST["bSIMU_fch_Anio"];
            $SIMU_indicador = $_POST["bSIMU_indicador"];
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            
            $_SESSION["TIPTRIP_id"] = $TIPTRIP_id;
            $_SESSION["SIMU_fch_Mes"] = $SIMU_fch_Mes;
            $_SESSION["SIMU_fch_Anio"] = $SIMU_fch_Anio;
            $_SESSION["SIMU_indicador"] = $SIMU_indicador;
            $_SESSION["TRIP_apellido"] = $TRIP_apellido;
            
            $simulador = new Simulador_model();
            if($TIPTRIP_id == '' and $SIMU_fch_Mes == '' and $SIMU_fch_Anio == '' and $SIMU_indicador == '' and $TRIP_apellido == ''){
                $this->model->Redirect(URLLOGICA."apto/listarResumenApto");
            } else {
                $this->view->objResumenSimulador = $simulador->buscarResumenSimulador($TIPTRIP_id,$SIMU_fch_Mes,$SIMU_fch_Anio,$SIMU_indicador,$TRIP_apellido);
                $this->view->objResumenSimuladorMatriz = $simulador->buscarResumenSimuladorMatriz($TIPTRIP_id,$SIMU_fch_Mes,$SIMU_fch_Anio,$SIMU_indicador,$TRIP_apellido);

                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->listarTripulante('','','','');

                $detalle = new Detalle_model();
                $this->view->objTipoTripulante = $detalle->listarTipoTrip();
                $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
                $this->view->objMes = $detalle->listarMes();
                $this->view->objAnio = $detalle->listarAnio();
                
                $this->view->render('simulador');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Enviar Correo de Simuladores ---------------------------------*/
    public function enviarCorreoSimulador(){
        try{
            //$SIMU_fchvenci_Mes = $_POST["SIMU_fchvenci_Mes"];
            $SIMU_fchvenci_Anio = $_POST["SIMU_fchvenci_Anio"];
            //$TIPTRIP_id = $_POST["TIPTRIP_id"];
            
            $simulador = new Simulador_model();
            $objSimulador = $simulador->listarSimulador('',$SIMU_fchvenci_Anio,'');
            $objSimulador = $this->array_utf8_encode($objSimulador);
            $TIPTRIP_descripcion = $objSimulador[0]["TIPTRIP_descripcion"];
            //$SIMU_fchini_Mes = strftime('%B',strtotime($objSimulador[0]["SIMU_fchini2"]));
            $SIMU_fchini_Anio = strftime('%Y',strtotime($objSimulador[0]["SIMU_fchini2"]));
                        
            $detalle = new Detalle_model();
            $objCorreos = $detalle->listarCorreoCondicionales();
            foreach($objCorreos as $listaCorreos){
                $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
            }
            $listaDestino = substr($listaDestino, 1);
            
            $email = new Email();
            $txt = "<p>Señores:<p>";
            //$txt .= "<p>El presente es para informarles la programación de los siguientes Simuladores de los ". $TIPTRIP_descripcion ." del mes de ".$SIMU_fchini_Mes." del año ".$SIMU_fchini_Anio.":<p>";
            $txt .= "<p>El presente es para informarles la programación de los siguientes Simuladores de los ". $TIPTRIP_descripcion ." del año ".$SIMU_fchini_Anio.":<p>";
            
            foreach( $objSimulador as $listaobjSimulador ){                
                $txt .= "<p>Capitan: ". $listaobjSimulador["TRIP_nombre"] ." ". $listaobjSimulador["TRIP_apellido"] ."<p>";
                
                if( $listaobjSimulador["TRIP_id2"] != "0" ){
                    $txt .= "<p>Primer Oficial: ". $listaobjSimulador["TRIP_nombre2"] ." ". $listaobjSimulador["TRIP_apellido2"] ."<p>";
                }
                
                $txt .= "<p>Fch. Inicio: ". $listaobjSimulador["SIMU_fchini"] ."<p>";
                $txt .= "<p>Fch. Fin : ". $listaobjSimulador["SIMU_fchfin"] ."<p>";
                $txt .= "<p><br/><p>";
            }
            
            $txt .= "<p>Saludos cordiales.</p>";
                        
            $asunto = "PROGRAMACIÓN DE SIMULADORES DEL AÑO ".mb_strtoupper($SIMU_fchini_Anio);
            $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",'','',"simulador");
            
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>