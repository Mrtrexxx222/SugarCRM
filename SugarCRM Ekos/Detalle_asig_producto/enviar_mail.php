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
	$nombre_cuenta = $_POST['nombre_cuenta'];
	$nombres_usuario = $_POST['nombres_usuario'];

	$db =  DBManagerFactory::getInstance(); 
	$query = "select user_id, role_id from acl_roles_users";
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
	$mail->Subject = "Asignacion de producto";
	$mail->Body = "<html><body><p>Se ha solicitado asignaciones de productos</p></br>
	<p>El usuario comercial es: <b>".$nombres_usuario."</b></p></br>
	<p>La cuenta es: <b>".$nombre_cuenta."</b></p></br> 
	<p>Por favor revise en el modulo de asignaciones de productos en SugarCRM</p></br></body></html>";
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
	$cuenta = $_POST['cuenta'];
	$id_usuario = $_POST['id_usuario'];
	$producto = $_POST['producto'];
	$estatus = $_POST['estatus'];

	$current_user = new User();
	$current_user->retrieve_by_string_fields(array('id'=>$id_usuario));
	$nombres = $current_user->first_name." ".$current_user->last_name;

	$user=BeanFactory::getBean('Users',$id_usuario);
	$primary_email=$user->emailAddress->getPrimaryAddress($user); 

	$mail->AddAddress($primary_email, $nombres);
	//$mail->AddCC("spachano@plus-projects.com","Sebastian Pachano");
	$mail->From     = $admin->settings['notify_fromaddress']; 
	$mail->FromName = $admin->settings['notify_fromname'];
	$mail->Subject = "Aprobacion/Negacion de solicitud para asignacion de producto";
	$mail->Body = "<html><body><p>Estimado(a): <b>".$nombres."</b></p></br>
	<p>El producto: <b>".$producto."</b> le ha sido <b>".$estatus."</b></p></br>
	<p>La cuenta es: <b>".$cuenta."</b></p></br>
	<p>Por favor revise en el modulo de asignaciones de productos en SugarCRM</p></br></body></html>";
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

	$resultado.=$cuenta." ".$producto." ".$nombres." ".$estatus;
}

echo $resultado;
?>