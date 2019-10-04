<?php
session_start();
/* Se comporta como un AUTOLOADER del proyecto */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__file__)) . DS);
define("LIBS_PATH", ROOT. 'Libs' . DS);

require "./Config/paths.php";
require "./Config/interfaz.php";

require "./Libs/database.php";

require "./Libs/model.php";

require "./Public/WsSeguridad/WsSeguridad.php";
//require "./Model/login_model.php";
require "./Model/usuario_model.php";
require "./Model/componente_model.php";
require "./Model/log_model.php";
require "./Model/detalle_model.php";
require "./Model/avion_model.php";
require "./Model/tripulante_model.php";
require "./Model/apto_model.php";
require "./Model/curso_model.php";
require "./Model/chequeo_model.php";
require "./Model/simulador_model.php";
require "./Model/ausencia_model.php";
require "./Model/condicion_model.php";
require "./Model/itinerario_model.php";
require "./Model/programacion_model.php";
require "./Model/motor_model.php";
require "./Model/reserva_model.php";
require "./Model/Email_model.php";
require "./Model/ruta_model.php";
//echo LIBS_PATH . 'Autoload.php';
//require_once LIBS_PATH . 'Autoload.php';

//require "./Controller/motor_controller.php";


require_once '../ApiLogin/apiLogin.php';

require "./Libs/view.php";
require "./Libs/controller.php";
require "./Libs/bootstrap.php";
$app = new Bootstrap();

?>