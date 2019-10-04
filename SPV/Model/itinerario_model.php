<?php
if( !isset($_SESSION)){
	session_start();
}

class Itinerario_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar Resumen Itinerario ---------------------------------*/
    public function listarResumenItinerario() {
        try{
            $sql_1 = "SELECT DISTINCT
                        (SELECT CONVERT(VARCHAR(20),MIN([ITI_fch]),103) FROM [dbo].[SPV_ITINERARIO] 
                        WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103)
						AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)) 
						AS ITI_fchini,
                        (SELECT CONVERT(VARCHAR(20),MAX([ITI_fch]),103) FROM [dbo].[SPV_ITINERARIO] 
                        WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103) 
						AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108))
						AS ITI_fchfin,
                        ITI.[ITI_proceso],
                        CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103) AS [AUD_fch_cre],

						-- DAY(ITI.[ITI_fch]) AS [ITI_fch_dia],
						MONTH(ITI.[ITI_fch]) AS [ITI_fch_mes],
						YEAR(ITI.[ITI_fch]) AS [ITI_fch_year]

                        FROM [dbo].[SPV_ITINERARIO] ITI
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON ITI.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        
                        WHERE YEAR(ITI.[ITI_fch]) = 2019
                        
                        GROUP BY 
                        ITI.[ITI_proceso],
                        CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103),
						CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108),
						DAY(ITI.[ITI_fch]),
						MONTH(ITI.[ITI_fch]),
						YEAR(ITI.[ITI_fch])

                        ORDER BY 5 DESC,6, 1 DESC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Itinerario ---------------------------------*/
    public function listarItinerario($ITI_fechaini,$ITI_fechafin,$RUT_num_vuelo) {
        try{
            $condicional = "";
            $param_1 = array();
            
            $parts = explode('/',$ITI_fechaini);
            $ITI_fchini2 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            if($ITI_fechaini != "" and $ITI_fechafin != ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."CONVERT(VARCHAR(20),ITI.[ITI_fch],103) BETWEEN ? and ? AND RUTD.[RUTDIA_diaSemana] = DateName(weekday,?)";
                $param = array($ITI_fechaini,$ITI_fechafin,$ITI_fchini2);
                $param_1 = array_merge($param_1,$param);
            }
            if($RUT_num_vuelo != ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."ITI.[RUT_num_vuelo] = ?";
                $param = array($RUT_num_vuelo);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT 
                        ITI .[ITI_id],
                        ITI.[ITI_proceso],
						ITI.[AVI_id],
						TIPAVI.TIPAVI_serie,
                        AV.[AVI_num_cola],
						CONVERT(VARCHAR(20),ITI.[ITI_fch],103) AS [ITI_fch],
                        CONVERT(VARCHAR(10),ITI.[ITI_fch],120) AS [ITI_fch2],
                        DATENAME(dw,ITI.[ITI_fch]) AS [ITI_dia],
                        ITI.[RUT_num_vuelo],
                        RUT.[RUT_relacion],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        RUT.[RUT_campoAltura],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                        ITI.[AUD_usu_cre],CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        ITI.[AUD_usu_mod],CONVERT(VARCHAR(20),ITI.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_ITINERARIO] ITI
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON ITI.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        LEFT JOIN [dbo].[SPV_AVION] AV ON ITI.[AVI_id] = AV.[AVI_id]
                        LEFT JOIN  [dbo].[SPV_RUTAxDIA] RUTD ON RUTD.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        LEFT JOIN SPV_TIPOAVION TIPAVI ON TIPAVI.TIPAVI_id = AV.TIPAVI_id
                        ".$condicional." 
                        GROUP BY
                        ITI .[ITI_id],
						TIPAVI.TIPAVI_serie,
                        ITI.[AVI_id],
                        ITI.[ITI_proceso],
                        AV.[AVI_num_cola],
						CONVERT(VARCHAR(20),ITI.[ITI_fch],103),
                        CONVERT(VARCHAR(10),ITI.[ITI_fch],120),
                        DATENAME(dw,ITI.[ITI_fch]),
                        ITI.[RUT_num_vuelo],
                        RUT.[RUT_relacion],
                        RUT.[CIU_id_origen],RUT.[CIU_id_destino],
                        RUT.[RUT_campoAltura],
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108),
                        CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108),
                        ITI.[AUD_usu_cre],CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],120),
                        ITI.[AUD_usu_mod],CONVERT(VARCHAR(20),ITI.[AUD_fch_mod],120),
                        RUT.[RUT_orden]
                        ORDER BY 
                        RUT.[RUT_orden]
                        ASC";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Itinerario ---------------------------------*/
    public function insertItinerario($RUT_num_vuelo,$AVI_id,$ITI_fecha,$ITI_proceso,$AUD_usu_mod,$AUD_fch_mod){
        try{
            if($AUD_usu_cre != "" and $AUD_fch_cre != ""){
                $sql_1 = "IF NOT EXISTS( 
                            SELECT [RUT_num_vuelo],[ITI_fch] 
                            FROM [dbo].[SPV_ITINERARIO]
                            WHERE 
                            [RUT_num_vuelo] = ? AND CONVERT(VARCHAR(10),[ITI_fch],120) = ?
                            )
                            INSERT INTO [dbo].[SPV_ITINERARIO]
                                ([RUT_num_vuelo],[AVI_id],[ITI_fch],[ITI_proceso],[AUD_usu_cre],[AUD_fch_cre],[AUD_usu_mod],[AUD_fch_mod])
                                VALUES(?,?,?,?,?,?,?,?);";
                $param_1 = array($RUT_num_vuelo,$ITI_fecha,$RUT_num_vuelo,$AVI_id,$ITI_fecha,$ITI_proceso,$AUD_usu_mod,$AUD_fch_mod,$this->usuario,date("Ymd H:i:s"));
            } else {
                $sql_1 = "IF NOT EXISTS( 
                            SELECT [RUT_num_vuelo],[ITI_fch]
                            FROM [dbo].[SPV_ITINERARIO] 
                            WHERE 
                            [RUT_num_vuelo] = ? AND CONVERT(VARCHAR(10),[ITI_fch],120) = ?
                            )
                            INSERT INTO [dbo].[SPV_ITINERARIO]
                                ([RUT_num_vuelo],[AVI_id],[ITI_fch],[ITI_proceso],[AUD_usu_cre],[AUD_fch_cre])
                                VALUES(?,?,?,?,?,?);";
                $param_1 = array($RUT_num_vuelo,$ITI_fecha,$RUT_num_vuelo,$AVI_id,$ITI_fecha,$ITI_proceso,$this->usuario,date("Ymd H:i:s"));
            }
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS ITI_id;";
            $ITI_id = $this->database->Consultar($sql_2);
            
            if($ITI_id[0]["ITI_id"] == ''){
                $sql_3 = "SELECT DISTINCT
                        (
						SELECT CONVERT(VARCHAR(20),MIN([ITI_fch]),103) FROM [dbo].[SPV_ITINERARIO] 
                        WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103)
						AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)
						) 
						AS ITI_fchini,
                        (
						SELECT CONVERT(VARCHAR(20),MAX([ITI_fch]),103) FROM [dbo].[SPV_ITINERARIO] 
                        WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103) 
						AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)
						)
						AS ITI_fchfin,
                        ITI.[ITI_proceso],
                        CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103) AS [AUD_fch_cre]
                        FROM [dbo].[SPV_ITINERARIO] ITI
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON ITI.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
						WHERE 
						(
						? BETWEEN (SELECT CONVERT(VARCHAR(10),MIN([ITI_fch]),120) FROM [dbo].[SPV_ITINERARIO] 
										WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103)
										AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)
									) AND 
									(SELECT CONVERT(VARCHAR(20),MAX([ITI_fch]),120) FROM [dbo].[SPV_ITINERARIO] 
										WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103) 
										AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)
									)
						OR
						? BETWEEN (SELECT CONVERT(VARCHAR(10),MIN([ITI_fch]),120) FROM [dbo].[SPV_ITINERARIO] 
										WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103)
										AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)
									) AND 
									(SELECT CONVERT(VARCHAR(20),MAX([ITI_fch]),120) FROM [dbo].[SPV_ITINERARIO] 
										WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103) 
										AND CONVERT(VARCHAR(6),[AUD_fch_cre],108) = CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)
									)
						)		
                        GROUP BY 
                        ITI.[ITI_proceso],
                        CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103),
						CONVERT(VARCHAR(6),ITI.[AUD_fch_cre],108)
                        ORDER BY 1 DESC;";
                $param_3 = array($ITI_fecha,$ITI_fecha);
                $result = $this->database->Consultar($sql_3,$param_3);
                /*return $result;
                echo "<pre>".print_r($ITI_id,true)."</pre>";die();*/
            } else {
                return $ITI_id[0]["ITI_id"];
            }
            //return $ITI_id[0]["ITI_id"];
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Eliminar Itinerario ---------------------------------*/
    public function deleteItinerario($ITI_fchini,$ITI_fchfin){
        try{
			$sql_1 = "DELETE FROM [dbo].[SPV_ITINERARIO] WHERE CONVERT(VARCHAR(20),[ITI_fch],103) BETWEEN ? and ?;";
			$param_1 = array($ITI_fchini,$ITI_fchfin);
            $ITI_id = $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Itinerario ---------------------------------*/
    public function updateItinerario($RUT_num_vuelo,$AVI_id,$ITI_fch,$ITI_proceso,$ITI_id,$ITI_fchini,$ITI_fchfin){
        try{
            if($RUT_num_vuelo == "" and $ITI_fchini != "" and $ITI_fchfin != ""){
                $sql_1 = "UPDATE [dbo].[SPV_ITINERARIO] 
                            SET [ITI_proceso] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                                WHERE CONVERT(VARCHAR(20),[ITI_fch],103) BETWEEN ? and ?";
                $param_1 = array($ITI_proceso,$this->usuario,date("Ymd H:i:s"),$ITI_fchini,$ITI_fchfin);
            } else if($AVI_id != "") {
                $sql_1 = "UPDATE [dbo].[SPV_ITINERARIO]
                            SET [AVI_id] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                                WHERE [ITI_id] = ?";
                $param_1 = array($AVI_id,$this->usuario,date("Ymd H:i:s"),$ITI_id);
            } else if($RUT_num_vuelo != "" and $ITI_fchini != "" and $ITI_fchfin != ""){
                $sql_1 = "UPDATE [dbo].[SPV_ITINERARIO] 
                            SET [ITI_proceso] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                                WHERE 
                                RUT_num_vuelo = ? AND
                                CONVERT(VARCHAR(20),[ITI_fch],103) BETWEEN ? and ?";
                $param_1 = array($ITI_proceso,$this->usuario,date("Ymd H:i:s"),$RUT_num_vuelo,$ITI_fchini,$ITI_fchfin);
            }
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar Itinerario ---------------------------------*/
    public function buscarItinerario($ITI_fchini,$ITI_fchfin){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($ITI_fchini <> '' and $ITI_fchfin <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."CONVERT(VARCHAR(20),ITI.[ITI_fch],103) BETWEEN ? and ?";
                $param = array($ITI_fchini,$ITI_fchfin);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT DISTINCT
                        (SELECT CONVERT(VARCHAR(20),MIN([ITI_fch]),103) FROM [dbo].[SPV_ITINERARIO]
                        WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103)) AS ITI_fchini,
                        (SELECT CONVERT(VARCHAR(20),MAX([ITI_fch]),103) FROM [dbo].[SPV_ITINERARIO]
                        WHERE CONVERT(VARCHAR(20),[AUD_fch_cre],103) = CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103)) AS ITI_fchfin,
                        ITI.[ITI_proceso],
                        CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103) AS [AUD_fch_cre]
                        FROM [dbo].[SPV_ITINERARIO] ITI
                        LEFT JOIN [dbo].[SPV_RUTA] RUT ON ITI.[RUT_num_vuelo] = RUT.[RUT_num_vuelo]
                        ".$condicional."
                        GROUP BY 
                        ITI.[ITI_proceso],
                        CONVERT(VARCHAR(20),ITI.[AUD_fch_cre],103)
                        ORDER BY 4 DESC";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
}
?>