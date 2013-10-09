<?php
$md5Hash="21232f297a57a5a743894a0e4a801fc3";
$md5Hash="e10adc3949ba59abbe56e057f20f883e";

require("PhpMd5Decrypter.inc.php");
$phpMd5Decrypter=new PhpMd5Decrypter();
$normalText=$phpMd5Decrypter->decrypt($md5Hash);

if($normalText===false){
	echo "The Password was too strong to crack.";
}
else{
	echo "Password was too weak: It was $normalText";
}
?>