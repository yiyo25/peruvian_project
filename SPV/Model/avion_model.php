<?php
if( !isset($_SESSION)){
	session_start();
}

class Avion_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode( $_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar Avión ---------------------------------*/
    public function listarAvion($AVI_id,$AVI_id_exepcion){
        try{
            $condicional = "";
            $param_1 = array();
            if($AVI_id != ""){
                $condicional = " WHERE a.[AVI_id] = ?";
                $param_1 = array($AVI_id);
            }
            if($AVI_id_exepcion != ""){
                $condicional = " WHERE a.[AVI_id] NOT IN (?)";
                $param_1 = array($AVI_id_exepcion);
            }
            $sql_1 = "SELECT a.[AVI_id],a.[TIPAVI_id],ta.[TIPAVI_modelo],ta.[TIPAVI_serie],a.[AVI_num_cola],a.[AVI_cant_pasajeros],
                        a.[AVI_cap_carga_max],a.[AVI_estado],
                        a.[AUD_usu_cre],CONVERT(VARCHAR(20),a.[AUD_fch_cre],120) AS [AUD_fch_cre],
						a.[AUD_usu_mod],CONVERT(VARCHAR(20),a.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_AVION] a
                        INNER JOIN [dbo].[SPV_TIPOAVION] ta ON a.[TIPAVI_id] = ta.[TIPAVI_id]
                        ".$condicional."
			 AND a.AVI_estado = 1
                        ORDER BY a.[AVI_num_cola] ASC";
            /*echo $sql_1;
            echo "<pre>".print_r($result,true)."</pre>";*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarAvionHabilitadosxFecha($ITI_fchini,$ITI_fchfin){
        try{
            $sql_1 = "SELECT
						a.[AVI_id],a.[TIPAVI_id],ta.[TIPAVI_modelo],ta.[TIPAVI_serie],a.[AVI_num_cola],a.[AVI_cant_pasajeros],
                        a.[AVI_cap_carga_max],a.[AVI_estado],
                        a.[AUD_usu_cre],CONVERT(VARCHAR(20),a.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        CONVERT(VARCHAR(20),MANTAV.[MANTAVI_fchini],103) AS [MANTAVI_fchini],
                        CONVERT(VARCHAR(20),MANTAV.[MANTAVI_fchfin],103) AS [MANTAVI_fchfin]
                        FROM [dbo].[SPV_AVION] a
                        INNER JOIN [dbo].[SPV_TIPOAVION] ta ON a.[TIPAVI_id] = ta.[TIPAVI_id]
                        LEFT JOIN [dbo].[SPV_MANTAVION] MANTAV ON a.[AVI_id] = MANTAV.[AVI_id]
                        WHERE 
                        a.[AVI_id] NOT IN (
							SELECT
							a.[AVI_id]
	                        FROM [dbo].[SPV_AVION] a
	                        LEFT JOIN [dbo].[SPV_MANTAVION] MANTAV ON a.[AVI_id] = MANTAV.[AVI_id]
	                        WHERE 
	                        CONVERT(VARCHAR(20),MANTAV.[MANTAVI_fchini],103) BETWEEN ? AND ? AND
	                        CONVERT(VARCHAR(20),MANTAV.[MANTAVI_fchfin],103) BETWEEN ? AND ?
                        )
                        ORDER BY CONVERT(VARCHAR(20),a.[AUD_fch_cre],120) DESC";
            $param_1 = array($ITI_fchini,$ITI_fchfin,$ITI_fchini,$ITI_fchfin);
            /*echo $sql_1;
            echo "<pre>".print_r($result,true)."</pre>";*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Avion en Manto ---------------------------------*/
    public function listarResumenMantoAvion(){
        try{
            $sql_1 = "SELECT
                        COUNT(AV.[AVI_id]) AS [AVI_afectados],
                        (DATENAME(month,MANTAV.[MANTAVI_fchini]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchini]))  
                        + ' / ' +
                        (DATENAME(month,MANTAV.[MANTAVI_fchfin]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchfin])) AS [AVI_fch_Mes],
                        
                        MONTH(MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchiniMes],
                        MONTH(MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchfinMes],
                        YEAR(MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchiniAnio],
                        YEAR(MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchfinAnio]
                        
                        FROM [dbo].[SPV_MANTAVION] MANTAV
                        LEFT JOIN [dbo].[SPV_AVION] AV ON MANTAV.[AVI_id] = AV.[AVI_id]
                        GROUP BY
                        DATENAME(month,MANTAV.[MANTAVI_fchini]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchini]),
                        DATENAME(month,MANTAV.[MANTAVI_fchfin]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchfin]),
                        MONTH(MANTAV.[MANTAVI_fchini]),
                        MONTH(MANTAV.[MANTAVI_fchfin]),
                        YEAR(MANTAV.[MANTAVI_fchini]),
                        YEAR(MANTAV.[MANTAVI_fchfin])
                        ORDER BY MONTH(MANTAV.[MANTAVI_fchini]) DESC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Detalle de Avion en Manto ---------------------------------*/
    public function listarMantoAvion($MANTAVI_fchiniMes,$MANTAVI_fchiniAnio,$MANTAVI_fchfinMes,$MANTAVI_fchfinAnio,$MANTAVI_id,$ITI_fchini,$ITI_fchfin,$fchActual){
        try{
            $condicional = "";
            $condicional_2 = "";
            $param = array();
            
            if($ITI_fchini != "" and $ITI_fchfin != ""){
                $condicional = " WHERE MANTAV.[MANTAVI_fchini] >= ? AND MANTAV.[MANTAVI_fchfin] <= ?";
                $param_1 = array($ITI_fchini,$ITI_fchfin);
            } else if($MANTAVI_id != ""){
                $condicional = " WHERE MANTAV.[MANTAVI_id] = ?";
                $param_1 = array($MANTAVI_id);
            } else {
                $condicional = " WHERE
                                    MONTH(MANTAV.[MANTAVI_fchini]) = ?
                                AND YEAR(MANTAV.[MANTAVI_fchini]) = ?
                                AND MONTH(MANTAV.[MANTAVI_fchfin]) = ?
                                AND	YEAR(MANTAV.[MANTAVI_fchfin]) = ?";
                $param_1 = array($MANTAVI_fchiniMes,$MANTAVI_fchiniAnio,$MANTAVI_fchfinMes,$MANTAVI_fchfinAnio);
            }
            
            if($fchActual != ''){
                $condicional_2 = "and ( CONVERT(VARCHAR(10),GETDATE(),121) <= MANTAV.[MANTAVI_fchini] or CONVERT(VARCHAR(10),GETDATE(),121) <= MANTAV.[MANTAVI_fchfin] )";
            }
            
            $sql_1 = "SELECT
                            MANTAV.[MANTAVI_id],
                            MANTAV.[AVI_id],AV.[TIPAVI_id],TA.[TIPAVI_modelo],TA.[TIPAVI_serie],AV.[AVI_num_cola],
                            CONVERT(VARCHAR(20),MANTAV.[MANTAVI_fchini],103) AS [MANTAVI_fchini],
                            CONVERT(VARCHAR(20),MANTAV.[MANTAVI_fchfin],103) AS [MANTAVI_fchfin],
                            
                            DateName(day,MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchDiaNi],
                            DateName(weekday,MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchDiai],
                            CONVERT(VARCHAR(2),MANTAV.[MANTAVI_fchini],101) AS [MANTAVI_fchMesNi],
							DateName(month,MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchMesi],
							DateName(year,MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchAnioi],

                            DateName(day,MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchDiaNf],
                            DateName(weekday,MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchDiaf],
							CONVERT(VARCHAR(2),MANTAV.[MANTAVI_fchfin],101) AS [MANTAVI_fchMesNf],
							DateName(month,MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchMesf],
							DateName(year,MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchAniof],
                            
                            MANTAV.[MANTAVI_tipoChequeo],MANTAV.[MANTAVI_ordenTrabajo],MANTAV.[MANTAVI_observacion],
                            MANTAV.[AUD_usu_cre],CONVERT(VARCHAR(20),MANTAV.[AUD_fch_cre],120) AS [AUD_fch_cre],
                            MANTAV.[AUD_usu_mod],CONVERT(VARCHAR(20),MANTAV.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_MANTAVION] MANTAV
                        LEFT JOIN [dbo].[SPV_AVION] AV ON MANTAV.[AVI_id] = AV.[AVI_id]
                        LEFT JOIN [dbo].[SPV_TIPOAVION] TA ON AV.[TIPAVI_id] = TA.[TIPAVI_id]
                        ".$condicional."
                        ".$condicional_2."
                         ORDER BY CONVERT(VARCHAR(20),MANTAV.[MANTAVI_fchini],103) ASC";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Avion x Fecha ---------------------------------*/
    public function listarAvionDisponiblexFecha($ITI_fchini,$ITI_fchfin){
        try{
            $condicional = "";
            $param = array();
            if($ITI_fchini != "" and $ITI_fchfin != ""){
                $condicional = " WHERE ((? BETWEEN MANTAVI.[MANTAVI_fchini] AND MANTAVI.[MANTAVI_fchfin]) OR (? BETWEEN MANTAVI.[MANTAVI_fchini] AND MANTAVI.[MANTAVI_fchfin]))";
                $param_1 = array($ITI_fchini,$ITI_fchfin);
            }
            $sql_1 = "SELECT
                            AV.[AVI_id],AV.[TIPAVI_id],AV.[AVI_num_cola],AV.[AVI_cant_pasajeros],
                            AV.[AVI_cap_carga_max],AV.[AVI_estado],
                            AV.[AUD_usu_cre],CONVERT(VARCHAR(20),AV.[AUD_fch_cre],120) AS [AUD_fch_cre],
                            AV.[AUD_usu_mod],CONVERT(VARCHAR(20),AV.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_AVION] AV
                        WHERE AV.[AVI_id]
                        NOT IN (
                            SELECT a.[AVI_id]
                            FROM [dbo].[SPV_AVION] a
                            INNER JOIN [dbo].[SPV_MANTAVION] MANTAVI ON a.[AVI_id] = MANTAVI.[AVI_id]
                            ".$condicional.")";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Avion en Itinerario ---------------------------------*/
    public function listarAvionNoDisponiblexItinerario($AVI_id,$MANTAVI_fchini,$MANTAVI_fchfin){
        try{
            $param_1 = array();
            $condicional = "";
            
            if( $MANTAVI_fchini != "" and $MANTAVI_fchfin != "" ){
                $condicional = " CONVERT(VARCHAR(10),ITI.[ITI_fch],121) BETWEEN ? AND ?";
                $param_1 = array($MANTAVI_fchini,$MANTAVI_fchfin);
            } else {
                $condicional = " MANTAVI.[AVI_id] = ? AND CONVERT(VARCHAR(10),ITI.[ITI_fch],121) BETWEEN MANTAVI.[MANTAVI_fchini] AND MANTAVI.[MANTAVI_fchfin]";
                $param_1 = array($AVI_id);
            }
            
            $sql_1 = "SELECT 
                            ITI.[ITI_id],ITI.[RUT_num_vuelo],ITI.[AVI_id],CONVERT(VARCHAR(20),ITI.[ITI_fch],103) AS [ITI_fch],ITI.[ITI_proceso],
                            MANTAVI.[MANTAVI_id],MANTAVI.[AVI_id],
                            CONVERT(VARCHAR(20),MANTAVI.[MANTAVI_fchini],103) AS MANTAVI_fchini,
                            CONVERT(VARCHAR(20),MANTAVI.[MANTAVI_fchfin],103) AS MANTAVI_fchfin,
                            MANTAVI.[MANTAVI_tipoChequeo],MANTAVI.[MANTAVI_ordenTrabajo],MANTAVI.[MANTAVI_observacion],
							AVI.[AVI_id],AVI.[TIPAVI_id],AVI.[AVI_num_cola]
                        FROM [dbo].[SPV_MANTAVION] MANTAVI
                        LEFT JOIN [dbo].[SPV_ITINERARIO] ITI ON MANTAVI.[AVI_id] = ITI.[AVI_id]
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON ITI.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
						LEFT JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = MANTAVI.[AVI_id]
                        where
                        RUT.[RUT_primer_vuelo] = 'No' AND
						ITI.[ITI_proceso] = 'ENVIADO' AND
                        ".$condicional;
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Avión ---------------------------------*/
    public function insertAvion($TIPAVI_id,$AVI_num_cola,$AVI_cant_pasajeros,$AVI_cap_carga_max,$AVI_estado){
        try{
			$sql_1 = "IF NOT EXISTS( SELECT [AVI_num_cola] FROM [dbo].[SPV_AVION] WHERE [AVI_num_cola] = ? )
                        INSERT INTO [dbo].[SPV_AVION]
                            ([TIPAVI_id],[AVI_num_cola],[AVI_cant_pasajeros],[AVI_cap_carga_max],[AVI_estado],[AUD_usu_cre],[AUD_fch_cre])
     			        VALUES (?,?,?,?,?,?,?);";
			$param_1 = array(utf8_decode($AVI_num_cola),$TIPAVI_id,utf8_decode($AVI_num_cola),$AVI_cant_pasajeros,$AVI_cap_carga_max,$AVI_estado,$this->usuario,date("Ymd H:i:s"));
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS AVI_id;";
            $AVI_id = $this->database->Consultar($sql_2);
            
            if($AVI_id[0]["AVI_id"] == ''){
                $sql_3 = "SELECT [AVI_num_cola] FROM [dbo].[SPV_AVION] WHERE [AVI_num_cola] = ?";
                $param_3 = array($AVI_num_cola);
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $AVI_id[0]["AVI_id"];
            }
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Insertar Avión en Manto ---------------------------------*/
    public function insertMantoAvion($AVI_id,$MANTAVI_fchini,$MANTAVI_fchfin,$MANTAVI_tipoChequeo,$MANTAVI_ordenTrabajo,$MANTAVI_observacion){
        try{
			$sql_1 = "IF NOT EXISTS(
                        SELECT [AVI_id],[MANTAVI_fchini],[MANTAVI_fchfin]
                            FROM [dbo].[SPV_MANTAVION]
                            WHERE
                            ((? BETWEEN [MANTAVI_fchini] AND [MANTAVI_fchfin]) OR
                            (? BETWEEN [MANTAVI_fchini] AND [MANTAVI_fchfin]))
                            AND [AVI_id] = ?
                        )
                        INSERT INTO [dbo].[SPV_MANTAVION]
                            ([AVI_id],[MANTAVI_fchini],[MANTAVI_fchfin],[MANTAVI_tipoChequeo],[MANTAVI_ordenTrabajo],[MANTAVI_observacion],[AUD_usu_cre],[AUD_fch_cre])
                            VALUES (?,?,?,?,?,?,?,?);";
			$param_1 = array($MANTAVI_fchini,$MANTAVI_fchfin,$AVI_id,$AVI_id,$MANTAVI_fchini,$MANTAVI_fchfin,utf8_decode($MANTAVI_tipoChequeo),utf8_decode($MANTAVI_ordenTrabajo),utf8_decode($MANTAVI_observacion),$this->usuario,date("Ymd H:i:s"));
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS MANTAVI_id;";
            $MANTAVI_id = $this->database->Consultar($sql_2);
            
            if($MANTAVI_id[0]["MANTAVI_id"] == ''){
                $sql_3 = "SELECT 
                            MANTAVI.[AVI_id],AV.[AVI_num_cola],
                            CONVERT(VARCHAR(20),MANTAVI.[MANTAVI_fchini],103) AS MANTAVI_fchini,
                            CONVERT(VARCHAR(20),MANTAVI.[MANTAVI_fchfin],103) AS MANTAVI_fchfin,
                            [MANTAVI_tipoChequeo],[MANTAVI_ordenTrabajo],[MANTAVI_observacion]
                                FROM [dbo].[SPV_MANTAVION] MANTAVI
                                INNER JOIN [dbo].[SPV_AVION] AV 
                                ON MANTAVI.[AVI_id] = AV.[AVI_id]
                                WHERE
                                ((? BETWEEN MANTAVI.[MANTAVI_fchini] AND MANTAVI.[MANTAVI_fchfin]) OR
                                (? BETWEEN MANTAVI.[MANTAVI_fchini] AND MANTAVI.[MANTAVI_fchfin]))
                                AND MANTAVI.[AVI_id] = ?";
                $param_3 = array($MANTAVI_fchini,$MANTAVI_fchfin,$AVI_id);
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $MANTAVI_id[0]["MANTAVI_id"];
            }
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Avión ---------------------------------*/
    public function updateAvion($AVI_id,$TIPAVI_id,$AVI_num_cola,$AVI_cant_pasajeros,$AVI_cap_carga_max,$AVI_estado){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_AVION]
                        SET [TIPAVI_id] = ?,[AVI_num_cola] = ?,[AVI_cant_pasajeros] = ?,[AVI_cap_carga_max] = ?,[AVI_estado] = ?,
                            [AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [AVI_id] = ?";
			$param_1 = array($TIPAVI_id,utf8_decode($AVI_num_cola),$AVI_cant_pasajeros,$AVI_cap_carga_max,$AVI_estado,$this->usuario,date("Ymd H:i:s"),$AVI_id);
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Avión en Manto ---------------------------------*/
    public function updateMantoAvion($AVI_id,$MANTAVI_fchini,$MANTAVI_fchfin,$MANTAVI_tipoChequeo,$MANTAVI_ordenTrabajo,$MANTAVI_observacion,$MANTAVI_id){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_MANTAVION]
                        SET [AVI_id] = ?,[MANTAVI_fchini] = ?,[MANTAVI_fchfin] = ?,
                            [MANTAVI_tipoChequeo] = ?,[MANTAVI_ordenTrabajo] = ?,[MANTAVI_observacion] = ?,
                            [AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [MANTAVI_id] = ?";
			$param_1 = array($AVI_id,$MANTAVI_fchini,$MANTAVI_fchfin,$MANTAVI_tipoChequeo,$MANTAVI_ordenTrabajo,$MANTAVI_observacion,$this->usuario,date("Ymd H:i:s"),$MANTAVI_id);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar Avión ---------------------------------*/
    public function buscarAvion($TIPAVI_id,$AVI_num_cola){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPAVI_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."a.[TIPAVI_id] LIKE ?";
                $param = array($TIPAVI_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($AVI_num_cola <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."a.[AVI_num_cola] LIKE ?";
                $param = array("%".utf8_decode($AVI_num_cola)."%");
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT a.[AVI_id],a.[TIPAVI_id],ta.[TIPAVI_modelo],ta.[TIPAVI_serie],a.[AVI_num_cola],a.[AVI_cant_pasajeros],a.[AVI_cap_carga_max],a.[AVI_estado],
                        a.[AUD_usu_cre],CONVERT(VARCHAR(20),a.[AUD_fch_cre],120) AS [AUD_fch_cre],
						a.[AUD_usu_mod],CONVERT(VARCHAR(20),a.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_AVION] a
                        INNER JOIN [dbo].[SPV_TIPOAVION] ta ON a.[TIPAVI_id] = ta.[TIPAVI_id] "
                        .$condicional.
                        " ORDER BY 1 DESC";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Buscar Avión en Manto ---------------------------------*/
    public function buscarMantoAvion($TIPAVI_id,$AVI_id,$AVI_fch_Mes,$AVI_fch_Anio){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPAVI_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."AV.[TIPAVI_id] = ?";
                $param = array($TIPAVI_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($AVI_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."AV.[AVI_id] = ?";
                $param = array($AVI_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($AVI_fch_Mes <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."(MONTH(MANTAV.[MANTAVI_fchini]) = ? OR MONTH(MANTAV.[MANTAVI_fchfin]) = ?)";
                $param = array($AVI_fch_Mes,$AVI_fch_Mes);
                $param_1 = array_merge($param_1,$param);
            }
            if($AVI_fch_Anio <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."(YEAR(MANTAV.[MANTAVI_fchini]) = ? OR YEAR(MANTAV.[MANTAVI_fchfin]) = ?)";
                $param = array($AVI_fch_Anio,$AVI_fch_Anio);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT
                        COUNT(AV.[AVI_id]) AS [AVI_afectados],
                        (DATENAME(month,MANTAV.[MANTAVI_fchini]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchini]))  
                        + ' / ' +
                        (DATENAME(month,MANTAV.[MANTAVI_fchfin]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchfin])) AS [AVI_fch_Mes],
                        MONTH(MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchiniMes],
                        MONTH(MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchfinMes],
                        YEAR(MANTAV.[MANTAVI_fchini]) AS [MANTAVI_fchiniAnio],
                        YEAR(MANTAV.[MANTAVI_fchfin]) AS [MANTAVI_fchfinAnio]
                        FROM [dbo].[SPV_MANTAVION] MANTAV
                        LEFT JOIN [dbo].[SPV_AVION] AV ON MANTAV.[AVI_id] = AV.[AVI_id]
                        ".$condicional."
                        GROUP BY
                        DATENAME(month,MANTAV.[MANTAVI_fchini]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchini]),
                        DATENAME(month,MANTAV.[MANTAVI_fchfin]) + '-' + DATENAME(year,MANTAV.[MANTAVI_fchfin]),
                        MONTH(MANTAV.[MANTAVI_fchini]),
                        MONTH(MANTAV.[MANTAVI_fchfin]),
                        YEAR(MANTAV.[MANTAVI_fchini]),
                        YEAR(MANTAV.[MANTAVI_fchfin])
                        ORDER BY MONTH(MANTAV.[MANTAVI_fchini]), YEAR(MANTAV.[MANTAVI_fchini]) ASC";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
}
?>