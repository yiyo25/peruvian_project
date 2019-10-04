<?php

ini_set('display_errors', 1);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__file__)) . DS);
define('APP_PATH', ROOT . 'app' . DS);
define('URL_LOGIN_PRINCIPAL', 'https://dev.peruvian.pe/loginPeruvian/ES/');

//echo APP_PATH;exit;
try {
    //$mantenimiento = false;
    //if(!$mantenimiento){

        require_once '../ApiLogin/apiLogin.php';
        require_once  APP_PATH .'Datos.php';
        require_once  APP_PATH .'UtilsSql.php';
        require_once  APP_PATH .'ConexionPrasysPeruvian.php';
        require_once  APP_PATH .'ConexionPasarela.php';

        require_once APP_PATH . 'Helper.php';

        require_once APP_PATH . 'Autoload.php';
        //require_once APP_PATH . 'ORM.php';
        require_once APP_PATH . 'Config.php';


        Session::init();
        Bootstrap::run(new Request);
   /* }else{
        echo "estamos en matenimiento";exit;
        //header('location:');
    }*/
    
} catch (Exception $e) {
    echo $e->getMessage();
}
?>