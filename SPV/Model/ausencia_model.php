<?php
if( !isset($_SESSION)){
	session_start();
}

class Ausencia_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar Ausencia ---------------------------------*/
    public function listarAusencia($AUS_id) {
        try{
            $condicional = "";
            $param_1 = array();
            
            if($AUS_id != ""){
                $condicional = " WHERE AU.[AUS_id] = ?";
                $param_1 = array($AUS_id);
            }
            
            $sql_1 = "SELECT AU.[AUS_id],
                            AU.[TIPAUS_id],TA.[TIPAUS_descripcion],
							TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                            AU.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],T.[TRIP_numlicencia],
                            TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                            CONVERT(VARCHAR(20),AU.[AUS_fchini],103) AS [AUS_fchini],
                            CONVERT(VARCHAR(20),AU.[AUS_fchfin],103) AS [AUS_fchfin],
                            AU.[AUD_usu_cre],CONVERT(VARCHAR(20),AU.[AUD_fch_cre],120) AS [AUD_fch_cre],
                            AU.[AUD_usu_mod],CONVERT(VARCHAR(20),AU.[AUD_fch_mod],120) AS [AUD_fch_mod],
                            AU.[AUS_estado]
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
    
    /*--------------------------------- Insertar Ausencia ---------------------------------*/
    public function insertAusencia($TIPAUS_id,$TRIP_id,$AUS_fchini,$AUS_fchfin,$AUS_estado){
        try{
			$sql_1 = "IF NOT EXISTS(
                        SELECT [TRIP_id],[AUS_fchini],[AUS_fchfin]
                            FROM [dbo].[SPV_AUSENCIA]
                            WHERE
                            ((? BETWEEN [AUS_fchini] AND [AUS_fchfin])
                            OR
                            (? BETWEEN [AUS_fchini] AND [AUS_fchfin]))
                            AND [TRIP_id] = ?
                        )
                        INSERT INTO [dbo].[SPV_AUSENCIA]
                        ([TIPAUS_id],[TRIP_id],[AUS_fchini],[AUS_fchfin],[AUS_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES(?,?,?,?,?,?,?);";
			$param_1 = array($AUS_fchini,$AUS_fchfin,$TRIP_id,$TIPAUS_id,$TRIP_id,$AUS_fchini,$AUS_fchfin,$AUS_estado,$this->usuario,date("Ymd H:i:s"));
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS AUS_id;";
            $AUS_id = $this->database->Consultar($sql_2);
            
            if($AUS_id[0]["AUS_id"] == ''){
                $sql_3 = "SELECT	
                                AUS.[TRIP_id],
                                T.[TRIP_nombre],T.[TRIP_apellido],
                                CONVERT(VARCHAR(20),AUS.[AUS_fchini],103) AS [AUS_fchini],
                                CONVERT(VARCHAR(20),AUS.[AUS_fchfin],103) AS [AUS_fchfin]
                            FROM [dbo].[SPV_AUSENCIA] AUS
                            INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AUS.[TRIP_id] = T.[TRIP_id]
                            WHERE
                            ((? BETWEEN AUS.[AUS_fchini] AND AUS.[AUS_fchfin])
                            OR
                            (? BETWEEN AUS.[AUS_fchini] AND AUS.[AUS_fchfin]))
                            AND AUS.[TRIP_id] = ?";
                $param_3 = array($AUS_fchini,$AUS_fchfin,$TRIP_id);
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $AUS_id[0]["AUS_id"];
            }
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Ausencia ---------------------------------*/
    public function updateAusencia($TIPAUS_id,$TRIP_id,$AUS_fchini,$AUS_fchfin,$AUS_estado,$AUS_id){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_AUSENCIA]
                        SET [TIPAUS_id] = ?,[TRIP_id] = ?,[AUS_fchini] = ?,[AUS_fchfin] = ?,[AUS_estado] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [AUS_id] = ?";
			$param_1 = array($TIPAUS_id,$TRIP_id,$AUS_fchini,$AUS_fchfin,$AUS_estado,$this->usuario,date("Ymd H:i:s"),$AUS_id);
            
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar Ausencia ---------------------------------*/
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
                            AU.[AUD_usu_mod],CONVERT(VARCHAR(20),AU.[AUD_fch_mod],120) AS [AUD_fch_mod],
                            AU.[AUS_estado]
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