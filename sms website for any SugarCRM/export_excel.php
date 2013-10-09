<?php

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte_SMS.xls");

/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
require_once("conexion.php");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Plus-Projects</title>
</head>
<body>
<?php
$intercambia=0;
$user = $_GET['var'];
$fecha_inicio = $_GET['f_i'];
$fecha_fin = $_GET['f_f'];
	$query = "SELECT m2.fecha_envio, m.destinatario, m.id_clickatell_sms, e.nombre Estado, m.mensaje ,m.id_estado_interno
							FROM mensajes m 
							INNER JOIN mensajes m2 ON m.id_mensaje = m2.id_mensaje
							INNER JOIN estado_interno e ON m.id_estado_interno = e.id_estado_interno
							WHERE m.id_usuario = ".$user." 
							AND m.id_estado_interno = 2
							AND m2.fecha_envio BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'
							ORDER BY m2.fecha_envio DESC";	
	$result = mysql_query($query);
	$numero_filas = numero_filas($result);
	if ($numero_filas > 0)
	{
		$resultado.="<div id='ver_reporte' >
					<table >
					  <tr >
						<th align='center' colspan='5'><br /></th>						
					  </tr>
					  <tr >
						<th align='center' colspan='5'>REPORTE POR RANGO DE FECHAS</th>						
					  </tr>
					  <tr >
						<th align='center' colspan='5'><br /></th>						
					  </tr>
					  <tr >
						<th align='center' colspan='5'><br /></th>						
					  </tr>
					  <tr >
						<th style=\"border-right:1px solid #929292;border-bottom:1px solid #929292;background-color:#999999;\">Fecha de envio</th>
						<th style=\"border-right:1px solid #929292;border-bottom:1px solid #929292;background-color:#999999;\">Destinatario</th>
						<th style=\"border-right:1px solid #929292;border-bottom:1px solid #929292;background-color:#999999;\">Estado</td>
						<th style=\"border-right:1px solid #929292;border-bottom:1px solid #929292;background-color:#999999;\">Id de Mensaje</th>
						<th style=\"border-bottom:1px solid #929292;background-color:#999999;\">Mensaje</th>
					  </tr>";
		while($row = mysql_fetch_assoc($result))
		{
			if($intercambia==0)
			{
				$resultado.="<tr class='fila2'>
								<td style=\"border-right:1px solid #929292;background-color:#EAEDF2;\">".$row['fecha_envio']."</td>
								<td style=\"border-right:1px solid #929292;background-color:#EAEDF2;mso-number-format:'0';\">".$row['destinatario']."</td>
								<td style=\"border-right:1px solid #929292;background-color:#EAEDF2;\">".$row['Estado']."</td>
								<td style=\"border-right:1px solid #929292;background-color:#EAEDF2;\">".$row['id_clickatell_sms']."</td>
								<td style=\"background-color:#EAEDF2;\">".$row['mensaje']."</td>
							 </tr>";			
				$intercambia=1;
			}
			else
			{
				$resultado.="<tr class='fila2'>
								<td style=\"border-right:1px solid #929292;background-color:#CCCCCC;\">".$row['fecha_envio']."</td>
								<td style=\"border-right:1px solid #929292;background-color:#CCCCCC;mso-number-format:'0'; \">".$row['destinatario']."</td>
								<td style=\"border-right:1px solid #929292;background-color:#CCCCCC;\">".$row['Estado']."</td>
								<td style=\"border-right:1px solid #929292;background-color:#CCCCCC;\">".$row['id_clickatell_sms']."</td>
								<td style=\"background-color:#CCCCCC;\">".$row['mensaje']."</td>
							 </tr>";			
				$intercambia=0;
			}
		}
		$resultado.="</table>";
	}
	else
	{
		$resultado .='<p><div align="center" style="color:#999;font:14px \'Capriola-Regular\';">No existe informaci&oacute;n que coincida con los parametros ingresados.</div></p>';	
	}	
	echo $resultado;
?>
</body>
</html>


