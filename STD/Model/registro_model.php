<?php
session_start();
class registro_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
	
	public function insertarRegistro(	$td_id,$tram_nro_doc,$tram_fec_doc,$tram_asunto,$tram_tip_ent,$emptram_id,$contactram_id,
					  					$tram_prioridad,$tram_fec_resp,$tram_usu_reg,$tram_fec_reg,$seg_hora_reg,$usu_numdoc,
					  					$usu_nomb,$usu_ape,$tram_ruta_doc,$email,$name,$area_descripcion,$cargo_descripcion,
										$usu_correo,$usu_numdocI,$usu_nombre,$usu_area,$usu_cargo,$identificador,$bloqueo,$nro_referencia,
										$tipo_referencia,$tipo_referencia_id,$correo_copia){
			try{
				$sql_1 = "	EXEC dbo.SPP9_TRAMITE_DOCUMENTARIO ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
				//echo $sql_1;Exit;
				$param_1 = 	array(	$td_id,utf8_decode($tram_nro_doc),$tram_fec_doc,utf8_decode($tram_asunto),utf8_decode($tram_tip_ent),
									$emptram_id,$contactram_id,utf8_decode($tram_prioridad),$tram_fec_resp,utf8_decode($tram_usu_reg),
									$tram_fec_reg,$seg_hora_reg,$usu_numdoc,$usu_nomb,$usu_ape,$tram_ruta_doc,utf8_decode($email),utf8_decode($name),
									utf8_decode($area_descripcion),utf8_decode($cargo_descripcion),utf8_decode($usu_correo),$usu_numdocI,utf8_decode($usu_nombre),
									$usu_area,$usu_cargo,$identificador,$bloqueo,$nro_referencia,$tipo_referencia,$tipo_referencia_id,utf8_decode($correo_copia));
							
				$result =  $this->database_tramite->Consultar($sql_1,$param_1);
				return ($result[0][0]);				
	        } catch(Exception $e){
	            throw $e;
			}
	}
										
	public function filtrar_contacto($empresa_id) {
		try {
			if ($empresa_id == 1){
				/*$sql = "SELECT	[usu_id] [contac_id], [usu_apellidos]+' '+[usu_nombres] [contac_nombre],
								[usu_numdoc] [contac_dni], [area_id] [areatrab_id], [cargo_id] [cargocontac_id],
								[usu_correo] [contac_correo] 
						FROM 	[db_segSeguridad].[dbo].[seg_usuarios]";*/
				$sql = "SELECT	contac.IdUsuario [contac_id],
                        contac.UserNom+' '+contac.UserApe [contac_nombre],
                        '' contac_dni ,
                        contac.UserEmail contac_correo,
                        0 [areatrab_id],
                        contac.UserAre [area_descripcion],
                        0 [cargocontac_id],
                        contac.UserCar cargo_descripcion
                FROM	[db_seguridad].[dbo].[sysUsuarios] contac";
			}else{
				$sql = " SELECT * FROM [db_std].[Contacto] WHERE empcontac_id = ".$empresa_id;
			}			
			
			$result = $this->database_tramite->Consultar($sql);
			
			return $result;
		} catch (Exception $e){
            throw $e;
		}
	}
	
	public function filtrar_area_cargo($contacto_id,$empresa_id) {
		try {
			
			if(!is_numeric($contacto_id)){
				return FALSE;
			}
			
			if ($empresa_id == 1){
				/*$sql = "SELECT	[usu_id] [contac_id],
								[usu_nombres]+' '+[usu_apellidos] [contac_nombre],
								[usu_numdoc],
								[usu_correo],
								[contac].[area_id] [areatrab_id],
								[are].[area_nombre] [area_descripcion],
								[contac].[cargo_id] [cargocontac_id],
								[car].[cargo_descripcion]
						FROM	[db_segSeguridad].[dbo].[seg_usuarios] contac
						LEFT	JOIN [db_segSeguridad].[dbo].[seg_areas] are ON are.area_id = contac.area_id 
						LEFT	JOIN [db_segSeguridad].[dbo].[seg_cargo] car ON car.cargo_id = contac.cargo_id
						WHERE	[usu_id] = ".$contacto_id;*/
                $sql = "SELECT	contac.IdUsuario [contac_id],
                                contac.UserNom+' '+contac.UserApe [contac_nombre],
                                '' usu_numdoc ,
                                contac.UserEmail usu_correo,
                                0 [areatrab_id],
                                contac.UserAre [area_descripcion],
                                0 [cargocontac_id],
                                contac.UserCar cargo_descripcion
                        FROM	[db_seguridad].[dbo].[sysUsuarios] contac
                        WHERE   contac.IdUsuario='".$contacto_id."'";
			}else{
				$sql = "  SELECT	[contac_id],
									[contac_nombre],
									[areatrab_id],
									[are].[area_descripcion],
									[cargocontac_id],
									[car].[cargo_descripcion]
							FROM	[db_std].[Contacto] contac
							LEFT	JOIN [db_std].[Area] are ON are.area_id = contac.areatrab_id 
							LEFT	JOIN [db_std].[Cargo] car ON car.cargo_id = contac.cargocontac_id
							WHERE	[contac_id] = ".$contacto_id;
			}
							
			$result = $this->database_tramite->Consultar($sql);
			
			return $result;
		} catch (Exception $e){
            throw $e;
		}
	}
	
	public function listarEmpresasTotal(){
		
		try{
			
			$sql_1 = "	SELECT 	[emp_id],
								[emp_ruc],
								[emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod]
						FROM 	[db_std].[Empresa]
						ORDER	BY 1 DESC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarEmpresas(){
		
		try{
			
			$sql_1 = "	SELECT 	[emp_id],
								[emp_ruc],
								[emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod]
						FROM 	[db_std].[Empresa]
						WHERE	[emp_tipo] = 'E'
						ORDER	BY [emp_razonsocial] ASC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarContactosTotal(){
		
	try{
			
			$sql_1 = "	SELECT	[contac_id],
								[contac_nombre],
								[contac_dni],
								[areatrab_id],
								[area].[area_descripcion],
								[cargocontac_id],
								[cargo].[cargo_descripcion],
								[empcontac_id],
								[emp].[emp_razonsocial],
								[contac_tipo],
								tipo_contacto = case
								WHEN contac_tipo = 'I' THEN 'Interno' ELSE 'Externo'END,
								[contac_estado],
								[contac_usu_reg],
								[contac_fec_reg],
								[contac_usu_mod],
								[contac_fec_mod],
								[contact_correo]
						FROM	[db_std].[Contacto] con
						LEFT	JOIN [db_std].[Area] area ON area.area_id = con.areatrab_id
						LEFT	JOIN [db_std].[Cargo] cargo ON cargo.cargo_id = con.cargocontac_id
						INNER	JOIN [db_std].[Empresa] emp	ON	emp.emp_id = con.empcontac_id
						ORDER	BY 1 DESC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarAreaTotal(){
		
		try{
			
			$sql_1 = "	SELECT [area_id]
						      ,[area_descripcion]
						      ,[area_estado]
						      ,[area_usu_reg]
						      ,[area_fec_reg]
						      ,[area_usu_mod]
						      ,[area_fec_mod]
						  FROM [db_std].[Area]
						ORDER	BY 1 DESC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarCargoTotal(){
		
		try{
			
			$sql_1 = "	SELECT 	[cargo_id]
						      	,[cargo_descripcion]
						      	,[cargo_estado]
						      	,[cargo_usu_reg]
						     	,[cargo_fec_reg]
						      	,[cargo_usu_mod]
						      	,[cargo_fec_mod]
						FROM 	[db_std].[Cargo]
						ORDER	BY 1 DESC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function listarDocumentoTotal(){
		
		try{
			
			$sql_1 = "	SELECT 	[td_id],
								[td_descripcion],
								[td_estado],
								[td_usu_reg],
								[td_fec_reg],
								[td_usu_mod],
								[td_fec_mod] 
						FROM 	[db_std].[TipoDocumento]
						ORDER	BY 1 DESC";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarEmpresasXEntidad($empresa){
		
		try{
			
			$sql_1 = "EXEC SPP9_LISTADO_EMPRESA ? "; 			
			
			$param_1 = 	array($empresa);
							
			$result =  $this->database_tramite->Consultar($sql_1,$param_1);
			
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function consultar_documento($id) {
		try {
			$sql = "	SELECT 	[td_bloqueo],[td_correlativo],[td_abreviacion]
						  FROM 	[db_std].[TipoDocumento]
						  WHERE	[td_id] = ".$id;
			
			$result = $this->database_tramite->Consultar($sql);			
			return $result;
			
		} catch (Exception $e){
            throw $e;
		}
	}
	
	public function BuscarTramite($num_documento,$tip_documento,$estado,$fec_inicial,$fec_final){
		
		try{
			
				$sql_base = "	SELECT	[tram_id],
										[tram_fec_reg],
										[Fecha],
										[Hora],
										[tram_nro_doc],
										[td_id],
										[td_descripcion],
										[tip_ent_desc],
										[contactram_id],
										[contac_nombre],
										[tram_usu_nom],
										[tram_asunto],
										UPPER([tram_estado]) AS [tram_estado],
										[tram_usuarios],
										[tram_tipo_doc],
										[tram_remitenteactual]
								FROM (
								SELECT	[tram_id]
										,[tram_fec_reg]
										,Convert(char, [tram_fec_reg], 103) AS [Fecha]
										,RIGHT( CONVERT(DATETIME, [tram_hora_reg], 108),8) AS [Hora] 
										,[tram_nro_doc]
										,[tram].[td_id] AS td_id
										,[td_descripcion]
										,tip_ent_desc = CASE
										when [tram_tip_ent] = 'I' then 'Interno' else 'Externo' END
										,[emptram_id]
										,[contactram_id]
										,[contac_nombre] = CASE
										WHEN [emptram_id] <> '1' THEN
										LTRIM(RTRIM((	SELECT	UPPER([con].[emp_razonsocial])
											FROM	[db_std].[Empresa] con 
											where	[con].[emp_id] = [tram].[emptram_id])))+
											' -	'
										+LTRIM(RTRIM((	SELECT	UPPER([con].[contac_nombre])
											FROM	[db_std].[Contacto] con 
											where	[con].[contac_id] = [tram].[contactram_id])))
										ELSE 
										(	SELECT	UPPER([con].[contac_nombre])
											FROM	[db_std].[Contacto] con 
											where	[con].[contac_id] = [tram].[contactram_id]) END
										,[tram_usu_nom]
										,[tram_asunto]	
										,[tram_estado]
										,[tram_usuarios]
										,[tram_tipo_doc] = CASE
										when [tram_tipo_doc] = 'OR' then 'ORIGINAL' else 'COPIA' END		
										,UPPER([tram_remitenteactual]) AS [tram_remitenteactual]
										,ROW_NUMBER() OVER (ORDER BY Convert(char, [tram_fec_reg], 103) DESC, RIGHT( CONVERT(DATETIME, [tram_hora_reg], 108),8) DESC) AS RowNumber															
								FROM	[db_std].[TramiteDocumentario] tram 
								INNER	JOIN [db_std].[TipoDocumento] tdoc on tram.td_id = tdoc.td_id) as tramite";
								
										
			if($num_documento <> ''  OR $tip_documento <> '' OR $estado <> '' OR $fec_inicial <> '' OR $fec_final <> '') 
			{
						
				$sql_base .= 	" WHERE ";												
				$existecondicional = FALSE;
				if($num_documento <> ''){
					$sql_base .= "[tram_nro_doc]  = '".$num_documento."'";
					$existecondicional = TRUE;
				}
				if($tip_documento <> ''){
					$sql_base .= ($existecondicional?" AND ":" ")."[td_descripcion]= '".$tip_documento."'";
					$existecondicional = TRUE;
				}
				if($estado <> ''){
					$sql_base .= ($existecondicional?" AND ":" ")."[tram_estado] = '".$estado."'";
					$existecondicional = TRUE;
				}
				if($fec_inicial <> '' AND $fec_final <> ''){
					$sql_base .= ($existecondicional?" AND ":" ")."[tram_fec_reg]  BETWEEN convert(datetime,'".$fec_inicial."',103) AND convert(datetime,'".$fec_final."',103)";
					$existecondicional = TRUE;
				}
			}
			
			$sql_base.= " ORDER	BY  [Fecha] DESC, [Hora] DESC";
			
			$result = $this->database_tramite->Consultar($sql_base);
			return $result;
			
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