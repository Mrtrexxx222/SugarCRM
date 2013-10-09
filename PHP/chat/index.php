<?php
@session_start();
include_once("chat.inc.php");

if(!empty($_POST['name']))
{
	$room="newroom";
	$_SESSION['SES_USER_NAME']=$_POST['name'];
	$mychat=new Chat($room);
	if($mychat->addUser($_POST['name'])===false)
	{
		$_SESSION['SES_USER_NAME']='';
		$_SESSION['MSG_LINES']=0;
		echo $mychat->room->getError();
	}
	
}

?>
<html>
<head>
<SCRIPT LANGUAGE="JavaScript">
<!--
function openchat()
{
	window.open("chat.php?room=<?php echo $room?>",'','toolbar=0,status=0,height=500,width=770');
}
//-->
</SCRIPT>
</head>
<body>
<table cellspacning=1 cellpadding=2 border=0>
<?php if(empty($_SESSION['SES_USER_NAME'])){?>

<form name='' action='' method='POST'>
<tr><td><b>Enter Your Name:</b></td>
<td><input name='name'></td>
<td colspan=><input type='submit' name='addme' value='Go!'></td>
</tr></form>
<?php }else {?>
<tr><td>
<a href='javascript:openchat()'>click here</a> to start the <a href='javascript:openchat()'>Chat.</a>
</td></tr>
<SCRIPT LANGUAGE="JavaScript">
<!--
openchat();
//-->
</SCRIPT>
<?php }?>

</table>
</body>
</html>


