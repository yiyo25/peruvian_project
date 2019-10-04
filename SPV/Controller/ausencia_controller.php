<?php
if( !isset($_SESSION)){
	session_start();
}
	
class ausencia extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar Ausencia ---------------------------------*/
    public function listarAusencia(){
        try{
            unset($_SESSION["TIPTRIP_id"]);
            unset($_SESSION["TRIP_apellido"]);
            unset($_SESSION["TRIP_numlicencia"]);
            unset($_SESSION["TIPAUS_id"]);
            
            $ausencia = new Ausencia_model();
            $this->view->objAusencia = $ausencia->listarAusencia('');
            
            $tripulante = new Tripulante_model();
            $this->view->objTripulante = $tripulante->listarTripulante('','','','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTrip('');
            $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
            $this->view->objTipoAusencia = $detalle->listarTipoAusencia();
            
            $this->view->render('ausencia');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Ausencia ---------------------------------*/
    public function insertAusencia(){
        try{
            $TIPAUS_id = $_POST["TIPAUS_id"];
            $TRIP_id = $_POST["TRIP_id"];
            $AUS_estado = $_POST["AUS_estado"];
                
            $parts = explode('/',$_POST["AUS_fchini"]);
            $AUS_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["AUS_fchfin"]);
            $AUS_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $ausencia = new Ausencia_model();
            $AUS_id = $ausencia->insertAusencia($TIPAUS_id,$TRIP_id,$AUS_fchini,$AUS_fchfin,$AUS_estado);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_AUSENCIA]','1');
            
            $this->view->objAusencia = $AUS_id;
            $this->view->objAusencia = $this->array_utf8_encode($this->view->objAusencia);
            header('Content-Type: application/json');
            echo json_encode($this->view->objAusencia);
            
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Det. de Ausencia (JSON) ---------------------------------*/
    public function listarDetAusencia(){
        try{
            $ausencia = new Ausencia_model();
            $AUS_id = $_POST["AUS_id"];
            $this->view->objDetAusencia = $ausencia->listarAusencia($AUS_id);
            $this->view->objDetAusencia = $this->array_utf8_encode($this->view->objDetAusencia);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetAusencia);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Ausencia ---------------------------------*/
    public function updateAusencia(){
        try{
            $AUS_id = $_POST["AUS_id"];
            $TIPAUS_id = $_POST["TIPAUS_id"];
            $TRIP_id = $_POST["TRIP_id"];
            $AUS_estado = $_POST["AUS_estado"];
                
            $parts = explode('/',$_POST["AUS_fchini"]);
            $AUS_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $parts = explode('/',$_POST["AUS_fchfin"]);
            $AUS_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $ausencia = new Ausencia_model();
            $DetAusencia = $ausencia->listarAusencia($AUS_id);
            
            $Log = new Log_model();
            
            if($DetAusencia[0]["TIPAUS_id"] != $TIPAUS_id){
                $Log->insertarLog("[SPV_AUSENCIA]","[TIPAUS_id]","UPDATE",$DetAusencia[0]["TIPAUS_id"],$TIPAUS_id,'',$AUS_id);
            }
            if($DetAusencia[0]["TRIP_id"] != $TRIP_id){
                $Log->insertarLog("[SPV_AUSENCIA]","[TRIP_id]","UPDATE",$DetAusencia[0]["TRIP_id"],$TRIP_id,'',$AUS_id);
            }
            if($DetAusencia[0]["AUS_fchini"] != $AUS_fchini){
                $Log->insertarLog("[SPV_AUSENCIA]","[AUS_fchini]","UPDATE",$DetAusencia[0]["AUS_fchini"],$AUS_fchini,'',$AUS_id);
            }
            if($DetAusencia[0]["AUS_fchfin"] != $AUS_fchfin){
                $Log->insertarLog("[SPV_AUSENCIA]","[AUS_fchfin]","UPDATE",$DetAusencia[0]["AUS_fchfin"],$AUS_fchfin,'',$AUS_id);
            }
            
            $ausencia->updateAusencia($TIPAUS_id,$TRIP_id,$AUS_fchini,$AUS_fchfin,$AUS_estado,$AUS_id);
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_AUSENCIA]','1');
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Ausencia ---------------------------------*/
    public function buscarAusencia(){
        try{
            $TIPTRIP_id = $_POST["bTIPTRIP_id"];
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            $TRIP_numlicencia = $_POST["bTRIP_numlicencia"];
            $TIPAUS_id = $_POST["bTIPAUS_id"];
            
            $_SESSION["TIPTRIP_id"] = $TIPTRIP_id;
            $_SESSION["TRIP_apellido"] = $TRIP_apellido;
            $_SESSION["TRIP_numlicencia"] = $TRIP_numlicencia;
            $_SESSION["TIPAUS_id"] = $TIPAUS_id;
            
            $ausencia = new Ausencia_model();
            
            if($TIPTRIP_id == '' and $TRIP_apellido == '' and $TRIP_numlicencia == '' and $TIPAUS_id == ''){
                $this->model->Redirect(URLLOGICA."ausencia/listarAusencia/");
            } else {
                $this->view->objAusencia = $ausencia->buscarAusencia($TIPTRIP_id,$TRIP_apellido,$TIPAUS_id,$TRIP_numlicencia);
                
                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->listarTripulante('','','','');

                $detalle = new Detalle_model();
                $this->view->objTipoTripulante = $detalle->listarTipoTrip('');
                $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
                $this->view->objTipoAusencia = $detalle->listarTipoAusencia();
                
                $this->view->render('ausencia');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>