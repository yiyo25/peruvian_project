<?php 
	$prod = FALSE;
	$sudDominio = "intranet";

	if(!$prod){
		$sudDominio = "dev";
	}

    define('URL','https://'.$sudDominio.'.peruvian.pe/GSO/');

    if(isset($_GET['lan'])){
        $LANG = $_GET['lan'];
    } else{
        header('Location: '.URL.'ES/');
    }

    if($LANG <> 'ES' && $LANG <> 'EN'){
        header('Location: '.URL.'ES/');
    }

    define('BASE_URL','https://'.$sudDominio.'.peruvian.pe/GSO/'.$LANG.'/');
	define("URL_LOGIN_APP", 'https://'.$sudDominio.'.peruvian.pe/loginPeruvian/ES');
    define('SERVER_NAME','https://'.$sudDominio.'.peruvian.pe/GSO/');
    define('SERVER_PUBLIC',SERVER_NAME.'Public'.DS);
	define('DEFAULT_CONTROLLER', 'index');
        
        /*************Base Datos **********************/

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'db_admin');
    define('DB_USER', 'userweb');
    define('DB_PASS', '#Peru*31x');
    define('DB_CHAR','UTF8');

    //ACCESO A BASE DE DATOS

    define('HOST_BASE_DATOS_PASARELA', '198.72.112.144');
    define('NOMBRE_BASE_DATOS_PASARELA', 'db_pasarela');
    define('USUARIO_BASE_DATOS_PASARELA', 'userweb');
    define('CLAVE_BASE_DATOS_PASARELA', '#Peru*31x');

    define('HOST_BASE_DATOS_PRASYS_PERUVIAN', '172.16.1.4');
    define('NOMBRE_BASE_DATOS_PRASYS_PERUVIAN', 'prasys_peruvian');
    define('USUARIO_BASE_DATOS_PRASYS_PERUVIAN', 'prasys');
    define('CLAVE_BASE_DATOS_PRASYS_PERUVIAN', 'peruvian2825');

    define("NAME_SESS_USER","uswbmnf");
//AMBIENTE
    define ('DESARROLLO',FALSE);
 ?>