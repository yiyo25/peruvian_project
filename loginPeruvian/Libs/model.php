<?php
//Administrador de Models
class Model{
    function __construct(){
    	try{
	    	$this->Contrasena = '@lexAnd3r';
			$this->database = new Database('db_seguridad','SQLServer');
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