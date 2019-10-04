<?php
session_start();
/* Se comporta como un AUTOLOADER del proyecto */
require_once __DIR__.'/vendor/autoload.php';

use Tracy\Debugger;
//Debugger::enable(Debugger::DEVELOPMENT, __DIR__ . '/logs', 'dev.team@peruvian.pe');
Debugger::enable(Debugger::DEVELOPMENT, __DIR__ . '/logs', 'dev.team@peruvian.pe');
Debugger::$logSeverity = E_ALL;
Debugger::$email = 'dev.team@peruvian.pe';
Debugger::$maxDepth = 20;
Debugger::$showLocation = true;
require "./Config/paths.php";

require "./Libs/database.php";
require "./Libs/model.php";
require "./Libs/view.php";
require "./Libs/controller.php";
require "./Libs/bootstrap.php";

require "../ApiLogin/apiLogin.php";

$app = new Bootstrap();
?>