<?php
class Gc extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('conciliacion_model');
	}
	function index(){
	
		$this->load->view('plantilla/header');
		$this->load->view('session');
		$this->load->view('gc/conciliacion');
		$this->load->view('plantilla/footer');
	}
	function conciliacion_pago(){
	
		$this->load->view('plantilla/header');
		$this->load->view('session');
		$this->load->view('gc/conciliacion_pago');
		$this->load->view('plantilla/footer');
		
	}
	
	function subir_csv_pago(){
	
		$tmp=$_FILES['files']['tmp_name'];		
		$rs=$this->conciliacion_model->guardar_csv_bd_pago($_FILES['files']['name']);		
		$uploaddir = './includes/csv_pago/'.$rs[0]->nombre_archivo;
		
		if(move_uploaded_file($tmp,$uploaddir)){
			
		}else{
		  echo "Error";
		}
	
	}
	function conciliar_pago(){
		
			$rs=$this->conciliacion_model->leer_csv_pago("762620140612.csv");
			echo "<pre>";
			print_r($rs);
			echo "</pre>";
	}
	
	function subir_csv(){
	
		$tmp=$_FILES['files']['tmp_name'];		
		$rs=$this->conciliacion_model->guardar_csv_bd($_FILES['files']['name']);
		$uploaddir = './includes/csv/'.$rs[0]->nombre_archivo;
		
		if(move_uploaded_file($tmp,$uploaddir)){
			//aca no hay nada mira si imprimo algo sale error, VES ? escibe pes mela
			//echo "QUINTO ENSALADA";
		}else{
		  echo "Error";
		}
	
	
	}
	function borrar_csv(){
		$ruta_csv = './includes/csv/'.$this->input->post('fileNames');
		unlink($ruta_csv);
	}
	
	function conciliar(){
	
		$data["fi"]=$this->input->post('fi');
		$data["ff"]=$this->input->post('ff');
		$data["fp"]=$this->input->post('fp');
		$this->load->view('gc/conciliacion_respuesta',$data);			

	}
	function conciliar_respuesta($fi,$ff,$fp){
	
		$rs=$this->conciliacion_model->conciliacion_gc_reserva($fi,$ff,$fp);
		echo json_encode($rs);
	}

}