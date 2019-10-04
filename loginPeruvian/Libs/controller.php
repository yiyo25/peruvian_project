<?php
class Controller {
	public $view;
	public $model;
    
	function __construct(){
		try{
            $this->view = new View();
		} catch(Exception $e){
            throw $e;
        }
	}
	
	//Cargar el model asociado a un controlador
	public function loadModel($name,$flag=false) {
		try{
			$path='./Model/'.$name.'_model.php';
			if(file_exists($path)){ //si existe el archivo
				if($flag){
					$modelName=$name;
				}
				else{
					if($name<>"error"){
						if (!class_exists($name.'_model')) {
							require './Model/'.$name.'_model.php';
						}
					}
					$modelName=$name.'_model';
				}
				//Instancia del model
				$this->model=new $modelName();
			}
		} catch(Exception $e){
            throw $e;
        }
	}
    
    public static function array_utf8_encode($dat) {
	    if (is_string($dat))
	        return utf8_encode($dat);
	    if (!is_array($dat))
	        return $dat;
	    $ret = array();
	    foreach ($dat as $i => $d)
	        $ret[$i] = self::array_utf8_encode($d);
	    return $ret;
	}
}
?>