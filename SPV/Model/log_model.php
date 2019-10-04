<?php
if( !isset($_SESSION)){
	session_start();
}

class Log_model extends Model {
	
    public function __construct(){
		parent::__construct();
        $this->usuario = $_SESSION[NAME_SESS_USER]["id_usuario"];
	}
	
	public function insertarLog($tabla,$campo,$operacion,$valor_actual,$valor_nuevo,$log_tablaApoyo,$elemento_id)
	{
		try{
            $log_descripcion = "";
            if($operacion == 'UPDATE'){
                $log_descripcion = "Se ha modificado el campo: ".$campo. ", del Valor: ".$valor_actual." cambio al Valor: ".$valor_nuevo;
            } else if($operacion == 'INSERT'){
                $log_descripcion = "Se ha agregado un registro: con el ID: ".$valor_nuevo;
            } else if ($operacion == 'DELETE'){
                $log_descripcion = "Se ha eliminado un regitro con el valor de: ".$valor_actual." con el ID: ".$elemento_id;
            }
			$sql_1 = "INSERT INTO [dbo].[SPV_LOG](
                        [log_tabla],[log_campo],[log_usu],[log_fch],[log_operacion],[log_valor_actual],[log_valor_nuevo],[log_descripcion],[log_tablaApoyo],[id_elemento])
                        VALUES (?,?,?,?,?,?,?,?,?,?);";
			$param_1 = array($tabla,$campo,utf8_decode($this->usuario),date("Ymd H:i:s"),$operacion,utf8_decode($valor_actual),utf8_decode($valor_nuevo),utf8_decode($log_descripcion),$log_tablaApoyo,$elemento_id);
            /*echo $sql_1;
            echo "<pre>".print_r($param_1,true)."</pre>";die();*/
			$this->database->Ejecutar($sql_1,$param_1);
        } catch(Exception $e){
            throw $e;
		}
	}
}
?>