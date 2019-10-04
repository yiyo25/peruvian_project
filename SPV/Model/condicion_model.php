<?php
if( !isset($_SESSION)){
	session_start();
}

class Condicion_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    public function listarResumenCondicion($CONDESP_id) {
        try{
            $condicional = "";
            $param_1 = array();
            
            if($CONDESP_id != ""){
                $condicional = " WHERE CONESP.[CONDESP_id] = ?";
                $param_1 = array($CONDESP_id);
            }
            
            $sql_1 = "SELECT
                        CONESP.[CONDESP_id],
                        CASE
                        WHEN	CONESP.[TRIP_id] != '' 
                            AND CONESP.[CONDESP_edad] IS NULL AND CONESP.[CONDESP_indiedad] IS NULL AND CONESP.[CIU_id] IS NULL
                            AND CONESP.[RUT_num_vuelo] IS NULL AND CONESP.[NIVING_id] IS NULL
                        THEN 'Por Tripulante'
                        ELSE
                            CASE
                            WHEN	CONESP.[CONDESP_edad] != '' AND CONESP.[CONDESP_indiedad] != ''
                                AND CONESP.[CIU_id] IS NULL AND CONESP.[RUT_num_vuelo] IS NULL AND CONESP.[NIVING_id] IS NULL
                            THEN 'Por Edad'
                            ELSE
                                CASE
                                WHEN	CONESP.[CIU_id] != '' 
                                    AND CONESP.[RUT_num_vuelo] IS NULL AND CONESP.[NIVING_id] IS NULL
                                THEN 'Por Ciudad'
                                ELSE
                                    CASE
                                    WHEN	CONESP.[RUT_num_vuelo] != '' 
                                        AND CONESP.[NIVING_id] IS NULL
                                    THEN 'Por Vuelo'
                                    ELSE
                                        CASE
                                        WHEN CONESP.[NIVING_id] != '' THEN 'Por Niv Ingles'
                                        END
                                    END
                                END
                            END
                        END AS 'TIP_condicion',
                        CONESP.[CONDESP_estado],
                        CONESP.[AUD_usu_cre],CONVERT(VARCHAR(20),CONESP.[AUD_fch_cre],103) AS [AUD_fch_cre]
                        FROM [dbo].[SPV_CONDI_ESPECIAL] CONESP
                        ".$condicional."
                        ORDER BY 1 DESC";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function insertCondicion ($TRIP_id,$CONDESP_edad,$CONDESP_indiedad,$CIU_id,$RUT_num_vuelo,$NIVING_id,$CONDESP_condicional,$TRIP_id_apli,$CONDESP_edad_apli,$CONDESP_indiedad_apli,$CIU_id_apli,$RUT_num_vuelo_apli,$NIVING_id_apli,$CONDESP_estado){
        try{
            if($CONDESP_indiedad != 'NULL'){
                $CONDESP_indiedad = "'".$CONDESP_indiedad."'";
            }
            if($CIU_id != 'NULL'){
                $CIU_id = "'".$CIU_id."'";
            }
            if($CONDESP_indiedad_apli != 'NULL'){
                $CONDESP_indiedad_apli = "'".$CONDESP_indiedad_apli."'";
            }
            if($CIU_id_apli != 'NULL'){
                $CIU_id_apli = "'".$CIU_id_apli."'";
            }
            
            $sql_1 = "INSERT INTO [dbo].[SPV_CONDI_ESPECIAL]
                        ([TRIP_id],[CONDESP_indiedad],[CONDESP_edad],[CIU_id],[RUT_num_vuelo],[NIVING_id],
                        [CONDESP_condicional],
                        [TRIP_id_apli],[CONDESP_indiedad_apli],[CONDESP_edad_apli],[CIU_id_apli],[RUT_num_vuelo_apli],[NIVING_id_apli],
                        [CONDESP_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (".$TRIP_id.",".$CONDESP_indiedad.",".$CONDESP_edad.",".$CIU_id.",".$RUT_num_vuelo.",".$NIVING_id.",?,".$TRIP_id_apli.",".$CONDESP_indiedad_apli.",".$CONDESP_edad_apli.",".$CIU_id_apli.",".$RUT_num_vuelo_apli.",".$NIVING_id_apli.",".$CONDESP_estado.",?,?);";
            $param_1 = array($CONDESP_condicional,$this->usuario,date("Ymd H:i:s"));
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS CONDESP_id;";
            $this->database->Ejecutar($sql_1,$param_1);
            $CONDESP_id = $this->database->Consultar($sql_2);
            return $CONDESP_id[0]["CONDESP_id"];
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function listarDetCondicion($CONDESP_id){
        try{
			$sql_1 = "SELECT
                        CONESP.[CONDESP_id],
                        TT.[TIPTRIP_id],TTD.[TIPTRIPDET_id],CONESP.[TRIP_id],
                        CONESP.[CONDESP_edad],CONESP.[CONDESP_indiedad],CONESP.[CIU_id],CONESP.[RUT_num_vuelo],CONESP.[NIVING_id],
                        CONESP.[CONDESP_condicional],
                        TT_APLI.[TIPTRIP_id] AS  [TIPTRIP_id_apli],TTD_APLI.[TIPTRIPDET_id] AS [TIPTRIPDET_id_apli],CONESP.[TRIP_id_apli],
                        CONESP.[CONDESP_edad_apli],CONESP.[CONDESP_indiedad_apli],CONESP.[CIU_id_apli],CONESP.[RUT_num_vuelo_apli],CONESP.[NIVING_id_apli],
                        CONESP.[CONDESP_estado],
                        CONESP.[AUD_usu_cre],CONVERT(VARCHAR(20),CONESP.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        CONESP.[AUD_usu_mod],CONVERT(VARCHAR(20),CONESP.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_CONDI_ESPECIAL] CONESP
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON CONESP.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T_APLI ON CONESP.[TRIP_id_apli] = T_APLI.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD_APLI ON T_APLI.[TIPTRIPDET_id] = TTD_APLI.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT_APLI ON TTD_APLI.[TIPTRIP_id] = TT_APLI.[TIPTRIP_id]
                        WHERE [CONDESP_id] = ?";
            $param_1 = array($CONDESP_id);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function updateCondicion ($TRIP_id,$CONDESP_edad,$CONDESP_indiedad,$CIU_id,$RUT_num_vuelo,$NIVING_id,$CONDESP_condicional,$TRIP_id_apli,$CONDESP_edad_apli,$CONDESP_indiedad_apli,$CIU_id_apli,$RUT_num_vuelo_apli,$NIVING_id_apli,$CONDESP_estado,$CONDESP_id){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_CONDI_ESPECIAL]
                        SET [TRIP_id] = ".$TRIP_id.",[CONDESP_edad] = ".$CONDESP_edad.",[CONDESP_indiedad] = ".$CONDESP_indiedad.",[CIU_id] = ".$CIU_id.",[RUT_num_vuelo] = ".$RUT_num_vuelo.",[NIVING_id] = ".$NIVING_id.",
                            [CONDESP_condicional] = ?,
                            [TRIP_id_apli] = ".$TRIP_id_apli.",[CONDESP_edad_apli] = ".$CONDESP_edad_apli.",[CONDESP_indiedad_apli] = ".$CONDESP_indiedad_apli.",[CIU_id_apli] = ".$CIU_id_apli.",[RUT_num_vuelo_apli] = ".$RUT_num_vuelo_apli.",[NIVING_id_apli] = ".$NIVING_id_apli.",
                            [CONDESP_estado] = ".$CONDESP_estado.",
                            [AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE CONDESP_id = ?";
			$param_1 = array($CONDESP_condicional,$this->usuario,date("Ymd H:i:s"),$CONDESP_id);
            
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function buscarAusencia($TIPTRIP_id,$TRIP_apellido,$TIPAUS_id,$TRIP_numlicencia){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPAUS_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."AU.[TIPAUS_id] = ?";
                $param = array($TIPAUS_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_numlicencia <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_numlicencia]= ?";
                $param = array($TRIP_numlicencia);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT AU.[AUS_id],
                            AU.[TIPAUS_id],TA.[TIPAUS_descripcion],
							TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                            AU.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],T.[TRIP_numlicencia],
                            TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                            CONVERT(VARCHAR(20),AU.[AUS_fchini],103) AS [AUS_fchini],
                            CONVERT(VARCHAR(20),AU.[AUS_fchfin],103) AS [AUS_fchfin],
                            AU.[AUD_usu_cre],CONVERT(VARCHAR(20),AU.[AUD_fch_cre],120) AS [AUD_fch_cre],
                            AU.[AUD_usu_mod],CONVERT(VARCHAR(20),AU.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_AUSENCIA] AU
						LEFT JOIN [dbo].[SPV_TIPOAUSENCIA] TA ON AU.[TIPAUS_id] = TA.[TIPAUS_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON AU.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOLICENCIA] TL ON T.[TIPLIC_id] = TL.[TIPLIC_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$condicional."
                        ORDER BY 1 DESC";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
}
?>