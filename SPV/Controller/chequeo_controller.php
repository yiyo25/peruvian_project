<?php
if( !isset($_SESSION)){
	session_start();
}
	
class chequeo extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar ResumenChequeo ---------------------------------*/
    public function listarResumenChequeo(){
        try{
            unset($_SESSION["TIPCHEQ_id"]);
            unset($_SESSION["TIPTRIP_id"]);
            unset($_SESSION["CHEQ_fch_Mes"]);
            unset($_SESSION["CHEQ_fch_Anio"]);
            unset($_SESSION["TRIP_apellido"]);
            
            $chequeo = new Chequeo_model();
            $this->view->objResumenChequeo = $chequeo->listarResumenChequeo();
            $this->view->objResumenChequeoMatriz = $chequeo->listarResumenChequeoMatriz();
            
            $tripulante = new Tripulante_model();
            $this->view->objTripulante = $tripulante->listarTripulante('','','','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTrip();
            $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
            $this->view->objTipoChequeo = $detalle->listarTipoChequeo();
            $this->view->objMes = $detalle->listarMes();
            $this->view->objAnio = $detalle->listarAnio();
            
            $this->view->render('chequeo');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Chequeo ---------------------------------*/
    public function insertChequeo(){
        try{
            $TIPCHEQ_id = $_POST["TIPCHEQ_id"];
            $TRIP_id = $_POST["TRIP_id"];
            $CHEQ_indicador = $_POST["CHEQ_indicador"];
            $CHEQ_estado = $_POST["CHEQ_estado"];
                
            $parts = explode('/',$_POST["CHEQ_fch"]);
            $CHEQ_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $chequeo = new Chequeo_model();
            $CHEQ_id = $chequeo->insertChequeo($TIPCHEQ_id,$TRIP_id,$CHEQ_fch,$CHEQ_indicador,$CHEQ_estado);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_CHEQUEO]','1');
            
            $this->view->objChequeo = $CHEQ_id;
            $this->view->objChequeo = $this->array_utf8_encode($this->view->objChequeo);
            header('Content-Type: application/json');
            echo json_encode($this->view->objChequeo);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Chequeo xMes xAnio (JSON) ---------------------------------*/
    public function listarChequeo(){
        try{
            $CHEQ_fch_Mes = $_POST["CHEQ_fch_Mes"];
            $CHEQ_fch_Anio = $_POST["CHEQ_fch_Anio"];
            $TIPTRIP_id = $_POST["TIPTRIP_id"];
            $chequeo = new Chequeo_model();
            $this->view->objChequeo = $chequeo->listarChequeo($CHEQ_fch_Mes,$CHEQ_fch_Anio,$TIPTRIP_id);
            $this->view->objChequeo = $this->array_utf8_encode($this->view->objChequeo);
            
            header('Content-Type: application/json');
            echo json_encode($this->view->objChequeo);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Detalle Chequeo (JSON) ---------------------------------*/
    public function listarDetChequeo(){
        try{
            $CHEQ_id = $_POST["CHEQ_id"];
            $chequeo = new Chequeo_model();
            $this->view->objDetChequeo = $chequeo->listarDetChequeo($CHEQ_id);
            $this->view->objDetChequeo = $this->array_utf8_encode($this->view->objDetChequeo);
            
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetChequeo);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Chequeo ---------------------------------*/
    public function updateChequeo(){
        try{
            $CHEQ_id = $_POST["CHEQ_id"];
            $TIPCHEQ_id = $_POST["TIPCHEQ_id"];
            $TRIP_id = $_POST["TRIP_id"];
            $CHEQ_indicador = $_POST["CHEQ_indicador"];
            $CHEQ_observacion = $_POST["CHEQ_observacion"];
            $CHEQ_estado = $_POST["CHEQ_estado"];
                
            $parts = explode('/',$_POST["CHEQ_fch"]);
            $CHEQ_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            if($_POST["CHEQ_fchentrega"] == ""){
                $CHEQ_fchentrega = "NULL";
            } else {
                $parts = explode('/',$_POST["CHEQ_fchentrega"]);
                $CHEQ_fchentrega = "'" . $parts[2] . '-' . $parts[1] . '-' . $parts[0] . "'";
            }
            
            $chequeo = new Chequeo_model();
            $DetChequeo = $chequeo->listarDetChequeo($CHEQ_id);
            
            $Log = new Log_model();
            
            if($DetChequeo[0]["TIPCHEQ_id"] != $TIPCHEQ_id){
                $Log->insertarLog("[SPV_CHEQUEO]","[TIPCHEQ_id]","UPDATE",$DetChequeo[0]["TIPCHEQ_id"],$TIPCHEQ_id,'',$CHEQ_id);
            }
            if($DetChequeo[0]["TRIP_id"] != $TRIP_id){
                $Log->insertarLog("[SPV_CHEQUEO]","[TRIP_id]","UPDATE",$DetChequeo[0]["TRIP_id"],$TRIP_id,'',$CHEQ_id);
            }
            if($DetChequeo[0]["CHEQ_indicador"] != $CHEQ_indicador){
                $Log->insertarLog("[SPV_CHEQUEO]","[CHEQ_indicador]","UPDATE",$DetChequeo[0]["CHEQ_indicador"],$CHEQ_indicador,'',$CHEQ_id);
            }
            if($DetChequeo[0]["CHEQ_fch"] != $CHEQ_fch){
                $Log->insertarLog("[SPV_CHEQUEO]","[CHEQ_fch]","UPDATE",$DetChequeo[0]["CHEQ_fch"],$CHEQ_fch,'',$CHEQ_id);
            }
            if($DetChequeo[0]["CHEQ_observacion"] != $CHEQ_observacion){
                $Log->insertarLog("[SPV_CHEQUEO]","[CHEQ_observacion]","UPDATE",$DetChequeo[0]["CHEQ_observacion"],$CHEQ_observacion,'',$CHEQ_id);
            }
            if($DetChequeo[0]["CHEQ_fchentrega"] != $CHEQ_observacion){
                $Log->insertarLog("[SPV_CHEQUEO]","[CHEQ_fchentrega]","UPDATE",$DetChequeo[0]["CHEQ_fchentrega"],$CHEQ_fchentrega,'',$CHEQ_id);
            }
            if($DetChequeo[0]["CHEQ_estado"] != $CHEQ_estado){
                $Log->insertarLog("[SPV_CHEQUEO]","[CHEQ_estado]","UPDATE",$DetChequeo[0]["CHEQ_estado"],$CHEQ_estado,'',$CHEQ_id);
            }
            
            $chequeo->updateChequeo($TIPCHEQ_id,$TRIP_id,$CHEQ_fch,$CHEQ_indicador,$CHEQ_fchentrega,$CHEQ_observacion,$CHEQ_estado,$CHEQ_id);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_CHEQUEO]','1');
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Chequeo ---------------------------------*/
    public function buscarChequeo(){
        try{
            $TIPCHEQ_id = $_POST["bTIPCHEQ_id"];
            $TIPTRIP_id = $_POST["bTIPTRIP_id"];
            $CHEQ_fch_Mes = $_POST["bCHEQ_fch_Mes"];
            $CHEQ_fch_Anio = $_POST["bCHEQ_fch_Anio"];
            $CHEQ_indicador = $_POST["bCHEQ_indicador"];
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            
            $_SESSION["TIPCHEQ_id"] = $TIPCHEQ_id;
            $_SESSION["TIPTRIP_id"] = $TIPTRIP_id;
            $_SESSION["CHEQ_fch_Mes"] = $CHEQ_fch_Mes;
            $_SESSION["CHEQ_fch_Anio"] = $CHEQ_fch_Anio;
            $_SESSION["CHEQ_indicador"] = $CHEQ_indicador;
            $_SESSION["TRIP_apellido"] = $TRIP_apellido;

            if($TIPCHEQ_id == '' and $TIPTRIP_id == '' and $CHEQ_fch_Mes == '' and $CHEQ_fch_Anio == '' and $CHEQ_indicador == '' and $TRIP_apellido == ''){
                $this->model->Redirect(URLLOGICA."chequeo/listarResumenChequeo");
            } else {
                $chequeo = new Chequeo_model();
                $this->view->objResumenChequeo = $chequeo->buscarResumenChequeo($TIPCHEQ_id,$TIPTRIP_id,$CHEQ_fch_Mes,$CHEQ_fch_Anio,$CHEQ_indicador,$TRIP_apellido);
                
                $this->view->objResumenChequeoMatriz = $chequeo->buscarResumenChequeoMatriz($TIPCHEQ_id,$TIPTRIP_id,$CHEQ_fch_Mes,$CHEQ_fch_Anio,$CHEQ_indicador,$TRIP_apellido);
                
                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->listarTripulante('','','','');

                $detalle = new Detalle_model();
                $this->view->objTipoTripulante = $detalle->listarTipoTrip();
                $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
                $this->view->objTipoChequeo = $detalle->listarTipoChequeo();
                $this->view->objMes = $detalle->listarMes();
                $this->view->objAnio = $detalle->listarAnio();
                
                $this->view->render('chequeo');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>