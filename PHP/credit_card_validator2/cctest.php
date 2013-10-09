<?php
	include("creditcard.inc.php");

	$cc=new CCVAL;
	
	$ccnum="411111111111111sd1";
	$cctype="visas";

	/*Test credit cards

		370000000000002 American Expres (amex)  

		6011000000000012 Discover

		5424000000000015 Master Card

		4111111111111111 visa
	*/

	if($cc->isVAlidCreditCard($ccnum))
		echo "Valid credit card .";
	else
		echo "Not valid!";

	if($cc->isVAlidCreditCard($ccnum,$type))
		echo "Valid credit card .";
	else
		echo "Not valid!";

	$obj=$cc->isVAlidCreditCard($ccnum,"",true);
	echo $obj->valid;
	echo "<br>";
	echo $obj->ccnum;
	echo "<br>";
	echo $obj->type;

?>