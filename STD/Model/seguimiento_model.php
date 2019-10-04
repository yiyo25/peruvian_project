<?php
session_start();
class seguimiento_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
	
	public function listarSeguimiento($seg_usuario,$PageSize,$PageNumber,$num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$num_referencia,$tram_prioridad,$tram_emp_remit)
	{
		
		try{
				
				$sql_0 = "		SELECT 	[emp_id],
								[emp_ruc],
								UPPER([emp_razonsocial]) [emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod]
  						FROM 	[db_std].[Empresa]
						WHERE	[emp_razonsocial] = '".$tram_emp_remit."'";
							  
    			$result_0 = $this->database_tramite->Consultar($sql_0);
    			
    			$sql_1 = "		SELECT 	[td_id],
								[td_descripcion],
								[td_estado],
								[td_usu_reg],
								[td_fec_reg],
								[td_usu_mod],
								[td_fec_mod] 
						FROM 	[db_std].[TipoDocumento]
						WHERE	[td_descripcion] = '".$tipo_docum."'";
						  
    			$result_1 = $this->database_tramite->Consultar($sql_1);
				
				$sql_base = "	SELECT	[tram_id],
										[tram_fec_reg],
										[Fecha],
										[Hora],
										[tram_nro_doc],
										[td_id],
										[td_descripcion],
										[tip_ent_desc],
										[emptram_id],
										[emp_nombre],
										[contactram_id],
										[contac_nombre],
										[tram_usu_nom],
										[tram_asunto],
										UPPER([tram_estado]) AS [tram_estado],
										[tram_usuarios],
										[tram_nro_referencia],
										[tram_tipo_referencia],
										[tram_prioridad],										
										[tram_tipo_doc],
										[tram_remitenteactual]
								FROM (
								SELECT	[tram_id]
										,[tram_fec_reg]
										,Convert(char, [tram_fec_reg], 103) AS [Fecha]
										,CONVERT(VARCHAR(5),CONVERT(DATETIME, [tram_hora_reg], 0), 108)  AS [Hora]  
										,[tram_nro_doc]
										,[tram].[td_id] AS td_id
										,[td_descripcion]
										,tip_ent_desc = CASE
										when [tram_tip_ent] = 'I' then 'Interno' else 'Externo' END
										,[emptram_id]
										,[emp].[emp_razonsocial] AS [emp_nombre]
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
										,[tram_estado] = CASE
										WHEN [tram_flag_estado] = 1 THEN UPPER([tram_estado])+'(*)' ELSE UPPER([tram_estado]) END
										,[tram_usuarios]
										,[tram_nro_referencia]
										,[tram_tipo_referencia]
										,[tram_prioridad] = CASE
										WHEN [tram_prioridad] = 'N' THEN 'NORMAL' ELSE 'URGENTE' END
										,[tram_tipo_doc] = CASE
										when [tram_tipo_doc] = 'OR' then 'ORIGINAL' else 'COPIA' END		
										,UPPER([tram_remitenteactual]) AS [tram_remitenteactual]											
										,ROW_NUMBER() OVER (ORDER BY [tram_fec_reg] DESC, CONVERT(VARCHAR(5),CONVERT(DATETIME, [tram_hora_reg], 0), 108) DESC) AS RowNumber																													
								FROM	[db_std].[TramiteDocumentario] tram 
								INNER	JOIN [db_std].[TipoDocumento] tdoc ON tram.td_id = tdoc.td_id
								INNER	JOIN [db_std].[Empresa] emp	ON emp.emp_id = tram.emptram_id
								WHERE [tram_usuarios] LIKE '%".$seg_usuario."%'";	
			// echo $tipo_docum;
			// die();							
			if($num_docum <> ''  OR $tipo_docum <> '' OR $fec_inicial <> '' OR $estado <> '' OR $num_referencia <> '' OR $tram_prioridad <> '' OR $tram_emp_remit <> '') 
			{					
				//$sql_base .= " WHERE [tram_usuarios] LIKE '%".$seg_usuario."%' AND ";
				
				$existecondicional = FALSE;
				if($num_docum <> ''){
					$sql_base .= ($existecondicional?" ":" AND ")."[tram_nro_doc] = '".$num_docum."'";
					$existecondicional = TRUE;
				}
								
				if($tipo_docum <> ''){
					$sql_base .= ($existecondicional?" ":" AND ")."[tram].[td_id]= ".$result_1[0]["td_id"];
					$existecondicional = TRUE;
				}
				
				if($estado <> ''){
					$sql_base .= ($existecondicional?" ":" AND ")."[tram_estado] = '".$estado."'";
					$existecondicional = TRUE;
				}
				if($fec_inicial <> '' AND $fec_final <> ''){
					$sql_base .= ($existecondicional?" ":" AND ")."[tram_fec_reg]  BETWEEN convert(datetime,'".$fec_inicial."',103) AND convert(datetime,'".$fec_final."',103)";
					$existecondicional = TRUE;
				}
				if($num_referencia <> ''){
					$sql_base .= ($existecondicional?" ":" AND ")."[tram_nro_referencia] = '".$num_referencia."'";				
					$existecondicional = TRUE;
				}
				if($tram_prioridad <> ''){
					$sql_base .= ($existecondicional?" ":" AND ")."[tram_prioridad] = '".$tram_prioridad."'";				
					$existecondicional = TRUE;
				}
				if($tram_emp_remit <> ''){
					$sql_base .= ($existecondicional?" ":" AND ")."[emptram_id] = ".$result_0[0]["emp_id"];				
					$existecondicional = TRUE;
				}
			}
			
			$sql_base.=") AS Tramite";	
			$sql_base.=" WHERE	RowNumber BETWEEN (".$PageSize."*".$PageNumber." + 1) AND (".$PageSize."*(".$PageNumber." + 1))";	
			$sql_base.=" ORDER	BY  [tram_fec_reg] DESC, [Hora] DESC";
			// echo $sql_base;
			// die();
            //echo $sql_base;exit;
			$result = $this->database_tramite->Consultar($sql_base);
			return $result;
			
		}catch(Exception $e){
            throw $e;
		}
	}
	
	// public function listarSeguimiento($seg_usuario,$PageSize,$PageNumber,$usu_numdoc,$tram_prioridad){
// 		
		// try{
			// $sql_1 = "	EXEC dbo.SPP9_PAGINACION_TRAMITE ?,?,?,?,?";
			// $param_1 = 	array($seg_usuario,$PageSize,$PageNumber,$usu_numdoc,$tram_prioridad);	
			// $result = $this->database_tramite->Consultar($sql_1,$param_1);
			// return $result;
		// }catch(Exception $e){
            // throw $e;
		// }
	// }
	
	public function listarSeguimientoTotal($num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$seg_usuario,$usu_numdoc,$num_referencia,$tram_prioridad,$tram_emp_remit){
		
		try{
			
			$sql_0 = "		SELECT 	[emp_id],
								[emp_ruc],
								UPPER([emp_razonsocial]) [emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod]
  						FROM 	[db_std].[Empresa]
						WHERE	[emp_razonsocial] = '".$tram_emp_remit."'";
							  
    		$result_0 = $this->database_tramite->Consultar($sql_0);
			
			$sql_base = "	SELECT	[tram_id]
								,[tram_fec_reg]
								,Convert(char, [tram_fec_reg], 103) AS [Fecha]
								,RIGHT( CONVERT(DATETIME, [tram_hora_reg], 108),8) AS [Hora] 
								,[tram_nro_doc]
								,[tram].[td_id] AS td_id
								,[td_descripcion]
								,tip_ent_desc = CASE
								when [tram_tip_ent] = 'I' then 'Interno' else 'Externo' END
								,[contactram_id]
								,[tram_usu_nom]
								,[tram_asunto]
								,[tram_remitenteactual]	
								,[tram_estado]
								,[tram_nro_referencia]
								,[tram_tipo_referencia]
								,[tram_prioridad]
								,ROW_NUMBER() OVER (ORDER BY Convert(char, [tram_fec_reg], 103) DESC, RIGHT( CONVERT(DATETIME, [tram_hora_reg], 108),8) DESC) AS RowNumber
						FROM	[db_std].[TramiteDocumentario] tram 
						INNER	JOIN [db_std].[TipoDocumento] tdoc on tram.td_id = tdoc.td_id";	
					
			if($num_docum == '' OR $tipo_docum == '' OR $fec_inicial == '' OR $fec_inicial == '' OR $estado <> '' OR $num_referencia <> '' OR $tram_prioridad <> '') 
			{					
				$sql_base .= " WHERE [tram_usuarios] LIKE '%".$seg_usuario."%' ";
				
				$existecondicional = FALSE;
				if($num_docum <> ''){
					$sql_base .= " AND [tram_nro_doc]  = '".$num_docum."'";
					$existecondicional = TRUE;
				}
				if($tipo_docum <> ''){
					$sql_base .= " AND [td_descripcion]= '".$tipo_docum."'";
					$existecondicional = TRUE;
				}
				if($estado <> ''){
					$sql_base .= " AND [tram_estado] = '".$estado."'";
					$existecondicional = TRUE;
				}
				if($fec_inicial <> '' AND $fec_final <> ''){
					$sql_base .= " AND [tram_fec_reg]  BETWEEN convert(datetime,'".$fec_inicial."',103) AND convert(datetime,'".$fec_final."',103)";
					$existecondicional = TRUE;
				}
				if($num_referencia<> ''){
					$sql_base .= " AND [tram_nro_referencia] = '".$num_referencia."'";
					$existecondicional = TRUE;
				}
				if($tram_prioridad<> ''){
					$sql_base .= " AND [tram_prioridad] = '".$tram_prioridad."'";
					$existecondicional = TRUE;
				}
				
				if($tram_emp_remit <> ''){
					$sql_base .= " AND [emptram_id] = ".$result_0[0]["emp_id"];				
					$existecondicional = TRUE;
				}
			}
			
			$sql_base.=" ORDER	BY  [tram_fec_reg] DESC, [Hora] DESC";			
			// $sql_base.=" ORDER	BY  [Fecha] ASC, [Hora] ASC";
			// echo $sql_base;
			// die();
			$result = $this->database_tramite->Consultar($sql_base);			
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarSeguimientoEstado($seg_usuario,$num_docum){
		
		try{
			
			$sql_1 = "	SELECT	[tram_id]
								,[tram_tip_ent]  = CASE when [tram_tip_ent] = 'I' then 'Interno' else 'Externo' END
								,[tram_estado]			
								,[tram_usuarios]
								,[tram_remitenteactual]													
						FROM	[db_std].[TramiteDocumentario] tram 
						INNER	JOIN [db_std].[Contacto] contac on tram.contactram_id = contac.contac_id
						INNER	JOIN [db_std].[TipoDocumento] tdoc on tram.td_id = tdoc.td_id
						WHERE	[tram_usuarios]	LIKE '%".$seg_usuario."' AND [tram_nro_doc] = '".$num_docum."'";
			
			
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarContactosEntidad($contac_dni) {
		try {
			$sql = " SELECT * FROM [db_std].[Contacto] where empcontac_id = ".$contac_dni;
			
			$result = $this->database_tramite->Consultar($sql);
			
			return $result;
		} catch (Exception $e){
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
                                '' contac_dni,
                                contac.UserEmail contac_correo,
                                '' [areatrab_id],
                                '' [cargocontac_id]
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
	
	public function BuscarTramite($seg_usuario,$PageSize,$PageNumber,$num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$num_referencia,$tram_prioridad,$tram_emp_remit)
	{
		
		try{
				
				$sql_0 = "		SELECT 	[emp_id],
								[emp_ruc],
								UPPER([emp_razonsocial]) [emp_razonsocial],
								[emp_tipo],
								[emp_estado],
								[emp_usu_reg],
								[emp_fec_reg],
								[emp_usu_mod],
								[emp_fec_mod]
  						FROM 	[db_std].[Empresa]
						WHERE	[emp_razonsocial] = '".$tram_emp_remit."'";
							  
    			$result_0 = $this->database_tramite->Consultar($sql_0);
    			
    			$sql_1 = "		SELECT 	[td_id],
								[td_descripcion],
								[td_estado],
								[td_usu_reg],
								[td_fec_reg],
								[td_usu_mod],
								[td_fec_mod] 
						FROM 	[db_std].[TipoDocumento]
						WHERE	[td_descripcion] = '".$tipo_docum."'";
						  
    			$result_1 = $this->database_tramite->Consultar($sql_1);
				
				$sql_base = "	SELECT	[tram_id],
										[tram_fec_reg],
										[Fecha],
										[Hora],
										[tram_nro_doc],
										[td_id],
										[td_descripcion],
										[tip_ent_desc],
										[emptram_id],
										[emp_nombre],
										[contactram_id],
										[contac_nombre],
										[tram_usu_nom],
										[tram_asunto],
										UPPER([tram_estado]) AS [tram_estado],
										[tram_usuarios],
										[tram_nro_referencia],
										[tram_tipo_referencia],
										[tram_prioridad],										
										[tram_tipo_doc],
										[tram_remitenteactual]
								FROM (
								SELECT	[tram_id]
										,[tram_fec_reg]
										,Convert(char, [tram_fec_reg], 103) AS [Fecha]
										,CONVERT(VARCHAR(5),CONVERT(DATETIME, [tram_hora_reg], 0), 108)  AS [Hora] 
										,[tram_nro_doc]
										,[tram].[td_id] AS td_id
										,[td_descripcion]
										,tip_ent_desc = CASE
										when [tram_tip_ent] = 'I' then 'Interno' else 'Externo' END
										,[emptram_id]
										,[emp].[emp_razonsocial] AS [emp_nombre]
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
										,[tram_estado] = CASE
										WHEN [tram_flag_estado] = 1 THEN UPPER([tram_estado])+'(*)' ELSE UPPER([tram_estado]) END
										,[tram_usuarios]
										,[tram_nro_referencia]
										,[tram_tipo_referencia]
										,[tram_prioridad] = CASE
										WHEN [tram_prioridad] = 'N' THEN 'NORMAL' ELSE 'URGENTE' END
										,[tram_tipo_doc] = CASE
										when [tram_tipo_doc] = 'OR' then 'ORIGINAL' else 'COPIA' END		
										,UPPER([tram_remitenteactual]) AS [tram_remitenteactual]
										,ROW_NUMBER() OVER (ORDER BY [tram_fec_reg] DESC, CONVERT(VARCHAR(5),CONVERT(DATETIME, [tram_hora_reg], 0), 108) DESC) AS RowNumber																
								FROM	[db_std].[TramiteDocumentario] tram 
								INNER	JOIN [db_std].[TipoDocumento] tdoc ON tram.td_id = tdoc.td_id
								INNER	JOIN [db_std].[Empresa] emp	ON emp.emp_id = tram.emptram_id
								WHERE [tram_usuarios] LIKE '%".$seg_usuario."%'";	
										
			if($num_docum <> ''  OR $tipo_docum <> '' OR $fec_inicial <> '' OR $estado <> '' OR $num_referencia <> '' OR $tram_prioridad <> '' OR $tram_emp_remit <> '') 
			{	
				$existecondicional = FALSE;
				if($num_docum <> ''){
					//$sql_base .= ($existecondicional?" ":" AND ")."[tram_nro_doc] = '".$num_docum."'";
					$sql_base .= " AND [tram_nro_doc]  = '".$num_docum."'";
					$existecondicional = TRUE;
				}
				if($tipo_docum <> ''){
					//$sql_base .= ($existecondicional?" ":" AND ")."tram.td_id= ".$result_1[0]["td_id"];
					$sql_base .= " AND [tram].[td_id]= '".$result_1[0]["td_id"]."'";
					$existecondicional = TRUE;
				}
				
				if($estado <> ''){
					//$sql_base .= ($existecondicional?" ":" AND ")."[tram_estado] = '".$estado."'";
					$sql_base .= " AND [tram_estado] = '".$estado."'";
					$existecondicional = TRUE;
				}
				
				if($fec_inicial <> '' AND $fec_final <> ''){
					//$sql_base .= ($existecondicional?" ":" AND ")."[tram_fec_reg]  BETWEEN convert(datetime,'".$fec_inicial."',103) AND convert(datetime,'".$fec_final."',103)";
					$sql_base .= " AND [tram_fec_reg]  BETWEEN convert(datetime,'".$fec_inicial."',103) AND convert(datetime,'".$fec_final."',103)";
					$existecondicional = TRUE;
				}
				
				if($num_referencia <> ''){
					//$sql_base .= ($existecondicional?" ":" AND ")."[tram_nro_referencia] = '".$num_referencia."'";
					$sql_base .= " AND [tram_nro_referencia] = '".$num_referencia."'";				
					$existecondicional = TRUE;
				}
				
				if($tram_prioridad <> ''){
					//$sql_base .= ($existecondicional?" ":" AND ")."[tram_prioridad] = '".$tram_prioridad."'";	
					$sql_base .= " AND [tram_prioridad] = '".$tram_prioridad."'";			
					$existecondicional = TRUE;
				}
				
				if($tram_emp_remit <> ''){
					// $sql_base .= ($existecondicional?" ":" AND ")."[emptram_id] = ".$result_0[0]["emp_id"];
					$sql_base .= " AND  [emptram_id] = ".$result_0[0]["emp_id"];				
					$existecondicional = TRUE;
				}
			}
			
			$sql_base.=") AS Tramite";	
			$sql_base.=" WHERE	RowNumber BETWEEN (".$PageSize."*".$PageNumber." + 1) AND (".$PageSize."*(".$PageNumber." + 1))";	
			$sql_base.=" ORDER	BY  [tram_fec_reg] DESC, [Hora] DESC";
			
			// echo $sql_base;
			// die();
// 			
			$result = $this->database_tramite->Consultar($sql_base);
			return $result;
			
		}catch(Exception $e){
            throw $e;
		}
	}	
			
    public function DerivarTramite(	$tramseg_id,$seg_tipent,$empseg_id,$contacseg_id,$seg_observacion,
									$seg_fecha_transito,$seg_hora_transito,$seg_usuario_transito,
									$seg_estado,$usu_numdoc,$area_descripcion,$cargo_descripcion,
									$usu_correo,$usu_numdocI,$usu_nombre,$correo_usuario_deriva){
    	try{

			$sql = "	EXEC dbo.SPP9_DERIVAR_TRAMITE ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
			$param = 	array(	$tramseg_id,$seg_tipent,$empseg_id,$contacseg_id,$seg_observacion,
									$seg_fecha_transito,$seg_hora_transito,$seg_usuario_transito,
									$seg_estado,$usu_numdoc,$area_descripcion,$cargo_descripcion,
									$usu_correo,$usu_numdocI,utf8_decode($usu_nombre),$correo_usuario_deriva);	
									 
			$result = $this->database_tramite->Consultar($sql,$param);
			return $result;	
						 
    	}catch(Exception $e){
            throw $e;
		}
    	
    }
	
	public function listarObservacionTotal($id='0'){
    	try{
    		if($id == '') $id='0';
    		$sql_1 = "SELECT	[seg_id],
						    	[tramseg_id],     							
								[seg_tipent]  = CASE WHEN [seg_tipent] = 'I' THEN 'INTERNO' ELSE 'EXTERNO' END,
								(	SELECT	[area_descripcion]
									FROM	[db_std].[Area] area 			
									INNER	JOIN [db_std].[contacto] contacto on [area].[area_id] = [contacto].[areatrab_id]
									where	[contacto].[contac_id] = [seg].[seg_contacRemitente_id]) AS [AreaRemitente],	
								[NombreRemitente] = CASE
								WHEN seg_empRemitente_id <> '1' THEN
								LTRIM(RTRIM((	SELECT	UPPER([con].[emp_razonsocial])
									FROM	[db_std].[Empresa] con 
									where	[con].[emp_id] = [seg].[seg_empRemitente_id])))+
									' -	'
								+LTRIM(RTRIM((	SELECT	UPPER([con].[contac_nombre])
									FROM	[db_std].[Contacto] con 
									where	[con].[contac_id] = [seg].[seg_contacRemitente_id])))
								ELSE 
								(	SELECT	UPPER([con].[contac_nombre])
									FROM	[db_std].[Contacto] con 
									where	[con].[contac_id] = [seg].[seg_contacRemitente_id]) END,
								(	SELECT	[con].[contac_dni]
									FROM	[db_std].[Contacto] con 
									where	[con].[contac_id] = [seg].[seg_contacRemitente_id]) AS [DNIRemitente],
								(	SELECT	UPPER([cargo_descripcion])
									FROM	[db_std].[Cargo] cargo
									INNER	JOIN [db_std].[contacto] contacto on [cargo].[cargo_id] = [contacto].[cargocontac_id]
									where	[contacto].[contac_id] = [seg].[seg_contacRemitente_id]) AS [CargoRemitente],
								(	SELECT	UPPER([area_descripcion])
									FROM	[db_std].[Area] cargo
									INNER	JOIN [db_std].[contacto] contacto on [cargo].[area_id] = [contacto].[areatrab_id]
									where	[contacto].[contac_id] = [seg].[contacseg_id]) AS [AreaDestino],
								[NombreDestino] = CASE
								WHEN empseg_id <> '1' THEN
								LTRIM(RTRIM((	SELECT	UPPER([con].[emp_razonsocial])
									FROM	[db_std].[Empresa] con 
									where	[con].[emp_id] = [seg].[empseg_id])))+
									' -	'
								+LTRIM(RTRIM((	SELECT	UPPER([con].[contac_nombre])
									FROM	[db_std].[Contacto] con 
									where	[con].[contac_id] = [seg].[contacseg_id])))
								ELSE 
								(	SELECT	UPPER([con].[contac_nombre])
									FROM	[db_std].[Contacto] con 
									where	[con].[contac_id] = [seg].[contacseg_id]) END,						
								(	SELECT	UPPER([cargo_descripcion])
									FROM	[db_std].[Cargo] cargo
									INNER	JOIN [db_std].[contacto] contacto on [cargo].[cargo_id] = [contacto].[cargocontac_id]
									where	[contacto].[contac_id] = [seg].[contacseg_id]) AS [CargoDestino],
								[seg_fec_recepcion] = CASE
								WHEN [seg_fec_recepcion] IS NULL AND [seg_hora_recepcion] IS NULL THEN ' ' ELSE LTRIM(RTRIM(CONVERT(CHAR, [seg_fec_recepcion], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_recepcion], 108),8))) END,
								[seg_fecha_transito] = CASE
								WHEN [seg_fecha_transito] IS NULL AND [seg_hora_transito] IS NULL THEN ' ' ELSE LTRIM(RTRIM(CONVERT(CHAR, [seg_fecha_transito], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_transito], 108),8))) END,
								[seg_fec_derivado] = CASE
								WHEN [seg_fec_derivado] IS NULL AND [seg_hora_derivado] IS NULL THEN ' ' ELSE  LTRIM(RTRIM(CONVERT(CHAR, [seg_fec_derivado], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_derivado], 108),8))) END,
								[seg_fec_concluido] = CASE
								WHEN [seg_fec_concluido] IS NULL AND [seg_hora_concluido] IS NULL THEN ' ' ELSE LTRIM(RTRIM(CONVERT(CHAR, [seg_fec_concluido], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_concluido], 108),8))) END,
								[seg_usu_recepcion],
								[seg_usuario_transito],
								[seg_usu_derivado],
								[seg_usu_concluido],
								[seg_estado],
								[seg_usuarios],
								ROW_NUMBER() OVER (ORDER BY [seg_id]) AS indice
						FROM	[db_std].[SeguimientoDocumentario] seg
						INNER	JOIN [db_std].[Empresa] emp ON seg.empseg_id = emp.emp_id					
						WHERE	[tramseg_id] = ".$id."
						ORDER	BY ROW_NUMBER() OVER (ORDER BY [seg_id]) DESC";
						
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;	
						 
    	}catch(Exception $e){
            throw $e;
		}
    }
    
    public function listarObservaciones($id,$PageSize,$PageNumber){
		
		try{
			$sql_1 = "	EXEC dbo.SPP9_SEGUIMIENTO_OBSERVACION ?,?,?";
			$param_1 = 	array($id,$PageSize,$PageNumber);	
				
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
    
    public function SegConcluirUpdate($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id){
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_CONCLUIR_SEGUIMIENTO ?,?,?,?,?";
			$param_1 = array($seg_fec,$seg_hora,utf8_decode($seg_usu),utf8_decode($seg_estado),$tramseg_id);
			
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function SegRecibirUpdate($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id){
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_RECIBIR_DERIVACION ?,?,?,?,?";
			
			$param_1 = array($seg_fec,$seg_hora,utf8_decode($seg_usu),utf8_decode($seg_estado),$tramseg_id);			
			
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
//Consulta para cuerpo de correo
	
	public function listarTransitoCorreo(){
		
		try{
			
			$sql_1 = "	SELECT	[tramseg_id],[tram_nro_doc],[tram_fec_reg],[tram_fec_doc],[seg_fecha_transito],
								DATEDIFF(day, [tram_fec_reg], getdate()) AS [Dias],
								[seg_empRemitente_id],[seg_contacRemitente_id],
								[empR].[emp_razonsocial]+' - '+[conR].[contac_nombre] AS [NombreRemitente],
								[empseg_id],[contacseg_id],
								[empD].[emp_razonsocial]+' - '+[conD].[contac_nombre] AS [NombreDestinatario],
								[tram_asunto],UPPER([tram_estado]) AS [tram_estado], [tram_estado_fecha],
								[seg_correo]
						FROM	[db_std].[SeguimientoDocumentario] seg
						INNER	JOIN [db_std].[TramiteDocumentario] tram ON [tram].[tram_id]=[seg].[tramseg_id]
						left	JOIN [db_std].[Empresa] empR ON [seg].[seg_empRemitente_id] = [empR].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conR ON [seg].[seg_contacRemitente_id] = [conR].[contac_id]
						left	JOIN [db_std].[Empresa] empD ON [seg].[empseg_id] = [empD].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conD ON [seg].[contacseg_id] = [conD].[contac_id]
						WHERE	[seg_estado]='transito'";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function listarFechaRespuesta(){
		
		try{
			
			$sql_1 = "	SELECT	[tramseg_id],[tip].[td_descripcion],[tram_nro_doc],[tram_fec_reg],[tram_fec_doc],[tram_fec_resp],
								[seg_empRemitente_id],[seg_contacRemitente_id],
								[empR].[emp_razonsocial]+' - '+[conR].[contac_nombre] AS [NombreRemitente],
								[empseg_id],[contacseg_id],
								[empD].[emp_razonsocial]+' - '+[conD].[contac_nombre] AS [NombreDestinatario],
								[tram_asunto],UPPER([seg_estado]) AS [tram_estado],
								[seg_correo],[seg_correo_copia]
						FROM	[db_std].[SeguimientoDocumentario] seg
						INNER	JOIN [db_std].[TramiteDocumentario] tram ON [tram].[tram_id]=[seg].[tramseg_id]
						LEFT	JOIN [db_std].[Empresa] empR ON [seg].[seg_empRemitente_id] = [empR].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conR ON [seg].[seg_contacRemitente_id] = [conR].[contac_id]
						LEFT	JOIN [db_std].[Empresa] empD ON [seg].[empseg_id] = [empD].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conD ON [seg].[contacseg_id] = [conD].[contac_id]
						LEFT	JOIN [db_std].[TipoDocumento] tip ON [tip].[td_id] = [tram].[td_id]
						WHERE	[seg_prioridad] = 'U' AND [seg_fecha_respuesta] <> '' AND 
								[seg_estado] in ('Recibido','Transito') AND [seg_tip_doc] = 'OR' ";
									
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function ConcluidoAutomatico(){
		
		try{
			
			$sql_1 = "	SELECT	[tramseg_id],[tram_nro_doc],[tram_fec_reg],[tram_fec_doc],[tram_fec_resp],
								[seg_empRemitente_id],[seg_contacRemitente_id],
								[empR].[emp_razonsocial]+' - '+[conR].[contac_nombre] AS [NombreRemitente],
								[empseg_id],[contacseg_id],
								[empD].[emp_razonsocial]+' - '+[conD].[contac_nombre] AS [NombreDestinatario],
								[tram_asunto],UPPER([tram_estado]) AS [tram_estado],[tram_estado_fecha],
								[seg_correo],[seg_correo_copia],[tram_prioridad]
						FROM	[db_std].[SeguimientoDocumentario] seg
						INNER	JOIN [db_std].[TramiteDocumentario] tram ON [tram].[tram_id]=[seg].[tramseg_id]
						LEFT	JOIN [db_std].[Empresa] empR ON [seg].[seg_empRemitente_id] = [empR].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conR ON [seg].[seg_contacRemitente_id] = [conR].[contac_id]
						LEFT	JOIN [db_std].[Empresa] empD ON [seg].[empseg_id] = [empD].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conD ON [seg].[contacseg_id] = [conD].[contac_id]
						WHERE	[seg_estado] ='Recibido'";
																					
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	

	public function ConcluidoTable($id){
		
		try{
			
			$sql_1 = "	SELECT [alerta_id]
						      ,[alerta_descripcion]
						      ,[alerta_asunto]
						      ,[alerta_mensaje]
						      ,[alerta_correo_origen]
						      ,[alerta_correo_copia]
						      ,[alerta_tiempo_dia]
						      ,[alerta_estado]
						  FROM [db_std].[Alertas]
						  WHERE	[alerta_id]=?";
			$param_1 = array($id);
			$result = $this->database_tramite->Consultar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function SeguimientoConcluido($id,$fecha_hoy,$hora_concluido,$usu_concluido){
		
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_UPDATE_CONCLUIDO_AUTOMATICO ?,?,?,?";
			$param_1 = array($id,$fecha_hoy,$hora_concluido,$usu_concluido);
			
			$this->database_tramite->Ejecutar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado){
		try{
			
			$sql_1 = "INSERT INTO [dbo].[Log_correos]
						           ([log_descripcion]
						           ,[log_mensaje]
						           ,[log_fecha]
						           ,[log_estado])
				     	VALUES (?,?,?,?)";
			$param_1 = array(utf8_decode($log_descripcion),utf8_decode($log_mensaje),$log_fecha,$log_estado);
			$this->database_tramite->Ejecutar($sql_1,$param_1);
		}catch(Exception $e){
         throw $e;
		}
	}	
	
	public function listarEmpresasTotal(){
		
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
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function historial_fechas($tram_id,$seg_id){
		
		try{
			
			$sql_1 = "	SELECT	[seg_id],[tramseg_id],
								[seg_fec_recepcion] = CASE
								WHEN [seg_fec_recepcion] IS NULL AND [seg_hora_recepcion] IS NULL THEN ' ' ELSE LTRIM(RTRIM(CONVERT(CHAR, [seg_fec_recepcion], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_recepcion], 108),8))) END,
								[seg_fecha_transito] = CASE
								WHEN [seg_fecha_transito] IS NULL AND [seg_hora_transito] IS NULL THEN ' ' ELSE LTRIM(RTRIM(CONVERT(CHAR, [seg_fecha_transito], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_transito], 108),8))) END,
								[seg_fec_derivado] = CASE
								WHEN [seg_fec_derivado] IS NULL AND [seg_hora_derivado] IS NULL THEN ' ' ELSE LTRIM(RTRIM(CONVERT(CHAR, [seg_fec_derivado], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_derivado], 108),8))) END,
								[seg_fec_concluido] = CASE
								WHEN [seg_fec_concluido] IS NULL AND [seg_hora_concluido] IS NULL THEN ' ' ELSE LTRIM(RTRIM(CONVERT(CHAR, [seg_fec_concluido], 103)))+' '+LTRIM(RTRIM(RIGHT( CONVERT(DATETIME, [seg_hora_concluido], 108),8))) END
								
								FROM	[db_std].[SeguimientoDocumentario] seg
						WHERE	[seg_id] = ".$seg_id." AND [tramseg_id] = ".$tram_id;
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function RecibidoAutomatico(){
		
		try{
			
			$sql_1 = "	SELECT	[tramseg_id],[tram_nro_doc],[tram_fec_reg],[tram_fec_doc],[tram_fec_resp],
								[seg_empRemitente_id],[seg_contacRemitente_id],
								[empR].[emp_razonsocial]+' - '+[conR].[contac_nombre] AS [NombreRemitente],
								[empseg_id],[contacseg_id],
								[empD].[emp_razonsocial]+' - '+[conD].[contac_nombre] AS [NombreDestinatario],
								[tram_asunto],UPPER([tram_estado]) AS [tram_estado],[tram_estado_fecha],
								[seg_correo],[seg_correo_copia],[tram_prioridad]
						FROM	[db_std].[SeguimientoDocumentario] seg
						INNER	JOIN [db_std].[TramiteDocumentario] tram ON [tram].[tram_id]=[seg].[tramseg_id]
						LEFT	JOIN [db_std].[Empresa] empR ON [seg].[seg_empRemitente_id] = [empR].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conR ON [seg].[seg_contacRemitente_id] = [conR].[contac_id]
						LEFT	JOIN [db_std].[Empresa] empD ON [seg].[empseg_id] = [empD].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conD ON [seg].[contacseg_id] = [conD].[contac_id]
						WHERE	[seg_estado] ='Transito'";
																					
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}
	
	public function SeguimientoRecibido($id,$fecha_hoy,$hora_recibido,$usu_recibido){
		
		try{
			
			$sql_1 = "	EXEC dbo.SPP9_UPDATE_RECIBIDO_AUTOMATICO ?,?,?,?";
			$param_1 = array($id,$fecha_hoy,$hora_recibido,$usu_recibido);
			
			$this->database_tramite->Ejecutar($sql_1,$param_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
	
	public function CorreoDerivado($tramseg_id){
		
		try{
			
			$sql_1 = "	SELECT	[tramseg_id],[tip].[td_descripcion],[tram_nro_doc],[tram_fec_reg],[tram_fec_doc],[seg_fecha_transito],
								DATEDIFF(day, [tram_fec_reg], getdate()) AS [Dias],
								[seg_empRemitente_id],[seg_contacRemitente_id],
								[empR].[emp_razonsocial]+' - '+[conR].[contac_nombre] AS [NombreRemitente],
								[empseg_id],[contacseg_id],
								[empD].[emp_razonsocial]+' - '+[conD].[contac_nombre] AS [NombreDestinatario],
								[tram_asunto],UPPER([tram_estado]) AS [tram_estado], [tram_estado_fecha],
								[seg_correo],[seg_correo_copia]
						FROM	[db_std].[SeguimientoDocumentario] seg
						INNER	JOIN [db_std].[TramiteDocumentario] tram ON [tram].[tram_id]=[seg].[tramseg_id]
						left	JOIN [db_std].[Empresa] empR ON [seg].[seg_empRemitente_id] = [empR].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conR ON [seg].[seg_contacRemitente_id] = [conR].[contac_id]
						left	JOIN [db_std].[Empresa] empD ON [seg].[empseg_id] = [empD].[emp_id]
						LEFT	JOIN [db_std].[Contacto] conD ON [seg].[contacseg_id] = [conD].[contac_id]
						LEFT	JOIN [db_std].[TipoDocumento] tip ON [tip].[td_id] = [tram].[td_id]
						WHERE	[tramseg_id] = ".$tramseg_id." AND [seg_estado] = 'Transito'";
							
			$result = $this->database_tramite->Consultar($sql_1);
			return $result;
		}catch(Exception $e){
            throw $e;
		}
	}	
}
?>