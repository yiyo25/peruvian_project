<?php
//define('URL','https://intranet.peruvian.pe/');
$prod = false;
$sudDominio = "intranet";

if(!$prod){
	$sudDominio = "dev";
}

define('URL','https://'.$sudDominio.'.peruvian.pe/loginPeruvian/');

if(isset($_GET['lan'])){
       $LANG = $_GET['lan'];
} else{
	header('Location: '.URL.'ES/');
}
if($LANG <> 'ES' && $LANG <> 'EN'){
	header('Location: '.URL.'ES/');
}

//define('URLLOGICA','https://intranet.peruvian.pe//'.$LANG.'');
define('URLLOGICA','https://'.$sudDominio.'.peruvian.pe/loginPeruvian/'.$LANG.'/');
//define('URLPUBLIC','https://intranet.peruvian.pe//Public');
define('URLPUBLIC','https://'.$sudDominio.'.peruvian.pe/loginPeruvian/Public');
//define('URLMODEL','https://intranet.peruvian.pe//Model/');
define('URLMODEL','https://'.$sudDominio.'.peruvian.pe/loginPeruvian/Model/');
define("URL_LOGIN_APP", 'https://'.$sudDominio.'.peruvian.pe/loginPeruvian/ES');
define('URLUNICA','https://'.$sudDominio.'.peruvian.pe/');
define('IPCLIENT',$_SERVER["REMOTE_ADDR"]);
define('EMPRESA','001');
define('EXPLORER',$_SERVER['HTTP_USER_AGENT']);
define('REFERER',$_SERVER['HTTP_REFERER']);
define('IDIOMA',$LANG);
define('USERGEOIP','PGqrN0hrCwmi');
?>