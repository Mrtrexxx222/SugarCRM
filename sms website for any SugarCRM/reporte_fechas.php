<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
require_once("procesar_datos.php");
session_start();
$id_usuario = $_SESSION['USUARIO']['id'];
$saldo = saldo($id_usuario);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Plus-Projects</title>
<script src="js/jquery/js/jquery-1.9.1.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.position.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.tooltip.js"></script>
<script src="js/js_sms.js"></script>
<link rel="stylesheet" href="js/jquery/development-bundle/themes/base/jquery.ui.all.css">
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
   <li ><a href='mensaje_individual.php'><span>Mensajes</span></a></li>
   <li class='active'><a href='reporte_fechas.php'><span>Reportes</span></a></li>
   <li class='last'><a href='logout.php'><span>Salir</span></a></li>
</ul>
</div>
<div class="contenedor_reporte">
	<form action="procesar_datos.php" method="post" >
	<input type="hidden" value="<?php echo $_SESSION['USUARIO']['id'];?>" id="id_user" name="id_user" />
		<div class="texto_formulario2">Tipo de reporte</div>
		<div class="ancholiformulariotabla">
			<select name='tipo_reporte' id='tipo_reporte'>
				<option value='Rango_de_fechas'>Rango de fechas</option>				
				<option value='por_mes'>Mensajes por mes</option>			
			</select>
		</div> 
		<br />
		<br />
		<div class="contenedor_fechas">
			<table >
				<tr>
					<td class="texto_fechas">Desde</td>
					<td class="ancholifechas2" style="max-height:30px;min-height:30px;"><input type='text' name='fecha_inicio' id='fecha_inicio' readOnly='true' value="<?php echo @$_GET['cf'];?>"></td>
					<td class="texto_fechas">Hasta</td>
					<td class="ancholifechas2" style="max-height:30px;min-height:30px;"><input type='text' name='fecha_fin' id='fecha_fin' readOnly='true' value="<?php echo @$_GET['cf'];?>"></td>
					<td class="boton_reporte" ><img src="img/btn_reporte.png" id="ejcutar" onClick="ReturnText(document.getElementById('fecha_inicio').value,document.getElementById('fecha_fin').value);"/></td>
				</tr>
			</table>
		</div>
	</form>
<br />
<div id='ver_reporte'></div>
<br />
</div>
</div>
</div>
</body>
</html>


<script>
	$(function() {			
		$( "#fecha_inicio,#fecha_fin" ).datepicker({
			showOn: "button", 			
			buttonImage: "js/jquery/development-bundle/demos/images/calendar.gif", 
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$( "#fecha_inicio,#fecha_fin" ).datepicker( "option", "dateFormat", "yy-mm-dd");		
		$("#fecha_inicio,#fecha_fin").datepicker( "setDate" , "<?php echo @$_GET['cf'];?>" );
	});
</script>

<script>
$(document).ready(function() 
{
	$(document).tooltip({
			track: true
		});
});
</script>