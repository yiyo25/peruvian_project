<?php
if( !isset($_SESSION)){
	session_start();
}

class Tripulante_model extends Model {
	
    public $usuario;
    
    public function __construct(){
		parent::__construct();
        $this->usuario = utf8_encode($_SESSION[NAME_SESS_USER]["id_usuario"]);
	}
    
    /*--------------------------------- Listar Tripulante ---------------------------------*/
    public function listarTripulante($TRIP_id,$TIPTRIP_id,$TIPTRIPDET_id,$TRIP_instructor) {
        try{
            $condicional = "";
            $param_1 = array();
            
            if($TIPTRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."TT.[TIPTRIP_id] = ?";
                $param = array($TIPTRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_id] = ?";
                $param = array($TRIP_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPTRIPDET_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TIPTRIPDET_id] = ?";
                $param = array($TIPTRIPDET_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_instructor <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_instructor] = ?";
                $param = array($TRIP_instructor);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT T.[TRIP_id],T.[TIPTRIPDET_id],T.[TRIP_instructor],TTD.[TIPTRIPDET_descripcion],
						TT.[TIPTRIP_id],TT.[TIPTRIP_descripcion],
						T.[TRIP_nombre],T.[TRIP_apellido],T.[TRIP_correo],
                        CONVERT(VARCHAR(20),T.[TRIP_fechnac],103) AS [TRIP_fechnac],
                        (((365* year(getdate()))-(365*(year([TRIP_fechnac]))))+ (month(getdate())-month([TRIP_fechnac]))*30 +(day(getdate()) - day([TRIP_fechnac])))/365 as [TRIP_edad],
						T.[idDist],PROV.[idProv],DEPA.[idDepa],T.[TRIP_domilicio],
                        T.[TIPLIC_id],TL.[TIPLIC_descripcion],T.[TRIP_numlicencia],T.[TRIP_DGAC],T.[NIVING_id],T.[CAT_id],T.[TRIP_estado],
                        TT.[TIPTRIP_id],
                        T.[AUD_usu_cre],CONVERT(VARCHAR(20),T.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        T.[AUD_usu_mod],CONVERT(VARCHAR(20),T.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_TRIPULANTE] T
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOLICENCIA] TL ON T.[TIPLIC_id] = TL.[TIPLIC_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_UBDISTRITO] DIST ON T.[idDist] = DIST.[idDist]
                        LEFT JOIN [dbo].[SPV_UBPROVINCIA] PROV ON DIST.[idProv] = PROV.[idProv]
                        LEFT JOIN [dbo].[SPV_UBDEPARTAMENTO] DEPA ON PROV.[idDepa] = DEPA.[idDepa]
                        ".$condicional."
                        AND T.[TRIP_id] != 0
                        ORDER BY 8 ASC";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
    
    /*--------------------------------- Insertar Tripulante ---------------------------------*/
    public function insertTripulante ($TRIP_nombre,$TRIP_apellido,$TRIP_correo,$TRIP_fechnac,$idDist,$TRIP_domilicio,$TIPTRIPDET_id,$TRIP_instructor,$TIPLIC_id,$TRIP_numlicencia,$TRIP_DGAC,$NIVING_id,$CAT_id,$TRIP_estado) {
        try{
			$sql_1 = "IF NOT EXISTS( SELECT [TIPTRIPDET_id],[TRIP_numlicencia] FROM [dbo].[SPV_TRIPULANTE] WHERE [TIPTRIPDET_id] = ? and [TRIP_numlicencia] = ?)
                        INSERT INTO [dbo].[SPV_TRIPULANTE](
                            [TIPTRIPDET_id],[TRIP_instructor],[TRIP_nombre],[TRIP_apellido],[TRIP_correo],[TRIP_fechnac],[idDist],[TRIP_domilicio],[TIPLIC_id],[TRIP_numlicencia],[TRIP_DGAC],[NIVING_id],[CAT_id],[TRIP_estado],[AUD_usu_cre],[AUD_fch_cre])
     			        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
			$param_1 = array($TIPTRIPDET_id,$TRIP_numlicencia,$TIPTRIPDET_id,$TRIP_instructor,utf8_decode($TRIP_nombre),utf8_decode($TRIP_apellido),utf8_decode($TRIP_correo),$TRIP_fechnac,$idDist,utf8_decode($TRIP_domilicio),$TIPLIC_id,$TRIP_numlicencia,$TRIP_DGAC,$NIVING_id,$CAT_id,$TRIP_estado,$this->usuario,date("Ymd H:i:s"));
            
            
            $this->database->Ejecutar($sql_1,$param_1);
            
            $sql_2 = "SELECT SCOPE_IDENTITY() AS TRIP_id;";
            $TRIP_id = $this->database->Consultar($sql_2);
            
            if($TRIP_id[0]["TRIP_id"] == ''){
                $sql_3 = "SELECT *
                            FROM [dbo].[SPV_TRIPULANTE] WHERE [TIPTRIPDET_id] = ? and [TRIP_numlicencia] = ?";
                $param_3 = array($TIPTRIPDET_id,$TRIP_numlicencia);
                $result = $this->database->Consultar($sql_3,$param_3);
                return $result;
            } else {
                return $TRIP_id[0]["TRIP_id"];
            }
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Modificar Tripulante ---------------------------------*/
    public function updateTripulante ($TRIP_id,$TRIP_nombre,$TRIP_apellido,$TRIP_correo,$TRIP_fechnac,$idDist,$TRIP_domilicio,$TIPTRIPDET_id,$TRIP_instructor,$TIPLIC_id,$TRIP_numlicencia,$TRIP_DGAC,$NIVING_id,$CAT_id,$TRIP_estado){
        try{
			$sql_1 = "UPDATE [dbo].[SPV_TRIPULANTE]
                        SET [TIPTRIPDET_id] = ?,[TRIP_instructor] = ?,[TRIP_nombre] = ?,[TRIP_apellido] = ?,[TRIP_correo] = ?,[TRIP_fechnac] = ?,[idDist] = ?,[TRIP_domilicio] = ?
                            ,[TIPLIC_id] = ?,[TRIP_numlicencia] = ?,[TRIP_DGAC] = ?,[NIVING_id] = ?,[CAT_id] = ?,[TRIP_estado] = ?
                            ,[AUD_usu_mod] = ?,[AUD_fch_mod] = ?
                        WHERE [TRIP_id] = ?";
			$param_1 = array($TIPTRIPDET_id,$TRIP_instructor,utf8_decode($TRIP_nombre),utf8_decode($TRIP_apellido),utf8_decode($TRIP_correo),$TRIP_fechnac,$idDist,utf8_decode($TRIP_domilicio),$TIPLIC_id,$TRIP_numlicencia,$TRIP_DGAC,$NIVING_id,$CAT_id,$TRIP_estado,$this->usuario,date("Ymd H:i:s"),$TRIP_id);
            
            /*echo $sql_1."</br>";
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
            
            $this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
    }
    
    /*--------------------------------- Buscar Tripulante ---------------------------------*/
    public function buscarTripulante($TRIP_apellido,$TIPLIC_id,$TRIP_numlicencia,$TIPTRIPDET_id){
        try{
            $condicional = '';
            $param_1 = array();
            
            if($TRIP_apellido <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_apellido] LIKE ?";
                $param = array("%".utf8_decode($TRIP_apellido)."%");
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPLIC_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TIPLIC_id] = ?";
                $param = array($TIPLIC_id);
                $param_1 = array_merge($param_1,$param);
            }
            if($TRIP_numlicencia <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TRIP_numlicencia]= ?";
                $param = array($TRIP_numlicencia);
                $param_1 = array_merge($param_1,$param);
            }
            if($TIPTRIPDET_id <> ''){
                $condicional .= ($condicional == ''?" WHERE ":" AND ")."T.[TIPTRIPDET_id] = ?";
                $param = array($TIPTRIPDET_id);
                $param_1 = array_merge($param_1,$param);
            }
            
            $sql_1 = "SELECT T.[TRIP_id],T.[TIPTRIPDET_id],T.[TRIP_instructor],TTD.[TIPTRIPDET_descripcion],TT.[TIPTRIP_descripcion],T.[TRIP_nombre],T.[TRIP_apellido],T.[TRIP_correo],
                        CONVERT(VARCHAR(20),T.[TRIP_fechnac],103) AS [TRIP_fechnac],
						T.[idDist],PROV.[idProv],DEPA.[idDepa],T.[TRIP_domilicio],
                        T.[TIPLIC_id],TL.[TIPLIC_descripcion],T.[TRIP_numlicencia],T.[TRIP_DGAC],T.[NIVING_id],T.[CAT_id],T.[TRIP_estado],
                        T.[AUD_usu_cre],CONVERT(VARCHAR(20),T.[AUD_fch_cre],120) AS [AUD_fch_cre],
                        T.[AUD_usu_mod],CONVERT(VARCHAR(20),T.[AUD_fch_mod],120) AS [AUD_fch_mod]
                        FROM [dbo].[SPV_TRIPULANTE] T
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTEDET] TTD ON T.[TIPTRIPDET_id] = TTD.[TIPTRIPDET_id]
                        LEFT JOIN [dbo].[SPV_TIPOLICENCIA] TL ON T.[TIPLIC_id] = TL.[TIPLIC_id]
                        LEFT JOIN [dbo].[SPV_TIPOTRIPULANTE] TT ON TTD.[TIPTRIP_id] = TT.[TIPTRIP_id]
                        LEFT JOIN [dbo].[SPV_UBDISTRITO] DIST ON T.[idDist] = DIST.[idDist]
                        LEFT JOIN [dbo].[SPV_UBPROVINCIA] PROV ON DIST.[idProv] = PROV.[idProv]
                        LEFT JOIN [dbo].[SPV_UBDEPARTAMENTO] DEPA ON PROV.[idDepa] = DEPA.[idDepa]"
                        .$condicional.
                        " ORDER BY 1 DESC";
            $result = $this->database->Consultar($sql_1,$param_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
    }
}
?>