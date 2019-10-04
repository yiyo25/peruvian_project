<?php
class Login_model extends Model {
	
    public function __construct(){
		parent::__construct();
	}
    
	public function UserLogin($Usuario,$Password){
		try{
            $sql_1 = "exec [sys_GetUserLogin] '".$Usuario."', '".$Password."', '".IPCLIENT."', ''";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
	}
    
	public function AccesoListaSistemas($IdEmpresa,$Usuario){
		try{
            $sql_1 = "exec [sys_GetAccesoListaSistemas]  '".$IdEmpresa."', '".$Usuario."'";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
	}
    
	public function AccesoSistema($IdEmpresa,$Usuario,$IdSistema){
		try{
            $sql_1 = "exec [sys_GetAccesoSistema] '".$IdEmpresa."','".$Usuario."', '".$IdSistema."'";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
	}
    
	public function MenuUsuario($IdEmpresa,$Usuario,$IdSistema){
		try{
            $sql_1 = "exec [sys_GetMenuUsuario] '".$IdEmpresa."','".$Usuario."', '".$IdSistema."'";
            $result = $this->database->Consultar($sql_1);
            return $result;
        } catch (Excepcion $e){
            throw $e;
        }
	}
}
?>