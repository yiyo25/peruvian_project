<?php
class Database extends PDO {
	public function __construct($bd,$gestor){
		try{
            $dbname = $bd;
            
			if($gestor == "SQLServer"){
	            
                //$server = "172.16.1.160";
                $server = "172.16.1.4";
                //$user = "usr_tramstd";
                $user = "sa";
                //$clave = "tramite";
                $clave = "peruviandb01";
                
				$url ="dblib:host=$server;dbname=$dbname";
			}
	        elseif($gestor == "SQLyog"){
	            $server = "localhost";
	            $user = "userweb";
	            $clave = "#Peru*31x";
				$url = "mysql:host=$server;dbname=$dbname";
	        }
            
            parent::__construct($url,$user,$clave);
            $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  //Los errores se manejaran por excepciones
            
        } catch(PDOException $e){
            throw $e;
		}
	}
	
	public function Ejecutar($sql,$array){
		try{
        	$cmd=$this->prepare($sql);
        	if (isset($array)) {
				return $cmd->execute($array);
			} else {
				return $cmd->execute();
			}
         }
        catch(PDOException $e)
        {
           throw $e;
        }
	}
	
	public function Consultar($sql,$array=array()){
		try{
			$cmd=$this->prepare($sql);
        	if (count($array)>0) {
				if($cmd->execute($array)){
	                $lista=$cmd->fetchAll();
	                return $lista;
	            }else{
	                return false;
	            }
			} else {
				if($cmd->execute()){
	                $lista=$cmd->fetchAll();
	                return $lista;
                    //echo "<pre>".print_r($lista,true)."</pre>";die();
	            }else{
	                return false;
	            }
			}
        } catch(PDOException $e){
           	throw $e;
        }
	}
}
?>