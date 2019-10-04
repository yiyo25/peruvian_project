<?php
session_start();
class alertasEdit_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
		
	public function listarAlertas(){
		
		try{			
			$sql_1 = "	SELECT 	[alerta_id]
						      	,[alerta_descripcion]
						      	,[alerta_asunto]
						      	,[alerta_mensaje]
						      	,[alerta_correo_origen]
						      	,[alerta_correo_copia]
						      	,[alerta_tiempo_dia]
						      	,[alerta_estado]
						FROM  	[db_std].[Alertas]
						WHERE 	[alerta_estado] = 1
						ORDER	BY	[alerta_descripcion] ASC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function cargaAlertas($alerta_id){		
		try{
			
			$sql_1 = "	SELECT 	[alerta_id]
						      	,[alerta_descripcion]
						      	,[alerta_asunto]
						      	,[alerta_mensaje]
						      	,[alerta_correo_origen]
						      	,[alerta_correo_copia]
						      	,[alerta_tiempo_dia]
						      	,[alerta_estado]
						FROM  	[db_std].[Alertas]
						WHERE 	[alerta_id] = ".$alerta_id;
													
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
	        throw $e;
		}
	}
	
	public function editarRegistro($alerta_asunto,$alerta_mensaje,$alerta_correo_origen,$alerta_correo_copia,$alerta_tiempo_dia,$alerta_estado,$alerta_id){
		try{
			
			$sql_1 = "	UPDATE 	[db_std].[Alertas]
					   	SET 	[alerta_asunto] = ?,
						      	[alerta_mensaje] = ?,
						      	[alerta_correo_origen] = ?,
						     	[alerta_correo_copia] = ?,
						      	[alerta_tiempo_dia] = ?,
						      	[alerta_estado] = ?
					 	WHERE 	[alerta_id] = ?";
			$param_1 = 	array(utf8_decode($alerta_asunto),utf8_decode($alerta_mensaje),$alerta_correo_origen,$alerta_correo_copia,$alerta_tiempo_dia,$alerta_estado,$alerta_id);
 					  
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	 }	
	 
	 public function EliminarAlerta($id){
		try{
			
			$sql_1 = "	UPDATE 	[db_std].[Alertas]
					   	SET 	[alerta_estado] = '0'
					 	WHERE 	[alerta_id] = ?";
			
			$param_1 = 	array($_id);
			
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}			
}
?>