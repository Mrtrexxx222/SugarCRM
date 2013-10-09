<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
require_once("procesar_datos.php");
include_once('conexion.php'); 
session_start();
$id_usuario = $_SESSION['USUARIO']['id'];
$archivo = $_FILES['archivo']['tmp_name'];
//EJECUTA FUNCION QUE LEERA EL CSV Y ME RETORNARA UN STRING
$resp = readCSV($archivo);
$partes = explode("/",$resp);
$buenos = $partes[0];
$textos = $partes[1];
$malos  = $partes[2];
//VALIDA QUE EXISTA ALGUN VALOR TANTO EN BUENOS COMO EN MALOS
$tot_buenos = 0;
$tot_malos 	= 0;
if($buenos != '')
{
	$tot_buenos = count(explode(",",$buenos));
}
if($malos != '')
{	
	$tot_malos = count(explode(",",$malos));
}
$habilita_o_no 	= '';
$sin_saldo	= '';
$saldo = saldo($id_usuario);
if($saldo < $tot_buenos)
{
	$sin_saldo 	= 'No dispone de saldo suficiente para realizar el envio.';
	$habilita_o_no 	= '<li class="boton_borrar" onclick="alert(\''.$sin_saldo.'\');"><img src="img/btn_enviar_dis.png" /> </li>';
}
else
{
	$habilita_o_no 	= '<li class="boton_borrar" onclick="document.forms[\'conf_gr\'].submit();"><img src="img/btn_enviar.png" /> </li>';
}
//FUNCION QUE LEE EL ARCHIVO CSV 
function readCSV($csvFile)
{
	$row = 1;
	$buenos = "";
	$malos = "";
	$textos = "";
	if (($handle = fopen($csvFile, "r")) !== FALSE)
	{
		while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE)
		{
			$num = count($data);			
			if($row == 1)
			{
				if($num != 2)
				{
					echo "<script>window.history.back();
					alert('El archivo CSV no tiene el delimitador correcto');
					</script>";	
					die;
				}
			}
			for ($c=0; $c < 1; $c++)
			{
				$numero = trim($data[0]);
				if(strlen($numero) != 12)
				{
					$malos .= $data[0].",";
				}
				else
				{
					$last_part = substr($numero, 3); 
					$first_char = substr($last_part,0,1);
					if($first_char == 0)
					{
						$malos .= $data[0].",";
					}
					else
					{
						$buenos .= $data[0].",";
						$textos .= substr($data[1], 0, 160).",";
					}
				}
			}
			$row++;
		}
		fclose($handle);
	}
	$buenos = substr_replace($buenos ,"",-1);
	$textos = substr_replace($textos ,"",-1);
	$malos = substr_replace($malos ,"",-1);
	return $buenos."/".$textos."/".$malos;
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
<form name="conf_gr" action="procesar_datos.php" method="post">
<input type="hidden" id="sms_op_g_f" name="sms_op_g_f" value="<?php echo $_POST['sms_op_g'];?>" />
<input type="hidden" id="id_user" name="id_user" value="<?php echo $_SESSION['USUARIO']['id'];?>" />
   <ul>
		<input id= 'numeros' name = 'numeros' type = 'hidden' value="<?php echo $buenos;?>">
		<input id= 'textos' name = 'textos' type = 'hidden' value="<?php echo $textos;?>">
		<li class="titulo_confirmacion">Confirmación del mensaje a enviar</li>
        <li class="texto_formularioALT">N&uacute;mero total de mensajes encontrados:</li>
		<li class="ancholiformulario3"><input type="text" class="form" value="<?php echo ($tot_buenos + $tot_malos);?>" readonly="readonly"></li>
		<li class="texto_formularioALT">N&uacute;mero de mensajes correctos:</li>
		<li class="ancholiformulario3"><input type="text" class="form" value="<?php echo $tot_buenos;?>" readonly="readonly"></li>
		<li class="texto_formularioALT">N&uacute;mero de mensajes incorrectos:</li>
		<li class="ancholiformulario3"><input type="text" class="form" value="<?php echo $tot_malos;?>" readonly="readonly"></li>
		<li class="boton_enviarALT" onclick="history.back();"><img src="img/btn_atras.png" /> </li>
		<?php echo $habilita_o_no;?>
	</ul>
</form>
</div>
</div>
</div>
</body>
</html>
