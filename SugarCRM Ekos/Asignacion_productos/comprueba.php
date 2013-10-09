<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$resultado="";
$id_cuenta = $_POST['id_cuenta'];
$id_producto = $_POST['id_producto'];

$det_asig_prod = new Detalle_asig_producto();
$det_asig_prod->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta));
if($det_asig_prod->id)
{
	if($det_asig_prod->estatus_c == 'Aprobado')
	{
		$resultado.="1/El producto ya se le aprobo a otro usuario";
	}
	else
	{
		$resultado.="/1";
	}
}

echo $resultado;
?>