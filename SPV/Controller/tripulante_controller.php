<?php
if( !isset($_SESSION)){
	session_start();
}
	
class tripulante extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar TripulantesView  ---------------------------------*/
    public function listarTripulante($variable){
        try{
            if($variable == 'Vuelo'){ $tipTripulante = '1'; } else if($variable == 'Cabina'){ $tipTripulante = '2'; }
            
            unset($_SESSION["TRIP_apellido"]);
            unset($_SESSION["TIPLIC_id"]);
            unset($_SESSION["TRIP_numlicencia"]);
            unset($_SESSION["TIPTRIPDET_id"]);
            
            $tripulante = new Tripulante_model();
            $this->view->objTripulante = $tripulante->listarTripulante('',$tipTripulante,'','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTripDetalle($tipTripulante);
            $this->view->objTipoLicencia = $detalle->listarTipoLicencia($tipTripulante);
            $this->view->objTripDepa = $detalle->listarDepartamento();
            $this->view->objTripProv = $detalle->listarProvincia();
            $this->view->objTripDist = $detalle->listarDistrito();
            $this->view->objTripNivIngles = $detalle->listarNivIngles();
            $this->view->objTripCate = $detalle->listarCategoria($tipTripulante);
            
            if($variable == 'Vuelo'){ $this->view->render('tripVuelo'); } else if($variable == 'Cabina'){ $this->view->render('tripCabina'); }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Tripulantes  ---------------------------------*/
    public function insertTripulante(){
        try{
            $TRIP_nombre = trim(mb_strtoupper($_POST["TRIP_nombre"],'UTF-8'));
            $TRIP_apellido = trim(mb_strtoupper($_POST["TRIP_apellido"],'UTF-8'));
            $TRIP_correo = trim(mb_strtoupper($_POST["TRIP_correo"],'UTF-8'));
            
            $parts = explode('/',$_POST["TRIP_fechnac"]);
            $TRIP_fechnac = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $idDist = $_POST["idDist"];
            $TRIP_domilicio = trim(mb_strtoupper($_POST["TRIP_domilicio"],'UTF-8'));
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $TRIP_instructor = $_POST["TRIP_instructor"];
            $TIPLIC_id = $_POST["TIPLIC_id"];
            $TRIP_numlicencia = $_POST["TRIP_numlicencia"];
            $TRIP_DGAC = $_POST["TRIP_DGAC"];
            $NIVING_id = $_POST["NIVING_id"];
            $CAT_id = $_POST["CAT_id"];
            $TRIP_estado = $_POST["TRIP_estado"];
            
            $tripulante = new Tripulante_model();
            $TRIP_id = $tripulante->insertTripulante($TRIP_nombre,$TRIP_apellido,$TRIP_correo,$TRIP_fechnac,$idDist,$TRIP_domilicio,$TIPTRIPDET_id,$TRIP_instructor,$TIPLIC_id,$TRIP_numlicencia,$TRIP_DGAC,$NIVING_id,$CAT_id,$TRIP_estado);
            //echo $TRIP_id;
            
            $this->view->objTrip = $TRIP_id;
            $this->view->objTrip = $this->array_utf8_encode($this->view->objTrip);
            header('Content-Type: application/json');
            echo json_encode($this->view->objTrip);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Tripulantes  ---------------------------------*/
    public function updateTripulante(){
        try{
            $TRIP_id = $_POST["TRIP_id"];
            $TRIP_nombre = trim(mb_strtoupper($_POST["TRIP_nombre"],'UTF-8'));
            $TRIP_apellido = trim(mb_strtoupper($_POST["TRIP_apellido"],'UTF-8'));
            $TRIP_correo = trim(mb_strtoupper($_POST["TRIP_correo"],'UTF-8'));
            
            $parts = explode('/',$_POST["TRIP_fechnac"]);
            $TRIP_fechnac = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $idDist = $_POST["idDist"];
            $TRIP_domilicio = trim(mb_strtoupper($_POST["TRIP_domilicio"],'UTF-8'));
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $TRIP_instructor = $_POST["TRIP_instructor"];
            $TIPLIC_id = $_POST["TIPLIC_id"];
            $TRIP_numlicencia = $_POST["TRIP_numlicencia"];
            $TRIP_DGAC = $_POST["TRIP_DGAC"];
            $NIVING_id = $_POST["NIVING_id"];
            $CAT_id = $_POST["CAT_id"];
            $TRIP_estado = $_POST["TRIP_estado"];
            
            $tripulante = new Tripulante_model();
            $DetTrip = $tripulante->listarTripulante($TRIP_id,'','','');
            
            $Log = new Log_model();
            
            if($DetTrip[0]["TRIP_nombre"] != $TRIP_nombre){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_nombre]","UPDATE",utf8_encode($DetTrip[0]["TRIP_nombre"]),$TRIP_nombre,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_apellido"] != $TRIP_apellido){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_apellido]","UPDATE",utf8_encode($DetTrip[0]["TRIP_apellido"]),$TRIP_apellido,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_correo"] != $TRIP_apellido){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_correo]","UPDATE",utf8_encode($DetTrip[0]["TRIP_correo"]),$TRIP_correo,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_fechnac"] != $TRIP_fechnac){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_fechnac]","UPDATE",$DetTrip[0]["TRIP_fechnac"],$TRIP_fechnac,'',$TRIP_id);
            }
            if($DetTrip[0]["idDist"] != $idDist){
                $Log->insertarLog("[SPV_TRIPULANTE]","[idDist]","UPDATE",$DetTrip[0]["idDist"],$idDist,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_domilicio"] != $TRIP_domilicio){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_domilicio]","UPDATE",utf8_encode($DetTrip[0]["TRIP_domilicio"]),$TRIP_domilicio,'',$TRIP_id);
            }
            if($DetTrip[0]["TIPTRIPDET_id"] != $TIPTRIPDET_id){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TIPTRIPDET_id]","UPDATE",$DetTrip[0]["TIPTRIPDET_id"],$TIPTRIPDET_id,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_instructor"] != $TRIP_instructor){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_instructor]","UPDATE",$DetTrip[0]["TRIP_instructor"],$TRIP_instructor,'',$TRIP_id);
            }
            if($DetTrip[0]["TIPLIC_id"] != $TIPLIC_id){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TIPLIC_id]","UPDATE",$DetTrip[0]["TIPLIC_id"],$TIPLIC_id,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_numlicencia"] != $TRIP_numlicencia){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_numlicencia]","UPDATE",$DetTrip[0]["TRIP_numlicencia"],$TRIP_numlicencia,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_DGAC"] != $TRIP_DGAC){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_DGAC]","UPDATE",$DetTrip[0]["TRIP_DGAC"],$TRIP_DGAC,'',$TRIP_id);
            }
            if($DetTrip[0]["NIVING_id"] != $NIVING_id){
                $Log->insertarLog("[SPV_TRIPULANTE]","[NIVING_id]","UPDATE",$DetTrip[0]["NIVING_id"],$NIVING_id,'',$TRIP_id);
            }
            if($DetTrip[0]["CAT_id"] != $CAT_id){
                $Log->insertarLog("[SPV_TRIPULANTE]","[CAT_id]","UPDATE",$DetTrip[0]["CAT_id"],$CAT_id,'',$TRIP_id);
            }
            if($DetTrip[0]["TRIP_estado"] != $TRIP_estado){
                $Log->insertarLog("[SPV_TRIPULANTE]","[TRIP_estado]","UPDATE",$DetTrip[0]["TRIP_estado"],$TRIP_estado,'',$TRIP_id);
            }
            
            $tripulante->updateTripulante($TRIP_id,$TRIP_nombre,$TRIP_apellido,$TRIP_correo,$TRIP_fechnac,$idDist,$TRIP_domilicio,$TIPTRIPDET_id,$TRIP_instructor,$TIPLIC_id,$TRIP_numlicencia,$TRIP_DGAC,$NIVING_id,$CAT_id,$TRIP_estado);
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Tripulantes  ---------------------------------*/
    public function buscarTripulante($variable){
        try{
            if($variable == 'Vuelo'){ $tipTripulante = '1'; } else if($variable == 'Cabina'){ $tipTripulante = '2'; }
           
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            $TIPLIC_id = $_POST["bTIPLIC_id"];
            $TRIP_numlicencia = $_POST["bTRIP_numlicencia"];
            $TIPTRIPDET_id = $_POST["bTIPTRIPDET_id"];
            
            $_SESSION["TRIP_apellido"] = $TRIP_apellido;
            $_SESSION["TIPLIC_id"] = $TIPLIC_id;
            $_SESSION["TRIP_numlicencia"] = $TRIP_numlicencia;
            $_SESSION["TIPTRIPDET_id"] = $TIPTRIPDET_id;
            
            if($TRIP_apellido == '' and $TIPLIC_id == '' and $TRIP_numlicencia == '' and $TIPTRIPDET_id == ''){
                $this->model->Redirect(URLLOGICA."tripulante/listarTripulante/".$variable);
            } else {
                $detalle = new Detalle_model();
                $this->view->objTipoTripulante = $detalle->listarTipoTripDetalle($tipTripulante);
                $this->view->objTipoLicencia = $detalle->listarTipoLicencia($tipTripulante);
                $this->view->objTripDepa = $detalle->listarDepartamento();
                $this->view->objTripProv = $detalle->listarProvincia();
                $this->view->objTripDist = $detalle->listarDistrito();
                $this->view->objTripNivIngles = $detalle->listarNivIngles();
                $this->view->objTripCate = $detalle->listarCategoria($tipTripulante);
                
                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->buscarTripulante($TRIP_apellido,$TIPLIC_id,$TRIP_numlicencia,$TIPTRIPDET_id);
                if($variable == 'Vuelo'){ $this->view->render('tripVuelo'); } else if($variable == 'Cabina'){ $this->view->render('tripCabina'); }
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Det. Tripulante (JSON) ---------------------------------*/
    public function listarDetTrip(){
        try{
            $tripulante = new Tripulante_model();
            $TRIP_id = $_POST["TRIP_id"];
            $this->view->objDetTrip = $tripulante->listarTripulante($TRIP_id,'','','');
            $this->view->objDetTrip = $this->array_utf8_encode($this->view->objDetTrip);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetTrip);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Tripulante (JSON) ---------------------------------*/
    public function listarTripulantes(){
        try{
            $tripulante = new Tripulante_model();
            $this->view->objTrip = $tripulante->listarTripulante('','','');
            $this->view->objTrip = $this->array_utf8_encode($this->view->objTrip);
            header('Content-Type: application/json');
            echo json_encode($this->view->objTrip);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>