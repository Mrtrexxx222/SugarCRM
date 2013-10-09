<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$resultado="";
$cuenta = $_POST['cuenta'];
$id_cuenta = $_POST['id_cuenta'];
$id_usuario = $_POST['id_usuario'];

if(strpos($cuenta,"/") !== false)
{
	$cuenta = str_replace("/", "&", $cuenta);
}

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
	$resultado = "La asignacion ha sido creada exitosamente";
}

echo $resultado;
?>