<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
session_start();
require_once('conexion.php'); 
$result = mysql_query("SELECT (valor_credito - SUM(valor_debito)) saldo FROM balance WHERE id_usuario = ".$_SESSION['USUARIO']['id']." GROUP BY id_credito ORDER BY id_balance DESC LIMIT 1");
if ($row = mysql_fetch_assoc($result))
{
	$saldo = $row['saldo'];
}
else
{
	$saldo = 0;
}
if(isset($_GET['t']) && $_GET['t'] == '1')
{
	$id_carga = $_GET['id'];
	$result1 = mysql_query("SELECT m2.fecha_envio, m.destinatario, m.id_clickatell_sms, e.nombre Estado, m.mensaje ,m.id_estado_interno
							FROM mensajes m 
							INNER JOIN mensajes m2 ON m.id_mensaje = m2.id_mensaje
							INNER JOIN estado_interno e ON m.id_estado_interno = e.id_estado_interno
							WHERE m.id_usuario = ".$_SESSION['USUARIO']['id']."
							AND m.id_estado_interno = 2
							AND m.id_carga_usuario = ".$id_carga."
							AND m2.fecha_envio IS NOT NULL
							AND m.id_clickatell_sms IS NOT NULL
							ORDER BY m2.fecha_envio DESC ");
	if ($row1 = mysql_fetch_assoc($result1))
	{
		$mensaje= "Se ha enviado correctamente el siguiente mensaje:<br /><br /><br />Para: ".$row1['destinatario']."<br /><br />Mensaje:<br /><br />".$row1['mensaje']."";
	} 
	else
	{
		$mensaje= "Se produjo un error al intentar el envio.";
	}
}
if(isset($_GET['t']) && $_GET['t'] == '2')
{
	$id_carga = $_GET['id'];
	$result2 = mysql_query("SELECT valor_debito FROM debito
							WHERE id_carga_usuario = ".$id_carga."
							AND id_usuario = ".$_SESSION['USUARIO']['id']."");
	if ($row2 = mysql_fetch_assoc($result2))
	{
		$mensaje= "Se ha enviado correctamente un total de <strong>".$row2['valor_debito']."</strong> mensajes.<br /><br />";
	}
	else
	{
		$mensaje= "Se produjo un error al intentar el envio.";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Plus-Projects</title>

<link rel="stylesheet" type="text/css" href="css/style.css"/>
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
<?php 
if(isset($_GET['t']) && $_GET['t'] == '1')
{
?>
<div class="contenedor_formulario">
<ul>	
	<li class="titulo_confirmacion">Resumen de envio</li>
	<li class="texto_formulario"></li>
	<li class="texto_formulario_ALT3"><?php echo $mensaje;?></li>	
	<li class="texto_formulario"></li>
	<li class="ancholiformulario"></li>	
	<li class="boton_enviar" onclick="window.location = 'mensaje_individual.php';" ><img src="img/btn_atras.png" /> </li>	
</ul>
</div>
<?php 
}
if(isset($_GET['t']) && $_GET['t'] == '2')
{
?>
<div class="contenedor_formulario">
<ul>	
	<li class="titulo_confirmacion">Resumen de envio</li>
	<li class="texto_formulario"></li>
	<li class="texto_formulario_ALT3"><?php echo $mensaje;?></li>	
	<li class="texto_formulario"></li>
	<li class="ancholiformulario"></li>	
	<li class="boton_enviar" onclick="window.location = 'mensaje_individual.php';" ><img src="img/btn_atras.png" /> </li>	
</ul>
</div>
<?php 
}
?>
</div>
</div>
</body>
</html>
