<? class Webpanel extends CI_Controller {
   
   function __construct()
   {
      parent::__construct();
	  $this->load->helper('form');
      $this->load->model('webpanel_model','webpanel');
	
	}
	function v_Reclamo(){
   
	  $this->load->view('plantilla/header');
	  $this->load->view('resiber/reclamo');
	  $this->load->view('plantilla/footer');
   
    }
   
    function ReclamoVista(){
	
		$data["fi"]=$this->input->post('fi');
		$data["ff"]=$this->input->post('ff');
	
		$this->load->view('resiber/reclamo_respuesta',$data);		

	}
	
    function ReclamoListado($fi,$ff){
   
		//echo $fi.$ff;die();
		$data=$this->webpanel->listado_reclamo($fi,$ff);	
		//header("Content-type: application/json");
		echo json_encode($data);
	
	}
	
	
   }
	
?>	