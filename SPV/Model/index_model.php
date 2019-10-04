<?php
class index_model extends Model {
	public function __construct(){
		//Logica de inicializacion del login_model
		//Hacer la conexion con la base de datos
		//tengo la instancia pdo en la propiedad
		//database
		parent::__construct();
	}
	//Reglas de negocios
	public function prueba(){
		//$cnv = $_SESSION["objcv"];
		//$cnv->VerDisponibilidad();
	}
}
?>