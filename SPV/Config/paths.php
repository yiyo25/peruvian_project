<?php
//define('URL','http://172.16.1.162/SPV/');
$prod = false;
$sudDominio = "intranet";

if(!$prod){
	$sudDominio = "dev";
}
define('URL','https://'.$sudDominio.'.peruvian.pe/SPV/');

if(isset($_GET['lan'])){
       $LANG = $_GET['lan'];
} else{
	header('Location: '.URL.'ES/');
}
if($LANG <> 'ES' && $LANG <> 'EN'){
	header('Location: '.URL.'ES/');
}
//echo $sudDominio;exit;
//define('URLLOGICA','http://172.16.1.162/SPV/'.$LANG.'/');
define('URLLOGICA','https://'.$sudDominio.'.peruvian.pe/SPV/'.$LANG.'/');
//define('URLPUBLIC','http://172.16.1.162/SPV/Public');
define('URLPUBLIC','https://'.$sudDominio.'.peruvian.pe/SPV/Public');

//define('URLRUTAITINERARIO','/var/www/html/SPV/Public/itinerario/');
define('URLRUTAITINERARIO','/var/www/real/SPV/Public/itinerario/');

//define('URLRUTASIMULADOR','/var/www/html/SPV/Public/simulador/');
define('URLRUTASIMULADOR','/var/www/real/SPV/Public/simulador/');

define('IPCLIENT',$_SERVER["REMOTE_ADDR"]);
define('EXPLORER',$_SERVER['HTTP_USER_AGENT']);
define('REFERER',$_SERVER['HTTP_REFERER']);
define('IDIOMA',$LANG);

define('USERGEOIP','PGqrN0hrCwmi');

define("NAME_SESS_USER","uswbspv");

define("URL_LOGIN_APP", 'https://'.$sudDominio.'.peruvian.pe/loginPeruvian/ES');


?>