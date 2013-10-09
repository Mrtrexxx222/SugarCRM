<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
require_once("procesar_datos.php");
require_once('conexion.php'); 
session_start();
$id_usuario = $_SESSION['USUARIO']['id'];
$saldo = saldo($id_usuario);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Plus-Projects</title>
<script type='text/javascript' src="phpChart_Basic/js/jquery.js" ></script>
<script type='text/javascript' src='phpChart_Basic/js/jquery.jqplot.min.js' ></script>
<script type='text/javascript' src='phpChart_Basic/js/plugins/jqplot.barrenderer.js' ></script>
<script type='text/javascript' src='phpChart_Basic/js/plugins/jqplot.categoryaxisrenderer.min.js' ></script>
<script type='text/javascript' src='phpChart_Basic/js/plugins/jqplot.pointlabels.min.js' ></script>
<script type="text/javascript" src="js/js_sms.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel='stylesheet' type='text/css' href='phpChart_Basic/js/jquery.jqplot.min.css'>		

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
   <li class='active'><a href='#'><span>Reportes</span></a></li>
   <li class='last'><a href='logout.php'><span>Salir</span></a></li>
</ul>
</div>
<div class="contenedor_reporte">
	<div class="texto_formulario2">Tipo de reporte</div>
	<div class="ancholiformulariotabla">
		<select name='tipo_reporte' id='tipo_reporte'>
			<option value='Rango_de_fechas'>Rango de fechas</option>				
			<option value='por_mes' selected>Mensajes por mes</option>
		</select>
	</div> 
	<br />	
	<br />	
<form name="reporte_x_mes" action="procesar_datos.php" method="post">  
	<input type="hidden" value="por_mes" name="tipo_reporte">
	<input type="hidden" value="<?php echo $_SESSION['USUARIO']['id'];?>" id="id_user" name="id_user" />
    <div class="contenedor_fechas">
    <ul>
    <li class="texto_fechas">Año</li>
    <li class="ancholifechas2">
	<select id="anio" name="anio">
	<?php
	$result_a = periodo($id_usuario, 2);
	while($row_a = mysql_fetch_assoc($result_a))
	{
		echo "<option value='".$row_a['anio']."'>".$row_a['anio']."</option>";
	}	
	?>
	</select>
	</li>
    <li class="texto_fechas">Mes</li>
    <li class="ancholifechas2">
	<select id="mes" name="mes">
	<?php
	for($i=1;$i<=12;$i++)
	{
		echo "<option value='".$i."'>".getMes($i)."</option>";
	}	
	?>
	</select>	
	</li>
	<li class="boton_reporte" onclick="ReturnText_r2($('#mes option:selected').val(),$('#anio option:selected').val());"><img src="img/btn_reporte.png" /></li>
    </ul>	
	</div>	
	<div id='error_msj'></div>	
	<div id='info_pipe' style='z-index:1000;' ><span id='texto'>Clic para ver detalle.</span></div>
	<div class="contenedor_tabla" align="center" style="display:none;">
	<div id='total'></div><br />
	<div id='basic_chart'></div>
	</div>	
	<br />		
</form>
</div>
</div>
</div>

</body>
</html>
