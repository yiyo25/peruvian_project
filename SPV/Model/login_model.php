<?php
if( !isset($_SESSION)){
	session_start();
}

class Login_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
    
	public function Logueo($IdAplicacion,$Usuario,$Password){
		try{
            $webServicesSeguridad = new WsSeguridad();
            $login = $webServicesSeguridad->Login($IdAplicacion,$Usuario,$Password);

            $objloginError = $login["LoginResult"]["Error"];
            if(!(isset($objloginError["Error"]))) {
                return TRUE;
            } else {
                return FALSE;
            }
        }catch(Exception $e){
            throw $e;
        }
	}
}
?>