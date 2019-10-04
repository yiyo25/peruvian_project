<?php
session_start();
class agregarCopia_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}		
							
	public function listarTramitexUsuario($seg_usuario){		
		try{
			
			$sql_1 = "	SELECT	[tramseg_id],[tram].[tram_nro_doc]
						FROM	[db_std].[SeguimientoDocumentario] [seg]
						INNER	JOIN [db_std].[TramiteDocumentario] [tram] ON [tram].[tram_id] = [seg].[tramseg_id]
						WHERE	[seg_usuarios]  = '".$seg_usuario."' AND seg_estado = 'Recibido'";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
	        throw $e;
		}
	}
	
	public function insert_contacto($tram_id,$seg_fecha_transito,$seg_hora_transito,$seg_usu_transito,$usu_nombre,
									$usu_correo,$usu_numdoc,$area_descripcion,$cargo_descripcion,$usu_numdoc){
		try{			
						
			$sql_1 = "	EXEC dbo.SPP9_GENERAR_COPIA_TRAMITE ?,?,?,?,?,?,?,?,?,?";
			$param_1 = 	array($tram_id,$seg_fecha_transito,$seg_hora_transito,$seg_usu_transito,$usu_nombre,
							  $usu_correo,$usu_numdoc,$area_descripcion,$cargo_descripcion,$usu_numdoc);
 					  
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	 }
	
	public function listarContacto(){
		
		try{
			
			/*$sql_1 = "	SELECT	[usu_id] [contac_id],
								[usu_nombres]+' '+[usu_apellidos] [contac_nombre],
								[usu_numdoc],
								[usu_correo],
								[contac].[area_id] [areatrab_id],
								[are].[area_nombre] [area_descripcion],
								[contac].[cargo_id] [cargocontac_id],
								[car].[cargo_descripcion]
						FROM	[db_segSeguridad].[dbo].[seg_usuarios] contac
						LEFT	JOIN [db_segSeguridad].[dbo].[seg_areas] are ON are.area_id = contac.area_id 
						LEFT	JOIN [db_segSeguridad].[dbo].[seg_cargo] car ON car.cargo_id = contac.cargo_id";*/
			$sql_1 = "SELECT	contac.IdUsuario [contac_id],
                            contac.UserNom+' '+contac.UserApe [contac_nombre],
                            '' usu_numdoc,
                            contac.UserEmail,
                            '' [areatrab_id],
                            '' [area_descripcion],
                            '' [cargocontac_id],
                            '' cargo_descripcion
                    FROM	[db_seguridad].[dbo].[sysUsuarios] contac";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}			  
}
?>