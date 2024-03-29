<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UploadGSO extends CI_Controller{
	function UploadGSO(){
		parent::Controller();
		$this->load->helper(array('form','url'));
	}
	function index(){
		$this->load->view('formulario_carga', array('error' => ' ' ));
	}
	function do_upload(){
		$config['upload_path'] = './reportes/archivosReportesGSO';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';		
		$this->load->library('upload', $config);	
		if ( ! $this->upload->do_upload()){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('formulario_carga', $error);
		}	
		else{
			$data = array('upload_data' => $this->upload->data());			
			$this->load->view('upload_success', $data);
		}
	}	
}