<?php
//Administrador de Models
class ModelLogin{
    function __construct(){
    	try{
	    	$this->Contrasena = '@lexAnd3r';
			$this->database = new DatabaseLogin('db_seguridad','SQLServer');
		}catch(Exception $e){
            throw $e;
        }
	}
    
    public function Redirect($url){
		header('Location: '.$url);
		exit();
	}
}
?>