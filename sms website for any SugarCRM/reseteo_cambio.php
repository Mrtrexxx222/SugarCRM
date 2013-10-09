<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
//require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
session_start();
include_once('conexion.php'); 
include('php_lib/login.class.php'); //incluimos las funciones
//funcion que genera passwords aleatoriamente
function generaPass()
{
	//Se define una cadena de caractares. Te recomiendo que uses esta.
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	//Obtenemos la longitud de la cadena de caracteres
	$longitudCadena=strlen($cadena);

	//Se define la variable que va a contener la contraseña
	$pass = "";
	//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
	$longitudPass=10;
	 
	//Creamos la contraseña
	for($i=1 ; $i<=$longitudPass ; $i++){
	//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
	$pos=rand(0,$longitudCadena-1);
	 
	//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
	$pass .= substr($cadena,$pos,1);
	}
	return $pass;
}

$mensaje = "";
if (isset($_POST['Reseteo_Clave']) == 'Reseteo_Clave')
{
	$nueva_clave = generaPass();
	//$mensaje = "SELECT id_usuario,usuario,empresa,nombre,apellido,correo,estado,fecha_clave_temp,tipo_clave FROM usuario WHERE correo = '".$_POST['correo']."'";
	$result = mysql_query("SELECT id_usuario,usuario,empresa,nombre,apellido,correo,estado,fecha_clave_temp,tipo_clave FROM usuario WHERE correo = '".$_POST['correo']."'");		
	if ($row = mysql_fetch_assoc($result))
	{	
		$pass_cod = md5($nueva_clave);
		$result2 = mysql_query("UPDATE usuario SET contrasenia = '".$pass_cod."', fecha_clave_temp = NOW(), tipo_clave = 0 WHERE id_usuario = '".$row['id_usuario']."'");
		require_once('PHPMailer_5.2.4/class.phpmailer.php');
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // 587 or 465
		$mail->IsHTML(true);
		$mail->Username = "aguerron@plus-projects.com";
		$mail->Password = "123ageAGE";
		$mail->SetFrom("aguerron@plus-projects.com");
		$mail->Subject = "Reinicio Clave de Usuario SMS - Plus Projects";
		$mail->Body = "<br>Estimado ".$row['apellido']." ".$row['nombre'].",<br>"; 
		$mail->Body.= "<br>Ha solicitado reiniciar su clave de acceso al sistema de envio de SMS, por lo que se ha generado una clave temporal.";
		$mail->Body.= "<br><br><strong>Datos de inicio de session:</strong><br>";
		$mail->Body.= "<br>Usuario: <strong>".$row['usuario']."</strong>";
		$mail->Body.= "<br>Clave temporal: <strong>".$nueva_clave."</strong>";
		$mail->Body.= "<br><br> Por favor ingrese al sistema para continuar con el reinicio de su clave o haga click en el siguente link: ";
		$mail->Body.= "<a href=\"http://sms.plus-projects.com\">Plus Projects - SMS</a><br> ";
		$mail->Body.= "<br>Recuerde que esta clave es temporal y tiene una validez de 24 horas. <br> ";
		$mail->Body.= "<br>Pasada las 24 horas la clave quedara desabilitada y debera que repetir el proceso de reinicio de clave.<br> ";
		$mail->AddAddress($row['correo']);
		$mail->Send();
		$titulo = 'Recuperar mi contraseña';
		$mensaje = "Se ha enviado un correo con las instruciones para el reinicio de su clave.<br><br>Por favor verifique su correo y siga las indicaciones detalladas en el mismo.";		
	}
	else
	{
		$titulo = 'Recuperar mi contraseña';
		$mensaje = "El correo ingresado no se encuentra registrado en el sistema.";
	}
}
if (isset($_POST['Cambio_Clave']) == 'Cambio_Clave')
{	
	$titulo = '';
	$result = mysql_query("SELECT (TIME_TO_SEC(TIMEDIFF(NOW(),fecha_clave_temp))/60)/60 Horas 
							FROM usuario
							WHERE id_usuario = ".$_SESSION['USUARIO']['id']."
							AND estado = 1
							AND tipo_clave = 0");
	if(numero_filas($result)>0)
	{
		$row = mysql_fetch_assoc($result);
		if($row['Horas'] <= 24)
		{
			$pass_cod = md5($_POST['confirma_clave']);
			$result2 = mysql_query("UPDATE usuario SET contrasenia = '".$pass_cod."', fecha_clave_temp = NOW(), tipo_clave = 1 WHERE id_usuario = '".$_SESSION['USUARIO']['id']."'");
			//$_SESSION['USUARIO']= array('t_clave'=>1,'pass'=>$pass_cod);
			$titulo = 'Cambio de contraseña';			
			$mensaje = "La su clave ha sido cambiada exitosamente!";
		}
		else
		{
			Login::logout(); //vacia la session del usuario actual		
			$titulo = 'Lo sentimos, su contraseña temporal ha expirado.';
			$mensaje = "Lo sentimos, la su clave que intenta usar ha caducado.<br /><br />Recuerde que el tiempo maximo de duracion de su clave temporal es de 24 horas.";
		}
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
<div class="logo2"><!--<img src="img/geotrust_logo_1.png" width="109px" height="45px" >--><img src="img/geotrust_logo_2.png"  width="143px" height="60px" ></div>
<!--<div class="datos_login"><span class="datos_loginALT">Username:</span>&nbsp;<span><?php echo $_SESSION['USUARIO']['user'];?> </span><br /><span class="datos_loginALT">Balance:</span>&nbsp;<span><?php echo $saldo;?></span></div>-->
<div id='cssmenu'>
<ul>
   <li><a href='index.php'><span>Inicio</span></a></li>
   <li class='active'><a href='mensaje_individual.php'><span>Mensajes</span></a></li>
   <li><a href='reporte_fechas.php'><span>Reportes</span></a></li>
   <li class='last'><a href='logout.php'><span>Salir</span></a></li>
</ul>
</div>
<?php 
if (isset($_POST['Reseteo_Clave']) == 'Reseteo_Clave')
{
?>
<div class="imagen"> </div>
<div class="contenedor_formulario">
<ul>
	<li class="titulo_confirmacion"><?php echo $titulo;?></li>
	<li class="texto_formulario"></li>
	<li class="texto_formulario_ALT3"><?php echo $mensaje;?></li>
	<li class="texto_formulario"></li>
	<li class="ancholiformulario"></li>	
	<li class="boton_enviar" onclick="window.location = 'index.php';" ><img src="img/btn_atras.png" /> </li>	
</ul>
</div>
<?php
} 
if (isset($_POST['Cambio_Clave']) == 'Cambio_Clave')
{
?>
<div class="imagen"> </div>
<div class="contenedor_formulario">
<ul>	
	<li class="titulo_confirmacion"><?php echo $titulo;?></li>
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
