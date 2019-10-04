<?php 
	$prod = false;
	$sudDominio = "intranet";

	if(!$prod){
		$sudDominio = "dev";
	}
	define("URL_LOGIN_APP", 'https://'.$sudDominio.'.peruvian.pe/loginPeruvian/ES');
	define('BASE_URL', 'https://'.$sudDominio.'.peruvian.pe/CCO/');
    define('SERVER_NAME',BASE_URL);
    define('SERVER_PUBLIC',SERVER_NAME.'Public'.DS);
	define('DEFAULT_CONTROLLER', 'index');
        
        /*************Base Datos **********************/
	define('DB_HOST','172.16.1.4');
	define('DB_USER','ihuapaya');
	define('DB_PASS','ivan98x');
	define('DB_NAME','db_operacionesDev');
	define('DB_CHAR','UTF8');
        
    define("NAME_SESS_USER","uswbcco");
 ?>