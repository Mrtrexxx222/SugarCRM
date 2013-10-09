<?php
	//para facebook
	function getTwitterProfileImage2($username)
	{
		//el type puede ser large
		 $foto2 = 'https://graph.facebook.com/'.$username.'/picture?type=large';
		 return $foto2;
	}
	$img2 = getTwitterProfileImage2('wilmer.alcivar.77');
	echo '<img src="'.$img2.'" width="200" height="200"/>';
?>