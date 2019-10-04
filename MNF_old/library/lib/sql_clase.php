<?php 
//phpinfo();
//include("../lib/settings.php");
//ini_set("display_errors",1);
class clsDataSql {

	public $sql = cSqlBuild;
	
	private $cn_host = "172.16.1.4";
	private $cn_data = "prasys_peruvian";
	private $cn_user = "prasys";
	private $cn_pass = "peruvian2825";
	private $conx;
        
        
       public $conected = false;
	
	function  __construct() {
	      $this->sql = new cSqlBuild();
	}
	  
	function conectar_val($svr, $usr, $pas, $db)
	{
		$this->cn_host = $svr;
		$this->cn_user = $usr;
		$this->cn_pass = $pas;
    	$this->cn_data = $db;

		return $this->conectar();
	}  
		
	function conectar() { 
  
	   if (!($link=mssql_connect($this->cn_host,$this->cn_user,$this->cn_pass)))    { 
		
	      echo "Error conectando a la base de datos.";
	      exit(); 
	   } 
	   	
	   if (!mssql_select_db($this->cn_data,$link))    { 
	      echo "Error seleccionando la base de datos."; 
	      exit(); 
	   } 
	   
	   $this->conx = $link; 
	   $this->conected = true;
	   
	} 
	
	function close() {
		mssql_close($this->conx);	
	}
	
	function func_select_sql($sql) { 
	
		if ($this->conected==false ) {
			die("Error Data No conectada");	
		}
		
		$rs=mssql_query($sql, $this->conx) or die ( mssql_get_last_message()) ; 
		$i=0;
		while( $row=mssql_fetch_array($rs) )	{
			$arraydata[$i]=$row;
			$i=$i+1;
		}
		mssql_free_result($rs);
		mssql_close($cn); 	
		return $arraydata; 
	} 
	
	
	function execute($sql) { 
	
		if ($this->conected==false ) {
			die("Error Data No conectada");	
		}
		
		$rt = mssql_query($sql, $this->conx) or die ( mssql_get_last_message()) ; 
		mssql_close($cn); 
		return $rt;
			
	} 
}



class clsDataMySql
{
	
	public $def_hostname_cn = DB_HOST;
       public $def_username_cn = DB_USER;
       public $def_password_cn = DB_PASSWORD;
       public $def_database_cn = DB_NAME;
		

       private $cn_host = "";
       private $cn_data = "";
       private $cn_user = "";
       private $cn_pass = "";
       private $conx;
       
       public $conected = false;
       public $last_rows = 0;
       public $result;
       public $obj;
       public $sql = cSqlBuild;

	function  __construct() {
	     $this->sql = new cSqlBuild();
	}

	function conectar_def()
	{	
		$this->cn_host = $this->def_hostname_cn;
		$this->cn_data = $this->def_database_cn;
		$this->cn_user = $this->def_username_cn;
		$this->cn_pass = $this->def_password_cn;
		
		$this->conectar();
	}
	
	function conectar_val($svr, $usr, $pas, $db)
	{
		$this->cn_host = $svr;
		$this->cn_user = $usr;
		$this->cn_pass = $pas;
    		$this->cn_data = $db;

		$this->conectar();
	}
        
	//Funcion para conectar a la db
	private function conectar()
	{
		$this->conx = new mysqli($this->cn_host, $this->cn_user, $this->cn_pass, $this->cn_data);
	      	$this->conx->set_charset("utf8");
	       $this->conx->select_db($this->cn_data);

           
	      if (mysqli_connect_errno())
	      {
		   printf("Connect failed: %s\n", mysqli_connect_error());
		   exit();
	      } else {
		   $this->conected = true;
	      }
  	}

        function close(){
            $this->conx->close();
            $this->conected = false;
        }

	// Ejecutar una sql no retorna nada 
	function execute($SqlStr)
	{
		
                $data = $this->conx->query($SqlStr);
                $this->last_rows = $this->conx->affected_rows ;

                if (!$data){
                    throw new Exception($this->conx->error);
                }
        }

        function insert($SqlStr)
	{
		echo $SqlStr;
                $data = $this->conx->query($SqlStr);
                $this->last_rows = $this->conx->affected_rows ;

                if (!$data){
                    throw new Exception($this->conx->error);
                }
                return $this->conx->insert_id;
        }
	
	// Ejecutar una sql y devolver data 
	function getdata($SqlStr)
	{
            $this->result = $this->conx->query($SqlStr);
            $this->last_rows = $this->result->num_rows;
            return $this->result;
	}
	
	
	function getobj($SqlStr)
	{
            $this->result = $this->conx->query($SqlStr);
            $this->last_rows = $this->result->num_rows;
            return $this->result->fetch_object();
	}
	
	function getresult($SqlStr)
	{
            $this->result = $this->conx->query($SqlStr);
            $this->last_rows = $this->result->num_rows;
            return $this->result;
	}
	
	function getfirstarray($SqlStr)
	{
            $this->result = $this->conx->query($SqlStr);
            $this->last_rows = $this->result->num_rows;
            return $this->result->fetch_assoc();
	}
	
	function cuenta_tabla($tabla, $where="")
	{
		$sql = "select count(*) as num from $tabla" ;
		if ($where)
		{
			$sql .= "Where=$where" ;
		}
		
                $rs = $this->conx->query($sql);
                $obj = $rs->fetch_object();
		
		return $obj->num;
	}

        function rs(&$result){
            return $result->fetch_object();
        }
	 
	 function getarray(&$result){
            return $result->fetch_assoc();
        }
        
}



class cSqlBuild 
{
	var $valores = array();
	var $campos = array();
	var $cuenta = 0;
	var $tabla = "";
	
	
	function AddValue($cCampo, $cValor)
	{
		$this->cuenta += 1 ;
		
		$arrCampos = $this->campos;
		$arrValores = $this->valores;
				
		$arrCampos[] = $cCampo;
		
		switch( strtoupper(substr(gettype($cValor), 0, 3))) 
		{
			
			case "INT" :
				$arrValores[] = $cValor;
				break;
				
			case "STR" :
				if (strtoupper($cValor) == "SYSFECHA") {
					$arrValores[] = "CURRENT_TIMESTAMP";
				} elseif (strtoupper($cValor) == "GETDATE()")  {
					$arrValores[] = "GETDATE()";
				}
				else {
					$arrValores[] = "'" . trim((addslashes($cValor))) . "'";
				}
				break;
				
			case "FLO" :
				$arrValores[] = $cValor;
				break;	
			
			case "DOU" :
				$arrValores[] = $cValor;
				break;	
			
			case "BOO" :
				$c = 0;
				if ($cValor) $c = "1";
				$arrValores[] =  $c ;
				break;
					
			default :
				$arrValores[] = "'" . trim(addslashes($cValor)) . "'";
				break;	
					
		}
		
		//echo strtoupper(substr(gettype($cValor), 0, 3)) . "<br>" ;
		
		$this->campos = $arrCampos ;
		$this->valores = $arrValores ;
	}
	
	function GetSqlInsert()
	{
		return "Insert Into " . $this->tabla . " (" . implode(",", $this->campos) . ") values (" . implode(",", $this->valores) .  ")";
	}
	
	function GetSqlValues()
	{
		return implode(",", $this->valores);
	}
	
	function GetSqlUpdate($where)
	{
		$cadena = "Update " . $this->tabla . " Set ";
		for ($i = 0; $i < $this->cuenta; $i++) 
		{
			$cadena .= $this->campos[$i] . "=" .  $this->valores[$i] ;
			if (($this->cuenta - $i) > 1 )
			{
				$cadena .= "," ;
			}
		}
		
		$cadena .= " where " . $where;
		return $cadena ;
	}
}



?>