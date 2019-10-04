<?php
session_start();
class empresa_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
	
	public function listarEmpresas($PageSize,$PageNumber){
		
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_PAGINACION_EMPRESA ?,?";
			$param_1 = 	array($PageSize,$PageNumber);	
				
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarEmpresasTotal($Emp_codigo,$Emp_descripcion){
		
		try{
			
			$sql_1 = "	SELECT 	[emp_id],
								[emp_ruc],
								UPPER([emp_razonsocial]) [emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod]
  						FROM 	[db_std].[Empresa]";
  									
			
			if($Emp_codigo <> '' OR $Emp_descripcion <> '') 
			{
				if ($Emp_codigo <> '' and $Emp_descripcion == '') {
					$busqueda = " [emp_ruc] like '%".$Emp_codigo."%'";
				}elseif ($Emp_codigo == '' and $Emp_descripcion <> '') {
					$busqueda = " [emp_razonsocial] like '%".$Emp_descripcion."%'";
				}elseif ($Emp_codigo <> '' and $Emp_descripcion <> '') {
					$busqueda = " [emp_ruc] = '".$Emp_codigo."' and [emp_razonsocial] like '%".$Emp_descripcion."%'";
				}
				
				$sql_1.= " WHERE ".$busqueda;
				
			}
			
													
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function BuscarEmpresa($Emp_codigo,$Emp_descripcion,$PageSize,$PageNumber){
		try{
			if ($Emp_codigo <> '' and $Emp_descripcion == '') {
				$busqueda = " [emp_ruc] like ?";
				$param_1 = array("%".utf8_decode($Emp_codigo)."%");
			}elseif ($Emp_codigo == '' and $Emp_descripcion <> '') {
				$busqueda = " [emp_razonsocial] like ?";
				$param_1 = array("%".utf8_decode($Emp_descripcion)."%");
			}elseif ($Emp_codigo <> '' and $Emp_descripcion <> '') {
				$busqueda = " [emp_ruc] like ? and [emp_razonsocial] like ?";
				$param_1 = array("%".utf8_decode($Emp_codigo)."%","%".utf8_decode($Emp_descripcion)."%");
			}
			
			$sql_1 = "	SELECT	[emp_id],
								[emp_ruc],
								[emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod]
						FROM (
						SELECT	[emp_id],
								[emp_ruc],
								[emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod],
								ROW_NUMBER() OVER (ORDER BY [emp_id]) AS RowNumber	
						FROM	[db_std].[Empresa]
						WHERE	".$busqueda;									
			$sql_1.=") AS Empresa";	
			$sql_1.=" WHERE	RowNumber BETWEEN (".$PageSize."*".$PageNumber." + 1) AND (".$PageSize."*(".$PageNumber." + 1))";
			
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
	
	public function GrabarEmpresa($emp_ruc,$emp_razonsocial,$emp_tipo,$emp_estado,$emp_usu_reg,$emp_fec_reg){
		try{
			$sql_1 = "	EXEC dbo.SPP9_INSERT_EMPRESA ?,?,?,?,?,?";
			$param_1 = array(utf8_decode($emp_ruc),utf8_decode($emp_razonsocial),$emp_tipo,$emp_estado,utf8_decode($emp_usu_reg),$emp_fec_reg);
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function EliminarEmpresa($emp_id){
		try{
			
			$sql_1 = "	UPDATE [db_std].[Empresa]
						   SET [emp_estado] = 0      
						 WHERE [emp_id]=".$emp_id;
			
			$this->database_tramite->Ejecutar($sql_1);
		}catch(Exception $e){
         throw $e;
		}
	}
	public function UpdateEmpresa($emp_ruc,$emp_razonsocial,$emp_tipo,$emp_estado,$emp_usu_mod,$emp_fec_mod,$emp_id){
		try{
			$sql_1 = "	UPDATE 	[db_std].[Empresa]
						SET 	[emp_ruc] = ?,
						      	[emp_razonsocial] = ?,
						      	[emp_tipo] = ?,
						      	[emp_estado] = ?,
						      	[emp_usu_mod] = ?,
						      	[emp_fec_mod] = ?
					   WHERE 	[emp_id] = ?";
 			$param_1 = array($emp_ruc,utf8_decode($emp_razonsocial),utf8_encode($emp_tipo),$emp_estado,utf8_decode($emp_usu_mod),$emp_fec_mod,$emp_id);
 					  
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	 }
	
	public function ValidaNombre($emp_razonsocial) {
		try {
			$sql = "SELECT	[emp_razonsocial] 
					FROM 	[db_std].[Empresa]
					WHERE	[emp_razonsocial] = '".$emp_razonsocial."'";
			
			$result =  $this->database_tramite->Consultar($sql);
			return $result;
		} catch (Exception $e){
            throw $e;
		}
	}
}
?>