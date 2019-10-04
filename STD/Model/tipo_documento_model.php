<?php
session_start();
class tipo_documento_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
	
	public function listarDocumentos($PageSize,$PageNumber){
		
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_PAGINACION_DOCUMENTOS ?,?";
			$param_1 = 	array($PageSize,$PageNumber);	
				
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function listarDocumentoTotal($Doc_descripcion=''){
		
		try{
			
			$sql_1 = "	SELECT 	[td_id],
								[td_descripcion],
								[td_estado],
								[td_usu_reg],
								[td_fec_reg],
								[td_usu_mod],
								[td_fec_mod] 
						FROM 	[db_std].[TipoDocumento]";
						
			if ($Doc_descripcion <> '' ) {
					$busqueda = " [td_descripcion] like '%".$Doc_descripcion."%'";
					
					$sql_1.= " WHERE ".$busqueda;
				
				}
			
			$sql_1.= " ORDER BY [td_descripcion] ASC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function BuscarDocumentos($Doc_descripcion,$PageSize,$PageNumber)
	{
		try{
			if ($Doc_descripcion <> '') {
				$busqueda = "[td_descripcion] like ?";
				$param_1 = array("%".utf8_decode($Doc_descripcion)."%");
			} 
			
			$sql_1 = "	SELECT	[td_id],
								[td_descripcion],
								[td_estado],
								[td_usu_reg],
								[td_fec_reg],
								[td_usu_mod],
								[td_fec_mod],
								[td_bloqueo],
								[td_correlativo],
								[td_abreviacion]
						FROM (
								SELECT 	[td_id],
										[td_descripcion],
										[td_estado],
										[td_usu_reg],
										[td_fec_reg],
										[td_usu_mod],
										[td_fec_mod],
										[td_bloqueo],
										[td_correlativo],
										[td_abreviacion],
										ROW_NUMBER() OVER (ORDER BY [td_id]) AS RowNumber
								FROM 	[db_std].[TipoDocumento]
								WHERE 	".$busqueda;
			
			$sql_1.=") AS Documento";	
			$sql_1.=" WHERE	RowNumber BETWEEN (".$PageSize."*".$PageNumber." + 1) AND (".$PageSize."*(".$PageNumber." + 1))";
			
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
	
	public function GrabarDocumento($td_descripcion,$td_estado,$td_usu_reg,$td_fec_reg,$td_bloqueo,$td_correlativo,$td_abreviacion){
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_INSERT_DOCUMENTO ?,?,?,?,?,?,?";
			$param_1 = array(utf8_decode($td_descripcion),$td_estado,utf8_decode($td_usu_reg),$td_fec_reg,utf8_decode($td_bloqueo),$td_correlativo,utf8_decode($td_abreviacion));
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function EliminarDocumento($td_id){
		try{
			
			$sql_1 = "	DELETE FROM [db_std].[TipoDocumento]
						WHERE [td_id]=".$td_id;
			
			$this->database_tramite->Ejecutar($sql_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function UpdateDocumento($td_descripcion,$td_estado,$td_usu_mod,$td_fec_mod,$td_bloqueo,$td_correlativo,$td_abreviacion,$td_id){
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_UPDATE_TIPO_DOCUMENTO ?,?,?,?,?,?,?,?";
			$param_1 = array(utf8_decode($td_descripcion),$td_estado,utf8_decode($td_usu_mod),$td_fec_mod,utf8_decode($td_bloqueo),$td_correlativo,utf8_decode($td_abreviacion),$td_id);
			
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
		 throw $e;	
		}
	} 	
	
	public function validaNombreDoc($documento) {
		try {
			$sql = "SELECT	[td_descripcion]
					  FROM	[db_std].[TipoDocumento]
					 WHERE	[td_descripcion] = '".$documento."'";
			
			$result =  $this->database_tramite->Consultar($sql);
			return $result;
		} catch (Exception $e){
            throw $e;
		}
	}	
}
?>