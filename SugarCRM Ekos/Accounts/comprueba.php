<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$numero = $_REQUEST['numero'];

$db =  DBManagerFactory::getInstance(); 
$query = "select * from accounts_cstm where identificacion_c = '".$numero."'";
$result = $db->query($query, true, 'Error selecting the account record');
if($row=$db->fetchByAssoc($result))
{
	echo '1';
}
else
{
	echo '0';
}
?>