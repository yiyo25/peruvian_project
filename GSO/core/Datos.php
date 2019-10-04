<?php
class Datos{
		var $cn;
		function DatosNuevo(){
			$this->cn = new mysqli("localhost","userweb","#Peru*31x","db_admin") or die("Error en conexion ".mysql_error());
			mysqli_query("SET NAMES 'utf8'");
			mysqli_query("SET NAMES 'utf8'");			
		}
		function Datos(){
				$this->cn = mysql_connect("localhost","userweb","#Peru*31x") or die("Error en conexion ".mysql_error());
				mysql_select_db("db_admin",$this->cn)or die("Error en BD ".mysql_error());
				mysql_query("SET NAMES 'utf8'");
				mysql_query("SET NAMES 'utf8'");			
		}
		function ListarDatos($sql){
				
			$rs= mysql_query($sql,$this->cn) or die("Error en query ".mysql_error());
			return $rs;	
		}
		function ListarDatos2($sql){		
			$rs= mysql_query($sql,$this->cn) or die("Error en query ".mysql_error());
				$lista=array();
			if($rs){
				while($fila=mysql_fetch_array($rs)){
					$lista[]=$fila;
					}
				mysql_free_result($rs);
				}
			return $lista;	
		}
		
		function EjecutarDatos($sql){				
			$rsx= mysql_query($sql,$this->cn) or die("Error en query ".mysql_error());
			if($rsx>=1){
			 $msg="Se realizaron los cambios";
			}else{
			  $msg ="No se pudo completar";			
			}
			return $msg;	
		}			
		function EjecutarDatosNuevo($sql){
			$this->DatosNuevo();		
			$rsx= mysqli_query($this->cn,$sql) or die("Error en query: ".$sql." ".mysqli_error($this->cn));
			return $rsx;	
		}
}