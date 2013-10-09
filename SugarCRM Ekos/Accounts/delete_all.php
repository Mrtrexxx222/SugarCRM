<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
class clase_del
{
    function funcion_del($bean, $event, $arguments)
	{		
		$db =  DBManagerFactory::getInstance();
		$query = "select contact_id from accounts_contacts where account_id = '".$bean->id."'";
		$result = $db->query($query, true, 'Error selecting the contacts record');
		while($row=$db->fetchByAssoc($result))
		{
			//elimina la relacion entre los contactos y la cuenta		
			$query2 = "update accounts_contacts set deleted = '1' where account_id = '".$bean->id."'";
			$result2 = $db->query($query2, true, 'Error deleting the contacts and account relationship');
			
			//elimina los contactos		
			$query3 = "update contacts set deleted = '1' where id = '".$row['contact_id']."'";
			$result3 = $db->query($query3, true, 'Error deleting the contacts record');
		}
		
		$query4 = "select opportunity_id from accounts_opportunities where account_id = '".$bean->id."'";
		$result4 = $db->query($query4, true, 'Error selecting the opportunities record');
		while($row4=$db->fetchByAssoc($result4))
		{
			//elimina la relacion entre las oportunidades y la cuenta		
			$query5 = "update accounts_opportunities set deleted = '1' where account_id = '".$bean->id."'";
			$result5 = $db->query($query5, true, 'Error deleting the opportunities and account relationship');
			
			//elimina los contactos		
			$query6 = "update opportunities set deleted = '1' where id = '".$row4['opportunity_id']."'";
			$result6 = $db->query($query6, true, 'Error deleting the opportunities record');
		}
		
		$query7 = "select id_c from asignacion_productos_cstm where account_id_c = '".$bean->id."'";
		$result7 = $db->query($query7, true, 'Error selecting the asignaciones record');
		while($row7=$db->fetchByAssoc($result7))
		{
			//elimina las asignaciones de productos involucradas con esta cuenta
			$query8 = "update asignacion_productos set deleted = '1' where id = '".$row7['id_c']."'";
			$result8 = $db->query($query8, true, 'Error deleting the asignaciones record');
			
			//elimina el detalle de la asignacion
			$query9 = "update detalle_asig_producto_cstm set estatus_c = 'No aprobado' where asignacion_productos_id_c = '".$row7['id_c']."'";
			$result9 = $db->query($query9, true, 'Error updating the status asignacion record');
		}
		return true;
	}
}
?>