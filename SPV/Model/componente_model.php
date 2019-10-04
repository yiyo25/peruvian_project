<?php
if( !isset($_SESSION)){
	session_start();
}

class Componente_model extends Model {
	
	public function __construct(){
		parent::__construct();
	}
    
	public function ListarComponenteMenu($IdAplicacion,$UsuarioId,$TipoComponente){
		try{
            $webServicesSeguridad = new WsSeguridad();
            
            $CompMenu = $webServicesSeguridad->ListarComponentes($IdAplicacion,$UsuarioId,$TipoComponente);
            $objMenu = $CompMenu["ListarComponentesResult"]["Componentes"]["cComponente"];
            foreach ($objMenu as $key => $row) { $aux[$key] = $row['Orden']; }
            array_multisort($aux, SORT_ASC, $objMenu);
            return $objMenu;
        }catch(Exception $e){
            throw $e;
        }
	}
}
?>