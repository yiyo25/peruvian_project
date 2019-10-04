<?php
require "nusoap/nusoap.php";
class WsSeguridad{
	public $client;
	//public $server = "http://172.16.1.160:8085/Seguridad.svc?wsdl"; //prueba
	public $server = "http://172.16.1.4:8085/Seguridad.svc?wsdl"; //producion
	public $action_Login = "http://tempuri.org/ISeguridad/Login";
	public $action_ListarComponentes = "http://tempuri.org/ISeguridad/ListarComponentes";
	public $action_ValidarPermisos = "http://tempuri.org/ISeguridad/ValidarPermisos";
	public $action_ListarAplicaciones = "http://tempuri.org/ISeguridad/ListarAplicaciones";
	public $action_ListarUsuarios = "http://tempuri.org/ISeguridad/ListarUsuarios";
	public $action_GuardarLog = "http://tempuri.org/ISeguridad/GuardarLog";
	
	public function WsSeguridad(){
		$this->client = new nusoap_client($this->server, true, false, false, false, false, 5, 10);
		$this->client->soap_defencoding = 'UTF-8';
        $this->client->useHTTPPersistentConnection();
	}
	public function Login($AplicacionId,$Usuario,$Password){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				   <soapenv:Header/>
				   <soapenv:Body>
				      <tem:Login>
				         <tem:AplicacionID>'.$AplicacionId.'</tem:AplicacionID>
				         <tem:Usuario>'.$Usuario.'</tem:Usuario>
				         <tem:Password>'.$Password.'</tem:Password>
				      </tem:Login>
				   </soapenv:Body>
				</soapenv:Envelope>';
		$result = $this->client->send($xml, $this->action_Login);
		return $result;
	}
	public function ListarComponentes($AplicacionId, $UsuarioId, $TipoComponente){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				   <soapenv:Header/>
				   <soapenv:Body>
				      <tem:ListarComponentes>
				         <tem:AplicacionID>'.$AplicacionId.'</tem:AplicacionID>
				         <tem:UsuarioId>'.$UsuarioId.'</tem:UsuarioId>
				         <tem:TipoComponente>'.$TipoComponente.'</tem:TipoComponente>
				      </tem:ListarComponentes>
				   </soapenv:Body>
				</soapenv:Envelope>';
		$result = $this->client->send($xml, $this->action_ListarComponentes);
		return $result;
	}
	public function ValidarPermisos($AplicacionId, $UsuarioId, $RolId, $AccionId){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				   <soapenv:Header/>
				   <soapenv:Body>
				      <tem:ValidarPermisos>
				         <tem:AplicacionID>'.$AplicacionId.'</tem:AplicacionID>
				         <tem:UsuarioID>'.$UsuarioId.'</tem:UsuarioID>
				         <tem:RolID>'.$RolId.'</tem:RolID>
				         <tem:AccionID>'.$AccionId.'</tem:AccionID>
				      </tem:ValidarPermisos>
				   </soapenv:Body>
				</soapenv:Envelope>';
		$result = $this->client->send($xml, $this->action_ValidarPermisos);
		return $result;
	}
	public function ListarAplicaciones($AplicacionId){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				   <soapenv:Header/>
				   <soapenv:Body>
				      <tem:ListarAplicaciones>
				         <tem:AplicacionID>'.$AplicacionId.'</tem:AplicacionID>
				      </tem:ListarAplicaciones>
				   </soapenv:Body>
				</soapenv:Envelope>';
		$result = $this->client->send($xml, $this->action_ListarAplicaciones);
		return $result;
	}
	public function ListarUsuarios($UsuarioId){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				   <soapenv:Header/>
				   <soapenv:Body>
				      <tem:ListarUsuarios>
				         <tem:UsuarioID>'.$UsuarioId.'</tem:UsuarioID>
				      </tem:ListarUsuarios>
				   </soapenv:Body>
				</soapenv:Envelope>';
		$result = $this->client->send($xml, $this->action_ListarUsuarios);
		return $result;
	}
	public function GuardarLog($AplicaiconId,$AccionId,$UsuarioId){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				   <soapenv:Header/>
				   <soapenv:Body>
				      <tem:GuardarLog>
				         <tem:AplicacionID>'.$AplicaiconId.'</tem:AplicacionID>
				         <tem:AccionID>'.$AccionId.'</tem:AccionID>
				         <tem:UsuarioID>'.$UsuarioId.'</tem:UsuarioID>
				      </tem:GuardarLog>
				   </soapenv:Body>
				</soapenv:Envelope>';
		$result = $this->client->send($xml, $this->action_GuardarLog);
		return $result;
	}
    
}

?>