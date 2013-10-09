<?php

include_once("include/workflow/alert_utils.php");
    class Accounts_alerts {
    function process_wflow_Accounts0_alert0(&$focus){
            include("custom/modules/Accounts/workflow/alerts_array.php");

	 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "5d9fcabd-98e0-c410-afd2-5175ed9884fa"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['Accounts0_alert0'], $alertshell_array, false); 
 	 unset($alertshell_array); 
	 }



    //end class
    }

?>