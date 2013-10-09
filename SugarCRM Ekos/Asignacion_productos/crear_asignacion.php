<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$resultado="";
$id_cuenta = $_POST['id_cuenta'];
$id_usuario = $_POST['id_usuario'];
$db =  DBManagerFactory::getInstance();
$cuenta_record = new Account();
$cuenta_record->retrieve_by_string_fields(array('id'=>$id_cuenta));
$cuenta=$cuenta_record->name;

$usuario = new User();
$usuario->retrieve_by_string_fields(array('id'=>$id_usuario));
$nombres = $usuario->first_name." ".$usuario->last_name;

$asig_prod = new Asignacion_productos();
$asig_prod->retrieve_by_string_fields(array('assigned_user_id'=>$id_usuario,'account_id_c'=>$id_cuenta));
if($asig_prod->id)
{
	$resultado = "Ya existe una asignacion de la cuenta ".$cuenta." para el relacionador ".$nombres."";
}
else
{
	$id_asignacion = md5(create_guid3());
	$query = "INSERT INTO asignacion_productos
		(id, NAME, date_entered, date_modified, modified_user_id, created_by, deleted, team_id, team_set_id, assigned_user_id)
		VALUES('".$id_asignacion."', 
		'".$cuenta."', 
		NOW(), 
		NOW(), 
		'".$id_usuario."', 
		'".$id_usuario."',  
		'0', 
		'1', 
		'1', 
		'".$id_usuario."')";
	$result = $db->query($query, true, 'Error selecting the user record'); 
	$query1 = "INSERT INTO asignacion_productos_cstm 
				(id_c, account_id_c)
				VALUES('".$id_asignacion."',  '".$id_cuenta."')";
	$result1 = $db->query($query1, true, 'Error selecting the user record'); 
	/*
	$focus = new Asignacion_productos();
	$focus->name = $cuenta;
	$focus->date_entered = date("Y-m-d H:i:s");
	$focus->date_modified = date("Y-m-d H:i:s");
	$focus->modified_user_id = $id_usuario;
	$focus->created_by = $id_usuario;
	$focus->team_id = '1';
	$focus->team_set_id = '1';
	$focus->assigned_user_id = $id_usuario;
	$focus->account_id_c = $id_cuenta;
	$focus->save();
	*/
	$resultado = "La asignacion ha sido creada exitosamente";	
}

echo $resultado;

//FUNCIONES PARA GENERAR IDS	
function create_guid3()
{
	$microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = dechex($a_dec* 1000000);
	$sec_hex = dechex($a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section3(3);
	$guid .= '-';
	$guid .= create_guid_section3(4);
	$guid .= '-';
	$guid .= create_guid_section3(4);
	$guid .= '-';
	$guid .= create_guid_section3(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section3(6);

	return $guid;
}

function create_guid_section3($characters)
{
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= dechex(mt_rand(0,15));
	}
	return $return;
}

function ensure_length3(&$string, $length)
{
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
}	

?>