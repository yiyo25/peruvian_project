<div id="navigation_user" style="display:none;">
    <div class="infoUsuario">
    	<h1>Robert Steve, Paredes Quispe</h1>
    </div>
    <ul class="menuUsuario">
        <h2>Usuario</h2>
        <li>
            <a href="#" onClick="menudiv('totalidad')"><span class="icoTotalidad">icoTotalidad </span>Cambiar Contrase&ntilde;a</a>
        </li>
        <li>
            <a href="#" onClick="menudiv('obs_pasajeros')"><span class="icoObservaciones">icoObservaciones </span>Salir</a>
        </li>
    </ul>
</div>
<style>
	#navigation_user{
		float:right;
		height:700px;
		background:#333;
		width:200px;
	}
	.infoUsuario{
		color:#FFF;
		padding-left:10px;
	}
	.menuUsuario{
		background: #2A2A2A;
    	margin-top: 15px;
	}
	.menuUsuario h2{
		background: #2A2A2A;
		box-sizing: border-box;
		color: #7B7B7B;
		display: block;
		font-family: "Open Sans",Helvetica,Arial,sans-serif;
		font-size: 13px;
		font-weight: 700;
		padding: 5px 0 3px 10px;
		text-transform: uppercase;
	}
	.menuUsuario li{
		background: #555555;
		border: 0 none;
		margin: 0;
		padding: 3px 0;
	}
	.menuUsuario li a{
		border-bottom: 1px solid #484848;
		display: inline-block;
		margin: 0 0 0 8px;
		padding: 5px 0;
		width: 95%;
	}
</style>
<script>
	$('#menu-user').sidr({
	  name	:	 	'sidr-menu',
	  speed		:	300,
	  side		: 	'right',
	  source	: 	'#navigation_user',
	  renaming	:	false,
	  body		:	'body'
	});
</script>