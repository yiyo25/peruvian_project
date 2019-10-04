<?php
if( !isset($_SESSION)){
	session_start();
}

class Apto_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION["objUsu"]["Usuario"]);
	}
    
    /*--------------------------------- Listar ResumenApto(conIndicador) ---------------------------------*/
	public function listarResumenApto(){
		try{
			$sql_1 = "SELECT
                        COUNT(AM.[APT_id]) AS [APT_Afectados],
                        (DATENAME(month,AM.[APT_fchvenci]) + '-' + DATENAME(year,AM.[APT_fchvenci])) AS [APT_fchvenci_MesApto],
                        TT.[TIPTRIP_descripcion],
                        AM.[APT_indicador],
                        MONTH(AM.[APT_fchvenci]) AS [APT_fchvenci_Mes],
						YEAR(AM.[APT_fchvenci]) AS [APT_fchvenci_Anio]
                        FROM [dbo].[SPV_APTOMED] AM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        group by
						AM.[APT_indicador],
                        (DATENAME(month,AM.[APT_fchvenci]) + '-' + DATENAME(year,AM.[APT_fchvenci])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(AM.[APT_fchvenci]),
						YEAR(AM.[APT_fchvenci])
                        ORDER BY MONTH(AM.[APT_fchvenci]) ASC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar ResumenApto(sinIndicador) ---------------------------------*/
    public function listarResumenAptoMatriz(){
		try{
			$sql_1 = "SELECT
                        COUNT(AM.[APT_id]) AS [APT_Afectados],
                        (DATENAME(month,AM.[APT_fchvenci]) + '-' + DATENAME(year,AM.[APT_fchvenci])) AS [APT_fchvenci_MesApto],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(AM.[APT_fchvenci]) AS [APT_fchvenci_Mes],
						YEAR(AM.[APT_fchvenci]) AS [APT_fchvenci_Anio]
                        FROM [dbo].[SPV_APTOMED] AM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        group by 
                        (DATENAME(month,AM.[APT_fchvenci]) + '-' + DATENAME(year,AM.[APT_fchvenci])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(AM.[APT_fchvenci]),
						YEAR(AM.[APT_fchvenci])
                        ORDER BY MONTH(AM.[APT_fchvenci]) ASC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Insertar Apto ---------------------------------*/
    public function insertApto($TRIP_id,$APT_fchvenci,$APT_fchgestion,$APT_indicador,$APT_estado){
        try{
			$sql_1 = "IF NOT EXISTS(
                        SELECT 
                            AP.[TRIP_id],AP.[APT_fchgestion],AP.[APT_fchvenci],
                            T.[TRIP_nombre],T.[TRIP_apellido]
                            FROM [dbo].[SPV_APTOMED] AP
                            INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AP.[TRIP_id] = T.[TRIP_id]
                            WHERE 
                            (AP.[TRIP_id] = ? AND AP.[APT_fchvenci] = ?) 
                            OR
                            (AP.[TRIP_id] = ? AND AP.[APT_fchgestion] = ".$APT_fchgestion.")
                        )
                        INSERT INTO [dbo].[SPV_APTOMED]
                        ([TRIP_id],[APT_fchvenci],[APT_fchgestion],[APT_indicador],[APT_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES(?,?,".$APT_fchgestion.",?,?,?,?)";
			$param_1 = array($TRIP_id,$APT_fchvenci,$TRIP_id,$TRIP_id,$APT_fchvenci,$APT_indicador,$APT_estado,$this->usuario,date("Ymd H:i:s"));
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS APT_id;";
            $APT_id = $this->database->Consultar($sql_2);
            
            if($APT_id[0]["APT_id"] == ''){
                $sql_3 = "SELECT 
                            AP.[TRIP_id],
                            CONVERT(VARCHAR(20),AP.[APT_fchgestion],103) AS [APT_fchgestion],
                            CONVERT(VARCHAR(20),AP.[APT_fchvenci],103) AS [APT_fchvenci],
                            T.[TRIP_nombre],T.[TRIP_apellido]
                            FROM [dbo].[SPV_APTOMED] AP
                            INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AP.[TRIP_id] = T.[TRIP_id]
                            WHERE 
                            (AP.[TRIP_id] = ? AND AP.[APT_fchvenci] = ?) 
                            OR
                            (AP.[TRIP_id] = ? AND AP.[APT_fchgestion] = ?)";
                $param_3 = array($TRIP_id,$APT_fchvenci,$TRIP_id,$APT_fchgestion);
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $APT_id[0]["APT_id"];
            }
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Listar Detalle Apto ---------------------------------*/
    public function listarDetApto($APT_id){
        try{
            $condicional = "";
            $param_1 = array();
            if($APT_id != ""){
                $condicional = " WHERE AM.[APT_id] = ?";
                $param_1 = array($APT_id);
            }
            $sql_1 = "SELECT AM.[APT_id],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        AM.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],
                        CONVERT(VARCHAR(20),AM.[APT_fchvenci],103) AS [APT_fchvenci],
                        CONVERT(VARCHAR(20),AM.[APT_fchgestion],103) AS [APT_fchgestion],
                        AM.[APT_indicador],
                        CONVERT(VARCHAR(20),AM.[APT_fchentrega],103) AS [APT_fchentrega],
						AM.[APT_observacion],AM.[APT_estado],
                        AM.[AUD_usu_cre],CONVERT(VARCHAR(20),AM.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        AM.[AUD_usu_mod],CONVERT(VARCHAR(20),AM.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_APTOMED] AM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]"
                        .$condicional;
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Apto xMes xAnio ---------------------------------*/
    public function listarApto($APT_fchvenci_Mes,$APT_fchvenci_Anio,$TIPTRIP_id){
        try{
            $condicional = "";
            $param_1 = array();
            if($APT_fchvenci_Mes != "" and $APT_fchvenci_Anio != "" and $TIPTRIP_id != ''){
                $condicional = " WHERE MONTH(AM.[APT_fchvenci]) = ? AND YEAR(AM.[APT_fchvenci]) = ? AND TT.TIPTRIP_id = ?";
                $param_1 = array($APT_fchvenci_Mes,$APT_fchvenci_Anio,$TIPTRIP_id);
            }
            $sql_1 = "SELECT AM.[APT_id],AM.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],
						TT.TIPTRIP_id,TT.[TIPTRIP_descripcion],
                        CONVERT(VARCHAR(20),AM.[APT_fchvenci],103) AS [APT_fchvenci],
                        AM.[APT_fchvenci] as [APT_fchvenci2],
                        CONVERT(VARCHAR(20),AM.[APT_fchgestion],103) AS [APT_fchgestion],
                        AM.[APT_indicador],
                        AM.[AUD_usu_cre],AM.[AUD_fch_cre],AM.[AUD_usu_mod],AM.[AUD_fch_mod]
                        FROM [dbo].[SPV_APTOMED] AM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AM.[TRIP_id] = T.[TRIP_id] 
						INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$condicional."
                        ORDER BY 7 ASC";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Modificar Apto ---------------------------------*/
    public function updateapto($TRIP_id,$APT_fchvenci,$APT_fchgestion,$APT_indicador,$APT_fchentrega,$APT_observacion,$APT_estado,$APT_id){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_APTOMED]
                        SET [TRIP_id] = ?,[APT_fchvenci] = ?,[APT_fchgestion] = ?,[APT_indicador] = ?,
	                        [APT_fchentrega] = ".$APT_fchentrega.",[APT_observacion] = ?,[APT_estado] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [APT_id] = ?";
			$param_1 = array($TRIP_id,$APT_fchvenci,$APT_fchgestion,$APT_indicador,$APT_observacion,$APT_estado,$this->usuario,date("Ymd H:i:s"),$APT_id);
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar ResumenApto(conIndicador) ---------------------------------*/
    public function buscarResumenApto($TIPTRIP_id,$APT_fchvenci_Mes,$APT_fchvenci_Anio,$APT_indicador,$TRIP_apellido){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($APT_fchvenci_Mes <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."MONTH(AM.[APT_fchvenci]) = ?";
                $param = array($APT_fchvenci_Mes);
                $param_1 = array_merge($param_1,$param);
            }
            if($APT_fchvenci_Anio <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."YEAR(AM.[APT_fchvenci]) = ?";
                $param = array($APT_fchvenci_Anio);
                $param_1 = array_merge($param_1,$param);
            }
            if($APT_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."AM.[APT_indicador] = ?";
                $param = array($APT_indicador);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT
                        COUNT(AM.[APT_id]) AS [APT_Afectados],
                        (DATENAME(month,AM.[APT_fchvenci]) + '-' + DATENAME(year,AM.[APT_fchvenci])) AS [APT_fchvenci_MesApto],
                        TT.[TIPTRIP_descripcion],
                        AM.[APT_indicador],
                        MONTH(AM.[APT_fchvenci]) AS [APT_fchvenci_Mes]
                        FROM [dbo].[SPV_APTOMED] AM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]"
                        .$condicional.
                        " group by T.[TRIP_id],TT.[TIPTRIP_descripcion],AM.[APT_fchvenci],AM.[APT_indicador]";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Buscar ResumenApto(sinIndicador) ---------------------------------*/
    public function buscarResumenAptoMatriz($TIPTRIP_id,$APT_fchvenci_Mes,$APT_fchvenci_Anio,$APT_indicador,$TRIP_apellido){
		try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($APT_fchvenci_Mes <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."MONTH(AM.[APT_fchvenci]) = ?";
                $param = array($APT_fchvenci_Mes);
                $param_1 = array_merge($param_1,$param);
            }
            if($APT_fchvenci_Anio <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."YEAR(AM.[APT_fchvenci]) = ?";
                $param = array($APT_fchvenci_Anio);
                $param_1 = array_merge($param_1,$param);
            }
            if($APT_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."AM.[APT_indicador] = ?";
                $param = array($APT_indicador);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            
			$sql_1 = "SELECT
                        COUNT(AM.[APT_id]) AS [APT_Afectados],
                        (DATENAME(month,AM.[APT_fchvenci]) + '-' + DATENAME(year,AM.[APT_fchvenci])) AS [APT_fchvenci_MesApto],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(AM.[APT_fchvenci]) AS [APT_fchvenci_Mes],
						YEAR(AM.[APT_fchvenci]) AS [APT_fchvenci_Anio]
                        FROM [dbo].[SPV_APTOMED] AM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON AM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]"
                        .$condicional.
                        " group by (DATENAME(month,AM.[APT_fchvenci]) + '-' + DATENAME(year,AM.[APT_fchvenci])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        MONTH(AM.[APT_fchvenci]),
                        YEAR(AM.[APT_fchvenci]);";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
}
?>