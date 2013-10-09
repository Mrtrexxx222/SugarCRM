<?php
	@session_start();
	include_once("chat.inc.php");
	$mychat=new Chat($_REQUEST['room']);
	
	//$message=$mychat->getMessageForUser($_SESSION['SES_USER_NAME']);
	$message=$mychat->getMessage();
	$users=$mychat->getUsers();
	if(!empty($message))
	{
?>
var mydiv=new getObj('msgbox');
mydiv.obj.innerHTML="<?php echo $message?>";
var userbox=new getObj('userbox');
userbox.obj.innerHTML="<?php echo $users?>";

mydiv.obj.scrollTop=10000;
mydiv.obj.scrollTop=10000;
<?php }?>