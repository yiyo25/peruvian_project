<?php
//Administrador de Models
class Model{
	public $database_tramite;
	public $database_pci;
	private $Contrasena;
	
	function __construct(){
		try{
			$this->Contrasena = '@lexAnd3r';
			$this->database_tramite = new Database('db_std','SQLServerST');
			//$this->database_seg = new Database('db_segSeguridad','SQLServerST');
		}catch(Exception $e){
			throw $e;
		}
	}
	
	function ConectarSoap($server){
		$this->client = new nusoap_client($server, true, false, false, false, false, 5, 10);
		$this->client->soap_defencoding = 'UTF-8';
		$this->client->useHTTPPersistentConnection();
	}
	
	public function GenerarHash($string){
		try{
			$result = '';
			$key = $this->Contrasena;
			for($i=0; $i<strlen($string); $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)+ord($keychar));
				$result.=$char;
			}
			return base64_encode($result);
		}catch(Exception $e){
			throw $e;
		}
	}
	
	public function ObtenerHash($string){
		try{
			$result = '';
			$key = $this->Contrasena;
			$string = base64_decode($string);
			for($i=0; $i<strlen($string); $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)-ord($keychar));
				$result.=$char;
			}
			return $result;
		}catch(Exception $e){
			throw $e;
		}
	}
	
	public function Redirect($url){
		try{
			header('Location: '.$url);
			exit();
		}catch(Exception $e){
			throw $e;
		}
	}
	
}
?>