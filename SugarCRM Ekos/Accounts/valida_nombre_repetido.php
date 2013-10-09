<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$resultado="";
$nombre_oportunidad = $_POST['nombre_oportunidad'];

$oportunity = new Opportunity();
$oportunity->retrieve_by_string_fields(array('name'=>$nombre_oportunidad));
if($oportunity->id)
{
	echo "1";
}
else
{
	echo "0";
}

?>