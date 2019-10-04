<?php
if( !(class_exists("ComposerAutoloaderInitbb66ac195b4e3f4f0fa4ff386382aa5d")) ){
    require_once __DIR__.'/vendor/autoload.php';
}
use Tracy\Debugger;
Debugger::enable(Debugger::DEVELOPMENT, __DIR__ . '/logs', 'dev.team@peruvian.pe');
Debugger::$logSeverity = E_ALL;
Debugger::$email = 'dev.team@peruvian.pe';
Debugger::$maxDepth = 20;
Debugger::$showLocation = true;


require __DIR__."/Libs/JWTLibs.php";
require __DIR__."/Libs/database.php";
require __DIR__."/Libs/model.php";

require __DIR__."/Model/login_model.php";

define("EMPRESA_ID", "001");

class ApiLogin {
    public $jwt;
    function __construct() {
        $this->jwt = new JWTLibs();
    }

    public function GetUserLogin($Usuario,$Password){
        try{

            $ClassLogueo = new Login_model();
            $UserLogin = $ClassLogueo->UserLogin($Usuario,$Password);            
            $result = $UserLogin[0]["Result"];
            $objUsuario = new stdClass();
            
            if( $result == "1" ){
                $objUsuario->Result = $UserLogin[0]["Result"];
                $objUsuario->Mensaje = $UserLogin[0]["Mensaje"];             
                $return = $objUsuario;
            } else if( $result == "0" ){
                $objUsuario->IdUsuario = $UserLogin[0]["IdUsuario"];
                $objUsuario->Nombre = $UserLogin[0]["Nombre"];
                $objUsuario->IdTipo = $UserLogin[0]["IdTipo"];
                $objUsuario->NomTipo = $UserLogin[0]["NomTipo"];
                $objUsuario->Result = $UserLogin[0]["Result"];
                $objUsuario->Mensaje = $UserLogin[0]["Mensaje"];
                $return = $objUsuario;
            }
            return $return;
		} catch(Exception $e){
            return 0;
        }
    }


    public function GetAccesoListaSistemas($IdEmpresa,$Usuario){
        try{
            $ClassLogueo = new Login_model();
            $ListaAplicaciones = $ClassLogueo->AccesoListaSistemas($IdEmpresa,$Usuario);            
            
            $appNoVisibles = array('REV','COM','REVB','SPF','MAN');
            $ListaAplicaciones = array_filter($ListaAplicaciones["data"], function($value) use ($appNoVisibles){
                return !(in_array($value["IdSistema"],$appNoVisibles));
            });
                        
            $ListaAplicaciones = array_values($ListaAplicaciones);
            $ListApps = new stdClass();
            if( count($ListaAplicaciones) == 0 ){
                $ListApps->data = array();
                $ListApps->result = false;
                $ListApps->Mensaje = "El usuario no tiene ninguna aplicación asignada."; 
                $return = $ListApps;
            } else {
                $ListApps->data = $ListaAplicaciones;
                $ListApps->Mensaje = "";
                $ListApps->result = true;
                $return = $ListApps;
            }
            return $return;
		} catch(Exception $e){
            $ListApps = new stdClass();
            $ListApps->data = array();
            $ListApps->result = false;
            $ListApps->Mensaje = "Ocurrio un problema, vuelva a intentarlo."; 
            return $ListApps;
        }
    }
    
    public function GetAccesoSistema($token){
        try{
            $ClassLogueo = new Login_model();
            $datatoken = $this->jwt->GetData($token);
            $Usuario = $datatoken->Usuario;
            $IdSistema = $datatoken->IdSistema;

            $AccesoSistema = $ClassLogueo->AccesoSistema(EMPRESA_ID,$Usuario,$IdSistema);            
            $result = $AccesoSistema[0]["Result"];
            $data = new stdClass();
            
            if( $result == "1" ){
                $data->Mensaje = "El usuario no tiene permiso para esta aplicación.";
                $data->result = false;
            } else if( $result == "0" ){
                $data->Mensaje = "";
                $data->result = true;
            }
            return $data;
        } catch(Exception $e){
            $data = new stdClass();
            $data->Mensaje = "El Token ha expirado, recarge la pagina para volver a ingresar.";
            $data->result = false;
            return $data;
        }
    }

    public function GetAccesoProgExec($Usuario,$Programa,$tipo){
       
        try {
            $ClassLogueo = new Login_model();
            $access_program = $ClassLogueo->AccesoProgramaExec(EMPRESA_ID,$Usuario,$Programa,$tipo);
            $data = new stdClass();
            if(count($access_program)>0){
                $result = $access_program[0]["Result"];
                if( $result == "1" ){
                    $data->Mensaje = "El usuario no tiene permiso para acceder al Programa.";
                    $data->result = false;
                } else if( $result == "0" ){
                    $data->Mensaje = "";
                    $data->result = true;
                }
               
            }else{
                $data->Mensaje = "No Existe Registro para los datos ingresados ";
                $data->result = false;
            }
            return $data;
        } catch (Exception $e) {
            $data = new stdClass();
            $data->Mensaje = "Ocurrio un error inesperado, vuelva a interntalo.";
            $data->result = false;
            return $data;
        }
    }

    

   
    public function GetMenuUsuario($Usuario,$IdSistema){
        try{
            $ClassLogueo = new Login_model();
            $MenuUsuario = $ClassLogueo->MenuUsuario(EMPRESA_ID,$Usuario,$IdSistema);
            $Menu = new stdClass();
            if( count($MenuUsuario) <= 0 ){
                $Menu->data = array();
                $Menu->result = false;
                $Menu->Mensaje = "El usuario no tiene ningún Menu asugnado."; 
                $return = $Menu;
            } else {
                $Menu->data = $MenuUsuario;
                $Menu->result = true;
                $Menu->Mensaje = "";
                $return = $Menu;
            }
            return $return;
		} catch(Exception $e){
            $Menu = new stdClass();
            $Menu->data = array();
            $Menu->result = false;
            $Menu->Mensaje = "El usuario no tiene ningún Menu asugnado.";
            return $Menu; 
        }
    }

    public function GetPermisosProgporPaginas($Usuario,$Programa,$tipo){
       
        try {
            $ClassLogueo = new Login_model();
            $access_program = $ClassLogueo->AccesosPrograma(EMPRESA_ID,$Usuario,$Programa,$tipo);
            $data = new stdClass();
            if(count($access_program)>0){
                $result = $access_program[0]["Result"];
                if( $result == "1" ){
                    $data->Mensaje = "El usuario no tiene permiso para acceder al Programa.";
                    $data->permisos = array();
                    $data->result = false;
                } else if( $result == "0" ){
                    $data->Mensaje = "";
                    $data->permisos= $access_program;
                    $data->result = true;
                }
               
            }else{
                $data->Mensaje = "No Existe Registro para los datos ingresados ";
                $data->permisos = array();
                $data->result = false;
            }
            return $data;
        } catch (Exception $e) {
            $data = new stdClass();
            $data->Mensaje = "Ocurrio un error inesperado, vuelva a interntalo.";
            $data->permisos = array();
            $data->result = false;
            return $data;
        }
    }

    public function getAllPermisos($Usuario,$tipo){
        try{
            $ClassLogueo = new Login_model();
            $access_program = $ClassLogueo->getAllAccessProgram(EMPRESA_ID,$Usuario,$tipo);
            $data = new stdClass();
            if(count($access_program)>0){
                $data->Mensaje = "";
                $data->permisos = $access_program;
                $data->result = true;
               
            }else{
                $data->Mensaje = "No Existe Registro para los datos ingresados ";
                $data->permisos = array();
                $data->result = false;
            }
             return $data;
        }catch(Exception $e){
            $data = new stdClass();
            $data->Mensaje = "Ocurrio un error inesperado, vuelva a interntalo.";
            $data->permisos = array();
            $data->result = false;
            return $data;
        }
        
    }

    public function GetDataToken($token){
        return $this->jwt->GetData($token);
    }

}

?>
