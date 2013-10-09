<?php
	@session_start();
	include_once("chat.inc.php");

	$mychat=new Chat($_REQUEST['room']);
	
	if(!empty($_POST[msg]))
		$mychat->putMessage(trim($_POST[msg]),$_SESSION['SES_USER_NAME']);
	if(isset($_POST['Logout']))
	{
		$mychat->putMessage($_SESSION['SES_USER_NAME']." has loged out at ".date("h:i:s a"));
		$mychat->delUser($_SESSION['SES_USER_NAME']);
		?>
		<SCRIPT LANGUAGE="JavaScript">
		
			window.parent.close();
		
		</SCRIPT>
		<?php
	}
?>
<HTML>
<body topmargin=0>
<form name='form1' method='Post' action=''>
<INPUT TYPE="hidden" name='room' value="<?php echo $_REQUEST['room']?>">
<input type="text" name="msg" size=75 >
<input type="Submit" value="Send">
<input type="Submit" name="Logout" value='Bye!'>
<br>
<span style='font-family:verdana;font-size:10px;color:#CC0000'>Kindly use the bye button to close properly. It is recommended.</span>
</form>
<SCRIPT LANGUAGE="JavaScript">

document.form1.msg.focus();

</SCRIPT>
</body>
</HTML>