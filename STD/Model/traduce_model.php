<?php
session_start();
class Traduce_model extends Model {
	public $variables;
	
    public function __construct(){
    	parent::__construct();
	}
    
	// public function listar_todo(){
		// try{
            // $sql = "SELECT idm_campo, idm_texto_sp, idm_texto_en FROM idioma";
			// $options = $this->database_tramite->Consultar($sql);
            // $this->variables = $options;
        // }catch(Exception $e){
            // throw $e;
		// }
	// }
}
?>