<?php
if( !isset($_SESSION)){
	session_start();
}

class Chequeo_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar ResumenChequeo (conIndicador) ---------------------------------*/
	public function listarResumenChequeo(){
		try{
			$sql_1 = "SELECT
                        COUNT(CQ.[CHEQ_id]) AS [CHEQ_Afectados],
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])) AS [CHEQ_fch_MesChequeo],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        CQ.[CHEQ_indicador],
                        MONTH(CQ.[CHEQ_fch]) AS [CHEQ_fch_Mes],
                        YEAR(CQ.[CHEQ_fch]) AS [CHEQ_fch_Anio]
                        FROM [dbo].[SPV_CHEQUEO] CQ
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON CQ.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOCHEQUEO] TCQ ON CQ.[TIPCHEQ_id] = TCQ.[TIPCHEQ_id]
                        group by
                        CQ.[CHEQ_indicador],
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(CQ.[CHEQ_fch]),
                        YEAR(CQ.[CHEQ_fch]);";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar ResumenChequeo (sinIndicador) ---------------------------------*/
    public function listarResumenChequeoMatriz(){
		try{
			$sql_1 = "SELECT
                        COUNT(CQ.[CHEQ_id]) AS [CHEQ_Afectados],
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])) AS [CHEQ_fch_MesChequeo],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(CQ.[CHEQ_fch]) AS [CHEQ_fch_Mes],
                        YEAR(CQ.[CHEQ_fch]) AS [CHEQ_fch_Anio]
                        FROM [dbo].[SPV_CHEQUEO] CQ
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON CQ.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOCHEQUEO] TCQ ON CQ.[TIPCHEQ_id] = TCQ.[TIPCHEQ_id]
                        group by
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(CQ.[CHEQ_fch]),
                        YEAR(CQ.[CHEQ_fch]);";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Insertar Chequeo  ---------------------------------*/
    public function insertChequeo($TIPCHEQ_id,$TRIP_id,$CHEQ_fch,$CHEQ_indicador,$CHEQ_estado){
        try{
			$sql_1 = "IF NOT EXISTS(
                        SELECT [TRIP_id],[CHEQ_fch]
                            FROM [dbo].[SPV_CHEQUEO]
                            WHERE [TRIP_id] = ? AND [CHEQ_fch] = ?
                        )
                        INSERT INTO [dbo].[SPV_CHEQUEO]
                        ([TIPCHEQ_id],[TRIP_id],[CHEQ_fch],[CHEQ_indicador],[CHEQ_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES(?,?,?,?,?,?,?)";
			$param_1 = array($TRIP_id,$CHEQ_fch,$TIPCHEQ_id,$TRIP_id,$CHEQ_fch,$CHEQ_indicador,$CHEQ_estado,$this->usuario,date("Ymd H:i:s"));
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS CHEQ_id;";
            $CHEQ_id = $this->database->Consultar($sql_2);
            
            if($CHEQ_id[0]["CHEQ_id"] == ''){
                $sql_3 = "SELECT
							CQ.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],
							CONVERT(VARCHAR(20),CQ.[CHEQ_fch],103) AS [CHEQ_fch]
                            FROM [dbo].[SPV_CHEQUEO] CQ
							INNER JOIN [dbo].[SPV_TRIPULANTE] T ON CQ.[TRIP_id] = T.[TRIP_id]
                            WHERE CQ.[TRIP_id] = ? AND CQ.[CHEQ_fch] = ?;";
                $param_3 = array($TRIP_id,$CHEQ_fch);
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $CHEQ_id[0]["CHEQ_id"];
            }
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Listar Detalle Chequeo  ---------------------------------*/
    public function listarDetChequeo($CHEQ_id){
        try{
            $condicional = "";
            $param_1 = array();
            if($CHEQ_id != ""){
                $condicional = " WHERE CQ.[CHEQ_id] = ?";
                $param_1 = array($CHEQ_id);
            }
            $sql_1 = "SELECT CQ.[CHEQ_id],
						TCQ.[TIPCHEQ_id],TCQ.[TIPCHEQ_descripcion],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        CQ.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],
                        CONVERT(VARCHAR(20),CQ.[CHEQ_fch],103) AS [CHEQ_fch],
                        CONVERT(VARCHAR(20),CQ.[CHEQ_fchentrega],103) AS [CHEQ_fchentrega],
                        CQ.[CHEQ_indicador],
                        CQ.[CHEQ_observacion],
                        CQ.[CHEQ_estado],
                        CQ.[AUD_usu_cre],CONVERT(VARCHAR(20),CQ.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        CQ.[AUD_usu_mod],CONVERT(VARCHAR(20),CQ.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_CHEQUEO] CQ
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON CQ.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
						LEFT JOIN [dbo].[SPV_TIPOCHEQUEO] TCQ ON CQ.[TIPCHEQ_id] = TCQ.[TIPCHEQ_id]"
                        .$condicional;
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Chequeo xMes xAnio  ---------------------------------*/
    public function listarChequeo($CHEQ_fch_Mes,$CHEQ_fch_Anio,$TIPTRIP_id){
        try{
            $condicional = "";
            $param_1 = array();
            if($CHEQ_fch_Mes != "" and $CHEQ_fch_Anio != "" and $TIPTRIP_id != ''){
                $condicional = " WHERE MONTH(CQ.[CHEQ_fch]) = ? AND YEAR(CQ.[CHEQ_fch]) = ? AND TT.TIPTRIP_id = ?";
                $param_1 = array($CHEQ_fch_Mes,$CHEQ_fch_Anio,$TIPTRIP_id);
            }
            $sql_1 = "SELECT CQ.[CHEQ_id],
                        TCQ.[TIPCHEQ_descripcion],
                        CQ.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],TT.TIPTRIP_id,
                        CONVERT(VARCHAR(20),CQ.[CHEQ_fch],103) AS [CHEQ_fch],
                        CQ.[CHEQ_indicador],
                        CQ.[AUD_usu_cre],CQ.[AUD_fch_cre],CQ.[AUD_usu_mod],CQ.[AUD_fch_mod]
                        FROM [dbo].[SPV_CHEQUEO] CQ
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON CQ.[TRIP_id] = T.[TRIP_id] 
						LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOCHEQUEO] TCQ ON CQ.[TIPCHEQ_id] = TCQ.[TIPCHEQ_id]"
                        .$condicional.
                        " ORDER BY 1 DESC";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";DIE();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar ResumenChequeo  ---------------------------------*/
    public function updateChequeo($TIPCHEQ_id,$TRIP_id,$CHEQ_fch,$CHEQ_indicador,$CHEQ_fchentrega,$CHEQ_observacion,$CHEQ_estado,$CHEQ_id){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_CHEQUEO]
                        SET [TIPCHEQ_id] = ?,[TRIP_id] = ?,[CHEQ_fch] = ?,[CHEQ_indicador] = ?,[CHEQ_fchentrega] = ".$CHEQ_fchentrega.",[CHEQ_observacion] = ?,[CHEQ_estado] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [CHEQ_id] = ?";
			$param_1 = array($TIPCHEQ_id,$TRIP_id,$CHEQ_fch,$CHEQ_indicador,$CHEQ_observacion,$CHEQ_estado,$this->usuario,date("Ymd H:i:s"),$CHEQ_id);
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar ResumenChequeo (conIndicador) ---------------------------------*/
    public function buscarResumenChequeo($TIPCHEQ_id,$TIPTRIP_id,$CHEQ_fch_Mes,$CHEQ_fch_Anio,$CHEQ_indicador,$TRIP_apellido){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPCHEQ_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."CQ.[TIPCHEQ_id]";
                $param = array($TIPCHEQ_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id]= ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($CHEQ_fch_Mes <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."MONTH(CQ.[CHEQ_fch]) = ?";
                $param = array($CHEQ_fch_Mes);
                $param_1 = array_merge($param_1,$param);
            }
            if($CHEQ_fch_Anio <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."YEAR(CQ.[CHEQ_fch]) = ?";
                $param = array($CHEQ_fch_Anio);
                $param_1 = array_merge($param_1,$param);
            }
            if($CHEQ_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."CQ.[CHEQ_indicador] = ?";
                $param = array($CHEQ_indicador);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT
                        COUNT(CQ.[CHEQ_id]) AS [CHEQ_Afectados],
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])) AS [CHEQ_fch_MesChequeo],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        CQ.[CHEQ_indicador],
                        MONTH(CQ.[CHEQ_fch]) AS [CHEQ_fch_Mes],
                        YEAR(CQ.[CHEQ_fch]) AS [CHEQ_fch_Anio]
                        FROM [dbo].[SPV_CHEQUEO] CQ
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON CQ.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOCHEQUEO] TCQ ON CQ.[TIPCHEQ_id] = TCQ.[TIPCHEQ_id]"
                        .$condicional.
                        " group by
                        CQ.[CHEQ_indicador],
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(CQ.[CHEQ_fch]),
                        YEAR(CQ.[CHEQ_fch])";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Buscar ResumenChequeo (sinIndicador) ---------------------------------*/
    public function buscarResumenChequeoMatriz($TIPCHEQ_id,$TIPTRIP_id,$CHEQ_fch_Mes,$CHEQ_fch_Anio,$CHEQ_indicador,$TRIP_apellido){
		try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPCHEQ_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."CQ.[TIPCHEQ_id]";
                $param = array($TIPCHEQ_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id]= ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($CHEQ_fch_Mes <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."MONTH(CQ.[CHEQ_fch]) = ?";
                $param = array($CHEQ_fch_Mes);
                $param_1 = array_merge($param_1,$param);
            }
            if($CHEQ_fch_Anio <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."YEAR(CQ.[CHEQ_fch]) = ?";
                $param = array($CHEQ_fch_Anio);
                $param_1 = array_merge($param_1,$param);
            }
            if($CHEQ_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."CQ.[CHEQ_indicador] = ?";
                $param = array($CHEQ_indicador);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            
			$sql_1 = "SELECT
                        COUNT(CQ.[CHEQ_id]) AS [CHEQ_Afectados],
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])) AS [CHEQ_fch_MesChequeo],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(CQ.[CHEQ_fch]) AS [CHEQ_fch_Mes],
                        YEAR(CQ.[CHEQ_fch]) AS [CHEQ_fch_Anio]
                        FROM [dbo].[SPV_CHEQUEO] CQ
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON CQ.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOCHEQUEO] TCQ ON CQ.[TIPCHEQ_id] = TCQ.[TIPCHEQ_id]"
                        .$condicional.
                        " group by
                        TCQ.[TIPCHEQ_descripcion],
                        (DATENAME(month,CQ.[CHEQ_fch]) + '-' + DATENAME(year,CQ.[CHEQ_fch])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(CQ.[CHEQ_fch]),
                        YEAR(CQ.[CHEQ_fch])";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
}
?>