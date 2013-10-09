<?php
require_once("sms.inc.php");

//https://dragon.operatelecom.com:1089/Gateway 
//https://dragon.operatelecom.com:1089

$smshost = "dragon.operatelecom.com";
$smsurl = "/";
$smsport = 1089;
$smsuser = "userid";
$smspwd = "passphrase";


$serviceid=0000; // Service id
$source="sortcode"; // Source 
$channel=0; // Source Channel
$Phone= '+00000000';//'+61438442344'; // Phone

$Content="test message."; // Content
$Premium=0; // Premium

$PremiumSms = 4695;
$smsch = 437;
$smschb = 1944;

$expiry = date('Ymd\THis',time() + 24*60*60);

$sms = new SMS();
//$sms->sms_test = true;
$sms->setHost($smshost,$smsurl,$smsport);
$sms->setUser($smsuser,$smspwd);
$sms->setChannels($smsch,$smschb,$PremiumSms);
$sms->setInfo($serviceid,$source);

 //List the channel available to service
/*$result = $sms->getChannel();
if($result==false)
	echo $sms->error();
else 
	print_r($result);
*/

 //List the networks
/*$result = $sms->getNetworks();
if($result==false)
	echo $sms->error();
else 
	print_r($result);*/

//vodafone-au
//telstra-au
//optus-au
//virgin-au

//Send SMS

$result = $sms->sendSMS($Phone,"Free");
if($result==false)
	echo $sms->error();
else 
	print_r($result);

//Send Premium SMS
/*$result = $sms->sendSMS($Phone,"PSMS",1);
if($result==false)
	echo $sms->error();
else 
	print_r($result);
	*/


/*$result = $sms->sendWapPush($Phone,"Wap");
if($result==false)
	echo $sms->error();
else 
	echo "Success : ".$result;*/
?>
