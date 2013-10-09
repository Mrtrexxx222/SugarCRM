<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
include_once('conexion.php'); 
session_start();
$result = mysql_query("SELECT (valor_credito - SUM(valor_debito)) saldo FROM balance WHERE id_usuario = ".$_SESSION['USUARIO']['id']." GROUP BY id_credito ORDER BY id_balance DESC LIMIT 1");
if ($row = mysql_fetch_assoc($result))
{
	$saldo = $row['saldo'];
}
else
{
	$saldo = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script language="javascript" src="js/jquery/js/jquery-1.9.1.js"></script>
<script language="javascript" src="js/js_sms.js"></script>
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
   <li class='active'><a href='mensaje_individual.php'><span>Mensajes</span></a></li>
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
		<option value="individual" >Individual</option>
		<option value="grupal" selected="selected">Grupal</option>
		</select>
	</li>
	<form name="env_gr" action="confirmacion_mensaje_grupal.php" method="post" enctype="multipart/form-data">
	<input type="hidden" id="sms_op_g" name="sms_op_g" value="grupal"/></td>
	<li class="texto_formulario">Seleccione el archivo CSV</li>
	<li class="ancholiformulario"><input type="file" name="archivo" id="archivo" size="40" class="form"></li>
	<li class="texto_formulario"></li>
	<li class="texto_vinculo" style="float:left;"><a href="csv/plantilla.csv">Descargar plantilla de ejemplo</a></li>
	<li class="boton_subirarchivos" onclick="grupal_vacio();"> </li>  
	</form>
</ul>
</div>
</div>
</div>
</body>
</html>
