<?php
session_start();
/* Se comporta como un AUTOLOADER del proyecto */
date_default_timezone_set('America/Lima');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__file__)) . DS);
define("LIBS_PATH", ROOT. 'Libs' . DS);

require "./Config/paths.php";
require "./Config/interfaz.php";
require "./Model/nusoap/nusoap.php"; //Librería de web service client
require "./Libs/database.php";
require "./Libs/model.php";

//require "./Model/login_model.php";
require "./Model/log_model.php";
require "./Model/traduce_model.php";
require "./Model/registroEdit_model.php";
require "./Model/registro_model.php";
require "./Model/seguimiento_model.php";
require "./Model/empresa_model.php";
require "./Model/tipo_documento_model.php";
require "./Model/area_model.php";
require "./Model/cargo_model.php";
require "./Model/contacto_model.php";
require "./Model/agregarCopia_model.php";
require "./Model/alertasEdit_model.php";
require "./Model/nas_model.php";

require_once '../ApiLogin/apiLogin.php';

require "./Libs/view.php";
require "./Libs/controller.php";
require "./Libs/bootstrap.php";

require "./Config/variables.php";

$app = new Bootstrap();

?>