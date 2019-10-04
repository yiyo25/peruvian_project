<?
class Geoip_model extends CI_Model {

	function __construct(){
    	parent::__construct();
		$this->load->library('csvreader');		
	}
	
	function leer_csv(){
		
		$filePath = base_url().'includes/csv_geoip/Country-Location.csv';
		$rs = $this->csvreader->parse_file($filePath);		
		return $rs;
		
	}
	
	function leer_csv_ip(){
		
		$filePath = base_url().'includes/csv_geoip/Country-Blocks.csv';
		$rs = $this->csvreader->parse_file($filePath);	
		return $rs;
		
	}
	
	function geo_ip_pasarela(){
	
		$db_pasarela = $this->load->database('pasarela', TRUE);	
		$db_pasarela->select("*");
		$db_pasarela->from("pais");
		return $db_pasarela->get()->result();
	
		
	}
	

}

?>