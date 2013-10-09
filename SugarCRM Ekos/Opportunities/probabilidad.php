<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

class clases
{
    function funcions($bean, $event, $arguments)
	{
		$db =  DBManagerFactory::getInstance();
		$probabilidad ="";		
		$query2 = "select * from opportunities where name = '".$bean->name."'";
		$result2 = $db->query($query2, true, 'Error selecting the opportunity products record');
		if($row2=$db->fetchByAssoc($result2))
		{
			if($bean->sales_stage == 'Needs Analysis')
			{
				$probabilidad = 25;
			}
			if($bean->sales_stage == 'Perception Analysis')
			{
				$probabilidad = 50;
			}
			if($bean->sales_stage == 'Quote')
			{
				$probabilidad = 75;
			}
			if($bean->sales_stage == 'Closed Won')
			{
				$probabilidad = 100;
			}
			if($bean->sales_stage == 'Closed lost')
			{
				$probabilidad = 0;
			}
			$query12 = "update opportunities set probability = '".$probabilidad."' where name = '".$row2['name']."'";
			$result12 = $db->query($query12, true, 'Error creating the quote oportunity record...');
		}
	}
}
?>