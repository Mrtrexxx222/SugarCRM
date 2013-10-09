<?php
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
require_once('conexion.php'); 
//incluye la clase para envio de SMS
require_once("class_clickatellsms.php");
//datos para autenticarse en Clickatell
$USERNAME 	= 'walcivar';
$PASSWORD	= 'DFQgINHCMPZfAT';
$API_ID		= '3434151';
$SENDER_ID	= '593991335604';
//Instancia la la clase de envio de SMS's
$sms_obj = new ClickATellSMS($USERNAME, $PASSWORD, $API_ID, $SENDER_ID);  
//////////////////////////////////// ID USUARIO CLIENTE  (REEMPLAZAR CON EL ID REAL - PENDIENTE)
$id_cliente_usuario = $_POST['id_user'];

///** ENVIO DE MESAJE INDIVIDUAL **//
if(isset($_POST['sms_op_i_f'])=='individual')
{
	//datos a enviar
	$to 	= $_POST['destino'];
	$text 	= $_POST['mensaje'];
	//Envio SMS y obtengo ID del SMS de clickatell
	$response_send = $sms_obj->sendSMS($to, $text); 
	$response = explode(" ",$response_send);
	if($response[0] == 'ID:')
	{
		$id_sms	  = $response[1];
	}
	else if($response[0] == 'ERR:')
	{
		$id_sms	  = $response_send; 
	}
	//conexion a la base de datos	
	//obtengo el ultimo ID_CARGA_USUARIO de de la tabla de ID's
	$ultimo_id_carga = "";
	$sql_id_carga = mysql_query("SELECT COUNT(*) AS numero FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_carga_usuario'");
	if($row_id_carga = mysql_fetch_array($sql_id_carga))
	{	
		if($row_id_carga['numero']==0)
		{
			$ultimo_id_carga = $row_id_carga['numero']+1;
		}else if($row_id_carga['numero']>0)
		{
			$sql_val_id_carga 	= mysql_query("SELECT MAX(DISTINCT(valor)) AS valor FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_carga_usuario'");
			if($row_val_id_carga = mysql_fetch_array($sql_val_id_carga))
			{			
				$ultimo_id_carga = $row_val_id_carga['valor']+1;
			}
		}
	}
	//obtengo el ultimo ID_MENSAJE de de la tabla de ID's
	$ultimo_id_sms = "";
	$sql_id_sms = mysql_query("SELECT COUNT(*) AS numero FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_mensaje'");
	if($row_id_sms = mysql_fetch_array($sql_id_sms))
	{	
		if($row_id_sms['numero']==0)
		{
			$ultimo_id_sms = $row_id_sms['numero']+1;
		}else if($row_id_sms['numero']>0)
		{
			$sql_id_sms = mysql_query("SELECT MAX(DISTINCT(valor)) AS valor FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_mensaje'");
			if($row_val_id_sms = mysql_fetch_array($sql_id_sms))
			{
				$ultimo_id_sms = $row_val_id_sms['valor']+1;
			}
		}
	}
	//INSERT EN TABLA DE ID's: ID_TABLE 
	try
	{
		$sql_01 = mysql_query("insert into id_tabla(tabla,campos,valor) values('mensajes','id_carga_usuario',".$ultimo_id_carga.")");
	}
	catch(Exception $e)
	{
		$error = $e->getMessage();
		echo '<br />';
		echo $error;
	}
	try
	{
		$sql_02 = mysql_query("insert into id_tabla(tabla,campos,valor) values('mensajes','id_mensaje',".$ultimo_id_sms.")");
	}
	catch(Exception $e)
	{
		$error = $e->getMessage();
		echo '<br />';
		echo $error;
	}
	//INSERT EN TABLA MENSAJES - ENVIO 
	try
	{
		$sql_03 = mysql_query("INSERT INTO mensajes (destinatario,mensaje,fecha_programado,fecha_envio,id_mensaje,id_usuario,id_carga_usuario,id_estado_interno)
							   VALUES ('".$to."','".$text."',now(),now(),".$ultimo_id_sms.",".$id_cliente_usuario.",".$ultimo_id_carga.",1)");
	}
	catch(Exception $e)
	{
		$error = $e->getMessage();
		echo '<br />';
		echo $error;
	}
	//OBTENGO EL STATUS DEL MENSAJE DE CLICKATELL MEDIANTE EL ID DEL MENSAJE y valido si se envio o no, en caso el caso SI se activa la bandera para realizar el descuento de SMS´s
		$estado_interno = "";	
		$debita_o_no 	= 0;
		$status_click 	= $sms_obj->statusSMS($id_sms);
		$statusSMS 		= explode(" ",$status_click);
		if($statusSMS[0] == 'ID:')
		{
			$estado_interno = 2; //enviado
			$statusSMS 		= $statusSMS[3];
			$debita_o_no 	= 1;		
		}else if($statusSMS[0] == 'ERR:')
		{
			$estado_interno = 3;//fallo el envio
			$statusSMS 		= $status_click;
		}

	//INSERT EN TABLA MENSAJES - RETORNO(Clickatell) 
	try
	{
		$sql_05 = mysql_query("insert into mensajes(id_clickatell_sms,destinatario,mensaje,fecha_programado_c,fecha_envio_c,estado_c,id_mensaje,id_usuario,id_carga_usuario,id_estado_interno)
							   values ('".$id_sms."','".$to."','".$text."',now(),now(),'".$statusSMS."',".$ultimo_id_sms.",".$id_cliente_usuario.",".$ultimo_id_carga.",".$estado_interno.")");
	}
	catch(Exception $e)
	{
		$error = $e->getMessage();
		echo '<br />';
		echo $error;
	}
	//REGISTRO - PARTE FINANCIERA DEBITOS Y BALANCE
	if($debita_o_no == 1)
	{	
		//REGISTRO DE TRANSACCION EN TABLA DEBITO
		try
		{
			$sql_06 = mysql_query("insert into debito(id_usuario,fecha_debito,valor_debito,id_carga_usuario) values (".$id_cliente_usuario.",NOW(),1,".$ultimo_id_carga.")");				
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			echo '<br />';
			echo $error;
		}
		//REGISTRO DE TRANSACCION EN TABLA BALANCE
		$sql_cred = mysql_query("SELECT id_credito,fecha_credito,num_factura,valor_credito FROM credito WHERE id_usuario = ".$id_cliente_usuario." ORDER BY fecha_credito DESC LIMIT 1");		
		$row_cred = mysql_fetch_array($sql_cred);	
		$sql_deb = mysql_query("SELECT id_debito, id_usuario, fecha_debito, valor_debito, id_carga_usuario FROM debito
							   WHERE id_usuario = ".$id_cliente_usuario." AND id_carga_usuario = ".$ultimo_id_carga."");	
		if($row_deb = mysql_fetch_array($sql_deb))
		{
			try
			{
				$sql_09 = mysql_query("INSERT INTO balance(id_usuario,id_credito,id_debito,valor_credito,valor_debito)
							VALUES (".$id_cliente_usuario.",".$row_cred['id_credito'].",".$row_deb['id_debito'].",".$row_cred['valor_credito'].",".$row_deb['valor_debito'].")");
			}
			catch(Exception $e)
			{
				$error = $e->getMessage();
				echo '<br />';
				echo $error;
			}
		}
	}
	echo "<script language='javascript'>window.location='https://www.plus-projects.com/sms/respuesta.php?&t=1&id=".$ultimo_id_carga."'</script>;";
}
if(isset($_POST['sms_op_g_f'])=='grupal')
{	
	if(isset($_POST['numeros']) && isset($_POST['textos']))
	{	
		//incluye la clase para envio de SMS
		require_once("class_clickatellsms.php");
		//datos para autenticarse en Clickatell
		$USERNAME 	= 'walcivar';
		$PASSWORD	= 'DFQgINHCMPZfAT';
		$API_ID		= '3434151';
		$SENDER_ID	= '593991335604';
		//Instancia la la clase de envio de SMS's
		$sms_obj = new ClickATellSMS($USERNAME, $PASSWORD, $API_ID, $SENDER_ID);  
		//datos a enviar		
		$to 	= $_POST['numeros'];
		$text 	= $_POST['textos'];
		//Envio de SMS y respuesta de clickatell
		$response = $sms_obj -> sendSMS_Grupal($to, $text,$id_cliente_usuario);
		$partes = explode("/",$response);
				
		$id_credito="";
		$id_debito="";
		$valor_credito="";
		$valor_debito="";
		mysql_query("insert into debito(id_usuario,fecha_debito,valor_debito,id_carga_usuario) values(".$id_cliente_usuario.",NOW(),".$partes[0].",".$partes[1].")");
		$result = mysql_query('SELECT id_credito,valor_credito FROM credito WHERE id_usuario = '.$id_cliente_usuario.' ORDER BY id_credito DESC LIMIT 1');
		if ($row = mysql_fetch_assoc($result))
		{
			$id_credito= $row['id_credito']; 
			$valor_credito=$row['valor_credito']; 
		}
		$result = mysql_query('select id_debito,valor_debito from debito WHERE id_usuario = '.$id_cliente_usuario.' order by id_debito desc LIMIT 1');
		if ($row = mysql_fetch_assoc($result))
		{
			$id_debito= $row['id_debito']; 
			$valor_debito=$row['valor_debito']; 
		}
		$saldo = $valor_credito - $valor_debito;
		mysql_query("insert into balance(id_usuario,id_credito,id_debito,valor_credito,valor_debito) 
					values(".$id_cliente_usuario.",".$id_credito.",".$id_debito.",".$valor_credito.",".$valor_debito.")");
		echo "<script language='javascript'>window.location='https://www.plus-projects.com/sms/respuesta.php?&t=2&id=".$partes[1]."'</script>;";		
	}	
}
if(isset($_REQUEST['tipo_reporte']) && $_GET['tipo_reporte'] == 'rango_fechas')
{
	$resultado = '';
	$intercambia=0;	
	$estado_interno="";
	$fecha_inicio = $_REQUEST['fecha_inicio'];
	$fecha_fin = $_REQUEST['fecha_fin'];	
	$result = mysql_query("SELECT m2.fecha_envio, m.destinatario, m.id_clickatell_sms, e.nombre Estado, m.mensaje ,m.id_estado_interno
							FROM mensajes m 
							INNER JOIN mensajes m2 ON m.id_mensaje = m2.id_mensaje
							INNER JOIN estado_interno e ON m.id_estado_interno = e.id_estado_interno
							WHERE m.id_usuario = ".$_REQUEST['cont']." 
							AND m.id_estado_interno = 2
							AND m2.fecha_envio BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'
							ORDER BY m2.fecha_envio DESC");
	$resultado.="<div id='ver_reporte' class='contenedor_tabla'>";
	$numero_filas = numero_filas($result);
	if ($numero_filas > 0)
	{
		$resultado.="<table width='100%' border='0' cellpadding='0' cellspacing='2' bordercolor='#fff'>
					  <tr class='cabecera'>
						<td class='titulo1'>Fecha de envio</td>
						<td class='titulo2'>Destinatario</td>
						<td class='titulo3'>Estado</td>
						<td class='titulo4'>Id de Mensaje</td>
						<td  class='titulo5'>Mensaje</td>
					  </tr>";
		while($row = mysql_fetch_assoc($result))
		{
			$mensaje = '';			
			if(strlen($row['mensaje']) > 15)
			{
				$mensaje = substr($row['mensaje'],0, 15);
				$mensaje = $mensaje."...";
			}
			else
			{
				$mensaje = $row['mensaje'];
			}			
			if($intercambia==0)
			{
				$resultado.="<tr class='fila2'>
								<td class='celda1'>".$row['fecha_envio']."</td>
								<td class='celda1'>".$row['destinatario']."</td>
								<td class='celda1'>".$row['Estado']."</td>
								<td class='celda1'>".$row['id_clickatell_sms']."</td>
								<td class='celda1' title='".$row['mensaje']."'>".$mensaje."</td>
							 </tr>";
				$intercambia=1;
			}
			else
			{
				$resultado.="<tr class='fila3'>
								<td class='celda1'>".$row['fecha_envio']."</td>
								<td class='celda1'>".$row['destinatario']."</td>
								<td class='celda1'>".$row['Estado']."</td>
								<td class='celda1'>".$row['id_clickatell_sms']."</td>
								<td class='celda1' title='".$row['mensaje']."'>".$mensaje."</td>
							</tr>";
				$intercambia=0;
			}
		}
		$resultado.="</table>";	
		$resultado.="</div>";	
		$resultado.="<br /><div class=\"boton_descargar2\" onclick=\"window.location = 'export_excel.php?f_i=".$fecha_inicio."&f_f=".$fecha_fin."&var=".$_REQUEST['cont']."'\"></div>";
	}
	else
	{
		$resultado .='<p><div align="center" style="color:#999;font:14px \'Capriola-Regular\';">No existe informaci&oacute;n que coincida con los parametros ingresados.</div></p>';	
		$resultado.="</div>";	
	}
	echo $resultado;
}
if(isset($_REQUEST['tipo_reporte']) && $_GET['tipo_reporte'] == 'por_mes')
{	
	$resultado = '';
	$fecha_inicio = $_REQUEST['fecha_inicio'];
	$fecha = $_REQUEST['fecha'];		
	$partes = explode("-",$fecha);
	$dia_fin = getUltimoDiaMes($partes[0],$partes[1]);
	$fecha_fin = $fecha.'-'.$dia_fin.' 23:59:59';
	$result = mysql_query("SELECT DISTINCT(COUNT(DAY(m2.fecha_envio))) Total, DAY(m2.fecha_envio) dia
							FROM mensajes m 
							INNER JOIN mensajes m2 ON m.id_mensaje = m2.id_mensaje
							INNER JOIN estado_interno e ON m.id_estado_interno = e.id_estado_interno
							WHERE m.id_usuario = ".$_REQUEST['cont']." 
							AND m.id_estado_interno = 2
							AND m2.fecha_envio IS NOT NULL
							AND m2.fecha_envio BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'
							GROUP BY DAY(m2.fecha_envio)
							ORDER BY m2.fecha_envio asc");		
	$numero_filas = numero_filas($result);
	$total_sms = 0;
	if ($numero_filas > 0) 
	{
		while($row = mysql_fetch_assoc($result))
		{
			$total_sms = $total_sms+$row['Total'];	
			$resultado .=$row['dia'].'_'.$row['Total'].',';	
		}				
	}
	else
	{
		$resultado .='x,';	
	}
	echo $dia_fin.':'.$resultado.':'.$total_sms;
}


function saldo($user)
{	
	$result = mysql_query("SELECT (valor_credito - SUM(valor_debito)) saldo FROM balance WHERE id_usuario = ".$user." GROUP BY id_credito ORDER BY id_balance DESC LIMIT 1");
	if ($row = mysql_fetch_assoc($result))
	{
		return $row['saldo'];
	}
	else
	{
		return 0;
	}
}
?>