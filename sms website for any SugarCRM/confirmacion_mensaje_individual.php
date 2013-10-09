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
$destino 	= $_POST['destino'];
$mensaje 	= $_POST['mensaje'];
$contador	= $_POST['contador'];
$habilita_o_no 	= '';
$sin_saldo	= '';
if($saldo <= 0)
{
	$sin_saldo 	= 'No dispone de saldo suficiente para realizar el envio.';
	$habilita_o_no 	= '<li class="boton_borrar" onclick="alert(\''.$sin_saldo.'\');"><img src="img/btn_enviar_dis.png" /> </li>';
}
else
{
	$habilita_o_no 	= '<li class="boton_borrar" onclick="document.forms[\'conf_in\'].submit();"><img src="img/btn_enviar.png" /> </li>';
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
<div class="contenedor_formulario">
<ul>
	<li class="titulo_confirmacion">Confirmación del mensaje a enviar</li>
	<form name="conf_in" action="procesar_datos.php" method="post">
	<input type="hidden" id="sms_op_i_f" name="sms_op_i_f" value="<?php echo $_POST['sms_op_i'];?>"/>
	<input type="hidden" value="<?php echo $_SESSION['USUARIO']['id'];?>" id="id_user" name="id_user" />
	<li class="texto_formulario">Número del receptor</li>
	<li class="ancholiformulario"><input type="text" class="form" value="<?php echo $destino;?>" name="destino" id="destino" readonly="readonly" ></li>
	<li class="texto_formulario">Escriba el mensaje</li>
	<li class="ancholiformulario"><textarea cols="30" rows="6"  style="width: 294px; height: 152px;" name="mensaje" id="mensaje" readonly="readonly"><?php echo $mensaje;?></textarea></li>
	<li class="texto_formulario">Contador de carácteres</li>
	<li class="ancholiformulario2"><input type="text" class="form"name="text" id="contador"  maxlength="3" size="3" readonly="readonly" value="<?php echo $contador;?>"></li>
	<li class="texto_formulario_ALT2">&nbsp;/160 caracteres.</li>
	<li class="boton_enviar" onclick="history.back();" ><img src="img/btn_atras.png" /> </li>
	<?php echo $habilita_o_no;?>
	</form>
</ul>
</div>
</div>
</div>
</body>
</html>
