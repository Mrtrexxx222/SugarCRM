<?php
//SET THE job_string number to 3 digits to prevent crashing with sugarcrm pre-define job id.
$job_strings[102] = 'send_reminder';
 
function send_reminder()
{
    $exp_date = "10/11/2012";
	$todays_date = date("d-m-Y");

	$today = strtotime($todays_date);
	$expiration_date = strtotime($exp_date);

	if ($expiration_date > $today) 
	{
		 $valid = "yes";
	} 
	else 
	{
		 $valid = "no";
	}
}
?>