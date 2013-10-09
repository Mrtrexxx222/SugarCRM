<?php
	@session_start();
	include_once("chat.inc.php");
	$room=$_REQUEST['room'];
	$mychat=new Chat($room);
	
?>
<HTML>
<head>
<!-- <meta http-equiv="refresh" content="1">-->
 
 <STYLE>
 body,td {
 font-family:verdana;
 font-size:11px;
 }
 </STYLE>


 <SCRIPT LANGUAGE="JavaScript">
<!--
function getObj(name)
{
  if (document.getElementById)
  {
  	this.obj = document.getElementById(name);
	this.style = document.getElementById(name).style;
  }
  else if (document.all)
  {
	this.obj = document.all[name];
	this.style = document.all[name].style;
  }
  else if (document.layers)
  {
	this.obj = getObjNN4(document,name);
	this.style = this.obj;
  }
}

function getObjNN4(obj,name)
{
	var x = obj.layers;
	var foundLayer;
	for (var i=0;i<x.length;i++)
	{
		if (x[i].id == name)
		 	foundLayer = x[i];
		else if (x[i].layers.length)
			var tmp = getObjNN4(x[i],name);
		if (tmp) foundLayer = tmp;
	}
	return foundLayer;
}


//-->
</SCRIPT>
	
	<script type="text/javascript" >
	var g_remoteServer = "getmessage.php?room=<?php echo $room?>";
	var g_intervalID;
	function callServer() 
	{	
		var head = document.getElementsByTagName('head').item(0);
		var old  = document.getElementById('lastLoadedCmds');
		if (old) head.removeChild(old);
		script = document.createElement('script');
		script.src = g_remoteServer;
		script.type = 'text/javascript';
		script.defer = true;
		script.id = 'lastLoadedCmds';
		void(head.appendChild(script));
	}
	g_intervalID = setInterval(callServer,1000);
	callServer();
	</script>

</head>
<body >
<div id='msgbox' style="position:absolute;left:10;border:thin inset;width:550;height:90%;overflow:auto;overflow-x:hidden;"><?php echo $mychat->getMessage();?>
</div>
<div id='userbox' style="position:absolute;left:560;border:thin inset;width:200;height:90%;overflow:auto">
<?php echo $mychat->getUsers();?>
</div>
</body>
<SCRIPT LANGUAGE="JavaScript">
<!--
var mydiv=new getObj('msgbox');
//alert(mydiv.obj.innerHeight);
mydiv.obj.scrollTop=10000;
mydiv.obj.scrollTop=10000;
//-->
</SCRIPT>
</HTML>