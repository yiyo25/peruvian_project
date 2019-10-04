<?php
//define('URL','https://intranet.peruvian.pe/');
define('URL','https://dev.peruvian.pe/ApiLogin/');

if(isset($_GET['lan'])){
       $LANG = $_GET['lan'];
} else{
	header('Location: '.URL.'ES/');
}
if($LANG <> 'ES' && $LANG <> 'EN'){
	header('Location: '.URL.'ES/');
}

//define('URLLOGICA','https://intranet.peruvian.pe//'.$LANG.'');
define('URLLOGICA','https://dev.peruvian.pe/ApiLogin/'.$LANG.'/');
//define('URLPUBLIC','https://intranet.peruvian.pe//Public');
define('URLPUBLIC','https://dev.peruvian.pe/ApiLogin/Public');
//define('URLMODEL','https://intranet.peruvian.pe//Model/');
define('URLMODEL','https://dev.peruvian.pe/ApiLogin/Model/');

define('IPCLIENT',$_SERVER["REMOTE_ADDR"]);
define('EMPRESA','001');
define('EXPLORER',$_SERVER['HTTP_USER_AGENT']);
define('REFERER',$_SERVER['HTTP_REFERER']);
define('IDIOMA',$LANG);
define('USERGEOIP','PGqrN0hrCwmi');
define('SECRECT_KEY','a%bsd&165aWEpom?sQPW#@4=!@*+,mXqzQ')
?>