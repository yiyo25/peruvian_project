<?php
session_start();
class nas_model extends Model {
	const PATH_WS = 'http://172.16.1.4:8080/servicesNas.svc?wsdl';
	const SAVE_ACTION = 'http://tempuri.org/IservicesNas/SaveFile';
	const LOAD_ACTION = 'http://tempuri.org/IservicesNas/GetFile';
	
	public function __construct(){
		parent::__construct();
		parent::ConectarSoap(self::PATH_WS);
	}
	
	public function saveFileNas($filename, $binary){
		try{
			$xml="<?xml version='1.0' encoding='utf-8'?>
				<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:tem='http://tempuri.org/' xmlns:wsn='http://schemas.datacontract.org/2004/07/wsNas'>
					<soapenv:Header/>
					<soapenv:Body>
						<tem:SaveFile>
							<tem:file>
								<wsn:Binary>".$binary."</wsn:Binary>
								<wsn:NameFile>".$filename."</wsn:NameFile>
							</tem:file>
						</tem:SaveFile>
					</soapenv:Body>
				</soapenv:Envelope>";
			$result = $this->client->send($xml,self::SAVE_ACTION);
		}catch(Exception $e){
			echo "<pre>";
			print_r($e);
			echo "</pre>";
			throw $e;
			return FALSE;
		}
		return TRUE;
	}
	
	public function loadFileNas($filename,$name){
		try{
			$xml="<?xml version='1.0' encoding='utf-8'?>
					<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:tem='http://tempuri.org/'>
					<soapenv:Header/>
					<soapenv:Body>
						<tem:GetFile>
						<tem:nameFile>".$filename."</tem:nameFile>
						</tem:GetFile>
					</soapenv:Body>
					</soapenv:Envelope>";
			$result = $this->client->send($xml,self::LOAD_ACTION);
			$data = $result['GetFileResult']['Data']['Binary'];
			header('Content-type: application/octet-stream');
			header("Content-Disposition: attachment; filename=".$name);
			header('Content-Transfer-Encoding: Unicode');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			
			echo base64_decode($data);
		}catch(Exception $e){
			echo "<pre>";
			print_r($e);
			echo "</pre>";
			throw $e;
			return FALSE;
		}
		return TRUE;
	}
}
?>