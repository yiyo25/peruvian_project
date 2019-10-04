<?php

/*setcookie("ck_usuario_ini","x",time()-3600);
setcookie("ck_usuario_nom","x",time()-3600);
setcookie("ck_usuario_per","x",time()-3600);
setcookie("ck_usuario_perc","",time()-3600);
setcookie("ck_usuario_perc","",time()-3600);
*/


session_start();

session_destroy();

header("location:index.php?app=login");

?>