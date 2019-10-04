<?php
//session_start();
class View {
	
	function __construct(){
		
	}
	
	//Metodo que genera la visualizacion de una vista
	//Pasar como parametro al vista a visualizar
	public function render($name){
		try{
			require "View/".$name."_view.php";
		}catch(Exception $e){
            throw $e;
        }
	}
}
?>