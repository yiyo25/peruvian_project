<?php
session_start();
class Reprogramacion_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    public function listarProgramacion($ITI_fch,$AVI_id) {
        try{
            $condicional = "";
            $param = array();
            
            if($AVI_id != ''){
                $condicional = " AND ITI.AVI_id = ?";
                $param = array($AVI_id);
            }
            $sql_1 = "SELECT ITI.ITI_id,
                        CASE
                        WHEN ITI.ITI_id in (SELECT ITRIP.ITI_id FROM SPV_ITI_TRIP_DET ITRIP) THEN 'Si' ELSE 'No' END AS 'Registrado',
                        ITI.AVI_id,AVI.AVI_num_cola,
                        RUT.RUT_num_vuelo,RUT.CIU_id_origen,RUT.CIU_id_destino,
                        CONVERT(VARCHAR(20),RUT.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUT.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                        ITI.ITI_fch
                        FROM SPV_ITINERARIO ITI
                        LEFT JOIN SPV_RUTA RUT ON ITI.RUT_num_vuelo = RUT.RUT_num_vuelo
                        LEFT JOIN SPV_AVION AVI ON AVI.AVI_id = ITI.AVI_id
                        WHERE
                        CONVERT(VARCHAR(20),ITI.[ITI_fch],103) = ?
                        AND ITI.[ITI_proceso] = 'ENVIADO'
                        ".$condicional."
                        ORDER BY ITI.ITI_fch,AVI.AVI_num_cola,RUT.RUT_hora_salida;";
            $param_1 = array($ITI_fch);
            $param_1 = array_merge($param_1,$param);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function insertProgramacion($ITI_id,$TRIP_id,$ITI_TRIP_tipo){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_ITI_TRIP_DET]
                        ([ITI_id],[TRIP_id],[ITI_TRIP_tipo],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?,?)";
            $param_1 = array($ITI_id,$TRIP_id,$ITI_TRIP_tipo,$this->usuario,date("Ymd H:i:s"));
            
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function listarProgramacionxTripulante($ITI_id) {
        try{
            $sql_1 = "SELECT ITRIP.[ITI_id],ITRIP.[TRIP_id],
                        T.[TRIP_nombre],T.[TRIP_apellido],
                        ITRIP.[ITI_TRIP_tipo],
                        ITRIP.[AUD_usu_cre],CONVERT(VARCHAR(20),ITRIP.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        ITRIP.[AUD_usu_mod],CONVERT(VARCHAR(20),ITRIP.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_ITI_TRIP_DET] ITRIP
                        LEFT JOIN [SPV_TRIPULANTE] T ON T.[TRIP_id] = ITRIP.[TRIP_id]
                        WHERE ITRIP.[ITI_id] = ?";
            $param_1 = array($ITI_id);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function deleteProgramacion($ITI_id){
        try{
			$sql_1 = "DELETE FROM [dbo].[SPV_ITI_TRIP_DET] WHERE ITI_id = ?;";
			$param_1 = array($ITI_id);
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    public function listarProgramacionResumenMatriz($ITI_fch,$AVI_id,$RUT_num_vuelo) {
        try{
            $condicional = "";
            $param = array();
            
            if($AVI_id != ''){
                $condicional = " AND ITI.AVI_id = ?";
                $param = array($AVI_id);
            }
            if($RUT_num_vuelo != ''){
                $condicional = " AND ITI.RUT_num_vuelo = ?";
                $param = array($RUT_num_vuelo);
            }
            $sql_1 = "SELECT
                                TRIPDET.[ITI_id],CONVERT(VARCHAR(20),ITI.[ITI_fch],103) AS [ITI_fch],
                                ITI.[RUT_num_vuelo],
                                AVI.[AVI_id],AVI.[AVI_num_cola],
                                RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                                CONVERT(VARCHAR(20),RUT.[RUT_hora_salida],108) AS [RUT_hora_salida],
                                CONVERT(VARCHAR(20),RUT.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                                TRIPDET.[AUD_usu_cre],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_cre],120) AS [AUD_fch_cre],
                                TRIPDET.[AUD_usu_mod],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_ITI_TRIP_DET] TRIPDET
                        INNER JOIN [dbo].[SPV_ITINERARIO] ITI ON ITI.[ITI_id] = TRIPDET.[ITI_id]
                        INNER JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id]
                        INNER JOIN [dbo].[SPV_RUTA] RUT ON RUT.[RUT_num_vuelo] = ITI.[RUT_num_vuelo]
                        WHERE
                        CONVERT(VARCHAR(20),ITI.[ITI_fch],103) = ?
                        AND ITI.[ITI_proceso] = 'ENVIADO'
                        ".$condicional."
                        GROUP BY 
						TRIPDET.[ITI_id],
						CONVERT(VARCHAR(20),ITI.[ITI_fch],103),
						ITI.[ITI_fch],
						ITI.[RUT_num_vuelo],
						AVI.[AVI_id],AVI.[AVI_num_cola],
						RUT.[CIU_id_origen],RUT.[CIU_id_destino],
						CONVERT(VARCHAR(20),RUT.[RUT_hora_salida],108),
						RUT.[RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUT.[RUT_hora_llegada],108),
						RUT.[RUT_hora_llegada],
						TRIPDET.[AUD_usu_cre],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_cre],120),
                        TRIPDET.[AUD_usu_mod],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_mod],120)
                        ORDER BY AVI.AVI_num_cola,RUT.RUT_hora_salida DESC;";
            $param_1 = array($ITI_fch);
            $param_1 = array_merge($param_1,$param);
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
                $condicional = " AND ITI.AVI_id = ?";
                $param = array($AVI_id);
            }
            if($RUT_num_vuelo != ''){
                $condicional = " AND ITI.RUT_num_vuelo = ?";
                $param = array($RUT_num_vuelo);
            }
            $sql_1 = "SELECT
                                TRIPDET.[ITI_id],CONVERT(VARCHAR(20),ITI.[ITI_fch],103) AS [ITI_fch],
                                ITI.[RUT_num_vuelo],
                                AVI.[AVI_id],AVI.[AVI_num_cola],
                                RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                                CONVERT(VARCHAR(20),RUT.[RUT_hora_salida],108) AS [RUT_hora_salida],
                                CONVERT(VARCHAR(20),RUT.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                                TRIPDET.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],TRIPDET.[ITI_TRIP_tipo],
                                TRIPDET.[AUD_usu_cre],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_cre],120) AS [AUD_fch_cre],
                                TRIPDET.[AUD_usu_mod],CONVERT(VARCHAR(20),TRIPDET.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_ITI_TRIP_DET] TRIPDET
                        INNER JOIN [dbo].[SPV_ITINERARIO] ITI ON ITI.[ITI_id] = TRIPDET.[ITI_id]
                        INNER JOIN [dbo].[SPV_AVION] AVI ON AVI.[AVI_id] = ITI.[AVI_id]
                        INNER JOIN [dbo].[SPV_RUTA] RUT ON RUT.[RUT_num_vuelo] = ITI.[RUT_num_vuelo]
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T	ON T.[TRIP_id] = TRIPDET.[TRIP_id]
                        WHERE
                        CONVERT(VARCHAR(20),ITI.[ITI_fch],103) = ?
                        AND ITI.[ITI_proceso] = 'ENVIADO'
                        ".$condicional."
                        ORDER BY AVI.AVI_num_cola,RUT.RUT_hora_salida DESC;";
            $param_1 = array($ITI_fch);
            $param_1 = array_merge($param_1,$param);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
}
?>