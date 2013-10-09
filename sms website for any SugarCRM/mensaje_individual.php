<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
session_start();
require("procesar_datos.php");
$saldo = saldo($_SESSION['USUARIO']['id']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="js/jquery/js/jquery-1.9.1.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.position.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.tooltip.js"></script>
<script language="javascript" src="js/js_sms.js"></script>
<link rel="stylesheet" href="js/jquery/development-bundle/themes/base/jquery.ui.all.css">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script language="javascript">
$(document).ready(function() 
{
	$(document).tooltip({
			track: true
		});
});
</script>

<title>Plus-Projects</title>
</head>

<body>
<div id="wrapper">
<div class="container">
<div class="logo"></div>
<div class="datos_login"><span class="datos_loginALT">Username:</span>&nbsp;<span><?php echo $_SESSION['USUARIO']['user'];?> </span><br /><span class="datos_loginALT">Balance:</span>&nbsp;<span><?php echo $saldo;?></span></div>
<div id='cssmenu'>
<ul>
   <li><a href='index.php'><span>Inicio</span></a></li>
   <li class='active'><a href='#'><span>Mensajes</span></a></li>
   <li><a href='reporte_fechas.php'><span>Reportes</span></a></li>
   <li class='last'><a href='logout.php'><span>Salir</span></a></li>
</ul>
</div>

<div class="imagen"> </div>
<div class="contenedor_formulario">
<ul>
<li class="texto_formulario">Seleccione el tipo de envio</li>
<li class="ancholiformulario">
	<select id="tipo_sms">
	<option value="individual" selected="selected">Individual</option>
	<option value="grupal">Grupal</option>
	</select>
</li>
<form name="env_in" action="confirmacion_mensaje_individual.php" method="post">
<input type="hidden" id="sms_op_i" name="sms_op_i" value="individual"/>
<li class="texto_formulario">Número del receptor</li>
<li class="ancholiformulario"><input type="text" title="Formato: 5939XXXXXXXX"class="form" name="destino" id="destino" maxlength="12" onkeypress="return fn_numeros(event)"/></li>
<li class="texto_formulario">Escriba el mensaje</li>
<li class="ancholiformulario"><textarea cols="30" rows="6" name="mensaje" id="mensaje" onkeyup="contar_carateres(this)" style="width: 294px; height: 152px;"></textarea></li>
<li class="texto_formulario">Caracteres Restantes</li>
<li class="ancholiformulario2"><input type="text" class="form" name="contador" id="contador" maxlength="3" size="3" readonly="readonly" /></li>
<li class="texto_formulario_ALT2">&nbsp;/160 caracteres.</li>
<li class="boton_enviar" onclick="vacios();"><img src="img/btn_enviar.png" /> </li>
<li class="boton_borrar" onclick="document.forms['env_in'].reset();"><img src="img/btn_borrar.png" /> </li>
</form>
</ul>
</div>
</div>
</div>
</body>
</html>
