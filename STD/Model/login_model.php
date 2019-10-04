<?php
session_start();
class Login_model extends Model {
	
	public $acceso;
	
    public function __construct(){
		parent::__construct();
	}
    
	public function verificarAcceso($usuario,$password){
		try{
			$sql_1 = "	SELECT 	u.*
						FROM 	[db_segSeguridad].[dbo].[seg_usuarios] u
						WHERE 	usu_usuario = ? and usu_password = (SELECT CONVERT(NVARCHAR(32),HashBytes('MD5', ?),2));";
			$param_1 = array($usuario,$password);
			$this->acceso = $this->database_seg->Consultar($sql_1, $param_1);
        }catch(Exception $e){
            throw $e;
        }
	}
}
?>