<?php
if( !isset($_SESSION)){
	session_start();
}

class Motor_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    public function listarTripulanteCondicionalesBasicas($TIPTRIP_id,$TIPTRIPDET_id,$fechaProg,$TRIP_id,$arrayTRIP_id,$Instructor,$libre) {
        try{
            $condicional = '';
            $condicional_2 = '';
            $condicional_3 = '';
            $param_1 = array();
            $param_2 = array();
            $param_3 = array();
            $fechaProgDiaSgte = strtotime ( '+1 day' , strtotime ( $fechaProg ) ) ;
            $fechaProgDiaSgte = date ( 'Y-m-d' , $fechaProgDiaSgte );
            
            if($TIPTRIP_id != '' and $TIPTRIPDET_id != '' and $Instructor == ''){
                $condicional = ' AND T.TIPTRIPDET_id = ? AND TT.[TIPTRIP_id] = ?';
                $param_1 = array($TIPTRIPDET_id,$TIPTRIP_id);
            }
            
            if($TIPTRIP_id != '' and $TIPTRIPDET_id != '' and $Instructor != ''){
                $condicional = ' AND T.TIPTRIPDET_id = ? AND TT.[TIPTRIP_id] = ? AND T.[TRIP_instructor] = ?';
                $param_1 = array($TIPTRIPDET_id,$TIPTRIP_id,$Instructor);
            }
            
            if ($TIPTRIPDET_id == '2'){
                $condicional .= ' AND CATREQ.[CAT_id] IN (SELECT T.[CAT_id] FROM [dbo].[SPV_TRIPULANTE] T WHERE T.[TIPTRIPDET_id] = 1 AND T.[TRIP_id] = ?) AND CATREQ.[CAT_idAcomp] = T.[CAT_id]';
                $complemento = " INNER JOIN [dbo].[SPV_CATEGREQUISITOS] CATREQ ON T.[TIPTRIPDET_id] = CATREQ.[TIPTRIPDET_idAcomp]";
                $param_2 = array($TRIP_id);
                $param_1 = array_merge($param_1,$param_2);
            }
            if( $arrayTRIP_id != '' and $libre == "" ){
                $condicional_2 = " AND T.[TRIP_id] NOT IN (".$arrayTRIP_id.")";
            }
            
            if( $libre == "" ){
                $condicional_3 = "AND T.[TRIP_id] NOT IN ( SELECT TRIP_LIB.[TRIP_id] FROM [dbo].[SPV_LIBRE_TRIP] TRIP_LIB WHERE ? = TRIP_LIB.[ITI_fch] AND TRIP_LIB.[TRIP_LIB_estado] = 1 )";
                $param_3 = array($fechaProg);
            }
            
            if( $libre != "" ){
                $condicional_3 = "AND T.[TRIP_id] IN ( SELECT TRIP_LIB.[TRIP_id] FROM [dbo].[SPV_LIBRE_TRIP] TRIP_LIB WHERE (? = TRIP_LIB.[ITI_fch] OR ? = TRIP_LIB.[ITI_fch]) AND TRIP_LIB.[TRIP_LIB_estado] = 1 ) AND T.[TRIP_id] NOT IN ( SELECT ITIDET.[TRIP_id] FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET WHERE CONVERT(VARCHAR(10),ITIDET.[ITI_fch],121) = ? )";
                $param_3 = array($fechaProg,$fechaProgDiaSgte,$fechaProg);
                $demo = "demo";
            }
            
            /*$sql_1 = "SELECT
                        T.[TRIP_id],
                        T.[TRIP_instructor],
                        (((365* year(getdate()))-(365*(year([TRIP_fechnac]))))+ (month(getdate())-month([TRIP_fechnac]))*30 +(day(getdate()) - day([TRIP_fechnac])))/365 AS [TRIP_edad],
                        T.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        T.[TRIP_nombre],T.[TRIP_apellido]
                        
                        FROM [dbo].[SPV_TRIPULANTE] T
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$complemento."
                        
                        WHERE
                        
                        T.[TRIP_id] NOT IN ( -- Para Aptos
                            SELECT AM.[TRIP_id] FROM [dbo].[SPV_APTOMED] AM
                            WHERE
                                (AM.[APT_fchgestion] = ? AND AM.[APT_estado] = 1)
                            -- OR	(AM.[APT_fchentrega] != '' AND AM.[APT_indicador] = 'No' AND AM.[APT_estado] = 1)
                            -- OR	(AM.[APT_fchvenci] <= ? AND AM.[APT_indicador] = 'No' AND AM.[APT_estado] = 1)
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Cursos
                            SELECT PA.[TRIP_id] FROM [dbo].[SPV_PARTICIPANTE] PA 
                            LEFT JOIN [dbo].[SPV_CURSO] CUR ON PA.[CUR_id] = CUR.[CUR_id]
                            WHERE
                                (? >= CUR.[CUR_fchini] AND ? <= CUR.[CUR_fchfin] AND CUR.[CUR_estado] = 1 )
                            -- OR	(CUR.[CUR_fchinforme] != '' AND PA.[PART_indicador] != 'APROBADO' AND CUR.[CUR_estado] = 1)
                            -- OR	(CUR.[CUR_fchfin] < ? AND PA.[PART_indicador] != 'APROBADO' AND CUR.[CUR_fchinforme] != '' AND CUR.[CUR_estado] = 1)
                        )
                        
                        -- AND
                        -- T.[TRIP_id] NOT IN ( -- Para Chequeo
                            -- SELECT CQ.[TRIP_id] FROM [dbo].[SPV_CHEQUEO] CQ 
                            -- WHERE
                                -- (CQ.[CHEQ_fchentrega] != '' AND CQ.[CHEQ_indicador] != 'APROBADO'  AND CQ.[CHEQ_estado] = 1)
                        -- )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Simulador
                            SELECT SIM.[TRIP_id] FROM [dbo].[SPV_SIMULADOR] SIM
                            WHERE
                                (? >= DATEADD(DAY,-1,SIM.[SIMU_fchini]) AND ? <= DATEADD(DAY,+1,SIM.[SIMU_fchfin]) AND SIM.[SIMU_estado] = 1 )
                            -- OR  (SIM.[SIMU_fchentrega] != '' AND SIM.[SIMU_indicador] != 'APROBADO'  AND SIM.[SIMU_estado] = 1)
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Ausencias
                            SELECT AUS.[TRIP_id] FROM [dbo].[SPV_AUSENCIA] AUS
                            WHERE
                                ? >= AUS.[AUS_fchini] AND ? <= AUS.[AUS_fchfin] AND AUS.[AUS_estado] = 1
                        )
                        
                        AND 
						T.[TRIP_id] NOT IN ( -- Para Libres
                            SELECT TRIP_LIB.[TRIP_id] FROM [dbo].[SPV_LIBRE_TRIP] TRIP_LIB
                            WHERE
                                ? = TRIP_LIB.[ITI_fch]
                            AND TRIP_LIB.[TRIP_LIB_estado] = 1
                        )
                        
                        ".$condicional_2."
						".$condicional;*/
            
            $sql_1 = "SELECT
                        T.[TRIP_id],
                        T.[TRIP_instructor],
                        (((365* year(getdate()))-(365*(year([TRIP_fechnac]))))+ (month(getdate())-month([TRIP_fechnac]))*30 +(day(getdate()) - day([TRIP_fechnac])))/365 AS [TRIP_edad],
                        T.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        T.[TRIP_nombre],T.[TRIP_apellido]
                        
                        FROM [dbo].[SPV_TRIPULANTE] T
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$complemento."
                        
                        WHERE
                        
                        T.[TRIP_id] NOT IN ( -- Para Aptos
                            SELECT AM.[TRIP_id] FROM [dbo].[SPV_APTOMED] AM
                            WHERE
                                (AM.[APT_fchgestion] = ? AND AM.[APT_estado] = 1)
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Cursos
                            SELECT PA.[TRIP_id] FROM [dbo].[SPV_PARTICIPANTE] PA 
                            LEFT JOIN [dbo].[SPV_CURSO] CUR ON PA.[CUR_id] = CUR.[CUR_id]
                            WHERE
                                (? >= CUR.[CUR_fchini] AND ? <= CUR.[CUR_fchfin] AND CUR.[CUR_estado] = 1 )
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Simulador
                            SELECT SIM.[TRIP_id] FROM [dbo].[SPV_SIMULADOR] SIM
                            WHERE
                                (? >= DATEADD(DAY,-1,SIM.[SIMU_fchini]) AND ? <= DATEADD(DAY,+1,SIM.[SIMU_fchfin]) AND SIM.[SIMU_estado] = 1 )
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Ausencias
                            SELECT AUS.[TRIP_id] FROM [dbo].[SPV_AUSENCIA] AUS
                            WHERE
                                ? >= AUS.[AUS_fchini] AND ? <= AUS.[AUS_fchfin] AND AUS.[AUS_estado] = 1
                        )
                        
                        ".$condicional_3."
                        ".$condicional_2."
						".$condicional;
            
            
            //$param = array($fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg);
            $param = array($fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg);
            $param_1 = array_merge($param,$param_3,$param_1);
            /*if($demo == "demo"){
                echo $sql_1;
                echo "<pre>".print_r($param_1,true)."</pre>";
            }*/
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarTripulanteCondicionalesBasicas_x_TripulanteVuelo($fechaProg,$TRIP_id) {
        try{
            $condicional = '';
            $param_1 = array();
            
            $sql_1 = "SELECT
                        T.[TRIP_id],
                        T.[TRIP_instructor],
                        (((365* year(getdate()))-(365*(year([TRIP_fechnac]))))+ (month(getdate())-month([TRIP_fechnac]))*30 +(day(getdate()) - day([TRIP_fechnac])))/365 AS [TRIP_edad],
                        T.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        T.[TRIP_nombre],T.[TRIP_apellido]
                        
                        FROM [dbo].[SPV_TRIPULANTE] T
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        
                        WHERE
						T.[TRIP_id] NOT IN ( -- Para Vuelos
							SELECT ITIDET.[TRIP_id] FROM [dbo].[SPV_ITI_TRIP_DET] ITIDET
                            WHERE
                                CONVERT(VARCHAR(10),ITIDET.[ITI_fch],121) = ?
						)
                        
                        AND T.[TRIP_id] = ?";
            
            $param = array($fechaProg);
            $param_1 = array($TRIP_id);
            $param_1 = array_merge($param,$param_1);
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarTripulanteCondicionalesBasicas_x_Tripulante($fechaProg,$TRIP_id) {
        try{
            $condicional = '';
            $param_1 = array();
            
            $sql_1 = "SELECT
                        T.[TRIP_id],
                        T.[TRIP_instructor],
                        (((365* year(getdate()))-(365*(year([TRIP_fechnac]))))+ (month(getdate())-month([TRIP_fechnac]))*30 +(day(getdate()) - day([TRIP_fechnac])))/365 AS [TRIP_edad],
                        T.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        T.[TRIP_nombre],T.[TRIP_apellido]
                        
                        FROM [dbo].[SPV_TRIPULANTE] T
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        
                        WHERE
                        
                        T.[TRIP_id] NOT IN ( -- Para Aptos
                            SELECT AM.[TRIP_id] FROM [dbo].[SPV_APTOMED] AM
                            WHERE
                                (AM.[APT_fchgestion] = ? AND AM.[APT_estado] = 1)
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Cursos
                            SELECT PA.[TRIP_id] FROM [dbo].[SPV_PARTICIPANTE] PA 
                            LEFT JOIN [dbo].[SPV_CURSO] CUR ON PA.[CUR_id] = CUR.[CUR_id]
                            WHERE
                                (? >= CUR.[CUR_fchini] AND ? <= CUR.[CUR_fchfin] AND CUR.[CUR_estado] = 1 )
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Simulador
                            SELECT SIM.[TRIP_id] FROM [dbo].[SPV_SIMULADOR] SIM
                            WHERE
                                (? >= DATEADD(DAY,-1,SIM.[SIMU_fchini]) AND ? <= DATEADD(DAY,+1,SIM.[SIMU_fchfin]) AND SIM.[SIMU_estado] = 1 )
                        )
                        
                        AND
                        T.[TRIP_id] NOT IN ( -- Para Ausencias
                            SELECT AUS.[TRIP_id] FROM [dbo].[SPV_AUSENCIA] AUS
                            WHERE
                                ? >= AUS.[AUS_fchini] AND ? <= AUS.[AUS_fchfin] AND AUS.[AUS_estado] = 1
                        )
                        
                        AND 
						T.[TRIP_id] NOT IN ( -- Para Libres
                            SELECT TRIP_LIB.[TRIP_id] FROM [dbo].[SPV_LIBRE_TRIP] TRIP_LIB
                            WHERE
                                ? = TRIP_LIB.[ITI_fch]
                            AND TRIP_LIB.[TRIP_LIB_estado] = 1
                        )
                        
                        AND T.[TRIP_id] = ?";
            
            $param = array($fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg,$fechaProg);
            $param_1 = array($TRIP_id);
            $param_1 = array_merge($param,$param_1);
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarTripulantexMovimiento($TIPTRIP_id,$TIPTRIPDET_id,$RUT_num_vuelo,$fechaProg) {
        try{
            $condicional_1 = '';
            $condicional_2 = '';
            $condicional_3 = '';
            $param = array();
            $param_1 = array();
            
            $parts = explode('-',$fechaProg);
            $fechaProg_2 = $parts[2] . '-' . $parts[0] . '-' . $parts[1];
            
            if($TIPTRIP_id != '' and $TIPTRIPDET_id != ''){
                $condicional_1 = ' WHERE T.TIPTRIPDET_id = ? AND TT.[TIPTRIP_id] = ?';
                $param = array($TIPTRIPDET_id,$TIPTRIP_id);
            }
            
            if($TIPTRIP_id != '' and $TIPTRIPDET_id == ''){
                $condicional_1 = ' WHERE TT.[TIPTRIP_id] = ?';
                $param = array($TIPTRIP_id);
            }
            
            if($RUT_num_vuelo != ''){
                foreach($RUT_num_vuelo as $listaRuta){
                    $condicional_2 .= " + (SELECT [RUTTIME_timeBT] FROM [dbo].[SPV_RUTA_TIMEPROY] WHERE [RUT_num_vuelo] = '".$listaRuta."')";
					$condicional_3 .= " + (SELECT [RUTTIME_timeDT] FROM [dbo].[SPV_RUTA_TIMEPROY] WHERE [RUT_num_vuelo] = '".$listaRuta."')";
                }
            }
            
                
            $sql_1 = "SELECT TRIP_id,[TRIP_edad],
                        sum([24HORA_BT]) AS '24HORA_BT',
                        sum([24HORA_BT_REAL]) AS '24HORA_BT_REAL',
                        sum([5DIA_BT]) AS '5DIA_BT',
                        sum([5DIA_BT_REAL]) AS '5DIA_BT_REAL',
                        sum([6DIA_BT]) AS '6DIA_BT',
                        sum([6DIA_BT_REAL]) AS '6DIA_BT_REAL',
                        sum([1MES_BT]) AS '1MES_BT',
                        sum([1MES_BT_REAL]) AS '1MES_BT_REAL',
                        sum([3MES_BT]) AS '3MES_BT',
                        sum([3MES_BT_REAL]) AS '3MES_BT_REAL',
                        sum([1ANIO_BT]) AS '1ANIO_BT',
                        sum([1ANIO_BT_REAL]) AS '1ANIO_BT_REAL',
                        sum([24HORA_DT]) AS '24HORA_DT',
                        sum([24HORA_DT_REAL]) AS '24HORA_DT_REAL'
                        from
                        (
                            SELECT
                            T.[TRIP_id],
							(((365* year(getdate()))-(365*(year([TRIP_fechnac]))))+ (month(getdate())-month([TRIP_fechnac]))*30 +(day(getdate()) - day([TRIP_fechnac])))/365 AS [TRIP_edad],
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) = '".$fechaProg."'
                                THEN SUM(RTP.[RUTTIME_timeBT]) ".$condicional_2."
                                ELSE 0
                            END AS '24HORA_BT',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) = '".$fechaProg."'
                                THEN SUM([MOVTRIP_BTreal_time])
                                ELSE 0
                            END AS '24HORA_BT_REAL',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(DAY,-5,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM(RTP.[RUTTIME_timeBT]) ".$condicional_2."
                                ELSE 0
                            END AS '5DIA_BT',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(DAY,-5,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM([MOVTRIP_BTreal_time])
                                ELSE 0
                            END AS '5DIA_BT_REAL',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(DAY,-6,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM(RTP.[RUTTIME_timeBT]) ".$condicional_2."
                                ELSE 0
                            END AS '6DIA_BT',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(DAY,-6,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM([MOVTRIP_BTreal_time])
                                ELSE 0
                            END AS '6DIA_BT_REAL',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(MONTH,-1,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM(RTP.[RUTTIME_timeBT]) ".$condicional_2."
                                ELSE 0
                            END AS '1MES_BT',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(MONTH,-1,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM([MOVTRIP_BTreal_time])
                                ELSE 0
                            END AS '1MES_BT_REAL',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(MONTH,-3,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM(RTP.[RUTTIME_timeBT]) ".$condicional_2."
                                ELSE 0
                            END AS '3MES_BT',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(MONTH,-3,'".$fechaProg_2."'),121) AND '".$fechaProg."'
                                THEN SUM([MOVTRIP_BTreal_time])
                                ELSE 0
                            END AS '3MES_BT_REAL',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(YEAR,-1,".$fechaProg_2."),121) AND '".$fechaProg."'
                                THEN SUM(RTP.[RUTTIME_timeBT]) ".$condicional_2."
                                ELSE 0
                            END AS '1ANIO_BT',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) BETWEEN CONVERT(VARCHAR(10),DATEADD(YEAR,-1,".$fechaProg_2."),121) AND '".$fechaProg."'
                                THEN SUM([MOVTRIP_BTreal_time])
                                ELSE 0
                            END AS '1ANIO_BT_REAL',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) = '".$fechaProg."'
                                THEN SUM(RTP.[RUTTIME_timeDT]) ".$condicional_3."
                                ELSE 0
                            END AS '24HORA_DT',
                            CASE
                            WHEN CONVERT(VARCHAR(10),[MOVTRIP_fch],121) = '".$fechaProg."'
                                THEN SUM([MOVTRIP_DTreal_time])
                                ELSE 0
                            END AS '24HORA_DT_REAL'
                            FROM [dbo].[SPV_MOVITRIP] MT

                            RIGHT JOIN [dbo].[SPV_RUTA_TIMEPROY] RTP ON MT.[RUT_num_vuelo] = RTP.[RUT_num_vuelo]
                            RIGHT JOIN [dbo].[SPV_TRIPULANTE] T ON T.[TRIP_id] = MT.[TRIP_id]
                            RIGHT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                            RIGHT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                            ".$condicional_1."

                            GROUP BY
                            T.[TRIP_id],[TRIP_fechnac],
                            CONVERT(VARCHAR(10),[MOVTRIP_fch],121)
                        ) AS tablaCompleta
                    GROUP BY [TRIP_id],[TRIP_edad]
					ORDER BY [TRIP_id] ASC";
            $param_1 = array_merge($param,$param_1);
            
            /*echo $sql_1."<br/>";
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function verificarEstadoFlag(){
        try{
            $sql_1 = "SELECT TOP 1 [FLAG_id],[FLAG_descripion],[FLAG_estado],[AUD_usu_cre],[AUD_fch_cre]
                        FROM [dbo].[SPV_MOTOR_FLAG]
                        ORDER BY 1 DESC";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function insertEstadoFlag($FLAG_estado,$FLAG_descripion){
        try{
            if($this->usuario == ''){
                $this->usuario = 'MOTOR';
            }
            
            $param_1 = array();
            $sql_1 = "INSERT INTO [dbo].[SPV_MOTOR_FLAG]
                        ([FLAG_estado],[FLAG_descripion],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?)";
            $param_1 = array($FLAG_estado,utf8_decode($FLAG_descripion),$this->usuario,date("Ymd H:i:s"));
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function insertMotorLog($MOT_descripcion,$MOT_fch){
        try{
            if($this->usuario == ''){
                $this->usuario = 'MOTOR';
            }
            
            $param_1 = array();
            $sql_1 = "INSERT INTO [dbo].[SPV_MOTOR_LOG]
                        ([MOT_descripcion],[MOT_fch],[MOT_usu])
                        VALUES (?,?,?);";
            $param_1 = array($MOT_descripcion,$MOT_fch,$this->usuario);
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function insertMotorCambio($TRIP_id,$MOTCAMB_tipoCambio,$MOTCAMB_original,$MOTCAMB_modificado,$ITI_fch){
        try{
            $param_1 = array();
            $sql_1 = "INSERT INTO [dbo].[SPV_MOTOR_CAMBIO]
                        ([TRIP_id],[MOTCAMB_tipoCambio],[MOTCAMB_original],[MOTCAMB_modificado],[ITI_fch],[AUD_usu_mod],[AUD_fch_mod])
                        VALUES (?,?,?,?,?,?,?)";
            $param_1 = array( $TRIP_id,$MOTCAMB_tipoCambio,$MOTCAMB_original,$MOTCAMB_modificado,$ITI_fch,$this->usuario,date("Ymd H:i:s") );
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    ################################################################ ED model 4x2 ########################################
    
       public function select4x2programacion($fechaProg,$TRIP_id,$TIPTRIP_id,$TIPTRIPDET_id){
        try{
                    $sql_1 = "


DECLARE @datetime2 datetime2 = ?
select   

tr.TRIP_id,

( SELECT (((365* year(getdate()))-(365*(year([TRIP_fechnac]))))+ 
(month(getdate())-month([TRIP_fechnac]))*30 +(day(getdate()) - day([TRIP_fechnac])))/365 
 FROM [dbo].[SPV_TRIPULANTE] where TRIP_id=tr.TRIP_id ) AS TRIP_edad,


(SELECT tr1.TIPTRIPDET_id FROM [dbo].[SPV_TRIPULANTE] tr1 where tr1.TRIP_id=tr.TRIP_id ) as TIPTRIPDET_id,
(SELECT tpd.TIPTRIP_id FROM [dbo].[SPV_TRIPULANTE] tr2 INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] tpd ON tr2.TIPTRIPDET_id=tpd.TIPTRIPDET_id
where tr2.TRIP_id=tr.TRIP_id) as TIPTRIP_id,

DATEADD(day, -0, @datetime2),DATEADD(day, 5, @datetime2),DATEADD(day, -6, @datetime2),DATEADD(day, -1, @datetime2),DATEADD(day, -6, @datetime2), DATEADD(day, -1, @datetime2),DATEADD(day, -0, @datetime2),CONVERT(VARCHAR(10), GETDATE() + 5, 120),
/*---------------------------------------------------apto medico------------------------------------------------*/
( select count(*) from [dbo].[SPV_APTOMED] ap where  ap.TRIP_id=tr.TRIP_id and  ap.APT_fchgestion between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2)) as 'apto_more6',
( select count(*) from [dbo].[SPV_APTOMED] ap where  ap.TRIP_id=tr.TRIP_id and  ap.APT_fchgestion between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2)) as 'apto_less6',
/*---------------------------------------------------fin apto medico------------------------------------------------*/

/*--------------------------------------------------- curso ------------------------------------------------*/
(select count(*) from [dbo].[SPV_PARTICIPANTE] pa
INNER JOIN [dbo].[SPV_CURSO] cu ON pa.CUR_id=cu.CUR_id where (
cu.CUR_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
cu.CUR_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2))  and pa.TRIP_id=tr.TRIP_id) as 'curso_more6',
(select count(*) from [dbo].[SPV_PARTICIPANTE] pa
INNER JOIN [dbo].[SPV_CURSO] cu ON pa.CUR_id=cu.CUR_id where (
cu.CUR_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
cu.CUR_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) and pa.TRIP_id=tr.TRIP_id) as 'curso_less6',
/*---------------------------------------------------fin  curso ------------------------------------------------*/

/*--------------------------------------------------- chequeo ------------------------------------------------*/
( select count(*) from [dbo].[SPV_CHEQUEO] ch where  ch.TRIP_id =tr.TRIP_id and
ch.CHEQ_fch  between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) as 'chequeo_more6',
( select count(*) from [dbo].[SPV_CHEQUEO] ch where  ch.TRIP_id =tr.TRIP_id and
ch.CHEQ_fch  between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) as 'chequeo_less6',
/*--------------------------------------------------- fin chequeo  ------------------------------------------------*/

/*--------------------------------------------------- simulador ------------------------------------------------*/
( select count(*) from [dbo].[SPV_SIMULADOR] sm where (sm.TRIP_id=tr.TRIP_id or sm.TRIP_id2=tr.TRIP_id) and (
sm.SIMU_fchini between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
sm.SIMU_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) ) as 'simulador_more6',
( select count(*) from [dbo].[SPV_SIMULADOR] sm where (sm.TRIP_id=tr.TRIP_id or sm.TRIP_id2=tr.TRIP_id) and (
sm.SIMU_fchini between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
sm.SIMU_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) ) as 'simulador_less6',
/*--------------------------------------------------- fin simulador  ------------------------------------------------*/

/*--------------------------------------------------- ausencia ------------------------------------------------*/
(select count(*) from [dbo].[SPV_AUSENCIA] au where au.TRIP_id=tr.TRIP_id and (
au.AUS_fchini between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
au.AUS_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) ) as 'ausencia_more6',
( select count(*) from [dbo].[SPV_AUSENCIA] au where au.TRIP_id=tr.TRIP_id and (
au.AUS_fchini between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
au.AUS_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) ) as 'ausencia_less6',

/*--------------------------------------------------- fin ausencia ------------------------------------------------*/

/*--------------------------------------------------- detalle de programacion------------------------------------------------*/  
( select count(DISTINCT dt.ITI_fch) from [dbo].[SPV_ITI_TRIP_DET] dt where dt.TRIP_id=tr.TRIP_id and
CONVERT(VARCHAR(10), dt.ITI_fch, 120) between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) as 'detalle_programaciom_more6',
( select count( DISTINCT dt.ITI_fch) from [dbo].[SPV_ITI_TRIP_DET] dt where dt.TRIP_id=tr.TRIP_id and
CONVERT(VARCHAR(10), dt.ITI_fch, 120) between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) as 'detalle_programaciom_less6',
/*--------------------------------------------------- fin detalle de programacion------------------------------------------------*/
  
/*--------------------------------------------------------sumatoria 6  dias atras------------------------------------------------------*/
(
( select count(*) from [dbo].[SPV_APTOMED] ap where  ap.TRIP_id=tr.TRIP_id and  ap.APT_fchgestion between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2)) 
+
(select count(*) from [dbo].[SPV_PARTICIPANTE] pa
INNER JOIN [dbo].[SPV_CURSO] cu ON pa.CUR_id=cu.CUR_id where (
cu.CUR_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
cu.CUR_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) and pa.TRIP_id=tr.TRIP_id) 
+
( select count(*) from [dbo].[SPV_CHEQUEO] ch where  ch.TRIP_id =tr.TRIP_id and
ch.CHEQ_fch  between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) )
)
+
( select count(*) from [dbo].[SPV_SIMULADOR] sm where (sm.TRIP_id=tr.TRIP_id or sm.TRIP_id2=tr.TRIP_id) and (
sm.SIMU_fchini between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
sm.SIMU_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) )
+
( select count(*) from [dbo].[SPV_AUSENCIA] au where au.TRIP_id=tr.TRIP_id and (
au.AUS_fchini between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
au.AUS_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) )
+
( select count( DISTINCT dt.ITI_fch) from [dbo].[SPV_ITI_TRIP_DET] dt where dt.TRIP_id=tr.TRIP_id and
CONVERT(VARCHAR(10), dt.ITI_fch, 120) between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) as 'valores_less6',
/*--------------------------------------------------------fin sumatoria 6  dias atras------------------------------------------------------*/

/*--------------------------------------------------------sumatoria 5  dias en adelante incluido el actual------------------------------------------------------*/
(
( select count(*) from [dbo].[SPV_APTOMED] ap where  ap.TRIP_id=tr.TRIP_id and  ap.APT_fchgestion between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2)) 
+
(select count(*) from [dbo].[SPV_PARTICIPANTE] pa
INNER JOIN [dbo].[SPV_CURSO] cu ON pa.CUR_id=cu.CUR_id where (
cu.CUR_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
cu.CUR_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) and pa.TRIP_id=tr.TRIP_id) 
+
( select count(*) from [dbo].[SPV_CHEQUEO] ch where  ch.TRIP_id =tr.TRIP_id and
ch.CHEQ_fch  between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) )
)
+
( select count(*) from [dbo].[SPV_SIMULADOR] sm where (sm.TRIP_id=tr.TRIP_id or sm.TRIP_id2=tr.TRIP_id) and (
sm.SIMU_fchini between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
sm.SIMU_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) )
+
( select count(*) from [dbo].[SPV_AUSENCIA] au where au.TRIP_id=tr.TRIP_id and (
au.AUS_fchini between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
au.AUS_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) )
+
( select count( DISTINCT dt.ITI_fch) from [dbo].[SPV_ITI_TRIP_DET] dt where dt.TRIP_id=tr.TRIP_id and
CONVERT(VARCHAR(10), dt.ITI_fch, 120) between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) as 'valores_more6'
/*--------------------------------------------------------sumatoria 5  dias en adelante incluido el actual------------------------------------------------------*/





from [dbo].[SPV_TRIPULANTE] tr
INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] tpd ON tr.TIPTRIPDET_id=tpd.TIPTRIPDET_id
INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] tp ON tpd.TIPTRIP_id=tp.TIPTRIP_id 
WHERE TR.TRIP_id= ?
group by tr.TRIP_id


/*-------------------------------------------------------------- Having ------------------------------------------------------------*/
HAVING
/*-------------------------------------------------------- validacion sumatoria 6  dias atras------------------------------------------------------*/
(
( select count(*) from [dbo].[SPV_APTOMED] ap where  ap.TRIP_id=tr.TRIP_id and  ap.APT_fchgestion between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2)) 
+
(select count(*) from [dbo].[SPV_PARTICIPANTE] pa
INNER JOIN [dbo].[SPV_CURSO] cu ON pa.CUR_id=cu.CUR_id where (
cu.CUR_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
cu.CUR_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) and pa.TRIP_id=tr.TRIP_id) 
+
( select count(*) from [dbo].[SPV_CHEQUEO] ch where  ch.TRIP_id =tr.TRIP_id and
ch.CHEQ_fch  between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) )
)
+
( select count(*) from [dbo].[SPV_SIMULADOR] sm where (sm.TRIP_id=tr.TRIP_id or sm.TRIP_id2=tr.TRIP_id) and (
sm.SIMU_fchini between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
sm.SIMU_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) )
+
( select count(*) from [dbo].[SPV_AUSENCIA] au where au.TRIP_id=tr.TRIP_id and (
au.AUS_fchini between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) or
au.AUS_fchfin between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) ) )
+
( select count( DISTINCT dt.ITI_fch) from [dbo].[SPV_ITI_TRIP_DET] dt where dt.TRIP_id=tr.TRIP_id and
CONVERT(VARCHAR(10), dt.ITI_fch, 120) between DATEADD(day, -6, @datetime2) and DATEADD(day, -1, @datetime2) )<5 
/*-------------------------------------------------------- fin validacion sumatoria 6  dias atras------------------------------------------------------*/
and
/*---------------------------------------------------------------validacion sumatoria 6  dias adelante--------------------------------------------------------------*/
(
( select count(*) from [dbo].[SPV_APTOMED] ap where  ap.TRIP_id=tr.TRIP_id and  ap.APT_fchgestion between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2)) 
+
(select count(*) from [dbo].[SPV_PARTICIPANTE] pa
INNER JOIN [dbo].[SPV_CURSO] cu ON pa.CUR_id=cu.CUR_id where (
cu.CUR_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
cu.CUR_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) and pa.TRIP_id=tr.TRIP_id) 
+
( select count(*) from [dbo].[SPV_CHEQUEO] ch where  ch.TRIP_id =tr.TRIP_id and
ch.CHEQ_fch  between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) )
)
+
( select count(*) from [dbo].[SPV_SIMULADOR] sm where (sm.TRIP_id=tr.TRIP_id or sm.TRIP_id2=tr.TRIP_id) and (
sm.SIMU_fchini between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
sm.SIMU_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) )
+
( select count(*) from [dbo].[SPV_AUSENCIA] au where au.TRIP_id=tr.TRIP_id and (
au.AUS_fchini between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) or
au.AUS_fchfin between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) ) )
+
( select count( DISTINCT dt.ITI_fch) from [dbo].[SPV_ITI_TRIP_DET] dt where dt.TRIP_id=tr.TRIP_id and
CONVERT(VARCHAR(10), dt.ITI_fch, 120) between DATEADD(day, -0, @datetime2) and DATEADD(day, 5, @datetime2) )<3
/*------------------------------------------------------------------fin validacion sumatoria 6  dias adelante---------------------------------------------------------------*/





and
/*-------------------------------------------------------- valicaion id de tripulante----------------------------------------------------------------*/
(SELECT tr1.TIPTRIPDET_id FROM [dbo].[SPV_TRIPULANTE] tr1 where tr1.TRIP_id=tr.TRIP_id )= ?
/*--------------------------------------------------------fin valicaion id de tripulante----------------------------------------------------------------*/
and 
/*--------------------------------------------------------valicaion id de clasificacion de tripulante----------------------------------------------------------------*/
(SELECT tpd.TIPTRIP_id FROM [dbo].[SPV_TRIPULANTE] tr2 INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] tpd ON tr2.TIPTRIPDET_id=tpd.TIPTRIPDET_id
where tr2.TRIP_id=tr.TRIP_id) = ?
/*--------------------------------------------------------fin valicaion id de clasificacion de tripulante----------------------------------------------------------------*/

order by tr.TRIP_id asc

";
                   //$param_1 = array($ITI_id);
                    $param_1 = array($fechaProg,$TRIP_id,$TIPTRIP_id,$TIPTRIPDET_id);
             
            
            /*echo $sql_1."<br/>";
            echo $sql_2."<br/>";
            echo $sql_3."<br/>";
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;

        } catch(Exception $e){
            throw $e;
             }
    }
    
    ####################################################################### ED ############################################################

}
?>