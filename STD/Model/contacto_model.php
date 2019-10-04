<?php
session_start();
class contacto_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
	
	public function listarContactos($PageSize,$PageNumber){
		
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_PAGINACION_CONTACTO ?,?";
			$param_1 = 	array($PageSize,$PageNumber);	
				
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function listarContactoTotal($Con_tipo='',$Con_descripcion='',$Con_area='',$Con_cargo=''){
		
		try{
			
			$sql_1 = "	SELECT	[contac_id],
								[contac_nombre],								
								[areatrab_id],
								[area].[area_descripcion],
								[cargocontac_id],
								[cargo].[cargo_descripcion],
								[empcontac_id],
								[emp].[emp_razonsocial],
								[contac_tipo],
								[contac_dni],
								tipo_contacto = case
								WHEN contac_tipo = 'I' THEN 'Interno' ELSE 'Externo'END,
								[contac_tipo],
								[contac_estado],
								[contac_usu_reg],
								[contac_fec_reg],
								[contac_usu_mod],
								[contac_fec_mod],
								[contact_correo]
						FROM	[db_std].[Contacto] con
						LEFT	JOIN [db_std].[Area] area ON area.area_id = con.areatrab_id
						LEFT	JOIN [db_std].[Cargo] cargo ON cargo.cargo_id = con.cargocontac_id
						INNER	JOIN [db_std].[Empresa] emp	ON	emp.emp_id = con.empcontac_id";
						
				if ($Con_tipo <> '' OR $Con_descripcion <> '' OR $Con_area <> '' OR $Con_cargo <> '') {				
					
					$sql_1.= " WHERE ";
					
					$existecondicional = FALSE;
					if($Con_tipo <> ''){
						$sql_1 .= "[contac_tipo]  = '".$Con_tipo."'";
						$existecondicional = TRUE;
					}
					if($Con_descripcion <> ''){
						$sql_1 .= ($existecondicional?" AND ":" ")."[contac_nombre] like '%".$Con_descripcion."%'";
						$existecondicional = TRUE;
					}
					if($Con_area <> ''){
						$sql_1 .= ($existecondicional?" AND ":" ")."[area].[area_descripcion] = '".$Con_area."'";
						$existecondicional = TRUE;
					}
					if($Con_cargo <> '' ){
						$sql_1 .= ($existecondicional?" AND ":" ")."[cargo].[cargo_descripcion] = '".$Con_cargo."'";
						$existecondicional = TRUE;
					}
					
				}
				
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function BuscarContactos($Con_tipo,$Con_descripcion,$Con_area,$Con_cargo,$PageSize,$PageNumber)
	{
		
		try{
			
			$sql_base = "	SELECT	[contac_id],
									[contac_nombre],
									[areatrab_id],
									[area_descripcion],
									[cargocontac_id],
									[cargo_descripcion],
									[empcontac_id],
									[emp_razonsocial],
									[contac_tipo],
									[contac_dni],
									[tipo_contacto],
									[contac_estado],
									[contac_usu_reg],
									[contac_fec_reg],
									[contac_usu_mod],
									[contac_fec_mod],
									[contact_correo]
							FROM (
									SELECT	[contac_id],
											[contac_nombre],
											[areatrab_id],
											[area].[area_descripcion] AS [area_descripcion],
											[cargocontac_id],
											[cargo].[cargo_descripcion] AS [cargo_descripcion],
											[empcontac_id],
											[emp].[emp_razonsocial] AS [emp_razonsocial],
											[contac_tipo],
											[contac_dni],
											tipo_contacto = case
											WHEN contac_tipo = 'I' THEN 'Interno' ELSE 'Externo'END,
											[contac_estado],
											[contac_usu_reg],
											[contac_fec_reg],
											[contac_usu_mod],
											[contac_fec_mod],
											[contact_correo],
											ROW_NUMBER() OVER (ORDER BY [contac_id]) AS RowNumber
									FROM	[db_std].[Contacto] con
									LEFT	JOIN [db_std].[Area] area ON area.area_id = con.areatrab_id
									LEFT	JOIN [db_std].[Cargo] cargo ON cargo.cargo_id = con.cargocontac_id
									INNER	JOIN [db_std].[Empresa] emp	ON	emp.emp_id = con.empcontac_id";
			
			if($Con_tipo <> '' or $Con_descripcion <> '' or $Con_area <> '' or $Con_cargo <> '')
			
			{
				$sql_base .= " WHERE ";
				
				$existecondicional = FALSE;
				if($Con_tipo <> ''){
					$sql_base .= "[contac_tipo]  = '".$Con_tipo."'";
					$existecondicional = TRUE;					
				}
				if($Con_descripcion <> ''){
					$sql_base .= ($existecondicional?" and ":" ")."[contac_nombre] like '%".$Con_descripcion."%' ";
					$existecondicional = TRUE;
				}
				if($Con_area <> ''){
					$sql_base .= ($existecondicional?" and ":" ")."[area].[area_descripcion] = '".$Con_area."'";
					$existecondicional = TRUE;
				}
				if($Con_cargo <> ''){
					$sql_base .= ($existecondicional?" and ":" ")."[cargo].[cargo_descripcion] = '".$Con_cargo."'";
					$existecondicional = TRUE;
				}
			}
			
			$sql_base.=") AS Contacto";	
			$sql_base.=" WHERE	RowNumber BETWEEN (".$PageSize."*".$PageNumber." + 1) AND (".$PageSize."*(".$PageNumber." + 1))";
									 
			$result = $this->database_tramite->Consultar($sql_base);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function GrabarContacto($contac_nombre,$areatrab_id,$cargocontac_id,$empcontac_id,$contac_tipo,$contac_estado,$contac_usu_reg,$contac_fec_reg,$contact_correo){
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_INSERT_CONTACTO ?,?,?,?,?,?,?,?,?";
			$param_1 = 	array(utf8_decode($contac_nombre),$areatrab_id,$cargocontac_id,$empcontac_id,utf8_decode($contac_tipo),$contac_estado,utf8_decode($contac_usu_reg),$contac_fec_reg,utf8_decode($contact_correo));	
			
			$this->database_tramite->Ejecutar($sql_1,$param_1);
			
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function EliminarContacto($contac_id){
		try{
			
			$sql_1 = "	DELETE FROM [db_std].[Contacto]
						WHERE [contac_id]=".$contac_id."";
			
			$this->database_tramite->Ejecutar($sql_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function ContactoUpdate($contac_nombre,$contac_correo,$contac_tipo,$cargocontac_id,$contac_estado,$contac_usu_mod,$contac_fec_mod,$contac_id){
		try{
			
			$sql_1 = "	UPDATE	[db_std].[Contacto]
						   SET	[contac_nombre] = ?,						   		
						   		[contact_correo] = ?,
								[contac_tipo] = ?,
								[cargocontac_id] = ?,		
								[contac_estado] = ?,
								[contac_usu_mod] = ?,
								[contac_fec_mod] = ?
						 WHERE	[contac_id] = ?";
			$param_1 = array(utf8_decode($contac_nombre),$contac_correo,utf8_decode($contac_tipo),$cargocontac_id,$contac_estado,utf8_decode($contac_usu_mod),$contac_fec_mod,$contac_id);
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function EmpresasTotal(){		
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
  						FROM 	[db_std].[Empresa]
  						ORDER	BY [emp_razonsocial] ASC";	
													
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function AreasTotal(){		
		try{			
			$sql_1 = "	SELECT 	[area_id],
								UPPER([area_descripcion]) [area_descripcion],
								[area_estado],
								[area_usu_reg],
								[area_fec_reg],
								[area_usu_mod],
								[area_fec_mod]
  						FROM 	[db_std].[Area]
  						ORDER	BY [area_descripcion] ASC";			
										
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	Public function CargosTotal(){		
		try{			
			$sql_1 = "	SELECT 	[cargo_id],
								UPPER([cargo_descripcion]) [cargo_descripcion],
								[cargo_estado],
								[cargo_usu_reg],
								[cargo_fec_reg],
								[cargo_usu_mod],
								[cargo_fec_mod]
  						FROM 	[db_std].[Cargo]
  						ORDER	BY [cargo_descripcion] ASC";
						
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
		
		
}
?>