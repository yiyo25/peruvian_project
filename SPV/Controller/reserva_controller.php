<?php
if( !isset($_SESSION)){
	session_start();
}
	
class reserva extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar Ausencia ---------------------------------*/
    public function listarResumenReserva(){
        try{
            unset($_SESSION["TRIP_apellido"]);
            unset($_SESSION["TRIP_numlicencia"]);
            unset($_SESSION["RES_fch"]);
            
            $reserva = new Reserva_model();
            $this->view->objResumenReserva = $reserva->listarResumenReserva();
            
            $tripulante = new Tripulante_model();
            $this->view->objTripulante = $tripulante->listarTripulante('','','','');
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTrip('');
            $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');
            
            $this->view->render('reserva');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Reserva ---------------------------------*/
    public function insertReserva(){
        try{
            $reserva = new Reserva_model();
            
            $parts = explode('/',$_POST["RES_fch"]);
            $RES_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            $RES_id = $_POST["RES_id"];
            
            if($_POST["accion"] == "update"){
                $reserva->deleteReserva($RES_id);
            }
            
            $RES_id = $reserva->insertReserva($RES_fch);
            
            if($_POST["TRIP_id_Instructor"] != ''){
                $TRIP_id_Instructor = $_POST["TRIP_id_Instructor"];
                $reserva->insertDetReserva($RES_id,$TRIP_id_Instructor,'Instructor');
            }
            
            if($_POST["TRIP_id_Piloto"] != ''){
                $TRIP_id_Piloto = $_POST["TRIP_id_Piloto"];
                $reserva->insertDetReserva($RES_id,$TRIP_id_Piloto,'Piloto');
            }
            
            if($_POST["TRIP_id_Copiloto"] != ''){
                $TRIP_id_Copiloto = $_POST["TRIP_id_Copiloto"];
                $reserva->insertDetReserva($RES_id,$TRIP_id_Copiloto,'Copiloto');
            }
            
            if($_POST["TRIP_id_JejeCabina"] != ''){
                $TRIP_id_JejeCabina = $_POST["TRIP_id_JejeCabina"];
                $reserva->insertDetReserva($RES_id,$TRIP_id_JejeCabina,'JefeCabina');
            }
            
            $num_TripCabina = $_POST["num_TripCabina"];
            for($i = 1; $i <= $num_TripCabina;$i++){
                if($_POST["TRIP_id_TripCabina".$i] != ''){
                    $TRIP_id_TripCabina = $_POST["TRIP_id_TripCabina".$i];
                    $reserva->insertDetReserva($RES_id,$TRIP_id_TripCabina,'TripCabina'.$i);
                }
            }            
            echo "EXITO";
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Det. de Reserva (JSON) ---------------------------------*/
    public function listarDetReserva(){
        try{
            $reserva = new Reserva_model();
            $RES_id = $_POST["RES_id"];
            $this->view->objDetReserva = $reserva->listarDetReserva($RES_id);
            $this->view->objDetReserva = $this->array_utf8_encode($this->view->objDetReserva);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetReserva);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Ausencia ---------------------------------*/
    public function buscarResumenReserva(){
        try{
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            $TRIP_numlicencia = $_POST["bTRIP_numlicencia"];
            $RES_fch = $_POST["bRES_fch"];
            
            $_SESSION["TRIP_apellido"] = $TRIP_apellido;
            $_SESSION["TRIP_numlicencia"] = $TRIP_numlicencia;
            $_SESSION["RES_fch"] = $RES_fch;
            
            $reserva = new Reserva_model();
            
            if($RES_fch == '' and $TRIP_apellido == '' and $TRIP_numlicencia == ''){
                $this->model->Redirect(URLLOGICA."reserva/listarReserva/");
            } else {
                $reserva = new Reserva_model();
                $this->view->objResumenReserva = $reserva->buscarResumenReserva($RES_fch,$TRIP_apellido,$TRIP_numlicencia);

                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->listarTripulante('','','','');
                $detalle = new Detalle_model();
                $this->view->objTipoTripulante = $detalle->listarTipoTrip('');
                $this->view->objTipoDetTripulante = $detalle->listarTipoTripDetalle('');

                $this->view->render('reserva');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>