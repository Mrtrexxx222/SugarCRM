<?php
if(empty($_GET['scriptJs'])) die('No script');
$src = $_GET['scriptJs'];
$debug = true;

require dirname(__FILE__).'/class.JavaScriptPacker.php';

$script = file_get_contents($src);

header("Content-type: application/x-javascript");

if($debug){
	echo($script);
	exit();
}

$packer = new JavaScriptPacker($script, 'Normal', true, false);
$packed = $packer->pack();

echo($packed);
exit();
?>