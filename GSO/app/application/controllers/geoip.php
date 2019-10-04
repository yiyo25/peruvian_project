<?
class Geoip extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('geoip_model');
	}
	
	function index(){
	
		$rs1=$this->geoip_model->leer_csv();		
		$rs2=$this->geoip_model->geo_ip_pasarela();
		$no_encontrado=array();
		$encontrado=array();
		
		$h=0;
		$r=0;
		for($t=0;$t<count($rs1);$t++){
			for($g=0;$g<count($rs2);$g++){				
				if($rs1[$t]["country_iso_code"]==$rs2[$g]->abreviatura ){
					$encontrado[$h]=$rs1[$t];
					$h++;break;
				}
				if(count($rs2)-1==$g){
					$no_encontrado[$r]="INSERT INTO pais (nombre,abreviatura) VALUES('".str_replace('"',"",$rs1[$t]["country_name"])."','".$rs1[$t]["country_iso_code"]."');";						
					echo "INSERT INTO pais (idpais,nombre,abreviatura) VALUES('','".str_replace('"',"",$rs1[$t]["country_name"])."','".$rs1[$t]["country_iso_code"]."');<br>";
					$r++;	
				}
				
			}
		}
		
	}
	
	function ip(){
		
		$rs_ip=$this->geoip_model->leer_csv_ip();
	
		echo "<pre>";
		print_r($rs_ip);
		echo "</pre>";
	}
	


}
?>