<?php
class Database extends PDO {
	public function __construct($bd,$gestor){
		try{
			if($gestor == "SQLServerST"){
	            $dbname = $bd;
	            $server = "172.16.1.4";
	            $user = "prasys";
	            $clave = "peruvian2825";
				$url ="dblib:host=$server;dbname=$dbname";
	            parent::__construct($url,$user,$clave);
				$this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  //Los errores se manejaran por excepciones
	        }
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
			//echo $cmd;Exit;
        	if (isset($array)) {
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
	            }else{
	                return false;
	            }
			}
        }catch(PDOException $e){
           	throw $e;
        }
	}
}
?>