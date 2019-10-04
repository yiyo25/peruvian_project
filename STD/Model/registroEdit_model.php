<?php
session_start();
class registroEdit_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
		
	public function listarTramites($tram_id){		
		try{
			
			$sql_1 = "	SELECT	[tram_id]
						,[tram_fec_reg]
						,Convert(char, [tram_fec_reg], 103) AS [Fecha]
						,RIGHT( CONVERT(DATETIME, [tram_hora_reg], 108),8) AS [Hora] 
						,[tram_fec_doc]
						,Convert(char, [tram_fec_doc], 103) AS [FechaDoc]
						,[tram_fec_resp]
						,Convert(char, [tram_fec_resp], 103) AS [FechaResp]		
						,[tram_nro_doc]
						,[tram].[td_id] AS td_id
						,[td_descripcion]
						,[tram_tip_ent]
						,tip_ent_desc = CASE
						when [tram_tip_ent] = 'I' then 'Interno' else 'Externo' END
						,[emptram_id]
						,[contactram_id]
						,[contac_nombre] = CASE
						WHEN [emptram_id] <> '1' THEN
						LTRIM(RTRIM((	SELECT	[con].[emp_razonsocial]
							FROM	[db_std].[Empresa] con 
							where	[con].[emp_id] = [tram].[emptram_id])))+
							' -	'
						+LTRIM(RTRIM((	SELECT	[con].[contac_nombre]
							FROM	[db_std].[Contacto] con 
							where	[con].[contac_id] = [tram].[contactram_id])))
						ELSE 
						(	SELECT	[con].[contac_nombre]
							FROM	[db_std].[Contacto] con 
							where	[con].[contac_id] = [tram].[contactram_id]) END
						,[area_id]
						,[area_descripcion]
						,[cargo_id]
						,[cargo_descripcion]
						,[tram_usu_nom]
						,[tram_asunto]	
						,[tram_estado]
						,[tram_usuarios]
						,[tram_prioridad]
						,[tram_ruta_doc]
						,[tram_nro_referencia]
						,[tram_tipo_referencia]
						,[tram_correo_copia]
						, (	SELECT	[con].[contac_dni]
							FROM	[db_std].[Contacto] con 
							where	[con].[contac_id] = [tram].[contactram_id]) AS usu_numdoc
						,ROW_NUMBER() OVER (ORDER BY [tram_id]) AS RowNumber													
				FROM	[db_std].[TramiteDocumentario] tram 
				LEFT	JOIN [db_std].[Contacto] contac on tram.contactram_id = contac.contac_id
				LEFT	JOIN [db_std].[TipoDocumento] tdoc on tram.td_id = tdoc.td_id
				LEFT	JOIN [db_std].[Area] area on contac.areatrab_id = area.area_id
				LEFT	JOIN [db_std].[Cargo] cargo on contac.cargocontac_id = cargo.cargo_id
				WHERE	[tram_id] = ".$tram_id;
													
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
	        throw $e;
		}
	}			
										
	public function listarTramitexUsuario($seg_usuario){		
		try{
			
			$sql_1 = "	SELECT	[tramseg_id],[tram].[tram_nro_doc]
						FROM	[db_std].[SeguimientoDocumentario] [seg]
						INNER	JOIN [db_std].[TramiteDocumentario] [tram] ON [tram].[tram_id] = [seg].[tramseg_id]
						WHERE	[seg_usuarios]  = '".$seg_usuario."' AND seg_estado = 'Recibido' AND 
								[seg_fec_derivado] IS NULL AND [seg_fecha_transito] IS NULL AND [seg_fec_concluido] IS NULL";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
	        throw $e;
		}
	}
	
	public function editarRegistro(	$registro,$td_id,$tram_nro_doc,$tram_fec_doc,$tram_asunto,$tram_tip_ent,$emptram_id,$contactram_id,
									$tram_prioridad,$tram_fec_resp,$usu_numdoc,$ruta_documento,$name,$area_descripcion,$cargo_descripcion,
									$usu_correo,$usu_numdocI,$usu_nombre,$tram_usu_reg,$fecha_reg,$doc_referencia,$tipo_referencia,$correo_copia){
		try{
							
			$sql_1 = "	EXEC dbo.SPP9_UPDATE_REGISTRO_DOCUMENTARIO ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
			$param_1 = 	array(	$registro,$td_id,$tram_nro_doc,$tram_fec_doc,$tram_asunto,$tram_tip_ent,$emptram_id,$contactram_id,
								$tram_prioridad,$tram_fec_resp,$usu_numdoc,$ruta_documento,$name,$area_descripcion,$cargo_descripcion,
								$usu_correo,$usu_numdocI,utf8_decode($usu_nombre),$tram_usu_reg,$fecha_reg,$doc_referencia,$tipo_referencia,$correo_copia);
 			 
			$this->database_tramite->Ejecutar($sql_1,$param_1);
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
						ORDER	BY	[emp_razonsocial] ASC";						
							
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
	
	public function listarContactosXEntidad($empresa){
		
		try {
			// if ($empresa == 'I'){
				// $sql = "SELECT	[usu_id] [contac_id], [usu_nombres]+' '+[usu_apellidos] [contac_nombre],
								// [usu_numdoc] [contac_dni], [area_id] [areatrab_id], [cargo_id] [cargocontac_id],
								// [usu_correo] [contac_correo] 
						// FROM 	[db_segSeguridad].[dbo].[seg_usuarios]";
			// }else{
				$sql = " SELECT * FROM [db_std].[Contacto] WHERE contac_tipo = '".$empresa."'";
			// }			
			
			$result = $this->database_tramite->Consultar($sql);
			
			return $result;
		} catch (Exception $e){
            throw $e;
		}
	}
	
	public function BuscarTramite($nro_tramite,$num_documento,$tip_documento,$estado,$fec_inicial,$fec_final)
	{
		
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
								INNER	JOIN [db_std].[TipoDocumento] tdoc on tram.td_id = tdoc.td_id) as tramite
								WHERE 	[tram_id] <> ".$nro_tramite;
								
										
			if($num_documento <> ''  OR $tip_documento <> '' OR $estado <> '' OR $fec_inicial <> '' OR $fec_final <> '') 
			{
						
				$existecondicional = FALSE;
				if($num_documento <> ''){
					$sql_base .= ($existecondicional?" AND ":" ")."[tram_nro_doc]  = '".$num_documento."'";
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
			// echo $sql_base;
			$result = $this->database_tramite->Consultar($sql_base);
			return $result;
			
		}catch(Exception $e){
            throw $e;
		}
	}

	public function filtrar_area_cargo($contacto_id,$empresa_id) {
		try {
			
			if(!is_numeric($contacto_id)){
				return FALSE;
			}
			
			$sql =		"  SELECT	[contac_id],
									[contac_nombre],
									[areatrab_id],
									[are].[area_descripcion],
									[cargocontac_id],
									[car].[cargo_descripcion]
							FROM	[db_std].[Contacto] contac
							LEFT	JOIN [db_std].[Area] are ON are.area_id = contac.areatrab_id 
							LEFT	JOIN [db_std].[Cargo] car ON car.cargo_id = contac.cargocontac_id
							WHERE	[contac_id] = ".$contacto_id;
							
			$result = $this->database_tramite->Consultar($sql);							
			
			if ($empresa_id == 1){
				if (!$result){
					/*$sql_1 = "SELECT	[usu_id] [contac_id],
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
					$sql_1 = "  SELECT	[contac_id],
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
			}else{
				$sql_1 = "  SELECT	[contac_id],
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
							
			$result = $this->database_tramite->Consultar($sql_1);
			
			return $result;
		} catch (Exception $e){
            throw $e;
		}
	}			
						  
}
?>