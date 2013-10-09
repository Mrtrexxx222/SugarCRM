<?php
//Validation Class 0.1 by ming0070913
CLASS Validation
{
	function check_email($value) //check a email address
	{
		return (bool) preg_match('/^[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,4}$/i', $value);
	}
	
	function check_ip($value) //check a IP address
	{
		return (bool) preg_match("/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){4}$/", $value.".");
	}
	
	function check_date($date, $format="dd/mm/yy") //check a date
	{
		if(!preg_match("/([0-9]+)([\.\/-])([0-9]+)(\\2)([0-9]+)/", $date, $m)) return false;
		$f = explode("/", $format);
		$d[$f[0]] = $m[1];
		$d[$f[1]] = $m[3];
		$d[$f[2]] = $m[5];
		return checkdate($d['mm'], $d['dd'], $d['yyyy'].$d['yy']);
	}
	
	function check_url($url) //check a URL
	{
		return (bool) preg_match("/^(?:(?:ht|f)tp(?:s?)\:\/\/|~\/|\/)?(?:(?:\w+\.)+)\w+(?:\:\d+)?(?:(?:\/[^\/?#]+)+)?\/?(?:\?[^?]*)?(#.*)?$/i", $url);
	}

	function check_local_phone($numeros)
	{
		$numeros=preg_replace("/[^0-9]/","",$numeros);//quitamos la basura
		$primer_numero=substr($numeros,0,1); // muy obio el primer digito
		$total=strlen($numeros);// el total de digitos
		if($primer_numero==0 && $total==9)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function check_mobile_phone($numeros)
	{
		$numeros=preg_replace("/[^0-9]/","",$numeros);//quitamos la basura
		$primer_numero=substr($numeros,0,1); // muy obio el primer digito
		$total=strlen($numeros);// el total de digitos
		if($total==8)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>