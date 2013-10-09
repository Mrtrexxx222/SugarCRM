<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/Administration/Administration.php");
require_once("include/SugarPHPMailer.php");

$mail=new SugarPHPMailer();
$admin = new Administration();
$admin->retrieveSettings();
$mail->isHTML(true);
$mail->CharSet = "UTF-8";

$resultado="";
$simple = $_POST['simple'];

if($simple == "si")
{
	$nombre_oportunidad = $_POST['nombre_oportunidad'];
	$id_cuenta = $_POST['id_cuenta'];
	$id_usuario = $_POST['id_usuario'];

	$cuenta = new Account();
	$cuenta->retrieve_by_string_fields(array('id'=>$id_cuenta));
	$usuario = new User();
	$usuario->retrieve_by_string_fields(array('id'=>$id_usuario));

	$db =  DBManagerFactory::getInstance(); 
	$query = "select role_id from acl_roles_users";
	$result = $db->query($query, true, 'Error selecting the detail product record');
	while($row=$db->fetchByAssoc($result))
	{
		$db2 =  DBManagerFactory::getInstance();
		$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
		$result2 = $db2->query($query2, true, 'Error selecting the detail product record');
		if($row2=$db2->fetchByAssoc($result2))
		{
			if($row2['name'] == 'Supervisor Operativo')
			{
				$current_user = new User();
				$current_user->retrieve_by_string_fields(array('id'=>$row['user_id']));
				$nombres = $current_user->first_name." ".$current_user->last_name;
				$id_usuario = $current_user->id;

				$user=BeanFactory::getBean('Users',$id_usuario);
				$primary_email=$user->emailAddress->getPrimaryAddress($user);
			}
		}
	}

	$mail->AddAddress($primary_email, $nombres);
	//$mail->AddCC("spachano@plus-projects.com","Sebastian Pachano");
	$mail->From     = $admin->settings['notify_fromaddress']; 
	$mail->FromName = $admin->settings['notify_fromname'];
	$mail->Subject = "Oportunidad al 75%";
	$mail->Body = "<html><body><p>Se ha actualizado una oportunidad al 75% de la etapa de ventas</p></br>
	<p>La oportunidad es es: <b>".$nombre_oportunidad."</b></p></br>
	<p>La cuenta es: <b>".$cuenta->name."</b></p></br> 
	<p>El usuario comercial es: <b>"$usuario->first_name." ".$usuario->last_name."</b></p></br> 
	<p>Por favor revise en el modulo de oportunidades en SugarCRM</p></br></body></html>";
	$mail->prepForOutbound();
	$mail->setMailerForSystem();
	if (!$mail->Send())
	{
		$resultado.="No se pudo enviar el mail ".$mail->ErrorInfo;
	}
	else
	{
		$resultado.="mail enviado";
	}
}
else
{
	$nombre_oportunidad = $_POST['nombre_oportunidad'];
	$probabilidad = $_POST['probabilidad'];
	$id_cuenta = $_POST['id_cuenta'];
	$id_usuario = $_POST['id_usuario'];     //duenio del registro
	$id_usuario2 = $_POST['id_usuario2'];   //Supervisor Operativo

	$cuenta = new Account();
	$cuenta->retrieve_by_string_fields(array('id'=>$id_cuenta));

	/*para el duenio del registro*/
	$current_user = new User();
	$current_user->retrieve_by_string_fields(array('id'=>$id_usuario));
	$nombres = $current_user->first_name." ".$current_user->last_name;

	$user=BeanFactory::getBean('Users',$id_usuario);
	$primary_email=$user->emailAddress->getPrimaryAddress($user); 

	/*Para el supervisor operativo*/
	$current_user2 = new User();
	$current_user2->retrieve_by_string_fields(array('id'=>$id_usuario2));
	$nombres2 = $current_user2->first_name." ".$current_user2->last_name;

	$user2=BeanFactory::getBean('Users',$id_usuario2);
	$primary_email2=$user2->emailAddress->getPrimaryAddress($user2);

	$mail->AddAddress($primary_email, $nombres);
	//$mail->AddCC("spachano@plus-projects.com","Sebastian Pachano");
	$mail->From     = $primary_email2; 
	$mail->FromName = $nombres2;
	$mail->Subject = "Aprobacion/Negacion de cierre de oportunidad";
	if($probabilidad != '100')
	{
		$mail->Body = "<html><body><p>Estimado(a): <b>".$nombres."</b></p></br>
		<p>El Supervisor Operativo ha revisado una oportunidad abierta por usted, pero no la ha cerrado por falta de datos</p></br>
		<p>La Oportunidad es: <b>".$nombre_oportunidad."</b></p></br>
		<p>La cuenta es: <b>".$cuenta->name."</b></p></br>
		<p>El estatus de la Oportunidad es: <b>Revisado</b></p></br>
		<p>La etapa de venta es: <b>75%</b></p></br>
		<p>Por favor revise en el modulo de oportunidades de SugarCRM y complete los datos que falten </p></br></body></html>";
	}
	else
	{
		$mail->Body = "<html><body><p>Estimado(a): <b>".$nombres."</b></p></br>
		<p>El Supervisor Operativo ha revisado una oportunidad abierta por usted y la ha cerrado satisfactoriamente, cumpliendo el 100% de la etapa de ventas</p></br>
		<p>La Oportunidad es: <b>".$nombre_oportunidad."</b></p></br>
		<p>La cuenta es: <b>".$cuenta->name."</b></p></br>
		<p>El estatus de la Oportunidad es: <b>Revisado</b></p></br>
		<p>La etapa de venta es: <b>100%</b></p></br>
		<p>Por favor revise en el modulo de oportunidades de SugarCRM</p></br></body></html>";
	}
	$mail->prepForOutbound();
	$mail->setMailerForSystem();
	if (!$mail->Send())
	{
		$resultado.="No se pudo enviar el mail ".$mail->ErrorInfo;
	}
	else
	{
		$resultado.="mail enviado";
	}
}

echo $resultado;
?>