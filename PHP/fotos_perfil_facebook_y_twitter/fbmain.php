<?php
	//para tiwtter
	function getTwitterProfileImage($username)
	{
		  //el size puede ser normal, bigger, original, mini
		  $foto = 'http://api.twitter.com/1/users/profile_image/'.$username.'.json?size=original';
		  return $foto;
	}
	$img = getTwitterProfileImage('wdalciva');
	echo '<img src="'.$img.'" width="200" height="150"/>';
	
	//para facebook
	function getTwitterProfileImage2($username)
	{
		//el type puede ser large
		 $foto2 = 'https://graph.facebook.com/'.$username.'/picture?type=large';
		 return $foto2;
	}
	$img2 = getTwitterProfileImage2('sebas.pachano');
	echo '<img src="'.$img2.'" width="200" height="150"/>';
?>