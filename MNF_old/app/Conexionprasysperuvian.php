<?php /**/

class ConexionPrasysPeruvian extends UtilsSql
{

    public function __construct() {
        //parent::__construct('mysql:dbname='.NOMBRE_BASE_DATOS_PRASYS_PERUVIAN.';host='.HOST_BASE_DATOS_PRASYS_PERUVIAN,USUARIO_BASE_DATOS_PRASYS_PERUVIAN,CLAVE_BASE_DATOS_PRASYS_PERUVIAN);
        try {
            $dbname = NOMBRE_BASE_DATOS_PRASYS_PERUVIAN;
            $server=HOST_BASE_DATOS_PRASYS_PERUVIAN;
            $user=USUARIO_BASE_DATOS_PRASYS_PERUVIAN;
            $clave = CLAVE_BASE_DATOS_PRASYS_PERUVIAN;
            $port = 1433;
            $url ="dblib:charset=UTF-8;host=$server:$port;dbname=$dbname";
            parent::__construct($url,$user,$clave);
            parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);
            parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_ASSOC);
            //parent::exec("SET CHARACTER SET utf8");

        } catch (PDOException $e) {

            echo 'Error BD: ' . $e->getMessage();

        }

    }

}
