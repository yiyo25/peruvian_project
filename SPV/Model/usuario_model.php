<?php
if( !isset($_SESSION)){
	session_start();
}

class Usuario_model extends Model {
	
	public function __construct(){
		parent::__construct();
	}
    
	public function ListarUsuario($IdAplicacion,$Usuario,$Password){
		try{
            $webServicesSeguridad = new WsSeguridad();
            $user = $webServicesSeguridad->Login($IdAplicacion,$Usuario,$Password);

            $ObjUsu = $user["LoginResult"]["Usuario"];
            return $ObjUsu;
        }catch(Exception $e){
            throw $e;
        }
	}
}
?>