<?php
if((empty($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on' ))
{
	header("Location: https://www.plus-projects.com".$_SERVER['REQUEST_URI']);
}

/*
 * Valida un usuario y contraseña o presenta el formulario para hacer login
 */

if ($_SERVER['REQUEST_METHOD']=='POST') { // ¿Nos mandan datos por el formulario?
    include('php_lib/config.ini.php'); //incluimos configuración
    include('php_lib/login.class.php'); //incluimos las funciones
	$cambio_clave = 0;
    $Login=new Login();
    //si hace falta cambiamos las propiedades tabla, campo_usuario, campo_contraseña, metodo_encriptacion

    //verificamos el usuario y contraseña mandados
    if ($Login->login($_POST['usuario'],$_POST['password'])) {		
        if($_SESSION['USUARIO']['t_clave'] == '0')
		{
			$cambio_clave = 1;			
		}
		else
		{
			header('Location: mensaje_individual.php');
			die();
		}			
        //saltamos al inicio del área restringida       
    } else {
        //acciones a realizar en un intento fallido
        //Ej: mostrar captcha para evitar ataques fuerza bruta, bloquear durante un rato esta ip, ....
        //Estas acciones se veran en los siguientes tutorianes en http://www.emiliort.com

        //preparamos un mensaje de error y continuamos para mostrar el formulario
        $mensaje='Usuario o contraseña incorrecto.';
		
    }
} //fin if post
//echo md5('clave');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Plus-Projects</title>
<script src="js/jquery/js/jquery-1.9.1.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.position.js"></script>
<script src="js/jquery/development-bundle/ui/jquery.ui.tooltip.js"></script>
<script language="javascript" src="js/js_sms.js"></script>

<link rel="stylesheet" href="js/jquery/development-bundle/themes/base/jquery.ui.all.css">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
<div class="container">
<div class="logo"></div>
<div class="logo2"><!--<img src="img/geotrust_logo_1.png" width="109px" height="45px" >--><img src="img/geotrust_logo_2.png"  width="143px" height="60px" ></div>

<div id='cssmenu'>
<ul>
   <li class='active'><a href='index.php'><span>Inicio</span></a></li>
   <li><a href='mensaje_individual.php'><span>Mensajes</span></a></li>
   <li><a href='reporte_fechas.php'><span>Reportes</span></a></li>
   <li class='last'><a href='logout.php'><span>Salir</span></a></li>
</ul>
</div>
<p><div id="alertas" align="center" style="color:red;font:14px 'Capriola-Regular';"><?php echo $mensaje;?>&nbsp;</div></p>
<div class="imagen"> </div>
<div class="contenedor_login">
<?php 
if($cambio_clave == 0)
{
?>
<form name="login" action="index.php" method="post">
 <ul>
	<li class="ancholi">Usuario<br><input type="text" value="" class="form" name="usuario" autocomplete="off" onkeydown="if(event.keyCode==13)$('#Ingresar').trigger('click');"></li>
	<li class="ancholi">Clave<br><input type="password" value="" class="form" name="password" onkeydown="if(event.keyCode==13)$('#Ingresar').trigger('click');"></li>
	<li class="boton_ingresar"><span class="olvido_password" onclick="reseteo_clave();" >Olvido su contraseña?</span><span class="boton_ingresarimagen" id="Ingresar" onclick="document.forms['login'].submit();"><img src="img/btn_ingresar.png" style="cursor:pointer;" /></span></li>
</ul>
</form>
<form name="reseteo" action="reseteo_cambio.php" method="post" style="display:none;">	
	<li class="titulo_contenedor">Reseteo de Clave:</li>	
	<input type="hidden" name="Reseteo_Clave" value="Reseteo_Clave">
 <ul>
	<li class="ancholi">Correo Electronico<br><input type="text" value="" class="form" name="correo" id="correo" autocomplete="off" onkeydown="if(event.keyCode==13)$('#Ingresar').trigger('click');"></li>	
	<li class="info_msg">Por favor ingrese el correo con el que esta registrado en el sistema.<br><br>Se enviara una clave temporal generada por el sistema para que pueda acceder.</li>	
	<li class="boton_ingresar">
	<span class="boton_ingresarimagen" id="cancela_reset" onclick="cancel_reset();"><img src="img/btn_atras.png" style="cursor:pointer;"/></span>
	<span class="boton_ingresarimagen" id="Ingresar" onclick="validar_correo();"><img src="img/btn_enviar.png" style="cursor:pointer;"/></span></li>
</ul>
</form>
<?php 
} 
else if($cambio_clave == 1)
{
?>
<form name="cambio" action="reseteo_cambio.php" method="post">
	<li class="titulo_contenedor">Cambio de Clave:</li>
	<input type="hidden" name="Cambio_Clave" value="Cambio_Clave">
 <ul>
	<li class="ancholi">Nueva Clave:<br><input type="password" value="" class="form" name="nueva_clave" id="nueva_clave" onkeydown="if(event.keyCode==13)$('#Ingresar').trigger('click');"></li>
	<li class="ancholi">Confirmar Clave:<br><input type="password" value="" class="form" name="confirma_clave" id="confirma_clave" onkeydown="if(event.keyCode==13)$('#Ingresar').trigger('click');"></li>
	<li class="boton_ingresar"><span class="boton_ingresarimagen" id="Ingresar" onclick="valida_pass();"><img src="img/btn_ingresar.png" style="cursor:pointer;"/></span></li>
</ul>
</form>
<?php 
}
?>
</div>
</div>

</body>
</html>
