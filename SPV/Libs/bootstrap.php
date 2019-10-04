<?php
setlocale(LC_ALL,"es_ES");
class Bootstrap {
	function __construct(){
		try{
			//los parametros fueron enviados a un array
			$url=isset($_GET['url']) ? $_GET['url'] : null ;
	        $url=rtrim($url,"/");
	        $url=explode('/',$url);
	
			//Asignar variables
			$entidad = ($url[0] == 'index.php') ? 'index' : $url[0];
			$metodo	= isset($url[1]) ? $url[1] : 'index';
			$param1 = isset($url[2]) ? $url[2] : false;
			$param2 = isset($url[3]) ? $url[3] : false;
			$param3 = isset($url[4]) ? $url[4] : false;
			$param4 = isset($url[5]) ? $url[5] : false;
			$param5 = isset($url[6]) ? $url[6] : false;
			$param6 = isset($url[7]) ? $url[7] : false;
	        
			//Cargar al controller solicitado
			$file='./Controller/'.$entidad.'_controller.php';
			
			if(file_exists($file)){
	        //Valida si el archivo existe.
				require $file;
				$flag = FALSE;
	            //Instancia de un controlador
				if(class_exists($entidad."_controller")){
	                //Valido que la clase x_controller exista.
					$entidad_c = $entidad."_controller";
					$flag = TRUE;
					$controller = new $entidad_c;
					//cargar el model asociado al controlador
					$controller->loadModel($entidad,$flag);
				}else{
					$controller = new $entidad;
					//cargar el model asociado al controlador
					$controller->loadModel($entidad,$flag);
				}
                
				switch ($entidad) {
					case 'motor':
						break;
					default:

						if(!isset($_SESSION[NAME_SESS_USER]["id_usuario"])){
                            if (!class_exists("Index") and !class_exists("Login") and !class_exists("Security")) {
								header('location:'.URL_LOGIN_APP);
								exit();
							}
						}
						break;
				}
			}
			else {
	            //Cuando el archivo controlador no existe...
				require './Controller/error_controller.php';
				$error=new error();
				$error->index();
				return false;  //Finalizamos el llamado al metodo
			}
	
			//Preguntar si existe un action
			if($param6){
				$controller->{$metodo}($param1,$param2,$param3,$param4,$param5,$param6);
			}
            elseif($param5){
				$controller->{$metodo}($param1,$param2,$param3,$param4,$param5);
			}
            elseif($param4){
				$controller->{$metodo}($param1,$param2,$param3,$param4);
			}
			elseif($param3){
				$controller->{$metodo}($param1,$param2,$param3);
			}
			elseif($param2){
				$controller->{$metodo}($param1,$param2);
			}
			elseif($param1){
				$controller->{$metodo}($param1);
			}
			else{
				if(method_exists($controller,$metodo)){
					$controller->{$metodo}();  //Llamamos a un action
				}else{
					require './Controller/error_controller.php';
					$error=new Error();
					$error-> errorMetodo();
					return false;  //Finalizamos el llamado al metodo
				}
			}
		}catch(Exception $e){
            throw $e;
        }
	}//End Construct
}
?>