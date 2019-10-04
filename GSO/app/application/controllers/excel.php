<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excel extends CI_Controller{
	function __construct(){
		parent::__construct();
		//$this->load->library('PHPExcel');
	}
	function xxx(){
		echo phpinfo();
	}
	function index(){
		$this->load->library('PHPExcel');
		PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getActiveSheet()->setTitle('Nuevo Formato');
		$objPHPExcel->getProperties()->setCreator("Peruvian Airline S.A.")
							 ->setLastModifiedBy("Peruvian Airline S.A.")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");		
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
												  ->setSize(8);
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'EMPRESA');
		$objPHPExcel->getActiveSheet()->setCellValue('B6', 'FECHA');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="resumen_de_vuelos.xls"');
		header('Cache-Control: max-age=0'); 	
		$objWriter->save('php://output');
		
			
		
		
		
		
		
		echo 'Hola Mundo';
		
	}		
}