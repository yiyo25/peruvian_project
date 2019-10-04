<?php
if( !isset($_SESSION)){
	session_start();
}

class Reserva_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar Resumen Reserva ---------------------------------*/
    public function listarResumenReserva() {
        try{
            $sql_1 = "SELECT RES.[RES_id],
                            CONVERT(VARCHAR(20),RES.[RES_fch],103) AS [RES_fch],
							COUNT(RESDET.[TRIP_id]) AS [RES_afectados]
                        FROM [dbo].[SPV_RESERVA] RES
						LEFT JOIN [dbo].[SPV_RESERVADET] RESDET ON RES.[RES_id] = RESDET.[RES_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON RESDET.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOLICENCIA] TL ON T.[TIPLIC_id] = TL.[TIPLIC_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
						GROUP BY 
						RES.[RES_id],
						CONVERT(VARCHAR(20),RES.[RES_fch],103)
                        ORDER BY CONVERT(VARCHAR(20),RES.[RES_fch],103) DESC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Detalle Reserva ---------------------------------*/
    public function listarDetReserva($RES_id) {
        try{
            $sql_1 = "SELECT RES.[RES_id],
                        RESDET.[TRIP_id],
                        RESDET.[RES_descripcion],
                        CONVERT(VARCHAR(20),RES.[RES_fch],103) AS [RES_fch],
                        RES.[AUD_usu_cre],CONVERT(VARCHAR(20),RES.[AUD_fch_cre],120) AS [AUD_fch_cre],
						RES.[AUD_usu_mod],CONVERT(VARCHAR(20),RES.[AUD_fch_mod],120) AS [AUD_fch_mod]
                    FROM [dbo].[SPV_RESERVA] RES
                    LEFT JOIN [dbo].[SPV_RESERVADET] RESDET ON RES.[RES_id] = RESDET.[RES_id]
                    LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON RESDET.[TRIP_id] = T.[TRIP_id]
                    LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                    LEFT JOIN [dbo].[SPV_TIPOLICENCIA] TL ON T.[TIPLIC_id] = TL.[TIPLIC_id]
                    LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                    WHERE RES.[RES_id] = ?;";
            $param_1 = array($RES_id);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Reserva ---------------------------------*/
    public function insertReserva($RES_fch){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_RESERVA]
                        ([RES_fch],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?);";
            $param_1 = array($RES_fch,$this->usuario,date("Ymd H:i:s"));
            $result = $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS RES_id;";
            $RES_id = $this->database->Consultar($sql_2);            
            return $RES_id[0]["RES_id"];
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Reserva Detalle ---------------------------------*/
    public function insertDetReserva($RES_id,$TRIP_id,$RES_tipo){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_RESERVADET]
                        ([RES_id],[TRIP_id],[RES_descripcion],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?,?);";
            $param_1 = array($RES_id,$TRIP_id,$RES_tipo,$this->usuario,date("Ymd H:i:s"));
            $result = $this->database->Ejecutar($sql_1,$param_1);
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    public function deleteReserva($RES_id){
        try{
			$sql_1 = "DELETE FROM [dbo].[SPV_RESERVADET] WHERE [RES_id] = ?;";
			$sql_2 = "DELETE FROM [dbo].[SPV_RESERVA] WHERE [RES_id] = ?;";
			$param_1 = array($RES_id);
            $this->database->Ejecutar($sql_1,$param_1);
            $this->database->Ejecutar($sql_2,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar Ausencia ---------------------------------*/
    public function buscarResumenReserva($RES_fch,$TRIP_apellido,$TRIP_numlicencia){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($RES_fch <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."CONVERT(VARCHAR(20),RES.[RES_fch],103) = ?";
                $param = array($RES_fch);
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
            
            $sql_1 = "SELECT RES.[RES_id],
                            CONVERT(VARCHAR(20),RES.[RES_fch],103) AS [RES_fch],
							COUNT(RESDET.[TRIP_id]) AS [RES_afectados]
                        FROM [dbo].[SPV_RESERVA] RES
						LEFT JOIN [dbo].[SPV_RESERVADET] RESDET ON RES.[RES_id] = RESDET.[RES_id]
                        LEFT JOIN [dbo].[SPV_TRIPULANTE] T ON RESDET.[TRIP_id] = T.[TRIP_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOLICENCIA] TL ON T.[TIPLIC_id] = TL.[TIPLIC_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        ".$condicional."
                        GROUP BY 
						RES.[RES_id],
						CONVERT(VARCHAR(20),RES.[RES_fch],103)
                        ORDER BY CONVERT(VARCHAR(20),RES.[RES_fch],103) DESC;";
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