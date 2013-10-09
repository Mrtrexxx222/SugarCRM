<?php
	//para tiwtter	
	session_start();
	require_once("twitteroauth/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
	$search = "wdalciva";
	$notweets = 50;
	$consumerkey = "wP7YhZmmGqePfTxQPKJbTA";
	$consumersecret = "FQBmOfs4e25Qi75ZbFv9ER4hbzo0qyU3v5Tu3BQ45e8";
	$accesstoken = "244941314-NZTJFYhEmvEfF50qV02CrEtoCKDbtjwC3izYraSf";
	$accesstokensecret = "MtfU1GStB1VTD7nZzga25LFC9BezI0rEIL6bH5NM2I";
	  
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret)
	{
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
	   
	$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
	$tweets = $connection->get("https://api.twitter.com/1.1/users/show.json?screen_name=".$search);
	  
	$arreglo = json_encode($tweets);
	$datos = json_decode($arreglo);
	$data = object_to_array($datos);
	$foto = str_replace("normal","bigger",$data['profile_image_url']);
	echo '<img src="'.$foto.'" width="100" height="100"/>';
	
	function object_to_array($data)
	{
		if (is_array($data) || is_object($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = object_to_array($value);
			}
			return $result;
		}
		return $data;
	}
?>