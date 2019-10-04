<?php
if( !isset($_SESSION)){
	session_start();
}
	
class condicion extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    public function listarCondicion(){
        try{
            $condicion = new Condicion_model();
            $this->view->objResumenCondicion = $condicion->listarResumenCondicion('');
            
            $tripulante = new Tripulante_model();
            $this->view->objTipoTripulante = $tripulante->listarTipoTrip('');
            $this->view->objTipoDetTripulante = $tripulante->listarTipoTripDetalle('');
            $this->view->objTripulante = $tripulante->listarTripulante('','');
            $this->view->objTripNivIngles = $tripulante->listarNivIngles();
            
            $itinerario = new Itinerario_model();
            $this->view->objCiudad = $itinerario->listarCiudad();
            $this->view->objRuta = $itinerario->listarRuta();
            
            $this->view->render('condicion');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function insertCondicion(){
        try{
            $condicion = new Condicion_model();
            
            if($_POST["CONDESP_edad"] != ''){ $CONDESP_edad = $_POST["CONDESP_edad"]; } else{ $CONDESP_edad = 'NULL'; }
            if($_POST["CONDESP_indiedad"] != ''){ $CONDESP_indiedad = $_POST["CONDESP_indiedad"]; } else{ $CONDESP_indiedad = 'NULL'; }
            if($_POST["CIU_id"] != ''){ $CIU_id = $_POST["CIU_id"]; } else{ $CIU_id = 'NULL'; }
            if($_POST["RUT_num_vuelo"] != ''){ $RUT_num_vuelo = $_POST["RUT_num_vuelo"]; } else{ $RUT_num_vuelo = 'NULL'; }
            if($_POST["NIVING_id"] != ''){ $NIVING_id = $_POST["NIVING_id"]; } else{ $NIVING_id = 'NULL'; }
            
            $CONDESP_condicional = $_POST["CONDESP_condicional"];
                    
            if($_POST["TRIP_id_apli"] != ''){ $TRIP_id_apli = $_POST["TRIP_id_apli"]; } else{ $TRIP_id_apli = 'NULL'; }
            
            if($_POST["CONDESP_edad_apli"] != ''){ $CONDESP_edad_apli = $_POST["CONDESP_edad_apli"]; } else{ $CONDESP_edad_apli = 'NULL'; }
            if($_POST["CONDESP_indiedad_apli"] != ''){ $CONDESP_indiedad_apli = $_POST["CONDESP_indiedad_apli"]; } else{ $CONDESP_indiedad_apli = 'NULL'; }
            if($_POST["CIU_id_apli"] != ''){ $CIU_id_apli = $_POST["CIU_id_apli"]; } else{ $CIU_id_apli = 'NULL'; }
            if($_POST["RUT_num_vuelo_apli"] != ''){ $RUT_num_vuelo_apli = $_POST["RUT_num_vuelo_apli"]; } else{ $RUT_num_vuelo_apli = 'NULL'; }
            if($_POST["NIVING_id_apli"] != ''){ $NIVING_id_apli = $_POST["NIVING_id_apli"]; } else{ $NIVING_id_apli = 'NULL'; }
            
            $CONDESP_estado = $_POST["CONDESP_estado"];
            
            if($_POST["TRIP_id"] != ''){
                $TRIP_id = $_POST["TRIP_id"];
                $CONDESP_id = $condicion->insertCondicion($TRIP_id,$CONDESP_edad,$CONDESP_indiedad,$CIU_id,$RUT_num_vuelo,$NIVING_id,$CONDESP_condicional,$TRIP_id_apli,$CONDESP_edad_apli,$CONDESP_indiedad_apli,$CIU_id_apli,$RUT_num_vuelo_apli,$NIVING_id_apli,$CONDESP_estado);
            }
            else{
                $tripulante = new Tripulante_model();
                $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
                $ObjTIPTRIPDET_id = $tripulante->listarTripulante('','',$TIPTRIPDET_id);
                foreach ($ObjTIPTRIPDET_id as $lista){
                    $TRIP_id = $lista["TRIP_id"];
                    $CONDESP_id = $condicion->insertCondicion($TRIP_id,$CONDESP_edad,$CONDESP_indiedad,$CIU_id,$RUT_num_vuelo,$NIVING_id,$CONDESP_condicional,$TRIP_id_apli,$CONDESP_edad_apli,$CONDESP_indiedad_apli,$CIU_id_apli,$RUT_num_vuelo_apli,$NIVING_id_apli,$CONDESP_estado);
                }
            }
            echo $CONDESP_id;
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function listarDetCondicion(){
        try{
            $condicion = new Condicion_model();
            $CONDESP_id = $_POST["CONDESP_id"];
            $this->view->objDetCondicion = $condicion->listarDetCondicion($CONDESP_id);
            $this->view->objDetCondicion = $this->array_utf8_encode($this->view->objDetCondicion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetCondicion);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
        
    public function updateCondicion(){
        try{
            $CONDESP_id = $_POST["CONDESP_id"];
            if($_POST["TRIP_id"] != ''){ $TRIP_id = $_POST["TRIP_id"]; } else{ $TRIP_id = 'NULL'; }
            if($_POST["CONDESP_edad"] != ''){ $CONDESP_edad = $_POST["CONDESP_edad"]; } else{ $CONDESP_edad = 'NULL'; }
            if($_POST["CONDESP_indiedad"] != ''){ $CONDESP_indiedad = $_POST["CONDESP_indiedad"]; } else{ $CONDESP_indiedad = 'NULL'; }
            if($_POST["CIU_id"] != ''){ $CIU_id = $_POST["CIU_id"]; } else{ $CIU_id = 'NULL'; }
            if($_POST["RUT_num_vuelo"] != ''){ $RUT_num_vuelo = $_POST["RUT_num_vuelo"]; } else{ $RUT_num_vuelo = 'NULL'; }
            if($_POST["NIVING_id"] != ''){ $NIVING_id = $_POST["NIVING_id"]; } else{ $NIVING_id = 'NULL'; }
            
            $CONDESP_condicional = $_POST["CONDESP_condicional"];
                    
            if($_POST["TRIP_id_apli"] != ''){ $TRIP_id_apli = $_POST["TRIP_id_apli"]; } else{ $TRIP_id_apli = 'NULL'; }
            if($_POST["CONDESP_edad_apli"] != ''){ $CONDESP_edad_apli = $_POST["CONDESP_edad_apli"]; } else{ $CONDESP_edad_apli = 'NULL'; }
            if($_POST["CONDESP_indiedad_apli"] != ''){ $CONDESP_indiedad_apli = $_POST["CONDESP_indiedad_apli"]; } else{ $CONDESP_indiedad_apli = 'NULL'; }
            if($_POST["CIU_id_apli"] != ''){ $CIU_id_apli = $_POST["CIU_id_apli"]; } else{ $CIU_id_apli = 'NULL'; }
            if($_POST["RUT_num_vuelo_apli"] != ''){ $RUT_num_vuelo_apli = $_POST["RUT_num_vuelo_apli"]; } else{ $RUT_num_vuelo_apli = 'NULL'; }
            if($_POST["NIVING_id_apli"] != ''){ $NIVING_id_apli = $_POST["NIVING_id_apli"]; } else{ $NIVING_id_apli = 'NULL'; }
            
            $CONDESP_estado = $_POST["CONDESP_estado"];
            
            $condicion = new Condicion_model();
            
            /*$DetAusencia = $ausencia->listarAusencia($AUS_id);
            
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
            }*/
            
            $condicion->updateCondicion($TRIP_id,$CONDESP_edad,$CONDESP_indiedad,$CIU_id,$RUT_num_vuelo,$NIVING_id,$CONDESP_condicional,$TRIP_id_apli,$CONDESP_edad_apli,$CONDESP_indiedad_apli,$CIU_id_apli,$RUT_num_vuelo_apli,$NIVING_id_apli,$CONDESP_estado,$CONDESP_id);
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function buscarCondicion(){
        try{
            $TIPTRIP_id = $_POST["bTIPTRIP_id"];
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            $TRIP_numlicencia = $_POST["bTRIP_numlicencia"];
            $TIPAUS_id = $_POST["bTIPAUS_id"];
            
            $simulador = new Simulador_model();
            
            if($TIPTRIP_id == '' and $TRIP_apellido == '' and $TRIP_numlicencia == '' and $TIPAUS_id == ''){
                $this->model->Redirect(URLLOGICA."ausencia/listarAusencia/");
            } else {
                $this->view->objAusencia = $ausenciar->buscarAusencia($TIPTRIP_id,$TRIP_apellido,$TIPAUS_id,$TRIP_numlicencia);
                $tripulante = new Tripulante_model();
                $this->view->objTipoTripulante = $tripulante->listarTipoTrip('');
                $this->view->objTipoDetTripulante = $tripulante->listarTipoTripDetalle('');
                $this->view->objTripulante = $tripulante->listarTripulante('','');
                $this->view->render('ausencia');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>