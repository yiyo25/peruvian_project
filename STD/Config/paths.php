<?php
/*define('URL','https://intranet.peruvian.pe/STD/');
	//$LANG = $_GET['lan'];
if(isset($_GET['lan'])){
	$LANG = $_GET['lan'];
}else{
	header('Location: '.URL.'ES/');
}
if($LANG <> 'ES' && $LANG <> 'EN'){
	header('Location: '.URL.'ES/');
}	*/

$prod = false;
$sudDominio = "intranet";

if(!$prod){
    $sudDominio = "dev";
}
define('URL','https://'.$sudDominio.'.peruvian.pe/STD/');

if(isset($_GET['lan'])){
    $LANG = $_GET['lan'];
} else{
    header('Location: '.URL.'ES/');
}
if($LANG <> 'ES' && $LANG <> 'EN'){
    header('Location: '.URL.'ES/');
}
define('URLLOGICA','https://'.$sudDominio.'.peruvian.pe/STD/'.$LANG.'/');
define('URLPUBLIC','https://'.$sudDominio.'.peruvian.pe/STD/Public');
define('IPCLIENT',$_SERVER["REMOTE_ADDR"]);
define('EXPLORER',$_SERVER['HTTP_USER_AGENT']);
define('REFERER',$_SERVER['HTTP_REFERER']);
define('IDIOMA',$LANG);
define('USERGEOIP','PGqrN0hrCwmi');

define("NAME_SESS_USER","uswbstd");

define("URL_LOGIN_APP", 'https://'.$sudDominio.'.peruvian.pe/loginPeruvian/ES');
?>