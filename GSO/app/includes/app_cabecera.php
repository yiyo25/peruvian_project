<div align="center"><span><img src="<?php echo base_url(); ?>img/banner.jpg"></span></div>
<div style="background:#EEE; border-style:solid; border-width:1px; height:25px;" >
<div id="div_refresca_session"></div>

<script type="text/javascript">
	function verificaSession(){	
		fAjax4('<?php echo base_url(); ?>./includes/app_refresca_session.php', "" , 'div_refresca_session');
		setTimeout("verificaSession()",20000);
	}
	setTimeout("verificaSession()",20000);
</script>

<?php 

//if ($_SERVER["REMOTE_ADDR"] == "172.16.1.50") echo "Url: " . $_SESSION['ck_usuario_ini'];

if( isset($_SESSION['ck_usuario_ini']) )
{
	include "./includes/app_yuimenu.php";
} else {
	
	session_destroy();
	
?>
    
    <script language="javascript1.2">
    	window.location="http://intranet.peruvian.pe";
    </script>
    
    
<?php
	exit;
}

?></div>