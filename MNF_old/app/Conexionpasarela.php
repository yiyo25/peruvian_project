<?php /**/

class ConexionPasarela extends UtilsSql
{

    public function __construct() {

        parent::__construct('mysql:dbname='.NOMBRE_BASE_DATOS_PASARELA.';host='.HOST_BASE_DATOS_PASARELA,USUARIO_BASE_DATOS_PASARELA,CLAVE_BASE_DATOS_PASARELA);

        try {

        parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);

        parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_ASSOC);

        //parent::exec("SET CHARACTER SET utf8");

        } catch (PDOException $e) {

            echo 'Error BD: ' . $e->getMessage();

        }

    }

}
