<?
extract($_POST);
session_id('mostlittlechat');
session_start();

$_SESSION['lastmessage']=!isset($_SESSION['lastmessage'])?0:$_SESSION['lastmessage'];
$_SESSION['msgs']=!isset($_SESSION['msgs'])?array():$_SESSION['msgs'];
$_SESSION['users']=!isset($_SESSION['users'])?array():$_SESSION['users'];

switch($action){
case "login":
	$arr=$_SESSION['users'];
	foreach($arr as $us){
		if ($us==$user) die("alert('user in use');");
	}


	
	$listusers = implode(",", $_SESSION['users']);
	$last=$_SESSION['lastmessage'];
	$ret.="self.start('$user','$listusers');\r\n";
	array_push($_SESSION['users'],$user);
	addmess("self.enter('$user');");

case "ping":
	
	$_SESSION["$user.time"]=time();
	$arr=$_SESSION['users'];
	foreach($arr as $us){
		if ($_SESSION["$us.time"]<(time()-10)){
			removefromusers($us);
			addmess("self.remove('$us');\r\n");
		}
	}
	
	if(isset($message)){
		$message=htmlentities($message);
		addmess("self.message('$user','$message');");	
	}
	
	//$last++;
	while(intval($last)!=intval($_SESSION['lastmessage'])){
		$ret.=$_SESSION['msgs'][$last]."\r\n";
		$last++; if ($last>99) $last=0;
	}
	
	$ret.="$('#last').val($last);\r\n";
	
break;

}

echo $ret;


function removefromusers($who){
	$ret=array();
	$arr=$_SESSION['users'];
	foreach($arr as $us){
		if ($us!=$who) array_push($ret,$us);
	} $_SESSION['users']=$ret;
}


function addmess($msg){
	if (count($_SESSION['msgs'])<100) {
		array_push($_SESSION['msgs'],$msg);
		$_SESSION['lastmessage']=count($_SESSION['msgs']);
		
	} else {
		$_SESSION['lastmessage']++;
		if ($_SESSION['lastmessage']>99) $_SESSION['lastmessage']=0;
		$_SESSION['msgs'][$_SESSION['lastmessage']]=$msg;
	}
}

?>