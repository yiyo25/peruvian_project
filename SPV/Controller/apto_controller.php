<?php
if( !isset($_SESSION)){
	session_start();
}
	
class apto extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar ResumenApto ---------------------------------*/
    public function listarResumenApto(){
        try{
            unset($_SESSION["TIPTRIP_id"]);
            unset($_SESSION["APT_fch_Mes"]);
            unset($_SESSION["APT_fch_Anio"]);
            unset($_SESSION["APT_indicador"]);
            unset($_SESSION["TRIP_apellido"]);
                        
            $apto = new Apto_model();
            $this->view->objResumenApto = $apto->listarResumenApto();
            $this->view->objResumenAptoMatriz = $apto->listarResumenAptoMatriz();
            
            $tripulante = new Tripulante_model();
            $this->view->objTripulante = $tripulante->listarTripulante('','','','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTrip();
            $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
            $this->view->objMes = $detalle->listarMes();
            $this->view->objAnio = $detalle->listarAnio();
            
            $this->view->render('apto');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Apto ---------------------------------*/
    public function insertApto(){
        try{
            $TRIP_id = $_POST["TRIP_id"];
            $APT_indicador = $_POST["APT_indicador"];
            $APT_estado = $_POST["APT_estado"];
                
            $parts = explode('/',$_POST["APT_fchvenci"]);
            $APT_fchvenci = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            if($_POST["APT_fchgestion"] == ""){
                $APT_fchgestion = "NULL";
            } else {
                $parts = explode('/',$_POST["APT_fchgestion"]);
                $APT_fchgestion = "'" . $parts[2] . '-' . $parts[1] . '-' . $parts[0] . "'";
            }
            
            $apto = new Apto_model();
            $APT_id = $apto->insertApto($TRIP_id,$APT_fchvenci,$APT_fchgestion,$APT_indicador,$APT_estado);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_APTOMED]','1');
            
            $this->view->objApto = $APT_id;
            $this->view->objApto = $this->array_utf8_encode($this->view->objApto);
            header('Content-Type: application/json');
            echo json_encode($this->view->objApto);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar AptoxMes (JSON) ---------------------------------*/
    public function listarApto(){
        try{
            $APT_fchvenci_Mes = $_POST["APT_fchvenci_Mes"];
            $APT_fchvenci_Anio = $_POST["APT_fchvenci_Anio"];
            $TIPTRIP_id = $_POST["TIPTRIP_id"];
            $apto = new Apto_model();
            $this->view->objApto = $apto->listarApto($APT_fchvenci_Mes,$APT_fchvenci_Anio,$TIPTRIP_id);
            $this->view->objApto = $this->array_utf8_encode($this->view->objApto);
            
            header('Content-Type: application/json');
            echo json_encode($this->view->objApto);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Detalle de Apto (JSON) ---------------------------------*/
    public function listarDetApto(){
        try{
            $APT_id = $_POST["APT_id"];
            $apto = new Apto_model();
            $this->view->objDetApto = $apto->listarDetApto($APT_id);
            $this->view->objDetApto = $this->array_utf8_encode($this->view->objDetApto);
            
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetApto);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Apto ---------------------------------*/
    public function updateApto(){
        try{
            $APT_id = $_POST["APT_id"];
            $TRIP_id = $_POST["TRIP_id"];
            $APT_indicador = $_POST["APT_indicador"];
            $APT_estado = $_POST["APT_estado"];
            $APT_observacion = $_POST["APT_observacion"];
                
            $parts = explode('/',$_POST["APT_fchvenci"]);
            $APT_fchvenci = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["APT_fchgestion"]);
            $APT_fchgestion = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            
            if($_POST["APT_fchentrega"] == ""){
                $APT_fchentrega = "NULL";
            } else {
                $parts = explode('/',$_POST["APT_fchentrega"]);
                $APT_fchentrega = "'" . $parts[2] . '-' . $parts[1] . '-' . $parts[0] . "'";
            }
            
            $apto = new Apto_model();
            $DetApto = $apto->listarDetApto($APT_id);
            
            $Log = new Log_model();
            
            if($DetApto[0]["TRIP_id"] != $TRIP_id){
                $Log->insertarLog("[SPV_APTOMED]","[TRIP_id]","UPDATE",$DetApto[0]["TRIP_id"],$TRIP_id,'',$APT_id);
            }
            if($DetApto[0]["APT_indicador"] != $APT_indicador){
                $Log->insertarLog("[SPV_APTOMED]","[APT_indicador]","UPDATE",$DetApto[0]["APT_indicador"],$APT_indicador,'',$APT_id);
            }
            if($DetApto[0]["APT_fchvenci"] != $APT_fchvenci){
                $Log->insertarLog("[SPV_APTOMED]","[APT_fchvenci]","UPDATE",$DetApto[0]["APT_fchvenci"],$APT_fchvenci,'',$APT_id);
            }
            if($DetApto[0]["APT_fchgestion"] != $APT_fchgestion){
                $Log->insertarLog("[SPV_APTOMED]","[APT_fchgestion]","UPDATE",$DetApto[0]["APT_fchgestion"],$APT_fchgestion,'',$APT_id);
            }
            if($DetApto[0]["APT_fchentrega"] != $APT_fchentrega){
                $Log->insertarLog("[SPV_APTOMED]","[APT_fchentrega]","UPDATE",$DetApto[0]["APT_fchentrega"],$APT_fchentrega,'',$APT_id);
            }
            if($DetApto[0]["APT_observacion"] != $APT_observacion){
                $Log->insertarLog("[SPV_APTOMED]","[APT_observacion]","UPDATE",$DetApto[0]["APT_observacion"],$APT_observacion,'',$APT_id);
            }
            if($DetApto[0]["APT_estado"] != $APT_estado){
                $Log->insertarLog("[SPV_APTOMED]","[APT_estado]","UPDATE",$DetApto[0]["APT_estado"],$APT_estado,'',$APT_id);
            }
            
            $apto->updateApto($TRIP_id,$APT_fchvenci,$APT_fchgestion,$APT_indicador,$APT_fchentrega,$APT_observacion,$APT_estado,$APT_id);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_APTOMED]','1');
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Apto ---------------------------------*/
    public function buscarApto(){
        try{
            $TIPTRIP_id = $_POST["bTIPTRIP_id"];
            $APT_fch_Mes = $_POST["bAPT_fch_Mes"];
            $APT_fch_Anio = $_POST["bAPT_fch_Anio"];
            $APT_indicador = $_POST["bAPT_indicador"];
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            
            $_SESSION["TIPTRIP_id"] = $TIPTRIP_id;
            $_SESSION["APT_fch_Mes"] = $APT_fch_Mes;
            $_SESSION["APT_fch_Anio"] = $APT_fch_Anio;
            $_SESSION["APT_indicador"] = $APT_indicador;
            $_SESSION["TRIP_apellido"] = $TRIP_apellido;
            
            if($TIPTRIP_id == '' and $APT_fch_Mes == '' and $APT_fch_Anio == '' and $APT_indicador == '' and $TRIP_apellido == ''){
                $this->model->Redirect(URLLOGICA."apto/listarResumenApto");
            } else {
                $apto = new Apto_model();
                $this->view->objResumenApto = $apto->buscarResumenApto($TIPTRIP_id,$APT_fch_Mes,$APT_fch_Anio,$APT_indicador,$TRIP_apellido);
                $this->view->objResumenAptoMatriz = $apto->buscarResumenAptoMatriz($TIPTRIP_id,$APT_fch_Mes,$APT_fch_Anio,$APT_indicador,$TRIP_apellido);
                
                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->listarTripulante('','','','');

                $detalle = new Detalle_model();
                $this->view->objTipoTripulante = $detalle->listarTipoTrip();
                $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
                $this->view->objMes = $detalle->listarMes();
                $this->view->objAnio = $detalle->listarAnio();
                
                $this->view->render('apto');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Enviar Correo de Apto Médicos ---------------------------------*/
    public function enviarCorreoApto(){
        try{
            $APT_fchvenci_Mes = $_POST["APT_fchvenci_Mes"];
            $APT_fchvenci_Anio = $_POST["APT_fchvenci_Anio"];
            $TIPTRIP_id = $_POST["TIPTRIP_id"];
            
            $apto = new Apto_model();
            $objApto = $apto->listarApto($APT_fchvenci_Mes,$APT_fchvenci_Anio,$TIPTRIP_id);
            $objApto = $this->array_utf8_encode($objApto);
            $TIPTRIP_descripcion = $objApto[0]["TIPTRIP_descripcion"];
            $APT_fchvenci_Mes = strftime('%B',strtotime($objApto[0]["APT_fchvenci2"]));
            $APT_fchvenci_Anio = strftime('%Y',strtotime($objApto[0]["APT_fchvenci2"]));
                        
            $detalle = new Detalle_model();
            $objCorreos = $detalle->listarCorreoCondicionales();
            foreach($objCorreos as $listaCorreos){
                $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
            }
            $listaDestino = substr($listaDestino, 1);
            
            $email = new Email();
            $txt = "<p>Señores:<p>";
            $txt .= "<p>El presente es para informarles la programación de los siguientes Aptos Médicos de los ". $TIPTRIP_descripcion ." del mes de ".$APT_fchvenci_Mes." del año ".$APT_fchvenci_Anio.":<p>";
            
            foreach( $objApto as $listaobjApto ){                
                $txt .= "<p>Tripulante          :   ". $listaobjApto["TRIP_nombre"] ." ". $listaobjApto["TRIP_apellido"] ."<p>";
                $txt .= "<p>Fch. Vencimiento    :   ". $listaobjApto["APT_fchvenci"] ."<p>";
                $txt .= "<p><br/><p>";
            }
            
            $txt .= "<p>Saludos cordiales.</p>";
                        
            $asunto = "PROGRAMACIÓN DE APTOS MÉDICOS DEL MES DE ".mb_strtoupper($APT_fchvenci_Mes) ." DEL ".mb_strtoupper($APT_fchvenci_Anio);
            $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",'','',"apto");
            
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>