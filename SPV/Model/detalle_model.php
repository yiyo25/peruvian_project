<?php
if( !isset($_SESSION)){
	session_start();
}

class Detalle_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar Mes ---------------------------------*/
	public function listarMes(){
		try{
			$sql_1 = "SELECT [MES_id],[MES_descripcion],
                        [AUD_usu_cre],CONVERT(VARCHAR(20),[AUD_fch_cre],120) AS [AUD_fch_cre],
						[AUD_usu_mod],CONVERT(VARCHAR(20),[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_MES]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Año ---------------------------------*/
    public function listarAnio(){
		try{
			$sql_1 = "SELECT [ANIO_id],[ANIO_descripcion],
                        [AUD_usu_cre],CONVERT(VARCHAR(20),[AUD_fch_cre],120) AS [AUD_fch_cre],
						[AUD_usu_mod],CONVERT(VARCHAR(20),[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_ANIO]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Tipo Avión ---------------------------------*/
	public function listarTipoAvion(){
		try{
			$sql_1 = "SELECT [TIPAVI_id],[TIPAVI_modelo],[TIPAVI_serie],[TIPAVI_estado],
                        [AUD_usu_cre],CONVERT(VARCHAR(20),[AUD_fch_cre],120) AS [AUD_fch_cre],
						[AUD_usu_mod],CONVERT(VARCHAR(20),[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_TIPOAVION] 
                        ORDER BY [TIPAVI_serie] desc;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Tipo Licencia ---------------------------------*/
    public function listarTipoLicencia($tipoTrip){
		try{
            $condicional = '';
            $param_1 = array();
            
            if($tipoTrip != ''){
                $condicional = ' WHERE [TIPTRIP_id] = ?';
                $param_1 = array($tipoTrip);
            }
			$sql_1 = "SELECT [TIPLIC_id],[TIPTRIP_id],[TIPLIC_abreviatura],[TIPLIC_descripcion],[TIPLIC_estado],
                        [AUD_usu_cre],CONVERT(VARCHAR(20),[AUD_fch_cre],120) AS [AUD_fch_cre],
                        [AUD_usu_mod],CONVERT(VARCHAR(20),[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_TIPOLICENCIA]
                        ".$condicional;
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Tipo Tripulante (Vuelo - Cabina) ---------------------------------*/
    public function listarTipoTrip($tipoTrip){
		try{
            $condicional = '';
            $param_1 = array();
            
            if($tipoTrip != ''){
                $condicional = ' WHERE [TIPTRIP_id] = ?';
                $param_1 = array($tipoTrip);
            }
            
			$sql_1 = "SELECT [TIPTRIP_id],[TIPTRIP_descripcion],[TIPTRIP_estado],
                        [AUD_usu_cre],CONVERT(VARCHAR(20),[AUD_fch_cre],120) AS [AUD_fch_cre],
                        [AUD_usu_mod],CONVERT(VARCHAR(20),[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_TIPOTRIPULANTE]
                        ".$condicional;
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Tipo Detalle Tripulante (Piloto-Copiloto-Auxiliar) ---------------------------------*/
    public function listarTipoTripDetalle($tipoTrip){
		try{
            $condicional = '';
            $param_1 = array();
            
            if($tipoTrip != ''){
                $condicional = ' WHERE TT.[TIPTRIP_id] = ?';
                $param_1 = array($tipoTrip);
            }
            
			$sql_1 = "SELECT
                        TTD.TIPTRIPDET_id,TTD.TIPTRIP_id,TT.TIPTRIP_descripcion,TTD.TIPTRIPDET_descripcion,TTD.TIPTRIPDET_estado,
                        TTD.AUD_usu_cre,TTD.AUD_fch_cre,TTD.AUD_usu_mod,TTD.AUD_fch_mod
                        FROM [dbo].[SPV_TIPOTRIPULANTEDET] TTD
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]"
                        .$condicional;
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Departamento ---------------------------------*/
    public function listarDepartamento(){
        try{
            $sql_1 = "SELECT [idDepa],[departamento]
                        FROM [dbo].[SPV_UBDEPARTAMENTO]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Provincia ---------------------------------*/
    public function listarProvincia(){
        try{
            $sql_1 = "SELECT [idProv],[provincia],[idDepa]
                        FROM [dbo].[SPV_UBPROVINCIA]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Distrito ---------------------------------*/
    public function listarDistrito(){
        try{
            $sql_1 = "SELECT [idDist],[distrito],[idProv]
                        FROM [dbo].[SPV_UBDISTRITO]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar NivelIngles ---------------------------------*/
    public function listarNivIngles(){
        try{
            $sql_1 = "SELECT [NIVING_id],[NIVING_descripcion],[NIVING_estado]
                        FROM [dbo].[SPV_NIVINGLES]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Categorias ---------------------------------*/
    public function listarCategoria($tipoTrip){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($tipoTrip != ''){
                $condicional = ' WHERE [TIPTRIP_id] = ?';
                $param_1 = array($tipoTrip);
            }
            $sql_1 = "SELECT [CAT_id],[TIPTRIP_id],[CAT_descripcion],[CAT_estado]
                        FROM [dbo].[SPV_CATEGORIA]
                        ".$condicional;
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar TipoCurso ---------------------------------*/
    public function listarTipoCurso(){
        try{
			$sql_1 = "SELECT [TIPCUR_id],[TIPCUR_descripcion],[TIPCUR_estado]
                        FROM [dbo].[SPV_TIPOCURSO]
                        ORDER BY [TIPCUR_descripcion]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Listar Tipo Chequeo  ---------------------------------*/
    public function listarTipoChequeo(){
        try{
			$sql_1 = "SELECT [TIPCHEQ_id],[TIPCHEQ_descripcion],[TIPCHEQ_estado] 
                        FROM [dbo].[SPV_TIPOCHEQUEO]
                        ORDER BY [TIPCHEQ_descripcion]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Listar Tipo de Ausencia ---------------------------------*/
    public function listarTipoAusencia(){
        try{
			$sql_1 = "SELECT [TIPAUS_id],[TIPAUS_descripcion],[TIPAUS_estado]
                        FROM [dbo].[SPV_TIPOAUSENCIA]
                        ORDER BY [TIPAUS_descripcion]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Listar Ruta ---------------------------------*/
    public function listarRuta($ITI_fchini,$programación) {
        try{
            $condicional = '';
            if($programación != ''){
                $condicional = " ORDER BY RUT.[RUT_orden] ASC";
            }
            $sql_1 = "SELECT RUT.[RUT_num_vuelo],RUT.[RUT_escala],RUT.[RUT_primer_vuelo],RUT.[RUT_orden],RUT.[RUT_relacion],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                        [RUT_estado]
                        FROM [dbo].[SPV_RUTA] RUT
						LEFT JOIN  [dbo].[SPV_RUTAxDIA] RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        WHERE [RUT_estado] = 1
                        AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?)
                        AND [RUT_aerolinea] = 'P9'
                        AND [RUTDIA_estado] = '1'
                        "
                        .$condicional;
            $param_1 = array($ITI_fchini);
            
            $result = $this->database->Consultar($sql_1,$param_1);
            //echo "<pre>".print_r($result,true)."</pre>";
        
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar RutaxDia ---------------------------------*/
    public function listarRutaxDia($ITI_fchini) {
        try{
            $sql_1 = "SELECT							
                                RUT.[RUT_num_vuelo],RUT.[RUT_orden],RUT.[RUT_relacion],RUT.[RUT_escala],
								RUT.[RUT_primer_vuelo],
								RUT.[CIU_id_origen],RUT.[CIU_id_destino],
								CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
								CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
								RUT.[RUT_estado],
                                RUTD.[RUTDIA_id],RUTD.[RUT_num_vuelo],RUTD.[RUTDIA_diaSemana],RUTD.[RUTDIA_estado],
                                RUTD.[AUD_usu_cre],RUTD.[AUD_fch_cre],RUTD.[AUD_usu_mod],RUTD.[AUD_fch_mod]
                        FROM [dbo].[SPV_RUTAxDIA] RUTD
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        WHERE 
                        RUTD.[RUTDIA_diaSemana] = DateName(weekday,?)";
            $param_1 = array($ITI_fchini);
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar RutaxGrupo ---------------------------------*/
    /*public function listarRutaxGrupo($RUT_num_vuelo_i,$RUT_num_vuelo_f) {
        try{
            $sql_1 = "SELECT RUT.[RUT_num_vuelo],RUT.[RUT_escala],RUT.[RUT_primer_vuelo],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                        [RUT_estado]
                        FROM [dbo].[SPV_RUTA] RUT
						LEFT JOIN  [dbo].[SPV_RUTAxDIA] RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        WHERE [RUT_estado] = 1
						AND RUT_num_vuelo >= ?
						AND RUT_num_vuelo <= ?";
            $param_1 = array($RUT_num_vuelo_i,$RUT_num_vuelo_f);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }*/
    
    /*--------------------------------- Listar Ciudad ---------------------------------*/
    public function listarCiudad() {
        try{
            $sql_1 = "SELECT [CIU_id],[CIU_nombre],[CIU_estado]
                        FROM [dbo].[SPV_CIUDAD]
                        WHERE [CIU_estado] = 1
                        ORDER BY [CIU_nombre] ASC";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Tripulacion ---------------------------------*/
    public function listarTripulacion() {
        try{
            $sql_1 = "SELECT [TIPTRIPU_id],[TIPTRIP_id],[TIPTRIPU_descripcion],[TIPTRIPU_estado]
                        FROM [dbo].[SPV_TIPOTRIPULACION]
                        WHERE --[TIPTRIP_id] = 2 AND 
                        [TIPTRIPU_estado] = 1";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Block Time ---------------------------------*/
    public function listarBlockTimexTripulacion($TIPTRIPU_id) {
        try{
            $sql_1 = "SELECT BT.[BT_id],
                            TIPTRIP.[TIPTRIP_id],TIPTRIP.[TIPTRIP_descripcion],
                            BT.[TIPTRIPU_id],TIPTRIPU.[TIPTRIPU_descripcion],
                            BT.[BT_cantidad],BT.[BT_periodo],
                            BT.[BT_condicional],BT.[BT_indicador],
                            BT.[BT_horaBT],BT.[BT_periodoBT],
                            BT.[BT_estado]
                    FROM [dbo].[SPV_BLOCKTIME] BT
                    INNER JOIN [dbo].[SPV_TIPOTRIPULACION] TIPTRIPU ON BT.[TIPTRIPU_id] = TIPTRIPU.[TIPTRIPU_id]
                    INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TIPTRIP ON TIPTRIPU.[TIPTRIP_id] = TIPTRIP.[TIPTRIP_id]
                    WHERE BT.[TIPTRIPU_id] = ?";
            $param_1 = array($TIPTRIPU_id);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Dutty Time ---------------------------------*/
    public function listarDuttyTimexTripulacion($TIPTRIPU_id) {
        try{
            $sql_1 = "SELECT DT.[DT_id],
                            TIPTRIP.[TIPTRIP_id],TIPTRIP.[TIPTRIP_descripcion],
                            DT.[TIPTRIPU_id],TIPTRIPU.[TIPTRIPU_descripcion],
                            DT.[DT_cantidad],DT.[DT_periodo],
							DT.[DT_condicional],DT.[DT_indicador],
							DT.[DT_horaDT],DT.[DT_periodoDT],
							DT.[DT_estado]
                    FROM [dbo].[SPV_DUTTYTIME] DT
                    INNER JOIN [dbo].[SPV_TIPOTRIPULACION] TIPTRIPU ON DT.[TIPTRIPU_id] = TIPTRIPU.[TIPTRIPU_id]
                    INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TIPTRIP ON TIPTRIPU.[TIPTRIP_id] = TIPTRIP.[TIPTRIP_id]
					WHERE DT.[TIPTRIPU_id] = ?;";
            $param_1 = array($TIPTRIPU_id);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Modificar Módulo ---------------------------------*/
    public function updateModulo($MOD_modulo,$MOD_estado){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_MODULO]
                        SET [MOD_estado] = ?,[AUD_usu_cre] = ?,[AUD_fch_cre] = ?
                            WHERE [MOD_modulo] = ?";
			$param_1 = array($MOD_estado,$this->usuario,date("Ymd H:i:s"),$MOD_modulo);
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Listar Módulo ---------------------------------*/
    public function listarModulo() {
        try{
            $sql_1 = "SELECT [MOD_id],[MOD_modulo],[MOD_estado],[AUD_usu_cre],[AUD_fch_cre]
                        FROM [dbo].[SPV_MODULO]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Módulo ---------------------------------*/
    public function listarCTFT() {
        try{
            $sql_1 = "SELECT [CT_FT_id],
                            [CT_FT_descripcion],
                            CONVERT(VARCHAR(20),[CT_FT_hora_ini],108) AS [CT_FT_hora_ini],
                            CONVERT(VARCHAR(20),[CT_FT_hora_fin],108) AS [CT_FT_hora_fin],
                            [AUD_usu_cre],[AUD_fch_cre],
                            [AUD_usu_mod],[AUD_fch_mod]
                        FROM [dbo].[SPV_CT_FT]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Correos ---------------------------------*/
    public function listarCorreoItinerario() {
        try{
            $sql_1 = "SELECT [CORR_id],[CORR_correo],[CORR_estado]
                        FROM [dbo].[SPV_CORREO_ITI]
                        WHERE [CORR_estado] = 1
                        ORDER BY [CORR_correo] ASC";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarCorreoMantenimiento() {
        try{
            $sql_1 = "SELECT [CORR_id],[CORR_correo],[CORR_estado]
                        FROM [dbo].[SPV_CORREO_MNTO]
                        WHERE [CORR_estado] = 1
                        ORDER BY [CORR_correo] ASC";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarCorreoInfoAvionItinerario() {
        try{
            $sql_1 = "SELECT [CORR_id],[CORR_correo],[CORR_estado]
                        FROM [dbo].[SPV_CORREO_AVI_ITI]
                        WHERE [CORR_estado] = 1
                        ORDER BY [CORR_correo] ASC";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarCorreoCondicionales() {
        try{
            $sql_1 = "SELECT [CORR_id],[CORR_correo],[CORR_estado]
                        FROM [dbo].[SPV_CORREO_CONDI]
                        WHERE [CORR_estado] = 1
                        ORDER BY [CORR_correo] ASC";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*public function listarDetalleTrip(){
        try{
            $sql_1 = "SELECT [TIPTRIPDET_id],[TIPTRIP_id],[TIPTRIPDET_descripcion],[TIPTRIPDET_estado]
                        FROM [dbo].[SPV_TIPOTRIPULANTEDET]";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }*/
}
?>