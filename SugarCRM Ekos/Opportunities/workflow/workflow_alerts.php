<?php

include_once("include/workflow/alert_utils.php");
    class Opportunities_alerts {
    function process_wflow_Opportunities3_alert0(&$focus){
            include("custom/modules/Opportunities/workflow/alerts_array.php");

	 $alertshell_array = array(); 

	 $alertshell_array['alert_msg'] = "69550a34-510a-5ab9-d913-5107d671276b"; 

	 $alertshell_array['source_type'] = "Custom Template"; 

	 $alertshell_array['alert_type'] = "Email"; 

	 process_workflow_alerts($focus, $alert_meta_array['Opportunities3_alert0'], $alertshell_array, false); 
 	 unset($alertshell_array); 
	 }



    //end class
    }

?>