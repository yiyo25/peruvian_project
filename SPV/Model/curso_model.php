<?php
if( !isset($_SESSION)){
	session_start();
}

class Curso_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar ResumenCurso(conIndicador) ---------------------------------*/
	public function listarResumenCurso(){
		try{
			$sql_1 = "SELECT
                        COUNT(T.TRIP_id) AS CUR_Afectados,
                        TT.[TIPTRIP_descripcion],
                        C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                        P.[CUR_id],P.[PART_indicador],
                        C.[CUR_fchini],C.[CUR_fchfin],
                        C.[AUD_fch_cre]
                        FROM [dbo].[SPV_CURSO] C
                        LEFT JOIN [dbo].[SPV_TIPOCURSO] TC ON C.[TIPCUR_id] = TC.[TIPCUR_id]
                        LEFT JOIN [dbo].[SPV_PARTICIPANTE] P ON P.[CUR_id] = C.[CUR_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON P.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        GROUP BY
                                TT.[TIPTRIP_descripcion],
                                C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                                P.[CUR_id],P.[PART_indicador],
                                C.[CUR_fchini],C.[CUR_fchfin],
                                C.[AUD_fch_cre]
                        ORDER BY C.[AUD_fch_cre] DESC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar ResumenCurso(sinIndicador) ---------------------------------*/
    public function listarResumenCursoMatriz(){
		try{
			$sql_1 = "SELECT	COUNT(T.TRIP_id) AS CUR_Afectados,
                        TT.[TIPTRIP_descripcion],
                        C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                        P.[CUR_id],
                        C.[CUR_fchini],C.[CUR_fchfin],
                        C.[AUD_fch_cre]
                        FROM [dbo].[SPV_CURSO] C
                        LEFT JOIN [dbo].[SPV_TIPOCURSO] TC ON C.[TIPCUR_id] = TC.[TIPCUR_id]
                        LEFT JOIN [dbo].[SPV_PARTICIPANTE] P ON P.[CUR_id] = C.[CUR_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON P.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        GROUP BY 
                                TT.[TIPTRIP_descripcion],
                                C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                                P.[CUR_id],
                                C.[CUR_fchini],C.[CUR_fchfin],
                                C.[AUD_fch_cre]
                        ORDER BY C.[AUD_fch_cre] DESC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Curso  ---------------------------------*/
    public function listarCurso($CUR_id,$TRIP_id){
        try{
            $condicional = "";
            $param_1 = array();
            if($CUR_id != "" and $PART_id == ""){
                $condicional = " WHERE P.[CUR_id] = ?";
                $param_1 = array($CUR_id);
            }
            if($CUR_id != "" and $TRIP_id != ""){
                $condicional = " WHERE P.[CUR_id] = ? AND P.[TRIP_id] = ?";
                $param_1 = array($CUR_id,$TRIP_id);
            }
            
            $sql_1 = "SELECT
                                P.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],
                                TC.[TIPCUR_id],TC.[TIPCUR_descripcion],P.[CUR_id],
                                TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                                CONVERT(VARCHAR(20),C.[CUR_fchini],103) AS [CUR_fchini],
								C.[CUR_fchini] AS [CUR_fchini2],
                                CONVERT(VARCHAR(20),C.[CUR_fchfin],103) AS [CUR_fchfin],
								C.[CUR_fchfin] AS [CUR_fchfin2],
                                C.[CUR_estado],
                                CONVERT(VARCHAR(20),C.[CUR_fchinforme],103) AS [CUR_fchinforme],
                                P.[PART_descripcion],P.[PART_indicador],P.[PART_observacion],
                                P.[AUD_usu_cre],CONVERT(VARCHAR(20),P.[AUD_fch_cre],120) AS [AUD_fch_cre],
                                P.[AUD_usu_mod],CONVERT(VARCHAR(20),P.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_PARTICIPANTE] P 
                        LEFT JOIN [dbo].[SPV_CURSO] C ON P.[CUR_id] = C.[CUR_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON P.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOCURSO] TC ON C.[TIPCUR_id] = TC.[TIPCUR_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]"
                        .$condicional.
                        " ORDER BY P.[PART_descripcion] desc";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Curso ---------------------------------*/
    public function insertCurso($TIPCUR_id,$CUR_fchini,$CUR_fchfin,$CUR_estado){
        try{
			$sql_1 = "IF NOT EXISTS(
                        SELECT
                            CUR.[CUR_fchini],CUR.[CUR_fchfin]
                            FROM [dbo].[SPV_CURSO] CUR
							WHERE
                            ((? BETWEEN CUR.[CUR_fchini] AND CUR.[CUR_fchfin])
                            OR
                            (? BETWEEN CUR.[CUR_fchini] AND CUR.[CUR_fchfin]))
                        )
                        INSERT INTO [dbo].[SPV_CURSO]
                            ([TIPCUR_id],[CUR_fchini],[CUR_fchfin],[CUR_estado],[AUD_usu_cre],[AUD_fch_cre])
                            VALUES (?,?,?,?,?,?)";
			$param_1 = array($CUR_fchini,$CUR_fchfin,$TIPCUR_id,$CUR_fchini,$CUR_fchfin,$CUR_estado,$this->usuario,date("Ymd H:i:s"));
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS CUR_id;";
            $CUR_id = $this->database->Consultar($sql_2);
            
            if($CUR_id[0]["CUR_id"] == ''){
                $sql_3 = "SELECT
                            CONVERT(VARCHAR(20),CUR.[CUR_fchini],103) AS [CUR_fchini],
                            CONVERT(VARCHAR(20),CUR.[CUR_fchfin],103) AS [CUR_fchfin]
                            FROM [dbo].[SPV_CURSO] CUR
							WHERE
                            ((? BETWEEN CUR.[CUR_fchini] AND CUR.[CUR_fchfin])
                            OR
                            (? BETWEEN CUR.[CUR_fchini] AND CUR.[CUR_fchfin]));";
                $param_3 = array($CUR_fchini,$CUR_fchfin);
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $CUR_id[0]["CUR_id"];
            }
            //return $CUR_id[0]["CUR_id"];
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Insertar Participante ---------------------------------*/
    public function insertParticipante($TRIP_id_a,$CUR_id,$PART_indicador,$PART_descripcion){
        try{
			$sql_1 = "INSERT INTO [dbo].[SPV_PARTICIPANTE]
                        ([TRIP_id],[CUR_id],[PART_indicador],[PART_descripcion],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?,?,?)";
			$param_1 = array($TRIP_id_a,$CUR_id,$PART_indicador,utf8_decode($PART_descripcion),$this->usuario,date("Ymd H:i:s"));
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Curso ---------------------------------*/
    public function updateCurso($TIPCUR_id,$CUR_fchini,$CUR_fchfin,$CUR_id,$CUR_fchinforme,$CUR_estado){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_CURSO]
                        SET [TIPCUR_id] = ?,[CUR_fchini] = ?,[CUR_fchfin] = ?,[CUR_fchinforme] = ".$CUR_fchinforme.",[CUR_estado] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [CUR_id] = ?";
			$param_1 = array($TIPCUR_id,$CUR_fchini,$CUR_fchfin,$CUR_estado,$this->usuario,date("Ymd H:i:s"),$CUR_id);
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Participante ---------------------------------*/
    public function updateParticipante($TRIP_id,$CUR_id,$PART_indicador,$PART_observacion,$PART_descripcion,$PART_id){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_PARTICIPANTE]
                        SET [TRIP_id] = ?,[CUR_id] = ?,[PART_indicador] = ?,[PART_observacion] = ?,[PART_descripcion] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [TRIP_id] = ? AND [CUR_id] = ?";
			$param_1 = array($TRIP_id,$CUR_id,$PART_indicador,$PART_observacion,$PART_descripcion,$this->usuario,date("Ymd H:i:s"),$PART_id,$CUR_id);
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar ResumenCurso(conIndicador) ---------------------------------*/
    public function buscarResumenCurso($TIPTRIP_id,$TIPCUR_id,$PART_indicador,$TRIP_apellido,$TRIP_numlicencia){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPCUR_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."C.[TIPCUR_id] = ?";
                $param = array($TIPCUR_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($PART_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."P.[PART_indicador] = ?";
                $param = array($PART_indicador);
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
            
            $sql_1 = "SELECT
                        COUNT(T.TRIP_id) AS CUR_Afectados,
                        TT.[TIPTRIP_descripcion],
                        C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                        P.[CUR_id],P.[PART_indicador],
                        C.[CUR_fchini],C.[CUR_fchfin],
                        C.[AUD_fch_cre]
                        FROM [dbo].[SPV_CURSO] C
                        LEFT JOIN [dbo].[SPV_TIPOCURSO] TC ON C.[TIPCUR_id] = TC.[TIPCUR_id]
                        LEFT JOIN [dbo].[SPV_PARTICIPANTE] P ON P.[CUR_id] = C.[CUR_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON P.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]"
                        .$condicional.
                        "GROUP BY
                                TT.[TIPTRIP_descripcion],
                                C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                                P.[CUR_id],P.[PART_indicador],
                                C.[CUR_fchini],C.[CUR_fchfin],
                                C.[AUD_fch_cre]";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Buscar ResumenCurso(sinIndicador) ---------------------------------*/
    public function buscarResumenCursoMatriz($TIPTRIP_id,$TIPCUR_id,$PART_indicador,$TRIP_apellido,$TRIP_numlicencia){
		try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPCUR_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."C.[TIPCUR_id] = ?";
                $param = array($TIPCUR_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($PART_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."P.[PART_indicador] = ?";
                $param = array($PART_indicador);
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
            
			$sql_1 = "SELECT	COUNT(T.TRIP_id) AS CUR_Afectados,
                        TT.[TIPTRIP_descripcion],
                        C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                        P.[CUR_id],
                        C.[CUR_fchini],C.[CUR_fchfin],
                        C.[AUD_fch_cre]
                        FROM [dbo].[SPV_CURSO] C
                        LEFT JOIN [dbo].[SPV_TIPOCURSO] TC ON C.[TIPCUR_id] = TC.[TIPCUR_id]
                        LEFT JOIN [dbo].[SPV_PARTICIPANTE] P ON P.[CUR_id] = C.[CUR_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON P.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]"
                        .$condicional.
                        "GROUP BY
                                TT.[TIPTRIP_descripcion],
                                C.[TIPCUR_id],TC.[TIPCUR_descripcion],
                                P.[CUR_id],
                                C.[CUR_fchini],C.[CUR_fchfin],
                                C.[AUD_fch_cre]";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
}
?>