<?php
//class Login_model extends Model {

class Login_model extends ModelLogin {
	public $jwt_model;
    public function __construct(){
		parent::__construct();
        $this->jwt_model = new JWTLibs();
	}
    
	public function UserLogin($Usuario,$Password){
		try{
            $sql_1 = "exec [sys_GetUserLogin] '".$Usuario."', '".$Password."', '".IPCLIENT."', ''";
           // echo $sql_1;exit;
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
            $sql_usuario = "SELECT IdUsuario,UserNom,UserApe,UserEmail FROM sysUsuarios where sysUsuarios.IdUsuario='".$Usuario."'";
            $result_usu = $this->database->Consultar($sql_usuario);
            $data = array();
            $array_result = array();
            foreach ($result as $key => $value) {
                 $data['IdSistema'] = $value["IdSistema"];
                 $data['NombreSistema'] = $value["NombreSistema"];
                 $create_token = array('Usuario' => $Usuario ,"IdSistema" => $value["IdSistema"] ,"DataUser"=>$result_usu[0]);
                 $token = $this->jwt_model->SignIn($create_token);
                 $data["token"] =$token;
                 $array_result[] = $data;
            }
            return array("data"=>$array_result);
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

    /*public function createTokenSistema($IdEmpresa,$Usuario)
    {
        
        $sql_1 = "exec [sys_GetAccesoListaSistemas]  '".$IdEmpresa."', '".$Usuario."'";

        $result = $this->database->Consultar($sql_1);
        $data = array();
        $array_result = array();
        if(count($result)>0){
            foreach ($result as $key => $value) {
                $access_toke = md5($value["IdSistema"]).time();
                $sql_update_secretKey = "update sysSistemas set access_token='". $access_toke."' where IdSistema='".$value["IdSistema"]."'";
                $this->database->Ejecutar($sql_update_secretKey);
            }
        }
    }

    public function deleteSecretKey($IdSistema){

        $sql_update_secretKey = "update sysSistemas set access_token='' where IdSistema='".$IdSistema."'";

        $this->database->Ejecutar($sql_update_secretKey);
    }

    public function getExistSecretKey($IdSistema){
        $sql_sistema = "select * from sysSistemas where IdSistema='".$IdSistema."'";
        $result = $this->database->Consultar($sql_sistema);
        if(count($result)>0){
            if($result[0]["access_token"]!=""){
                return true;
            }
        }
        return false;
    }*/

    public function AccesoProgramaExec($IdEmpresa,$Usuario,$Programa,$tipo){
        $sql_acceso_prog = "exec [sys_GetAccesoProgExec]  '".$IdEmpresa."', '".$Usuario."','".$Programa."','".$tipo."'";

        $result = $this->database->Consultar($sql_acceso_prog);
        return $result;

    }

    public function AccesosPrograma($IdEmpresa,$Usuario,$Programa,$tipo){
        $sql_acceso_prog = "exec [sys_GetAccesoProg]  '".$IdEmpresa."', '".$Usuario."','".$Programa."','".$tipo."'";

        $result = $this->database->Consultar($sql_acceso_prog);
        return $result;

    }

    public function getAllAccessProgram($IdEmpresa,$Usuario,$tipo){
        $sql_all_permisos = "select IdPrograma,Tipo , Ejecutar,Agregar,Modificar,Eliminar,Exportar,Procesar,Imprimir  
            from sysAccesos ,sysEmpresaUsuario
            WHERE   
            sysAccesos.IdEmpresaUsuario = sysEmpresaUsuario.IdEmpresaUsuario AND
            IdUsuario = '".$Usuario."' AND IdEmpresa = '".$IdEmpresa."' AND Tipo='".$tipo."'";

        $result = $this->database->Consultar($sql_all_permisos);
        return $result;
    }
}
?>