<?php

/**
 * 
 */


Class Controller {

    protected $_view;
    protected $_request;

    public function __construct() {
        $this->_view = new View();
        $this->_request = new Request();
        if ($this->isAccesoApp()) {
            $usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];
            $IdSistema = $_SESSION[NAME_SESS_USER]["IdSistema"];
            $this->showMenu($usuario, $IdSistema);
        }

        if (isset($_SESSION[NAME_SESS_USER]["id_usuario"])) {
            $this->_view->assign("NAME_USER", $_SESSION[NAME_SESS_USER]["id_usuario"]);
        }
    }

    public function isPost() {
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }

    public function isGet() {
        return ($_SERVER['REQUEST_METHOD'] == 'GET');
    }

    public function showMenu($usuario = '', $idSitema = '') {

        $apilogin = new ApiLogin();
        $menu = $apilogin->GetMenuUsuario($usuario, $idSitema);
        if(isset($menu->result) && $menu->result == true){
            $array_padre = array();
            foreach ($menu->data as $elemento) {
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
            }

            foreach ($menu->data as $value) {
                $class_active = "";
                $class_active_padre = "";
                if(($this->_request->getMetodo())!="index"){
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
                }
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
           
            $this->_view->assign('menu', $data);
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
                $link = BASE_URL . $menu['link'];
                
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

    protected function redireccionar($ruta = false) {
        if ($ruta) {
            header('location:' . BASE_URL . $ruta);
            exit();
        } else {
            header('location:' . BASE_URL);
            exit();
        }
    }

    public function verificarAccess() {
        if (!Session::get('token')) {
            return false;
        }
        return true;
    }
    
    function validNumero($valor){
        if(is_numeric($valor)){
            return true;
       }else{
            return false;
       }
    }
    
    function conversorSegundosHoras($tiempo_en_segundos) {
        $horas = floor($tiempo_en_segundos / 3600);
        $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
        $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
        
        if($horas==0){
            $horas = '00';
        }
        if($minutos==0){
            $minutos = '00';
        }
        if($segundos==0){
            $segundos = '00';
        }
        return $horas . ':' . $minutos;
    }
    
    function diferencia_entre_minutos($hora1,$hora2,$operacion="resta"){
        $minutos_array1 = explode(":", $hora1);
        $minutos_array2 = explode(":", $hora2);
        
        $minutos1 = ($minutos_array1[0]*60)+$minutos_array1[1];
        $minutos2 = ($minutos_array2[0]*60)+$minutos_array2[1];
        if($operacion=="resta"){
            $dif_minutos = $minutos2-$minutos1;
        }
        if($operacion=="suma"){
            $dif_minutos = $minutos2+$minutos1;
        }
        
        return $dif_minutos;
    }
    
    function isAccesoApp(){
        
        if(isset($_SESSION[NAME_SESS_USER]) && count($_SESSION[NAME_SESS_USER])>0){
            return true;
        }else{
            return false;
        }
        
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