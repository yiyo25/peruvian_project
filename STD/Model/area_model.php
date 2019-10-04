<?php
session_start();
class area_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
	
	public function listarAreas($PageSize,$PageNumber){
		
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_PAGINACION_AREA ?,?";
			$param_1 = 	array($PageSize,$PageNumber);	
				
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function listarAreasTotal($Area_descripcion=''){
		
		try{
			
			$sql_1 = "	SELECT 	[area_id],
								UPPER([area_descripcion]) [area_descripcion],
								[area_estado],
								[area_usu_reg],
								[area_fec_reg],
								[area_usu_mod],
								[area_fec_mod]
  						FROM 	[db_std].[Area] ";
			
				if ($Area_descripcion <> '' ) {
					$busqueda = " [area_descripcion] like '%".$Area_descripcion."%'";
					
					$sql_1.= " WHERE ".$busqueda;
				
				}
											
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function BuscarArea($Area_descripcion,$PageSize,$PageNumber){
		try{
			if ($Area_descripcion <> '') {
				$busqueda = "[area_descripcion] like ?";
				$param_1 = array("%".utf8_decode($Area_descripcion)."%");
			} 
			
			$sql_1 = "	SELECT	[area_id],
								[area_descripcion],
								[area_estado],
								[area_usu_reg],
								[area_fec_reg],
								[area_usu_mod],
								[area_fec_mod]
						FROM (
								SELECT	[area_id],
										[area_descripcion],
										[area_estado],
										[area_usu_reg],
										[area_fec_reg],
										[area_usu_mod],
										[area_fec_mod],
										ROW_NUMBER() OVER (ORDER BY [area_id]) AS RowNumber	
								FROM	[db_std].[Area]
								WHERE 	".$busqueda;
			$sql_1.=") AS Area";	
			$sql_1.=" WHERE	RowNumber BETWEEN (".$PageSize."*".$PageNumber." + 1) AND (".$PageSize."*(".$PageNumber." + 1))";
						
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
	
	public function GrabarArea($area_descripcion,$area_estado,$area_usu_reg,$area_fec_reg){
		try{
			
			$sql_1 = "INSERT INTO 	[db_std].[Area]
					              	([area_descripcion]
						           	,[area_estado]
						           	,[area_usu_reg]
						           	,[area_fec_reg])
				     	VALUES (?,?,?,?)";
			$param_1 = array(utf8_decode($area_descripcion),$area_estado,utf8_decode($area_usu_reg),$area_fec_reg);
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function EliminarArea($area_id){
		try{
			
			$sql_1 = "	DELETE FROM [db_std].[Area]
						WHERE [area_id]=".$area_id;
			
			$this->database_tramite->Ejecutar($sql_1);
		}catch(Exception $e){
         throw $e;
		}
	}
	
	public function GrabarEdicion($area_descripcion,$area_estado,$area_usu_mod,$area_fec_mod,$area_id){
		try{
			$sql_1 = "	UPDATE 	[db_std].[Area]
   						SET 	[area_descripcion] = ?,
					      		[area_estado] = ?,
						      	[area_usu_mod] = ?,
						      	[area_fec_mod] = ? 
					   WHERE 	[area_id] = ?";
 			$param_1 = array(utf8_decode($area_descripcion),$area_estado,utf8_decode($area_usu_mod),$area_fec_mod,$area_id);
 					  
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	 }		
}
?>