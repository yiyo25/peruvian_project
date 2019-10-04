<?php
if( !isset($_SESSION)){
	session_start();
}

class Simulador_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}    
    
    /*--------------------------------- Listar ResumenSimulador(conIndicador) ---------------------------------*/
	public function listarResumenSimulador(){
		try{
			$sql_1 = "SELECT
                        COUNT(SIM.[SIMU_id]) AS [SIMU_Afectados],
						TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
						SIM.[SIMU_fchini],
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])) AS [SIMU_fch_MesSimulador],
                        TT.[TIPTRIP_descripcion],
                        SIM.[SIMU_indicador],
                        MONTH(SIM.[SIMU_fchini]) AS [SIMU_fch_Mes],
						YEAR(SIM.[SIMU_fchini]) AS [SIMU_fch_Anio]
                        FROM [dbo].[SPV_SIMULADOR] SIM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        group by 
						SIM.[SIMU_indicador],
						SIM.[SIMU_fchini],
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
						TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        MONTH(SIM.[SIMU_fchini]),
						YEAR(SIM.[SIMU_fchini])
                        ORDER BY MONTH(SIM.[SIMU_fchini]) ASC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar ResumenSimulador(sinIndicador) ---------------------------------*/
    public function listarResumenSimuladorMatriz(){
		try{
			$sql_1 = "SELECT
                        COUNT(SIM.[SIMU_id]) AS [SIMU_Afectados],
						TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])) AS [SIMU_fch_MesSimulador],
                        TT.[TIPTRIP_descripcion],
                        MONTH(SIM.[SIMU_fchini]) AS [SIMU_fch_Mes],
						YEAR(SIM.[SIMU_fchini]) AS [SIMU_fch_Anio]
                        FROM [dbo].[SPV_SIMULADOR] SIM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        group by
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
						TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        MONTH(SIM.[SIMU_fchini]),
						YEAR(SIM.[SIMU_fchini])
                        ORDER BY MONTH(SIM.[SIMU_fchini]) ASC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch(Exception $e){
            throw $e;
		}
	}
    
    /*--------------------------------- Listar Simulador ---------------------------------
    public function listarSimulador($SIMU_id) {
        try{
            $condicional = "";
            $param_1 = array();
            
            if($SIMU_id != ""){
                $condicional = " WHERE SIM.[SIMU_id] = ?";
                $param_1 = array($SIMU_id);
            }
            
            $sql_1 = "SELECT SIM.[SIMU_id],
							TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                            SIM.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],T.[TRIP_numlicencia],
                            TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                            CONVERT(VARCHAR(20),SIM.[SIMU_fchini],103) AS [SIMU_fchini],
                            CONVERT(VARCHAR(20),SIM.[SIMU_fchfin],103) AS [SIMU_fchfin],
                            CONVERT(VARCHAR(20),SIM.[SIMU_fchentrega],103) AS [SIMU_fchentrega],
                            SIM.[SIMU_indicador],
                            SIM.[SIMU_observacion],
                            SIM.[SIMU_estado],
                            SIM.[AUD_usu_cre],CONVERT(VARCHAR(20),SIM.[AUD_fch_cre],120) AS [AUD_fch_cre],
                            SIM.[AUD_usu_mod],CONVERT(VARCHAR(20),SIM.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_SIMULADOR] SIM
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
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
    }*/
    
    /*--------------------------------- Listar simulador xMes xAnio ---------------------------------*/
    public function listarSimulador($SIMU_fch_Mes,$SIMU_fch_Anio,$TIPTRIP_id){
        try{
            $condicional = "";
            $param_1 = array();
            if($SIMU_fch_Mes != "" and $SIMU_fch_Anio != "" and $TIPTRIP_id != ''){
                $condicional = " WHERE MONTH(SIM.[SIMU_fchini]) = ? AND YEAR(SIM.[SIMU_fchini]) = ? AND TT.TIPTRIP_id = ?";
                $param_1 = array($SIMU_fch_Mes,$SIMU_fch_Anio,$TIPTRIP_id);
            }
            
            if($SIMU_fch_Mes == "" and $SIMU_fch_Anio != "" and $TIPTRIP_id == ''){
                $condicional = " WHERE YEAR(SIM.[SIMU_fchini]) = ?";
                $param_1 = array($SIMU_fch_Anio);
            }
            $sql_1 = "SELECT SIM.[SIMU_id],
						TT.TIPTRIP_id,TT.[TIPTRIP_descripcion],
                        
						SIM.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],TL.[TIPLIC_abreviatura],T.[TRIP_numlicencia],
						SIM.[TRIP_id2],T2.[TRIP_nombre] AS [TRIP_nombre2],T2.[TRIP_apellido] AS [TRIP_apellido2],TL.[TIPLIC_abreviatura] AS [TIPLIC_abreviatura2],T2.[TRIP_numlicencia] AS [TRIP_numlicencia2],
						
                        CONVERT(VARCHAR(20),SIM.[SIMU_fchini],103) AS [SIMU_fchini],
						CONVERT(VARCHAR(20),SIM.[SIMU_fchfin],103) AS [SIMU_fchfin],
                        SIM.[SIMU_fchini] as [SIMU_fchini2],
						SIM.[SIMU_fchfin] as [SIMU_fchfin2],
                        SIM.[SIMU_indicador],
                        SIM.[AUD_usu_cre],SIM.[AUD_fch_cre],SIM.[AUD_usu_mod],SIM.[AUD_fch_mod]
                        FROM [dbo].[SPV_SIMULADOR] SIM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id] 
						INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
						INNER JOIN [dbo].[SPV_TIPOLICENCIA] TL ON TL.[TIPLIC_id] = T.[TIPLIC_id]
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T2 ON SIM.[TRIP_id2] = T2.[TRIP_id]
                        ".$condicional."
                        ORDER BY 7 ASC";
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Detalle Simulador ---------------------------------*/
    public function listarDetSimulador($SIM_id){
        try{
            $condicional = "";
            $param_1 = array();
            if($SIM_id != ""){
                $condicional = " WHERE SIM.[SIMU_id] = ?";
                $param_1 = array($SIM_id);
            }
            $sql_1 = "SELECT SIM.[SIMU_id],
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        SIM.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],

						TT2.[TIPTRIP_id] AS [TIPTRIP_id2],TT2.[TIPTRIP_descripcion] AS [TIPTRIP_descripcion2],
                        TTD2.[TIPTRIPDET_id] AS [TIPTRIPDET_id2],TTD2.[TIPTRIPDET_descripcion] AS [TIPTRIPDET_descripcion2],
						SIM.[TRIP_id2],T2.[TRIP_nombre] AS [TRIP_nombre2],T2.[TRIP_apellido] AS [TRIP_apellido2],

                        CONVERT(VARCHAR(20),SIM.[SIMU_fchini],103) AS [SIMU_fchini],
						CONVERT(VARCHAR(20),SIM.[SIMU_fchfin],103) AS [SIMU_fchfin],
						CONVERT(VARCHAR(20),SIM.[SIMU_fchentrega],103) AS [SIMU_fchentrega],
                        SIM.[SIMU_indicador],
						SIM.[SIMU_observacion],SIM.[SIMU_estado],
                        SIM.[AUD_usu_cre],CONVERT(VARCHAR(20),SIM.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        SIM.[AUD_usu_mod],CONVERT(VARCHAR(20),SIM.[AUD_fch_mod],120) AS [AUD_fch_mod]

                        FROM [dbo].[SPV_SIMULADOR] SIM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]

						INNER JOIN [dbo].[SPV_TRIPULANTE] T2 ON SIM.[TRIP_id2] = T2.[TRIP_id]
						INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD2 ON T2.[TIPTRIPDET_id] = TTD2.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT2 ON TTD2.[TIPTRIP_id] = TT2.[TIPTRIP_id]"
                        .$condicional;
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Simulador ---------------------------------*/
    public function insertSimulador($TRIP_id,$TRIP_id2,$SIMU_fchini,$SIMU_fchfin,$SIMU_indicador,$SIMU_estado){
        try{
            if( $TRIP_id2 != "" ){
                $condicional = "([TRIP_id] = ? OR [TRIP_id2] = ?) OR ([TRIP_id] = ? OR [TRIP_id2] = ?)";
                $param_1 = array($SIMU_fchini,$SIMU_fchfin,$TRIP_id,$TRIP_id2,$TRIP_id2,$TRIP_id,$TRIP_id,$TRIP_id2,$SIMU_fchini,$SIMU_fchfin,$SIMU_indicador,$SIMU_estado,$this->usuario,date("Ymd H:i:s"));
                
                $sql_1 = "IF NOT EXISTS(
                        SELECT [TRIP_id],[TRIP_id2],[SIMU_fchini],[SIMU_fchfin]
                            FROM [dbo].[SPV_SIMULADOR]
                            WHERE
                            ((? BETWEEN DATEADD(DAY,-1,[SIMU_fchini]) AND DATEADD(DAY,-1,[SIMU_fchfin])) OR
                            (? BETWEEN DATEADD(DAY,-1,[SIMU_fchini]) AND DATEADD(DAY,-1,[SIMU_fchfin]))) AND
                            ".$condicional."
                        )
                        INSERT INTO [dbo].[SPV_SIMULADOR]
                        ([TRIP_id],[TRIP_id2],[SIMU_fchini],[SIMU_fchfin],[SIMU_indicador],[SIMU_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES(?,?,?,?,?,?,?,?)";
                
            } else{
                $condicional = "([TRIP_id] = ?) OR ([TRIP_id2] = ?)";
                //$TRIP_id2 = NULL;
                $param_1 = array($SIMU_fchini,$SIMU_fchfin,$TRIP_id,$TRIP_id,$TRIP_id,$SIMU_fchini,$SIMU_fchfin,$SIMU_indicador,$SIMU_estado,$this->usuario,date("Ymd H:i:s"));
                
                $sql_1 = "IF NOT EXISTS(
                        SELECT [TRIP_id],[TRIP_id2],[SIMU_fchini],[SIMU_fchfin]
                            FROM [dbo].[SPV_SIMULADOR]
                            WHERE
                            ((? BETWEEN DATEADD(DAY,-1,[SIMU_fchini]) AND DATEADD(DAY,-1,[SIMU_fchfin])) OR
                            (? BETWEEN DATEADD(DAY,-1,[SIMU_fchini]) AND DATEADD(DAY,-1,[SIMU_fchfin]))) AND
                            ".$condicional."
                        )
                        INSERT INTO [dbo].[SPV_SIMULADOR]
                        ([TRIP_id],[SIMU_fchini],[SIMU_fchfin],[SIMU_indicador],[SIMU_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES(?,?,?,?,?,?,?)";
            }
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";*/
            
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS SIMU_id;";
            $SIMU_id = $this->database->Consultar($sql_2);
            
            if( $TRIP_id2 != "" ){
                $condicional = "SIM.[TRIP_id] = ? OR SIM.[TRIP_id2] = ?";
                $param_3 = array($SIMU_fchini,$SIMU_fchfin,$TRIP_id,$TRIP_id2);
            } else{
                $condicional = "SIM.[TRIP_id] = ? OR SIM.[TRIP_id2] = ?";
                $param_3 = array($SIMU_fchini,$SIMU_fchfin,$TRIP_id,$TRIP_id);
            }
            
            if($SIMU_id[0]["SIMU_id"] == ''){
                $sql_3 = "SELECT	
                                SIM.[TRIP_id],SIM.[TRIP_id2],
                                T.[TRIP_nombre],T.[TRIP_apellido],
                                CONVERT(VARCHAR(20),SIM.[SIMU_fchini],103) AS [SIMU_fchini],
                                CONVERT(VARCHAR(20),SIM.[SIMU_fchfin],103) AS [SIMU_fchfin]
                            FROM [dbo].[SPV_SIMULADOR] SIM
                            INNER JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
                            WHERE
                            ((? BETWEEN DATEADD(DAY,-1,SIM.[SIMU_fchini]) AND DATEADD(DAY,-1,SIM.[SIMU_fchfin])) 
                            OR
                            (? BETWEEN DATEADD(DAY,-1,SIM.[SIMU_fchini]) AND DATEADD(DAY,-1,SIM.[SIMU_fchfin])))
                            AND 
                            ".$condicional;
                /*$param_3 = array($SIMU_fchini,$SIMU_fchfin,$TRIP_id);*/
                
                /*echo $sql_3;
                echo "<pre>".print_r($param_3,true)."</pre>";*/
                    
                    
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $SIMU_id[0]["SIMU_id"];
            }
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Simulador ---------------------------------*/
    public function updateSimulador($TRIP_id,$TRIP_id2,$SIMU_fchini,$SIMU_fchfin,$SIMU_indicador,$SIMU_fchentrega,$SIMU_observacion,$SIMU_estado,$SIMU_id){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_SIMULADOR]
                        SET [TRIP_id] = ?,[TRIP_id2] = ?,[SIMU_fchini] = ?,[SIMU_fchfin] = ?,[SIMU_indicador] = ?,[SIMU_fchentrega] = ".$SIMU_fchentrega.",[SIMU_observacion] = ?,[SIMU_estado] = ?,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [SIMU_id] = ?";
			$param_1 = array($TRIP_id,$TRIP_id2,$SIMU_fchini,$SIMU_fchfin,$SIMU_indicador,$SIMU_observacion,$SIMU_estado,$this->usuario,date("Ymd H:i:s"),$SIMU_id);
            
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar Simulador ---------------------------------*/
    public function buscarSimulador($TRIP_apellido,$TRIP_numlicencia,$SIMU_indicador,$TIPTRIPDET_id){
        try{
            $condicional = '';
            $param_1 = array();
            
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
            if($SIMU_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."SIM.[SIMU_indicador] = ?";
                $param = array($SIMU_indicador);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPTRIPDET_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TTD.[TIPTRIPDET_id] = ?";
                $param = array($TIPTRIPDET_id);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT SIM.[SIMU_id],
							TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                            SIM.[TRIP_id],T.[TRIP_nombre],T.[TRIP_apellido],T.[TRIP_numlicencia],
                            TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                            CONVERT(VARCHAR(20),SIM.[SIMU_fchini],103) AS [SIMU_fchini],
                            CONVERT(VARCHAR(20),SIM.[SIMU_fchfin],103) AS [SIMU_fchfin],
                            SIM.[SIMU_indicador],
                            SIM.[AUD_usu_cre],CONVERT(VARCHAR(20),SIM.[AUD_fch_cre],120) AS [AUD_fch_cre],
                            SIM.[AUD_usu_mod],CONVERT(VARCHAR(20),SIM.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_SIMULADOR] SIM
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOLICENCIA] TL ON T.[TIPLIC_id] = TL.[TIPLIC_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$condicional."
                        ORDER BY 1 DESC";
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Buscar ResumenSimulador(conIndicador) ---------------------------------*/
    public function buscarResumenSimulador($TIPTRIP_id,$SIMU_fch_Mes,$SIMU_fch_Anio,$SIMU_indicador,$TRIP_apellido){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($SIMU_fchvenci_Mes <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."MONTH(SIM.[SIMU_fchvenci]) = ?";
                $param = array($SIMU_fchvenci_Mes);
                $param_1 = array_merge($param_1,$param);
            }
            if($SIMU_fchvenci_Anio <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."YEAR(SIM.[SIMU_fchvenci]) = ?";
                $param = array($SIMU_fchvenci_Anio);
                $param_1 = array_merge($param_1,$param);
            }
            if($SIMU_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."SIM.[SIMU_indicador] = ?";
                $param = array($SIMU_indicador);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT
                        COUNT(SIM.[SIMU_id]) AS [SIMU_Afectados],
						TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
						SIM.[SIMU_fchini],
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])) AS [SIMU_fch_MesSimulador],
                        TT.[TIPTRIP_descripcion],
                        SIM.[SIMU_indicador],
                        MONTH(SIM.[SIMU_fchini]) AS [SIMU_fch_Mes],
						YEAR(SIM.[SIMU_fchini]) AS [SIMU_fch_Anio]
                        FROM [dbo].[SPV_SIMULADOR] SIM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$condicional."
                        group by 
						SIM.[SIMU_indicador],
						SIM.[SIMU_fchini],
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
						TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        MONTH(SIM.[SIMU_fchini]),
						YEAR(SIM.[SIMU_fchini]);";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Buscar ResumenSimulador(conIndicador) ---------------------------------*/
    public function buscarResumenSimuladorMatriz($TIPTRIP_id,$SIMU_fch_Mes,$SIMU_fch_Anio,$SIMU_indicador,$TRIP_apellido){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($SIMU_fchvenci_Mes <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."MONTH(SIM.[SIMU_fchvenci]) = ?";
                $param = array($SIMU_fchvenci_Mes);
                $param_1 = array_merge($param_1,$param);
            }
            if($SIMU_fchvenci_Anio <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."YEAR(SIM.[SIMU_fchvenci]) = ?";
                $param = array($SIMU_fchvenci_Anio);
                $param_1 = array_merge($param_1,$param);
            }
            if($SIMU_indicador <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."SIM.[SIMU_indicador] = ?";
                $param = array($SIMU_indicador);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT
                        COUNT(SIM.[SIMU_id]) AS [SIMU_Afectados],
						TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
                        TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
						SIM.[SIMU_fchini],
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])) AS [SIMU_fch_MesSimulador],
                        TT.[TIPTRIP_descripcion],
                        MONTH(SIM.[SIMU_fchini]) AS [SIMU_fch_Mes],
						YEAR(SIM.[SIMU_fchini]) AS [SIMU_fch_Anio]
                        FROM [dbo].[SPV_SIMULADOR] SIM
                        INNER JOIN [dbo].[SPV_TRIPULANTE] T ON SIM.[TRIP_id] = T.[TRIP_id]
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.TIPTRIPDET_id
                        INNER JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$condicional."
                        group by
						SIM.[SIMU_fchini],
                        (DATENAME(month,SIM.[SIMU_fchini]) + '-' + DATENAME(year,SIM.[SIMU_fchini])),
                        TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
						TTD.[TIPTRIPDET_id],TTD.[TIPTRIPDET_descripcion],
                        MONTH(SIM.[SIMU_fchini]),
						YEAR(SIM.[SIMU_fchini]);";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
}
?>