<?php
session_start();
	
class reprogramacion extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    public function listarReprogramacion(){
        try{
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            
            $this->view->render('reprogramacion');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
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
    }
    
    public function insertProgramacion(){
        try{
            $programacion = new Programacion_model();
            $ITI_id = $_POST["ITI_id"];
            
            if($_POST["accion"] == "update"){
                $programacion->deleteProgramacion($ITI_id);
            }
            
            if($_POST["TRIP_id_Instructor"] != ''){
                $TRIP_id_Instructor = $_POST["TRIP_id_Instructor"];
                $programacion->insertProgramacion($ITI_id,$TRIP_id_Instructor,'Instructor');
            }
            
            if($_POST["TRIP_id_Piloto"] != ''){
                $TRIP_id_Piloto = $_POST["TRIP_id_Piloto"];
                $programacion->insertProgramacion($ITI_id,$TRIP_id_Piloto,'Piloto');
            }
            
            if($_POST["TRIP_id_Copiloto"] != ''){
                $TRIP_id_Copiloto = $_POST["TRIP_id_Copiloto"];
                $programacion->insertProgramacion($ITI_id,$TRIP_id_Copiloto,'Copiloto');
            }
            
            if($_POST["TRIP_id_JejeCabina"] != ''){
                $TRIP_id_JejeCabina = $_POST["TRIP_id_JejeCabina"];
                $programacion->insertProgramacion($ITI_id,$TRIP_id_JejeCabina,'JefeCabina');
            }
            
            $num_TripCabina = $_POST["num_TripCabina"];
            for($i = 1; $i <= $num_TripCabina;$i++){
                if($_POST["TRIP_id_TripCabina".$i] != ''){
                    $TRIP_id_TripCabina = $_POST["TRIP_id_TripCabina".$i];
                    $programacion->insertProgramacion($ITI_id,$TRIP_id_TripCabina,'TripCabina'.$i);
                }
            }
            
            if($_POST["TRIP_id_ApoyoVuelo"] != ''){
                $TRIP_id_ApoyoVuelo = $_POST["TRIP_id_ApoyoVuelo"];
                $programacion->insertProgramacion($ITI_id,$TRIP_id_ApoyoVuelo,'ApoyoVuelo');
            }
            
            echo "EXITO";
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function listarDetProgramacion(){
        try{
            $programacion = new Programacion_model();
            $ITI_id = $_POST["ITI_id"];
            
            $this->view->objDetProgramacion = $programacion->listarProgramacionxTripulante($ITI_id);
            $this->view->objDetProgramacion = $this->array_utf8_encode($this->view->objDetProgramacion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetProgramacion);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function resumenProgramacion(){
        try{
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvion('','');
            
            $this->view->render('programacionResumen');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
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
}
?>