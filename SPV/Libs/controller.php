<?php
class Controller {
	public $view;
	public $model;
    
	function __construct(){
		try{
			//echo "aa";Exit;
            $this->view = new View();
            if ($this->isAccesoApp()) {

	            $usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];
	            $this->view->objUsu =$usuario;
	            $IdSistema = $_SESSION[NAME_SESS_USER]["IdSistema"];
	            $this->view->objMenu = "";
	            $this->showMenu($usuario, $IdSistema);
                $this->view->texto = "No hay Datos";
               
	        }
            //$this->view->objMenu = $_SESSION["objMenu"];
            //$this->view->objUsu = $_SESSION["objUsu"];
           // $this->view->objBotton = $_SESSION["objBotton"];
            //$this->view->objTab = $_SESSION["objTab"];
           
            //echo "<pre>".print_r($this->view->objBotton,true)."</pre>";die();
			//echo "Estoy en el controlador principal...";
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
    
    function conversorSegundosHoras($tiempo_en_segundos) {
        $horas = floor($tiempo_en_segundos / 3600);
        $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
        $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

        return $horas . ':' . $minutos;
    }

    protected function redireccionar($ruta = false) {
        if ($ruta) {
            header('location:' . URLLOGICA . $ruta);
            exit();
        } else {
            header('location:' . URLLOGICA);
            exit();
        }
    }

    function isAccesoApp(){
        
        if(isset($_SESSION[NAME_SESS_USER]) && count($_SESSION[NAME_SESS_USER])>0){
            return true;
        }else{
            return false;
        }
        
    }

    public function showMenu($usuario = '', $idSitema = '') {

        $apilogin = new ApiLogin();
        $menu = $apilogin->GetMenuUsuario($usuario, $idSitema);
        if(isset($menu->result) && $menu->result == true){
            $array_padre = array();
            /*foreach ($menu->data as $elemento) {
                if(($this->_request->getMetodo())!="index"){
                    $ruta = strtolower($this->_request->getControlador())."/".strtolower($this->_request->getMetodo());
                    if($ruta==$elemento["comp_funcion"]){
                        if ($elemento['comp_predecesor'] != 0) {
                            $array_padre[] = $elemento["comp_predecesor"];
                        }
                    }
                }else{
                    if(strtolower($this->_request->getControlador())==$elemento["comp_funcion"]){
                        if ($elemento['comp_predecesor'] != 0) {
                            $array_padre[] = $elemento["comp_predecesor"];
                        }
                    }
                }
            }*/

            foreach ($menu->data as $value) {
                $class_active = "";
                $class_active_padre = "";
                /*if(($this->_request->getMetodo())!="index"){
                    $ruta = strtolower($this->_request->getControlador())."/".strtolower($this->_request->getMetodo());
                    if($ruta==$value["comp_funcion"]){
                        $class_active = "active";
                    }
                }else{
                    if(strtolower($this->_request->getControlador())==$value["comp_funcion"]){
                        $class_active = "active";
                    }
                }
                
                if(in_array($value["IdMenu"], $array_padre)){
                    $class_active_padre = "active";
                    $class_active = "";
                }
                
                if(in_array($value["comp_predecesor"], $array_padre)){
                    $class_active_padre = "";
                    $class_active = "";
                }*/
                $array_menu[] = array(
                    'id' => $value["IdMenu"],
                    'nombre' => utf8_encode($value["comp_descripcion"]),
                    'link' => $value["comp_funcion"],
                    'parent_id' => $value["comp_predecesor"],
                    "class_active"=>$class_active,
                    "class_active_padre" => $class_active_padre
                );
            }
            $data = $this->buildTreeHtml($array_menu);
           	$this->view->objMenu = $data;
            //$this->_view->assign('menu', $data);
        }
        
    }

    function buildTreeHtml($data, $padre = 0, $htmlmenu = "") {
        $arr = array();
        // Sacando elementos hijos del padre indicado
        foreach ($data as $elem) {
            if ($elem['parent_id'] == $padre) {
                $arr[] = $elem;
            }
        }

        if (count($arr) > 0) {

            if ($padre > 0) {
                $htmlmenu .= "<ul class='treeview-menu menu-open'>";
            }
            foreach ($arr as $menu) {
                // Busco si el elemento tiene hijos
                $htmlmenuhijo = $this->buildTreeHtml($data, $menu['id']);
                $flecha = "";
                $icon = '';
                $link = URLLOGICA . $menu['link'];
                
                if ($htmlmenuhijo != "") {
                    $flecha = '<span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>';
                    $icon = '<i class="fa fa-link"></i>';
                    $link = '#';
                }
                $htmlmenu .= "<li class='treeview ".$menu["class_active"]." ".$menu["class_active_padre"]."'>"
                        . "<a href='" . $link . "'>" 
                        . "<i class='fa fa-link'></i><span>" . $menu['nombre'] . "</span>"
                        . $flecha
                        . "</a>";

                $htmlmenu .= $htmlmenuhijo;
                $htmlmenu .= "</li>";
            }
            if ($padre > 0) {
                $htmlmenu .= "</ul>";
            }
        }

        return $htmlmenu;
    }

    function isAccessProgram($programa,$tipo){
        
        $apilogin = new ApiLogin();
        $usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];
        $acceso = $apilogin->GetAccesoProgExec($usuario,$programa,$tipo);
       
        if(isset($acceso->result) && $acceso->result == true){
            return true;
        }else{
            return false;
        }
    }

    function PermisosporPaginas($programa,$tipo){
        $apilogin = new ApiLogin();
        $usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];
        $acceso = $apilogin->GetPermisosProgporPaginas($usuario,$programa,$tipo);
        return $acceso->permisos;
        
    }

    function getAllPermisos($usuario,$tipo=1){
        $apilogin = new ApiLogin();
        
        $acceso = $apilogin->getAllPermisos($usuario,$tipo);
        return $acceso->permisos;
        
    }
}
?>