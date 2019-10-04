<?php
if( !isset($_SESSION)){
	session_start();
}

class Ruta_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar Resumen Itinerario ---------------------------------*/
    public function listarResumenRuta() {
        try{
            $sql_1 = "SELECT DISTINCT
                            RUT.[RUT_num_vuelo],RUT.[RUT_orden],RUT.[RUT_relacion],RUT.[RUT_escala],RUT.[RUT_primer_vuelo],
                            RUT.[CIU_id_origen],CIUo.[CIU_nombre] AS CIU_nombre_o,
                            RUT.[CIU_id_destino],CIUd.[CIU_nombre] AS CIU_nombre_d,
                            RUT.[RUT_estado],
                            RUT.[AUD_usu_cre],RUT.[AUD_fch_cre],RUT.[AUD_usu_mod],RUT.[AUD_fch_mod]
                    FROM [dbo].[SPV_RUTA] RUT
                    INNER JOIN [dbo].[SPV_CIUDAD] CIUo ON RUT.[CIU_id_origen] = CIUo.CIU_id
                    INNER JOIN [dbo].[SPV_CIUDAD] CIUd ON RUT.[CIU_id_destino] = CIUd.CIU_id";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Buscar Resumen Itinerario ---------------------------------*/
    public function buscarResumenRuta($RUT_num_vuelo,$CIU_id_origen,$CIU_id_destino) {
        try{
            
            $condicional = '';
            $param_1 = array();
            
            if($RUT_num_vuelo <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."RUT.[RUT_num_vuelo] = ?";
                $param = array($RUT_num_vuelo);
                $param_1 = array_merge($param_1,$param);
            }
            if($CIU_id_origen <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."RUT.[CIU_id_origen] = ?";
                $param = array($CIU_id_origen);
                $param_1 = array_merge($param_1,$param);
            }
            if($CIU_id_destino <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."RUT.[CIU_id_destino] = ?";
                $param = array($CIU_id_destino);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT DISTINCT
                            RUT.[RUT_num_vuelo],RUT.[RUT_orden],RUT.[RUT_relacion],RUT.[RUT_escala],RUT.[RUT_primer_vuelo],
                            RUT.[CIU_id_origen],CIUo.[CIU_nombre] AS CIU_nombre_o,
                            RUT.[CIU_id_destino],CIUd.[CIU_nombre] AS CIU_nombre_d,
                            RUT.[RUT_estado],
                            RUT.[AUD_usu_cre],RUT.[AUD_fch_cre],RUT.[AUD_usu_mod],RUT.[AUD_fch_mod]
                    FROM [dbo].[SPV_RUTA] RUT
                    INNER JOIN [dbo].[SPV_CIUDAD] CIUo ON RUT.[CIU_id_origen] = CIUo.CIU_id
                    INNER JOIN [dbo].[SPV_CIUDAD] CIUd ON RUT.[CIU_id_destino] = CIUd.CIU_id"
                    .$condicional;
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Listar Ruta ---------------------------------*/
    public function listarDetRuta($RUT_relacion) {
        try{            
            $sql_1 = "SELECT
                            RUT.[RUT_num_vuelo],RUT.[RUT_orden],RUT.[RUT_relacion],RUT.[RUT_escala],RUT.[RUT_primer_vuelo],
                            RUT.[CIU_id_origen],CIUo.[CIU_nombre] AS CIU_nombre_o,
                            RUT.[CIU_id_destino],CIUd.[CIU_nombre] AS CIU_nombre_d,
                            RUT.[RUT_estado],
                            RUTD.[RUTDIA_diaSemana],
                            CONVERT(VARCHAR(20),RUTD.[RUT_hora_salida],108) AS [RUT_hora_salida],
                            CONVERT(VARCHAR(20),RUTD.[RUT_hora_llegada],108) AS [RUT_hora_llegada],
                            RUT.[AUD_usu_cre],CONVERT(VARCHAR(20),RUT.[AUD_fch_cre],120) AS [AUD_fch_cre],
                            RUT.[AUD_usu_mod],CONVERT(VARCHAR(20),RUT.[AUD_fch_mod],120) AS [AUD_fch_mod]
                    FROM [dbo].[SPV_RUTA] RUT
                    INNER JOIN [dbo].[SPV_CIUDAD] CIUo ON RUT.[CIU_id_origen] = CIUo.CIU_id
                    INNER JOIN [dbo].[SPV_CIUDAD] CIUd ON RUT.[CIU_id_destino] = CIUd.CIU_id
					INNER JOIN [dbo].[SPV_RUTAxDIA] RUTD ON RUT.[RUT_num_vuelo] = RUTD.[RUT_num_vuelo]
					WHERE 
					RUT.[RUT_relacion] = ?
                    ORDER BY RUT.[RUT_orden], [RUT_hora_salida];";
            $param_1 = array($RUT_relacion);
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Ruta ---------------------------------*/
    public function insertRuta($RUT_num_vuelo,$RUT_orden,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_origen,$CIU_id_destino,$RUT_estado){
        try{
            $sql_1 = "
                    IF NOT EXISTS(
                        SELECT [RUT_num_vuelo]
                            FROM [dbo].[SPV_RUTA]
                            where RUT_num_vuelo IN (?)
                        )
                    INSERT INTO [dbo].[SPV_RUTA]
                        ([RUT_num_vuelo],[RUT_orden],[RUT_relacion],[RUT_escala],[RUT_primer_vuelo],
                        [CIU_id_origen],[CIU_id_destino],[RUT_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?,?,?,?,?,?,?)";
            $param_1 = array($RUT_num_vuelo,$RUT_num_vuelo,$RUT_orden,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_origen,$CIU_id_destino,$RUT_estado,$this->usuario,date("Ymd H:i:s"));
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS RUT_num_vuelo;";
            $RUT_num_vuelo_id = $this->database->Consultar($sql_2);
            
            if($RUT_num_vuelo_id[0]["RUT_num_vuelo"] == ''){
                $sql_3 = " SELECT [RUT_num_vuelo]
                            FROM [dbo].[SPV_RUTA]
                            where RUT_num_vuelo IN (?)";
                $param_3 = array($RUT_num_vuelo);
                $result = $this->database->Consultar($sql_3,$param_3);
                //echo "<pre>5".print_r($result,true)."</pre>";die();
                return $result;
            } else {
                return $RUT_num_vuelo[0]["RUT_num_vuelo"];
                //echo "<pre>4".print_r($RUT_num_vuelo[0]["RUT_num_vuelo"],true)."</pre>";die();
            }
            
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Insertar RutaxDia ---------------------------------*/
    public function insertRutaxDia($RUT_num_vuelo,$RUTDIA_diaSemana,$RUT_hora_salida,$RUT_hora_llegada,$RUTDIA_estado){
        try{
            $sql_1 = "INSERT INTO [dbo].[SPV_RUTAxDIA]
                        ([RUT_num_vuelo],[RUTDIA_diaSemana],[RUT_hora_salida],[RUT_hora_llegada],[RUTDIA_estado],[AUD_usu_cre],[AUD_fch_cre])
                        VALUES (?,?,?,?,?,?,?)";
            $param_1 = array($RUT_num_vuelo,$RUTDIA_diaSemana,$RUT_hora_salida,$RUT_hora_llegada,$RUTDIA_estado,$this->usuario,date("Ymd H:i:s"));
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
                
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Listar Correlativo ---------------------------------*/
    public function ordenCorrelativo(){
        try{
            $sql_1 = "SELECT TOP 1 [RUT_orden]
                        FROM dbo.[SPV_RUTA]
                        ORDER BY [RUT_orden] DESC;";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Modificar Ruta ---------------------------------*/
    public function updateRuta($RUT_num_vuelo,$RUT_orden,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_origen,$CIU_id_destino,$RUT_estado,$RUT_num_vuelo_old){
        try{
            $sql_1 = "UPDATE [dbo].[SPV_RUTA]
                        SET
                                [RUT_num_vuelo] = ?
                               ,[RUT_orden] = ?
                               ,[RUT_relacion] = ?
                               ,[RUT_escala] = ?
                               ,[RUT_primer_vuelo] = ?
                               ,[CIU_id_origen] = ?
                               ,[CIU_id_destino] = ?
                               ,[RUT_estado] = ?
                               ,[AUD_usu_mod] = ?
                               ,[AUD_fch_mod] = ?
                         WHERE [RUT_num_vuelo] = ?";
            $param_1 = array($RUT_num_vuelo,$RUT_orden,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_origen,$CIU_id_destino,$RUT_estado,$this->usuario,date("Ymd H:i:s"),$RUT_num_vuelo_old);
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Eliminar RutaxDia ---------------------------------*/
    public function deleteRutaxDia($RUT_num_vuelo){
        try{
            $sql_1 = "DELETE FROM [dbo].[SPV_RUTAxDIA] WHERE [RUT_num_vuelo] = ?";
            $param_1 = array($RUT_num_vuelo);
            
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
}
?>