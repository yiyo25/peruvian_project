<?php
if( !isset($_SESSION)){
	session_start();
}

class detalle extends Controller {
	
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar Provincia (JSON) ---------------------------------*/
    public function listarProvincia(){
        try{
            $detalle = new Detalle_model();
            $this->view->objTripProv = $detalle->listarProvincia();
            $this->view->objTripProv = $this->array_utf8_encode($this->view->objTripProv);
            header('Content-Type: application/json');
            echo json_encode($this->view->objTripProv);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Distrito (JSON) ---------------------------------*/
    public function listarDistrito(){
        try{
            $detalle = new Detalle_model();
            $this->view->objTripDist = $detalle->listarDistrito();
            $this->view->objTripDist = $this->array_utf8_encode($this->view->objTripDist);
            header('Content-Type: application/json');
            echo json_encode($this->view->objTripDist);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Det. Tripulantes (Piloto-Copiloto_Auxiliar) (JSON) ---------------------------------*/
    public function listarTipoTripDetalle(){
        try{
            $detalle = new Detalle_model();
            $this->view->objDetTrip = $detalle->listarTipoTripDetalle('');
            $this->view->objDetTrip = $this->array_utf8_encode($this->view->objDetTrip);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetTrip);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Avión (JSON) (Listar avion disponible para modificar otro avión y disponible sewgún las fechas) ---------------------------------*/
    public function listarAvion(){
        try{
            $ITI_fchini = $_POST["ITI_fchini"];
            $ITI_fchfin = $_POST["ITI_fchfin"];
            $avion = new Avion_model();
            $this->view->objAvion = $avion->listarAvionHabilitadosxFecha($ITI_fchini,$ITI_fchfin);
            $this->view->objAvion = $this->array_utf8_encode($this->view->objAvion);
            header('Content-Type: application/json');
            echo json_encode($this->view->objAvion);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>