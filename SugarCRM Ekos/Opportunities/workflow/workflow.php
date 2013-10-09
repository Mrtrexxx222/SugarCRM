<?php

include_once("include/workflow/alert_utils.php");
include_once("include/workflow/action_utils.php");
include_once("include/workflow/time_utils.php");
include_once("include/workflow/trigger_utils.php");
//BEGIN WFLOW PLUGINS
include_once("include/workflow/custom_utils.php");
//END WFLOW PLUGINS
	class Opportunities_workflow {
	function process_wflow_triggers(& $focus){
		include("custom/modules/Opportunities/workflow/triggers_array.php");
		include("custom/modules/Opportunities/workflow/alerts_array.php");
		include("custom/modules/Opportunities/workflow/actions_array.php");
		include("custom/modules/Opportunities/workflow/plugins_array.php");
		
 if( (isset($focus->sales_stage) && $focus->sales_stage ==  'Quote')){ 
 

	 //Frame Secondary 

	 $secondary_array = array(); 
	 //Secondary Triggers 
	 //Secondary Trigger number #1
	 if( (
 	 ( 
 		isset($focus->revisado_c) && $focus->revisado_c === false ||
 		isset($focus->revisado_c) && $focus->revisado_c === 'false' ||
 		isset($focus->revisado_c) && $focus->revisado_c === 'off' ||
 		isset($focus->revisado_c) && $focus->revisado_c === 0 ||
 		isset($focus->revisado_c) && $focus->revisado_c === '0'
 	 )  
)	 ){ 
	 


	global $triggeredWorkflows;
	if (!isset($triggeredWorkflows['754dd325_d586_6240_046e_5166e0405b7a'])){
		$triggeredWorkflows['754dd325_d586_6240_046e_5166e0405b7a'] = true;
		 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "69550a34-510a-5ab9-d913-5107d671276b"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['Opportunities0_alert0'], $alertshell_array, false); 
 	 unset($alertshell_array); 
		}
 

	 //End Frame Secondary 

	 // End Secondary Trigger number #1
 	 } 

	 unset($secondary_array); 
 

 //End if trigger is true 
 } 


 if( ( !($focus->fetched_row['sales_stage'] ==  'Closed Won' )) && 
 (isset($focus->sales_stage) && $focus->sales_stage ==  'Closed Won')){ 
 

	 //Frame Secondary 

	 $secondary_array = array(); 
	 //Secondary Triggers 
	 //Secondary Trigger number #1
	 if( (
 	 ( 
 		isset($focus->revisado_c) && $focus->revisado_c === true ||
 		isset($focus->revisado_c) && $focus->revisado_c === 'true' ||
 		isset($focus->revisado_c) && $focus->revisado_c === 'on' ||
 		isset($focus->revisado_c) && $focus->revisado_c === 1 ||
 		isset($focus->revisado_c) && $focus->revisado_c === '1'
 	 )  
)	 ){ 
	 


	global $triggeredWorkflows;
	if (!isset($triggeredWorkflows['75a478d1_b4e5_9be7_e6cd_5166e0bd5d98'])){
		$triggeredWorkflows['75a478d1_b4e5_9be7_e6cd_5166e0bd5d98'] = true;
		 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "600e4117-c2df-9d97-6797-5107d9cc0f3c"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['Opportunities1_alert0'], $alertshell_array, false); 
 	 unset($alertshell_array); 
		}
 

	 //End Frame Secondary 

	 // End Secondary Trigger number #1
 	 } 

	 unset($secondary_array); 
 

 //End if trigger is true 
 } 


 if( (
 	 ( 
 		isset($focus->revisado_c) && $focus->revisado_c === true ||
 		isset($focus->revisado_c) && $focus->revisado_c === 'true' ||
 		isset($focus->revisado_c) && $focus->revisado_c === 'on' ||
 		isset($focus->revisado_c) && $focus->revisado_c === 1 ||
 		isset($focus->revisado_c) && $focus->revisado_c === '1'
 	 )  
)){ 
 

	 //Frame Secondary 

	 $secondary_array = array(); 
	 //Secondary Triggers 
	 //Secondary Trigger number #1
	 if( (isset($focus->sales_stage) && $focus->sales_stage ==  'Quote')	 ){ 
	 


	global $triggeredWorkflows;
	if (!isset($triggeredWorkflows['75e82525_f963_25b5_bcfa_5166e0576b4f'])){
		$triggeredWorkflows['75e82525_f963_25b5_bcfa_5166e0576b4f'] = true;
		 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "82793a60-b7a8-c8a8-4027-5107d7514af0"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['Opportunities2_alert0'], $alertshell_array, false); 
 	 unset($alertshell_array); 
		}
 

	 //End Frame Secondary 

	 // End Secondary Trigger number #1
 	 } 

	 unset($secondary_array); 
 

 //End if trigger is true 
 } 


	//end function process_wflow_triggers
	}

	//end class
	}

?>