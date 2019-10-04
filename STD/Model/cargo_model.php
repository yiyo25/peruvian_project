<?php
session_start();
class cargo_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
	
	public function listarCargos($PageSize,$PageNumber){
		
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_PAGINACION_CARGO ?,?";
			$param_1 = 	array($PageSize,$PageNumber);	
				
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function listarCargoTotal($Cargo_descripcion=''){
		
		try{
			
			$sql_1 = "	SELECT 	[cargo_id],
								UPPER([cargo_descripcion]) [cargo_descripcion],
								[cargo_estado],
								[cargo_usu_reg],
								[cargo_fec_reg],
								[cargo_usu_mod],
								[cargo_fec_mod]
  						FROM 	[db_std].[Cargo]";
			
			if ($Cargo_descripcion <> '' ) {
				$busqueda = " [cargo_descripcion] like '%".$Cargo_descripcion."%'";
				
				$sql_1.= " WHERE ".$busqueda;
				
				}
				
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function BuscarCargo($Cargo_descripcion,$PageSize,$PageNumber){
		try{
			if ($Cargo_descripcion <> '') {
				$busqueda = "[cargo_descripcion] like ?";
				$param_1 = array("%".utf8_decode($Cargo_descripcion)."%");				
			} 
			
			$sql_1 = "	SELECT	[cargo_id],
								[cargo_descripcion],
								[cargo_estado],
								[cargo_usu_reg],
								[cargo_fec_reg],
								[cargo_usu_mod],
								[cargo_fec_mod]
						FROM (
						SELECT	[cargo_id],
								[cargo_descripcion],
								[cargo_estado],
								[cargo_usu_reg],
								[cargo_fec_reg],
								[cargo_usu_mod],
								[cargo_fec_mod],
								ROW_NUMBER() OVER (ORDER BY [cargo_id]) AS RowNumber	
						FROM	[db_std].[Cargo] WHERE ".$busqueda;
			
			$sql_1.=") AS Cargo";	
			$sql_1.=" WHERE	RowNumber BETWEEN (".$PageSize."*".$PageNumber." + 1) AND (".$PageSize."*(".$PageNumber." + 1))";
			
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
	
	public function GrabarCargo($cargo_descripcion,$cargo_estado,$cargo_usu_reg,$cargo_fec_reg){
		try{
			
			$sql_1 = "	INSERT INTO [db_std].[Cargo]
						           	([cargo_descripcion]
						           	,[cargo_estado]
						           	,[cargo_usu_reg]
						          	,[cargo_fec_reg])
				     	VALUES (?,?,?,?)";
			$param_1 = array(utf8_decode($cargo_descripcion),$cargo_estado,utf8_decode($cargo_usu_reg),$cargo_fec_reg);
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function EliminarCargo($cargo_id){
		try{
			
			$sql_1 = "	DELETE FROM [db_std].[Cargo]
						WHERE [cargo_id]=".$cargo_id."";
			
			$this->database_tramite->Ejecutar($sql_1);
		}catch(Exception $e){
         throw $e;
		}
	}
	
	public function UpdateCargo($cargo_descripcion,$cargo_estado,$cargo_usu_mod,$cargo_fec_mod,$cargo_id){
		try{
			
			$sql_1 = "	UPDATE	[db_std].[Cargo]
						   SET	[cargo_descripcion] = ?,
								[cargo_estado] = ?,
								[cargo_usu_mod] = ?,
      							[cargo_fec_mod] = ?
						 WHERE	cargo_id = ?";
 			$param_1 = array(utf8_decode($cargo_descripcion),$cargo_estado,$cargo_usu_mod,$cargo_fec_mod,$cargo_id);
				 					  
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	 }	
}
?>