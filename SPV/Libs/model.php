<?php
//Administrador de Models
class Model{
    function __construct(){
    	try{
	    	$this->Contrasena = '@lexAnd3r';
			$this->database = new Database('db_SistProgVuelo','SQLServer');
		}catch(Exception $e){
            throw $e;
        }
	}
    
    public function Redirect($url){
		header('Location: '.$url);
		exit();
	}
    
    function get_nombre_dia($fecha){
       $fechats = strtotime($fecha); //pasamos a timestamp

        //el parametro w en la funcion date indica que queremos el dia de la semana
        //lo devuelve en numero 0 domingo, 1 lunes,....
        switch (date('w', $fechats)){
            /*case 0: return "Domingo"; break;
            case 1: return "Lunes"; break;
            case 2: return "Martes"; break;
            case 3: return "Miercoles"; break;
            case 4: return "Jueves"; break;
            case 5: return "Viernes"; break;
            case 6: return "Sabado"; break;*/
            case 0: return "Sunday"; break;
            case 1: return "Monday"; break;
            case 2: return "Tuesday"; break;
            case 3: return "Wednesday"; break;
            case 4: return "Thursday"; break;
            case 5: return "Friday"; break;
            case 6: return "Saturday"; break;
        }
    }
}
?>