<?php
class Bootstrap {
    const DEFAULT_INDEX = 'index';
    const FLIGHT_INDEX = 'flights';
    
	function __construct(){
		//los parametros fueron enviados a un array
		$url=isset($_GET['url']) ? $_GET['url'] : null ;
		$url=rtrim($url,"/");
		$url=explode('/',$url);
		
		//optional
		if(strtoupper( $url[0] ) == 'ES'){
			if(isset($url[1])) $url[0] = $url[1];
			if(isset($url[2])) $url[1] = $url[2];
			if(isset($url[3])) $url[2] = $url[3];
			if(isset($url[4])) $url[3] = $url[4];
			if(isset($url[5])) $url[4] = $url[5];
			if(isset($url[6])) $url[5] = $url[6];
			if(isset($url[7])) $url[6] = $url[7];
		}

		//Asignar variables
		$entidad = ($url[0]=='index.php')? self::DEFAULT_INDEX:$url[0];
		$metodo	= isset($url[1])? $url[1]: self::DEFAULT_INDEX; 
		$param1 = isset($url[2])? $url[2]: false; 
		$param2 = isset($url[3])? $url[3]: false;
		$param3 = isset($url[4])? $url[4]: false;
		$param4 = isset($url[5])? $url[5]: false;
		$param5 = isset($url[6])? $url[6]: false;
		//Cargar al controller solicitado
		$file='./Controller/'.$entidad.'_controller.php';
		
        if($entidad == self::FLIGHT_INDEX){
            if ( strpos($metodo, '=') !== false) {
                $param1 = $metodo;
                $metodo = self::DEFAULT_INDEX;
            }
        }
        
		if(file_exists($file)){
			require $file;
			$flag = FALSE;
			//Instancia de un controlador
			if(class_exists($entidad."_controller")){
				$entidad_c = $entidad."_controller";
				$flag = TRUE;
				$controller=new $entidad_c;
				//cargar el model asociado al controlador
				$controller->loadModel($entidad,$flag); 
			}else{
				$controller=new $entidad;
				//cargar el model asociado al controlador
				$controller->loadModel($entidad,$flag); 
			}	
		} else { //Cuando el archivo controlador no existe...
			require './Controller/index_controller.php';
			$error=new index();
			$error->index();
			return false;  //Finalizamos el llamado al metodo
		}

		//Preguntar si existe un action
		if($param5){
			$controller->{$metodo}($param1,$param2,$param3,$param4,$param5);
		} elseif($param4){
			$controller->{$metodo}($param1,$param2,$param3,$param4);
		} elseif($param3){
			$controller->{$metodo}($param1,$param2,$param3);
		} elseif($param2){
			$controller->{$metodo}($param1,$param2);
		} elseif($param1){
			$controller->{$metodo}($param1);
		} else{
			if(method_exists($controller,$metodo)){
				$controller->{$metodo}();  //Llamamos a un action
			}else{
				require './Controller/index_controller.php';
			    $error=new index();
				// $error->errorMetodo();
				$error->errorMetodo(print_r($controller, TRUE).' -> '.print_r($metodo, TRUE));
				return false;  //Finalizamos el llamado al metodo
			}
		}
	}//End Construct
}
?>
