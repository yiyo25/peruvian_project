<?php
if( !isset($_SESSION)){
	session_start();
}

class Programacion_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    public function listarProgramacion($ITI_fch,$AVI_id,$RUT_num_vuelo) {
        try{
            $condicional = "";
            $condicional_2 = "";
            $param = array();
            $param_1 = array();
            $param_2 = array();
            
            if($AVI_id != ''){
                $condicional_1 = " AND ITI.AVI_id = ?";
                $param = array($AVI_id);
            }
            if($ITI_fch != ''){
                $condicional_2 = " AND CONVERT(VARCHAR(20),ITI.[ITI_fch],103) = ?";
                $param_1 = array($ITI_fch);
            }
            if($RUT_num_vuelo != ''){
                $condicional_3 = " AND RUT.[RUT_num_vuelo] = ?";
                $param_2 = array($RUT_num_vuelo);
            }
            
            $sql_1 = "SELECT
                        ITI.ITI_id,
                        TIPAVI.TIPAVI_serie,
                        ITI.AVI_id,
                        AVI.AVI_num_cola,
                        RUT.RUT_num_vuelo,
                        RUT.[RUT_relacion],
                        RUT.[RUT_orden],
                        RUT.CIU_id_origen,
                        RUT.CIU_id_destino,
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                        CONVERT(VARCHAR(20),ITI.[ITI_fch],103) AS [ITI_fch]
                        FROM SPV_ITINERARIO ITI
                        LEFT JOIN SPV_RUTA RUT ON ITI.RUT_num_vuelo = RUT.RUT_num_vuelo
                        LEFT JOIN SPV_AVION AVI ON AVI.AVI_id = ITI.AVI_id
                        LEFT JOIN SPV_TIPOAVION TIPAVI ON TIPAVI.TIPAVI_id = AVI.TIPAVI_id
                        LEFT JOIN SPV_RUTAxDIA RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        WHERE
                        ITI.[ITI_fch] > GETDATE() 
                        AND ITI.[ITI_proceso] = 'ENVIADO' 
                        AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,ITI.[ITI_fch])
                        ".$condicional_3."
                        ".$condicional_2."
                        ".$condicional_1."
                        ORDER BY ITI.ITI_fch,RUT.RUT_orden ASC;";
            $param_1 = array_merge($param_1,$param);
            $param_2 = array_merge($param_2,$param_1);
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_2,true)."</pre>";*/
            $result = $this->database->Consultar($sql_1,$param_2);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarProgramacionMensual($ITI_fchini,$ITI_fchfin) {
        try{            
            $sql_1 = "SELECT
                        [ITI_id],[RUT_num_vuelo],
                        CONVERT(VARCHAR(10),[ITI_fch],120) AS [ITI_fch],
                        [TRIP_id],[TIPTRIPU_id],[ITI_TRIP_tipo],[AUD_usu_cre],[AUD_fch_cre]
                    FROM [dbo].[SPV_ITI_TRIP_DET]
                    WHERE 
                    CONVERT(VARCHAR(10),[ITI_fch],120) BETWEEN ? and ?";
            $param_1 = array($ITI_fchini,$ITI_fchfin);            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutasNoProg($ITI_fchini,$ITI_fchfin) {
        try{            
            $sql_1 = "SELECT DISTINCT
                        [ITI_id],[RUT_num_vuelo]
                    FROM [dbo].[SPV_ITI_TRIP_DET]
                    WHERE 
                    CONVERT(VARCHAR(10),[ITI_fch],120) BETWEEN ? and ?
					AND [ITI_id] IS NULL;";
            $param_1 = array($ITI_fchini,$ITI_fchfin);            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutasFaltantesxDia($ITI_fch,$TIPTRIPDET_id) {
        try{            
            $sql_1 = "SELECT RUT.[RUT_num_vuelo]
                        FROM [dbo].[SPV_RUTA] RUT
                        LEFT JOIN [dbo].[SPV_RUTAxDIA] RUTD ON RUT.[RUT_num_vuelo] = RUTD.[RUT_num_vuelo]
                        WHERE RUT.[RUT_num_vuelo] 
                            NOT IN (
                                SELECT ITI.[RUT_num_vuelo]
                                FROM [dbo].[SPV_ITI_TRIP_DET] ITI
                                LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON ITI.[TRIP_id] = T.[TRIP_id]
                                INNER JOIN [dbo].[SPV_ITI_TRIP_DET] TRIPDET ON T.[TRIP_id] = TRIPDET.[TRIP_id]
                                where CONVERT(VARCHAR(10),ITI.[ITI_fch],120) = ?
                                AND T.[TIPTRIPDET_id] = ?
                            )
                        AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?)
                        AND RUTD.[RUT_programacion] = 'Si' ";
            $param_1 = array($ITI_fch,$TIPTRIPDET_id,$ITI_fch);            
            $result = $this->database->Consultar($sql_1,$param_1);
            
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutasAdiconales($ITI_fchini,$ITI_fchfin) {
        try{            
            $sql_1 = "SELECT * FROM [dbo].[SPV_ITINERARIO]
                        WHERE 
                        (CONVERT(VARCHAR(10),[ITI_fch],120) BETWEEN ? and ?) AND
                        [RUT_num_vuelo] 
                            NOT IN ( 
                                SELECT DISTINCT [RUT_num_vuelo] FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET 
                                    WHERE CONVERT(VARCHAR(10),ITIDET.[ITI_fch],120) BETWEEN ? and ? 
                            );";
            $param_1 = array($ITI_fchini,$ITI_fchfin,$ITI_fchini,$ITI_fchfin);            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarTripxRutaxFch($RUT_num_vuelo,$ITI_fchini,$ITI_fchfin) {
        try{            
            $sql_1 = "SELECT DISTINCT
                        ITIDET.[ITI_id],ITIDET.[RUT_num_vuelo],ITIDET.[ITI_fch],
                        ITIDET.[ITI_TRIP_tipo],ITIDET.[TRIP_id],
                        T.[TRIP_nombre],T.[TRIP_apellido]

                            FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET
                            INNER JOIN [dbo].[SPV_TRIPULANTE] T ON ITIDET.[TRIP_id] = T.[TRIP_id]
                            WHERE 
                            CONVERT(VARCHAR(10),[ITI_fch],120) BETWEEN ? and ? AND 
                            ITIDET.[RUT_num_vuelo] = ?";
                            // AND [ITI_id] IS NULL ;";
            $param_1 = array($ITI_fchini,$ITI_fchfin,$RUT_num_vuelo);    
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }    
    
    public function deleteMovTripxFch($RUT_num_vuelo,$ITI_fchini,$ITI_fchfin) {
        try{            
            $sql_1 = "DELETE FROM [dbo].[SPV_MOVITRIP]
                        WHERE 
                            ( CONVERT(VARCHAR(10), [MOVTRIP_fch], 120) BETWEEN ? and ? ) AND
                            [RUT_num_vuelo] = ?";
            $param_1 = array($ITI_fchini,$ITI_fchfin,$RUT_num_vuelo);            
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
        
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutaxTipAvion($ITI_fchini,$ITI_fchfin) {
        try{            
            $sql_1 = "SELECT DISTINCT
                            ITIDET.[RUT_num_vuelo],
                            ITI.[AVI_id],TIPAVI.TIPAVI_serie,AV.[AVI_num_cola]
                        FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET
                        INNER JOIN [dbo].[SPV_ITINERARIO] ITI ON ITIDET.[ITI_id] = ITI.[ITI_id]
                        LEFT JOIN [dbo].[SPV_AVION] AV ON ITI.[AVI_id] = AV.[AVI_id]
                        LEFT JOIN SPV_TIPOAVION TIPAVI ON TIPAVI.TIPAVI_id = AV.TIPAVI_id
                        WHERE 
                        (CONVERT(VARCHAR(10), ITIDET.ITI_fch, 120) BETWEEN ? AND ?)
                        AND ITIDET.[ITI_id] IS NOT NULL";
                            // AND [ITI_id] IS NULL ;";
            $param_1 = array($ITI_fchini,$ITI_fchfin);    
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }    
    
    public function listarTripxVuelo($RUT_num_vuelo,$ITI_fch,$TIPTRIPDET_id){
        try{            
            $sql_1 = "SELECT
                            T.[TRIP_id],
							TRIPDET.*,
                            CONVERT(VARCHAR(10),TRIPDET.[ITI_fch],120) AS [ITI_fch], TRIPDET.[RUT_num_vuelo]

                    FROM [dbo].[SPV_TRIPULANTE] T
                    INNER JOIN [dbo].[SPV_ITI_TRIP_DET] TRIPDET ON T.[TRIP_id] = TRIPDET.[TRIP_id]
                    WHERE 
					TRIPDET.[RUT_num_vuelo] = ? AND
					CONVERT(VARCHAR(10),TRIPDET.[ITI_fch],120) = ? AND
					T.[TIPTRIPDET_id] = ?;";
            $param_1 = array($RUT_num_vuelo,$ITI_fch,$TIPTRIPDET_id);
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1)."</pre>";die();*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarTripxDia($TRIP_id,$TIPTRIPDET_id,$fch_ini,$fch_fin,$fch_ini2,$fch_fin2) {
        try{
            $condicional_1 = "";
            $param_1 = array();
            $param_2 = array();
            
            if( $TIPTRIPDET_id != "" ){
                $condicional_1 = " AND T.[TIPTRIPDET_id] = ?";
                $param_2 = array($TIPTRIPDET_id);
            } if( $TRIP_id != "" ){
                $condicional_1 = " AND T.[TRIP_id] = ?";
                $param_2 = array($TRIP_id);
            }
            
            $sql_1 = "SELECT DISTINCT
                                T.[TIPTRIPDET_id],TT.[TIPTRIP_id],
                                T.[TRIP_id],(T.[TRIP_apellido] +' '+ T.[TRIP_nombre]) AS [TRIP_nombreApellido],
                        CASE
                            WHEN CONVERT(VARCHAR(10), AM.[APT_fchgestion], 120) BETWEEN ? AND ?
                                THEN 'AM'
                                ELSE ''
                            END AS 'AptoMedico',

                        CASE
                            WHEN	(? BETWEEN CONVERT(VARCHAR(10), CUR.[CUR_fchini], 120) AND CONVERT(VARCHAR(10), CUR.[CUR_fchfin], 120)) OR
                                    (? BETWEEN CONVERT(VARCHAR(10), CUR.[CUR_fchini], 120) AND CONVERT(VARCHAR(10), CUR.[CUR_fchfin], 120))
                                THEN 'CUR'
                                ELSE ''
                            END AS 'Curso',

                        CASE
                            WHEN	CONVERT(VARCHAR(10), CHEQ.[CHEQ_fch], 120) BETWEEN ? AND ?
                                THEN 'CHEQ'
                                ELSE ''
                            END AS 'Chequeo',

                        CASE
                            WHEN	? BETWEEN DATEADD(DAY,-1,SIM.[SIMU_fchini]) AND DATEADD(DAY,-1,SIM.[SIMU_fchfin]) OR
                                    ? BETWEEN DATEADD(DAY,-1,SIM.[SIMU_fchini]) AND DATEADD(DAY,-1,SIM.[SIMU_fchfin])
                                THEN 'SIM'
                                ELSE ''
                            END AS 'Simulador',

                        CASE
                            WHEN	? BETWEEN CONVERT(VARCHAR(10), AU.[AUS_fchini], 120) AND CONVERT(VARCHAR(10), AU.[AUS_fchfin], 120) OR
                                    ? BETWEEN CONVERT(VARCHAR(10), AU.[AUS_fchini], 120) AND CONVERT(VARCHAR(10), AU.[AUS_fchfin], 120)
                                THEN
                                    CASE WHEN TIPAU.[TIPAUS_id] = '1' THEN 'LP'		ELSE
                                    CASE WHEN TIPAU.[TIPAUS_id] = '2' THEN 'VAC'	ELSE
                                    CASE WHEN TIPAU.[TIPAUS_id] = '3' THEN 'DM'		ELSE
                                    CASE WHEN TIPAU.[TIPAUS_id] = '4' THEN 'GEST'	ELSE
                                    CASE WHEN TIPAU.[TIPAUS_id] = '5' THEN 'PJ'			END END END END END
                                ELSE ''
                            END AS 'Ausencia',

                            CASE
                                WHEN T.[TRIP_id] in (SELECT [TRIP_id] FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET WHERE (CONVERT(VARCHAR(10), ITIDET.ITI_fch, 120) BETWEEN ? AND ?))
                                    THEN STUFF(
                                    (Select '-' + 
                                        [RUT_num_vuelo] 
                                            FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET 
                                                WHERE 
                                                    (CONVERT(VARCHAR(10), ITIDET.ITI_fch, 120) BETWEEN ? AND ? 
                                                    AND ITIDET.[TRIP_id] = T.[TRIP_id])
                                    FOR XML PATH('') ), 1, 1, '')
                                    ELSE ''
                                END AS 'Rutas',
                            
                            CASE
                                WHEN T.[TRIP_id] in (SELECT [TRIP_id] FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET WHERE (CONVERT(VARCHAR(10), ITIDET.ITI_fch, 120) BETWEEN ? AND ?))
                                    THEN STUFF(
										(Select '-' + 
											RUT.[RUT_pernocte] 
                                            FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET 
											LEFT JOIN [dbo].[SPV_RUTA] RUT ON ITIDET.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                                                WHERE 
                                                    ( CONVERT(VARCHAR(10), ITIDET.ITI_fch, 120) BETWEEN ? AND ? 
                                                    AND ITIDET.[TRIP_id] = T.[TRIP_id] )
                                    FOR XML PATH('') ), 1, 1, '')
                                    ELSE ''
                                END AS 'Pernocte',

							CASE
                                WHEN T.[TRIP_id] in (SELECT [TRIP_id] FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET WHERE (CONVERT(VARCHAR(10), ITIDET.ITI_fch, 120) BETWEEN ? AND ?))
                                    THEN STUFF(
										(Select '' + 
											RUT.[RUT_salidaPernocte]
                                            FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET 
											LEFT JOIN [dbo].[SPV_RUTA] RUT ON ITIDET.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                                                WHERE 
                                                    ( CONVERT(VARCHAR(10), ITIDET.ITI_fch, 120) BETWEEN ? AND ? 
                                                    AND ITIDET.[TRIP_id] = T.[TRIP_id] )
                                    FOR XML PATH('') ), 1, 1, '')
                                    ELSE ''
                                END AS 'salidaPernocte',
                                
                            (select sum([RUTTIME_timeBT])
                                    FROM [dbo].[SPV_RUTA_TIMEPROY] RTP 
                                    LEFT JOIN [dbo].[SPV_MOVITRIP] MT ON RTP.[RUT_num_vuelo] = MT.[RUT_num_vuelo] 
                                    WHERE 
                                    (CONVERT(VARCHAR(10), MT.[MOVTRIP_fch], 120) BETWEEN ? AND ?)
                                    AND 
                                    ( MT.[TRIP_id] = T.[TRIP_id] )
                            ) AS [TimeBT],

							CASE
                                WHEN T.[TRIP_id] in (SELECT [TRIP_id] FROM [dbo].[SPV_MOTOR_CAMBIO] MC WHERE (CONVERT(VARCHAR(10), MC.[ITI_fch], 120) BETWEEN ? AND ?))
                                    THEN 'Si'
                                    ELSE 'No'
                                END AS 'Cambio',
                            
                            CASE
                            WHEN CONVERT(VARCHAR(10), LIB.[ITI_fch], 120) BETWEEN ? AND ?
                                THEN 'LIB'
                                ELSE ''
                            END AS 'Libre',
                            
                            CASE
                            WHEN CONVERT(VARCHAR(10), RES.[ITI_fch], 120) BETWEEN ? AND ?
                                THEN 'DC'
                                ELSE ''
                            END AS 'Reserva'                            

                        FROM [dbo].[SPV_TRIPULANTE] T
                        LEFT JOIN [dbo].[SPV_APTOMED] AM ON  AM.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_PARTICIPANTE] P ON P.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_CURSO] CUR ON P.[CUR_id] = CUR.[CUR_id]
                        LEFT JOIN [dbo].[SPV_CHEQUEO] CHEQ ON CHEQ.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_SIMULADOR] SIM ON SIM.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_AUSENCIA] AU ON AU.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_LIBRE_TRIP] LIB ON LIB.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_RESERVA_TRIP] RES ON RES.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOAUSENCIA] TIPAU ON TIPAU.[TIPAUS_id] = AU.[TIPAUS_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
						LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        WHERE T.[TRIP_id] != 0
                        ".$condicional_1."
                        ORDER BY 3 ASC";
            $param_1 = array($fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini2,$fch_fin2,$fch_ini,$fch_fin,$fch_ini,$fch_fin,$fch_ini,$fch_fin);
            
            $param_1 = array_merge($param_1,$param_2);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            
            //echo "<pre>".print_r($result)."7</pre>";die();
            
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarHistorialTripxDia($TRIP_id,$fchLista) {
        try{
            $sql_1 = "SELECT [MOTCAMB_id],[TRIP_id],[MOTCAMB_tipoCambio],[MOTCAMB_original],[MOTCAMB_modificado],[ITI_fch],
                        [AUD_usu_mod],[AUD_fch_mod]
                        FROM [dbo].[SPV_MOTOR_CAMBIO]
                            WHERE  
                                    [ITI_fch] = ?
                                AND	[TRIP_id] = ?";
            $param_1 = array($fchLista,$TRIP_id);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutaConHorario($ITI_fch,$RUT_num_vuelo) {
        try{            
            $sql_1 = "SELECT DISTINCT
                        RUT.RUT_num_vuelo,
                        RUT.[RUT_relacion],
                        RUT.[RUT_orden],
                        RUT.CIU_id_origen,
                        RUT.CIU_id_destino,
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada]
                        FROM SPV_RUTA RUT
                        LEFT JOIN SPV_RUTAxDIA RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        WHERE
                        RUTD.[RUTDIA_diaSemana] = DateName(weekday,?) AND
                        RUT.RUT_num_vuelo = ?
                        ORDER BY RUT.RUT_orden ASC;";
            $param_1 = array($ITI_fch,$RUT_num_vuelo);
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutaCompleta($fechaProg,$RUT_pairing){
        try{            
            $condicional_1 = "";
            $param_1 = array();
            $param_2 = array();
            
            if( $RUT_pairing == "" && $fechaProg != "" ){
                $condicional_1 = " AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?) AND RUT.[RUT_num_vuelo] NOT IN ( SELECT RUT_num_vuelo FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET WHERE CONVERT(VARCHAR(10),ITIDET.[ITI_fch],120) = ? ) ";
                $param_1 = array($fechaProg,$fechaProg);
            }
            if( $RUT_pairing != '' ){
                $condicional_1 = " AND RUTD.[RUT_pairing] IN ( SELECT RUTD2.RUT_pairing from SPV_RUTA RUT2 LEFT JOIN SPV_RUTAxDIA RUTD2 ON RUTD2.[RUT_num_vuelo] = RUT2.[RUT_num_vuelo]  where  RUT2.RUT_relacion = ?  AND RUT2.[RUT_num_vuelo] = ? ) AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?) AND RUT.[RUT_num_vuelo] NOT IN ( SELECT RUT_num_vuelo FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET WHERE CONVERT(VARCHAR(10),ITIDET.[ITI_fch],120) = ? ) ";
                $param_1 = array($RUT_pairing,$RUT_pairing,$fechaProg,$fechaProg);
            }
            
            $sql_1 = "SELECT DISTINCT
                        RUT.RUT_num_vuelo,
                        RUT.[RUT_relacion],
                        RUTD.[RUT_pairing],
                        RUT.[RUT_orden],
                        RUT.CIU_id_origen,
                        RUT.CIU_id_destino,
                        RUT_campoAltura,
                        RUT_pernocte,
                        RUT_salidaPernocte,
                        RUT_avionTipico,
						RUTD.[RUT_hora_salida]
                        FROM SPV_RUTA RUT
                        LEFT JOIN SPV_RUTAxDIA RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
						WHERE RUTD.[RUT_programacion] = 'Si'
                        ".$condicional_1."
                        ORDER BY RUTD.[RUT_pairing], RUTD.[RUT_hora_salida] ASC;";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $param_1 = array_merge($param_1);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutaCompletaRelacion($fechaProg){
        try{            
            $condicional_1 = "";
            $param_1 = array();
            $param_2 = array();
            
            if( $RUT_pairing == "" && $fechaProg != "" ){
                $condicional_1 = " AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?) AND RUT.[RUT_num_vuelo] NOT IN ( SELECT RUT_num_vuelo FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET WHERE CONVERT(VARCHAR(10),ITIDET.[ITI_fch],120) = ? ) ";
                $param_1 = array($fechaProg,$fechaProg);
            }
            
            $sql_1 = "SELECT DISTINCT
                        RUT.RUT_num_vuelo,
                        RUT.[RUT_relacion],
                        RUTD.[RUT_pairing],
                        RUT.[RUT_orden],
                        RUT.CIU_id_origen,
                        RUT.CIU_id_destino,
                        RUT_campoAltura,
                        RUT_pernocte,
                        RUT_salidaPernocte,
                        RUT_avionTipico,
						RUTD.[RUT_hora_salida]
                        FROM SPV_RUTA RUT
                        LEFT JOIN SPV_RUTAxDIA RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
						WHERE RUTD.[RUT_programacion] = 'Si'
                        AND RUT.RUT_num_vuelo IN (SELECT RUT_relacion FROM SPV_RUTA) 
                        ".$condicional_1."
                        AND RUT.RUT_num_vuelo NOT IN ('126')
                        ORDER BY RUTD.[RUT_pairing], RUTD.[RUT_hora_salida] ASC;";
            $param_1 = array_merge($param_1);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
        
    public function listarRutaPernocte(){
        try{            
            $condicional_1 = "";
            $param_1 = array();
            
            $sql_1 = "SELECT
                            RUT.[RUT_num_vuelo],RUT.[RUT_aerolinea],RUT.[RUT_orden],RUT.[RUT_relacion],RUT.[RUT_escala],RUT.[RUT_primer_vuelo],RUT.[RUT_campoAltura],RUT.[RUT_pernocte],
                            RUT.[RUT_salidaPernocte],RUT.[CIU_id_origen],RUT.[CIU_id_destino],RUT.[RUT_estado]
                        FROM SPV_RUTA RUT
                        WHERE RUT.[RUT_pernocte] = 'Si'";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarsalidaRutaPernocte($RUT_num_vuelo,$fechaProg){
        try{            
            $condicional_1 = "";
            $param_1 = array();
            
            $sql_1 = "SELECT DISTINCT	[RUT_num_vuelo],[RUTDIA_diaSemana],[RUT_programacion],[RUT_pairing],[RUT_hora_salida],[RUT_hora_llegada],[RUTDIA_estado],[AUD_usu_cre],[AUD_fch_cre]
                        FROM [dbo].[SPV_RUTAxDIA]
                        WHERE [RUT_pairing] =
                            (SELECT DISTINCT RUTD.[RUT_pairing]
                                FROM [dbo].[SPV_RUTA] RUT
                                LEFT JOIN [dbo].[SPV_RUTAxDIA] RUTD ON RUT.[RUT_num_vuelo] = RUTD.[RUT_num_vuelo]
                                WHERE RUT.[RUT_salidaPernocte] is not null and RUT.[RUT_salidaPernocte] = ?)
                        AND [RUTDIA_diaSemana] = DateName(weekday,?) ";
            $param_1 = array($RUT_num_vuelo,$fechaProg);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarRutaAvionTipico($TIPAVI_serie){
        try{            
            $condicional_1 = "";
            
            $sql_1 = "SELECT
                            RUT.[RUT_num_vuelo],RUT.[RUT_aerolinea],RUT.[RUT_orden],RUT.[RUT_relacion],RUT.[RUT_escala],RUT.[RUT_primer_vuelo],RUT.[RUT_avionTipico],RUT.[RUT_campoAltura],RUT.[RUT_pernocte],
                            RUT.[RUT_salidaPernocte],RUT.[CIU_id_origen],RUT.[CIU_id_destino],RUT.[RUT_estado]
                        FROM SPV_RUTA RUT
						WHERE RUT.[RUT_avionTipico] = ?";
            $param_1 = array($TIPAVI_serie);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function verificarFchProgramada($ITI_fch){
        try{            
            $sql_1 = "SELECT 
                            [RUT_num_vuelo],
                            CONVERT(VARCHAR(10),[ITI_fch],120) AS [ITI_fch],
                            [TRIP_id],[TIPTRIPU_id],[ITI_TRIP_tipo],[AUD_usu_cre],[AUD_fch_cre]
                        FROM [dbo].[SPV_ITI_TRIP_DET]
                        WHERE CONVERT(VARCHAR(10),[ITI_fch],120) = ?;";
            $param_1 = array($ITI_fch);
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
        
    public function insertProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch,$TRIP_id,$TIPTRIPU_id,$ITI_TRIP_tipo){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_ITI_TRIP_DET]
                        ([ITI_id],[RUT_num_vuelo],[ITI_fch],[TRIP_id],[TIPTRIPU_id],[ITI_TRIP_tipo],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (".$ITI_id.",?,?,?,?,?,?,?)";
            $param_1 = array($RUT_num_vuelo,$ITI_fch,$TRIP_id,$TIPTRIPU_id,$ITI_TRIP_tipo,$this->usuario,date("Ymd H:i:s"));
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/ 
            //die();
            $result = $this->database->Ejecutar($sql_1,$param_1);
            
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function updateProgramacion($TRIP_id,$ITI_fch,$RUT_num_vuelo,$ITI_TRIP_tipo){
        try{
            $sql_1 = "UPDATE [dbo].[SPV_ITI_TRIP_DET]
                        SET [TRIP_id] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE CONVERT(VARCHAR(10), ITI_fch, 120) = ? AND [RUT_num_vuelo] = ? AND [ITI_TRIP_tipo] = ?";
            $param_1 = array($TRIP_id,$this->usuario,date("Ymd H:i:s"),$ITI_fch,$RUT_num_vuelo,$ITI_TRIP_tipo);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";//die();*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function updateProgramacion_xITI($ITI_id,$RUT_num_vuelo,$ITI_fch){
        try{
            $sql_1 = "UPDATE [dbo].[SPV_ITI_TRIP_DET]
                        SET [ITI_id] = ?, [AUD_usu_mod] = ?, [AUD_fch_mod] = ?
                        WHERE 
                        [RUT_num_vuelo] = ? AND
                        CONVERT(VARCHAR(10),[ITI_fch],120) = ?";
            
            $param_1 = array($ITI_id,$this->usuario,date("Ymd H:i:s"),$RUT_num_vuelo,$ITI_fch);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }  
    
    public function updateProgramacion_xTrip($TRIP_id,$TRIP_id_old,$ITI_fch,$RUT_num_vuelo){
        try{
            $sql_1 = "UPDATE [dbo].[SPV_ITI_TRIP_DET]
                        SET [TRIP_id] = ?, [AUD_usu_mod] = ?, [AUD_fch_mod] = ?
                        WHERE
                        [TRIP_id] = ? AND
                        CONVERT(VARCHAR(10),[ITI_fch],120) = ? AND
                        [RUT_num_vuelo] = ? ";
            
            $param_1 = array($TRIP_id,$this->usuario,date("Ymd H:i:s"),$TRIP_id_old,$ITI_fch,$RUT_num_vuelo);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*public function updateProgramacion_xTripRuta($TRIP_id,$ITI_TRIP_tipo,$ITI_fch,$RUT_num_vuelo){
        try{
            $sql_1 = "UPDATE [dbo].[SPV_ITI_TRIP_DET]
                        SET [TRIP_id] = ?, [AUD_usu_mod] = ?, [AUD_fch_mod] = ?
                        WHERE
                        [ITI_TRIP_tipo] = ? AND
                        CONVERT(VARCHAR(10),[ITI_fch],120) = ? AND
                        [RUT_num_vuelo] = ? ";
            
            $param_1 = array($TRIP_id,$this->usuario,date("Ymd H:i:s"),$ITI_TRIP_tipo,$ITI_fch,$RUT_num_vuelo);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }*/
    
    public function insertMovimientoTrip($TRIP_id,$ITI_fch,$RUT_num_vuelo,$MOVTRIP_BTreal_ini,$MOVTRIP_BTreal_fin,$MOVTRIP_BTreal_time,$MOVTRIP_BTreal_time_tipo,$MOVTRIP_DTreal_ini,$MOVTRIP_DTreal_fin,$MOVTRIP_DTreal_time,$MOVTRIP_DTreal_time_tipo){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_MOVITRIP]
                        ([TRIP_id],[MOVTRIP_fch],[RUT_num_vuelo],
                        [MOVTRIP_BTreal_ini],[MOVTRIP_BTreal_fin],[MOVTRIP_BTreal_time],[MOVTRIP_BTreal_time_tipo],
                        [MOVTRIP_DTreal_ini],[MOVTRIP_DTreal_fin],[MOVTRIP_DTreal_time],[MOVTRIP_DTreal_time_tipo],
                        [AUD_usu_cre],[AUD_fch_cre])
                        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $param_1 = array($TRIP_id,$ITI_fch,$RUT_num_vuelo,$MOVTRIP_BTreal_ini,$MOVTRIP_BTreal_fin,$MOVTRIP_BTreal_time,$MOVTRIP_BTreal_time_tipo,$MOVTRIP_DTreal_ini,$MOVTRIP_DTreal_fin,$MOVTRIP_DTreal_time,$MOVTRIP_DTreal_time_tipo,$this->usuario,date("Ymd H:i:s"));
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function insertLibreTrip($TRIP_id,$ITI_fch,$TRIP_LIB_estado){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_LIBRE_TRIP](
                        [TRIP_id],[ITI_fch],[TRIP_LIB_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?,?);";
            $param_1 = array($TRIP_id,$ITI_fch,$TRIP_LIB_estado,$this->usuario,date("Ymd H:i:s"));
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    
    public function insertCoTeFiTaTrip($TRIP_id,$CTFT_TRIP_fch,$RUT_num_vuelo,$CT_FT_id){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_COTEFITA_TRIP]
                        ([TRIP_id],[CTFT_TRIP_fch],[RUT_num_vuelo],[CT_FT_id],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?,?,?);";
            $param_1 = array($TRIP_id,$CTFT_TRIP_fch,$RUT_num_vuelo,$CT_FT_id,$this->usuario,date("Ymd H:i:s"));            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function updateMovimientoTrip($TRIP_id,$TRIP_id_old,$ITI_fch,$RUT_num_vuelo){
        try{
            $sql_1 = "UPDATE [dbo].[SPV_MOVITRIP]
                        SET [TRIP_id] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE CONVERT(VARCHAR(10),[MOVTRIP_fch],120) = ? AND [RUT_num_vuelo] = ? and [TRIP_id] = ?;";
            $param_1 = array($TRIP_id,$this->usuario,date("Ymd H:i:s"),$ITI_fch,$RUT_num_vuelo,$TRIP_id_old);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarProgramacionxTripulante($RUT_num_vuelo,$ITI_fch) {
        try{
            $sql_1 = "SELECT 
						ITRIP.[ITI_id],ITRIP.[TRIP_id],ITRIP.[TIPTRIPU_id],
						ITRIP.[RUT_num_vuelo],ITRIP.[ITI_fch],
                        T.[TRIP_nombre],T.[TRIP_apellido],
                        ITRIP.[ITI_TRIP_tipo],
                        ITRIP.[AUD_usu_cre],CONVERT(VARCHAR(20),ITRIP.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        ITRIP.[AUD_usu_mod],CONVERT(VARCHAR(20),ITRIP.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_ITI_TRIP_DET] ITRIP
                        LEFT JOIN [SPV_TRIPULANTE] T ON T.[TRIP_id] = ITRIP.[TRIP_id]
						WHERE 
						ITRIP.[RUT_num_vuelo] = ? AND
						CONVERT(VARCHAR(10),[ITI_fch],120) = ?";
            $param_1 = array($RUT_num_vuelo,$ITI_fch);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function deleteProgramacion($RUT_num_vuelo,$ITI_fch){
        try{
			$sql_1 = "DELETE FROM [dbo].[SPV_ITI_TRIP_DET] WHERE [RUT_num_vuelo] = ? AND CONVERT(VARCHAR(10),[ITI_fch],121) = ?;";
			$sql_2 = "DELETE FROM [dbo].[SPV_MOVITRIP] WHERE [RUT_num_vuelo] = ? AND CONVERT(VARCHAR(10),[MOVTRIP_fch],121) = ?;";
			$sql_3 = "DELETE FROM [dbo].[SPV_COTEFITA_TRIP] WHERE [RUT_num_vuelo] = ? AND CONVERT(VARCHAR(10),CTFT_TRIP_fch,121) = ?;";
			
            //$param_1 = array($ITI_id);
			$param_1 = array($RUT_num_vuelo,$ITI_fch);
			$param_2 = array($RUT_num_vuelo,$ITI_fch);
			$param_3 = array($RUT_num_vuelo,$ITI_fch);
            
            /*echo $sql_1."<br/>";
            echo $sql_2."<br/>";
            echo $sql_3."<br/>";
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $this->database->Ejecutar($sql_1,$param_1);
            $this->database->Ejecutar($sql_2,$param_2);
            $this->database->Ejecutar($sql_3,$param_3);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function deleteProgramacionMesSgte($ITI_fchIni,$ITI_fchFin){
        try{
			$sql_1 = "DELETE FROM [dbo].[SPV_ITI_TRIP_DET] WHERE CONVERT(VARCHAR(10),[ITI_fch],121) BETWEEN ? AND ?;";
			$sql_2 = "DELETE FROM [dbo].[SPV_MOVITRIP] WHERE CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN ? AND ?;";
			$sql_3 = "DELETE FROM [dbo].[SPV_COTEFITA_TRIP] WHERE CONVERT(VARCHAR(10),CTFT_TRIP_fch,121) BETWEEN ? AND ?;";
			$sql_4 = "DELETE FROM [dbo].[SPV_LIBRE_TRIP] WHERE CONVERT(VARCHAR(10),ITI_fch,121) BETWEEN ? AND ?;";
            
            $param_1 = array($ITI_fchIni,$ITI_fchFin);
            
            $this->database->Ejecutar($sql_1,$param_1);
            $this->database->Ejecutar($sql_2,$param_1);
            $this->database->Ejecutar($sql_3,$param_1);
            $this->database->Ejecutar($sql_4,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function deleteLibre($ITI_fch,$TRIP_id){
        try{
			$sql_1 = "DELETE FROM [dbo].[SPV_LIBRE_TRIP] WHERE [ITI_fch] = ? AND [TRIP_id] = ?";
			$param_1 = array($ITI_fch,$TRIP_id);
            
            /*echo $sql_1."<br/>";
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $this->database->Ejecutar($sql_1,$param_1);
            
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function cancelarProgramacion($ITI_id,$RUT_num_vuelo,$ITI_fch){
        try{
			$sql_2 = "DELETE FROM [dbo].[SPV_MOVITRIP] WHERE [RUT_num_vuelo] = ? AND CONVERT(VARCHAR(10),[MOVTRIP_fch],103) = ?;";
			$sql_3 = "DELETE FROM [dbo].[SPV_COTEFITA_TRIP] WHERE [RUT_num_vuelo] = ? AND CONVERT(VARCHAR(10),CTFT_TRIP_fch,103) = ?;";
			
            $param_2 = array($RUT_num_vuelo,$ITI_fch);
			$param_3 = array($RUT_num_vuelo,$ITI_fch);
            
            $this->database->Ejecutar($sql_2,$param_2);
            $this->database->Ejecutar($sql_3,$param_3);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function listarProgramacionResumenMatriz($ITI_fch,$AVI_id,$RUT_num_vuelo){
        try{
            $condicional = "";
            $param = array();
            
            if($AVI_id != ''){
                $condicional = " AND (SELECT ITI.[AVI_id] FROM [dbo].[SPV_ITINERARIO] ITI LEFT JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id] WHERE ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND  CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) = ?";
                $param = array($AVI_id);
            }
            if($RUT_num_vuelo != ''){
                $condicional = " AND TRIPDET.RUT_num_vuelo = ?";
                $param = array($RUT_num_vuelo);
            }
            $sql_1 = "SELECT 
                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN TRIPDET.[ITI_id]
                                ELSE ''
                            END AS 'ITI_id',
                        CONVERT(VARCHAR(20),TRIPDET.[ITI_fch],103) AS [ITI_fch],
                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN (
                                        SELECT ITI.[ITI_proceso] FROM [dbo].[SPV_ITINERARIO] ITI
                                        WHERE 
                                        ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND 
                                        CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120)
                                )
                                ELSE ''
                            END AS 'ITI_proceso',

                        TRIPDET.[RUT_num_vuelo],RUT.[RUT_relacion],RUT.[RUT_orden],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],

                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN (
                                        SELECT ITI.[AVI_id] FROM [dbo].[SPV_ITINERARIO] ITI 
                                        LEFT JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id]
                                        WHERE 
                                        ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND 
                                        CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120)
                                    )
                                ELSE ''
                            END AS 'AVI_id',

                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN (
                                        SELECT AVI.[AVI_num_cola] FROM [dbo].[SPV_ITINERARIO] ITI 
                                        LEFT JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id]
                                        WHERE 
                                        ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND 
                                        CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120)
                                    )
                                ELSE ''
                            END AS 'AVI_num_cola',

                        DATENAME(dw,TRIPDET.[ITI_fch]) AS [ITI_dia],
                        DATENAME(dd,TRIPDET.[ITI_fch]) AS [ITI_fchdiaN],
                        DATENAME(mm,TRIPDET.[ITI_fch]) AS [ITI_fchmes],
                        DATENAME(yy,TRIPDET.[ITI_fch]) AS [ITI_fchanio]

                        FROM [dbo].[SPV_ITI_TRIP_DET] TRIPDET
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON RUT.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo]
                        LEFT JOIN  [dbo].[SPV_RUTAxDIA] RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]

                        WHERE CONVERT(VARCHAR(20),TRIPDET.[ITI_fch],103) = ?
                        AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?)
                        
                        ".$condicional."

                        GROUP BY 
                        TRIPDET.[ITI_id],
                        TRIPDET.[ITI_fch],
                        TRIPDET.[RUT_num_vuelo],RUT.[RUT_relacion],RUT.[RUT_orden],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108),
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108)

                        ORDER BY RUT.RUT_orden ASC;";
            $param_1 = array($ITI_fch,$ITI_fch);
            $param_1 = array_merge($param_1,$param);
            
            /*echo $sql_1."<br/>";
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarProgramacionResumen($ITI_fch,$AVI_id,$RUT_num_vuelo) {
        try{
            $condicional = "";
            $param = array();
            
            if($AVI_id != ''){
                $condicional = " AND (SELECT ITI.[AVI_id] FROM [dbo].[SPV_ITINERARIO] ITI LEFT JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id] WHERE ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND  CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) = ?";
                $param = array($AVI_id);
            }
            if($RUT_num_vuelo != ''){
                $condicional = " AND TRIPDET.RUT_num_vuelo = ?";
                $param = array($RUT_num_vuelo);
            }
            $sql_1 = "SELECT 
                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN TRIPDET.[ITI_id]
                                ELSE ''
                            END AS 'ITI_id',
                        CONVERT(VARCHAR(20),TRIPDET.[ITI_fch],103) AS [ITI_fch],
                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN (
                                        SELECT ITI.[ITI_proceso] FROM [dbo].[SPV_ITINERARIO] ITI
                                        WHERE 
                                        ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND 
                                        CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120)
                                )
                                ELSE ''
                            END AS 'ITI_proceso',

                        TRIPDET.[RUT_num_vuelo],RUT.[RUT_relacion],RUT.[RUT_orden],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],

                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN (
                                        SELECT ITI.[AVI_id] FROM [dbo].[SPV_ITINERARIO] ITI 
                                        LEFT JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id]
                                        WHERE 
                                        ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND 
                                        CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120)
                                    )
                                ELSE ''
                            END AS 'AVI_id',

                        CASE
                            WHEN ( SELECT count(*) FROM [dbo].[SPV_ITINERARIO] ITI WHERE CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120) ) > 0
                                THEN (
                                        SELECT AVI.[AVI_num_cola] FROM [dbo].[SPV_ITINERARIO] ITI 
                                        LEFT JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id]
                                        WHERE 
                                        ITI.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo] AND 
                                        CONVERT(VARCHAR(10), ITI.[ITI_fch], 120) = CONVERT(VARCHAR(10), TRIPDET.[ITI_fch], 120)
                                    )
                                ELSE ''
                            END AS 'AVI_num_cola',

                        DATENAME(dw,TRIPDET.[ITI_fch]) AS [ITI_dia],
                        DATENAME(dd,TRIPDET.[ITI_fch]) AS [ITI_fchdiaN],
                        DATENAME(mm,TRIPDET.[ITI_fch]) AS [ITI_fchmes],
                        DATENAME(yy,TRIPDET.[ITI_fch]) AS [ITI_fchanio],

                        TRIPDET.[TRIP_id],TRIPDET.[TIPTRIPU_id],TRIPDET.[ITI_TRIP_tipo],
                        T.[TRIP_nombre],T.[TRIP_apellido],

                        TRIPDET.[AUD_usu_cre],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        TRIPDET.[AUD_usu_mod],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_mod],120) AS [AUD_fch_mod]

                        FROM [dbo].[SPV_ITI_TRIP_DET] TRIPDET
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON RUT.[RUT_num_vuelo] = TRIPDET.[RUT_num_vuelo]
                        LEFT JOIN  [dbo].[SPV_RUTAxDIA] RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T	ON T.[TRIP_id] = TRIPDET.[TRIP_id]

                        WHERE CONVERT(VARCHAR(20),TRIPDET.[ITI_fch],103) = ?
                        AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?)

                        ".$condicional."

                        GROUP BY 
                        TRIPDET.[ITI_id],
                        TRIPDET.[ITI_fch],
                        TRIPDET.[RUT_num_vuelo],RUT.[RUT_relacion],RUT.[RUT_orden],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108),
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108),
                        TRIPDET.[TRIP_id],TRIPDET.[TIPTRIPU_id],TRIPDET.[ITI_TRIP_tipo],
                        T.[TRIP_nombre],T.[TRIP_apellido],
                        TRIPDET.[AUD_usu_cre],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_cre],120),
                        TRIPDET.[AUD_usu_mod],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_mod],120)

                        ORDER BY RUT.RUT_orden ASC;";
            $param_1 = array($ITI_fch,$ITI_fch);
            $param_1 = array_merge($param_1,$param);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function data_last_month_day($mesProgramar) { 
        $month = $mesProgramar;
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }

    public function data_first_month_day($mesProgramar) {
        $month = $mesProgramar;
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }
}
?>