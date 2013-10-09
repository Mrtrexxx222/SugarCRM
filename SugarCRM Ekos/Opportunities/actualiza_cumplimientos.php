<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$resultado="";
$id_oportunidad = $_POST['id_record'];
$id_cuenta = $_POST['account_id'];

$db =  DBManagerFactory::getInstance(); 
$query = "SELECT * FROM cumplimientos_cstm WHERE account_id_c ='".$id_cuenta."' AND opportunity_id_c = '".$id_oportunidad."'";
$result = $db->query($query, true, 'Error selecting the cumplimientos record');
while($row=$db->fetchByAssoc($result))
{
	$id_mes = date("m");
	$anio = date("Y");
	if($id_mes=='01')
	{
		$id_mes= '1';
		$mes = 'Enero';
	}
	else if($id_mes=='02')
	{
		$id_mes= '2';
		$mes = 'Febrero';
	}
	else if($id_mes=='03')
	{
		$id_mes= '3';
		$mes = 'Marzo';
	}
	else if($id_mes=='04')
	{
		$id_mes= '4';
		$mes = 'Abril';
	}
	else if($id_mes=='05')
	{
		$id_mes= '5';
		$mes = 'Mayo';
	}
	else if($id_mes=='06')
	{
		$id_mes= '6';
		$mes = 'Junio';
	}
	else if($id_mes=='07')
	{
		$id_mes= '7';
		$mes = 'Julio';
	}
	else if($id_mes=='08')
	{
		$id_mes= '8';
		$mes = 'Agosto';
	}
	else if($id_mes=='09')
	{
		$id_mes= '9';
		$mes = 'Septiembre';
	}
	else if($id_mes=='10')
	{
		$mes = 'Octubre';
	}
	else if($id_mes=='11')
	{
		$mes = 'Noviembre';
	}
	else
	{
		$mes = 'Diciembre';
	}

	$focus = BeanFactory::getBean('Cumplimientos');
	$cumplimiento_bean = $focus->retrieve($row['id_c']);
	$cumplimiento_bean->id_mes_c = $id_mes;
	$cumplimiento_bean->mes_c = $mes;
	$cumplimiento_bean->anio_c = $anio;
	$cumplimiento_bean->save();

	echo "1";
}

?>