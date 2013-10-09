
<?php
	$server = "localhost";
	$usuario = "pluspro";
	$pass = "plus31597";
	$conn = mysql_connect($server,$usuario,$pass);
	mysql_select_db("pluspro_sms",$conn);
	
	//retorna el numero de filas de una consulta
	function numero_filas($result = null)
	{
		return mysql_num_rows($result);		
	}
	/**retorna los meses y sus nombres en español e ingles, dependiendo del usuario logueado y de el estado que seleccione**/
	//Retorma el nombre del mes 
	function getMes($elMes)
	{
		$nom_mes = '';
		switch ($elMes) 
		{
			case 1:
				$nom_mes = 'Enero';
				return $nom_mes;
				break;
			case 2:
				$nom_mes = 'Febrero';
				return $nom_mes;
				break;
			case 3:
				$nom_mes = 'Marzo';
				return $nom_mes;
				break;
			case 4:
				$nom_mes = 'Abril';
				return $nom_mes;
				break;
			case 5:
				$nom_mes = 'Mayo';
				return $nom_mes;
				break;
			case 6:
				$nom_mes = 'Junio';
				return $nom_mes;
				break;
			case 7:
				$nom_mes = 'Julio';
				return $nom_mes;
				break;
			case 8:
				$nom_mes = 'Agosto';
				return $nom_mes;
				break;
			case 9:
				$nom_mes = 'Septiembre';
				return $nom_mes;
				break;
			case 10:
				$nom_mes = 'Octubre';
				return $nom_mes;
				break;
			case 11:
				$nom_mes = 'Noviembre';
				return $nom_mes;
				break;
			case 12:
				$nom_mes = 'Diciembre';
				return $nom_mes;
				break;
		}
	}
	function getUltimoDiaMes($elAnio,$elMes) 
	{
	  return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
	}
	//Solo para los meses que existan en la base de datos
	function meses($id_user = null, $estado = null)
	{
		$result = mysql_query("SELECT DISTINCT(MONTH(m2.fecha_envio)) Mes, MONTHNAME(m2.fecha_envio) Nombre_1, 
								CASE WHEN MONTH(m2.fecha_envio) = 1 THEN 'Enero'
								WHEN MONTH(m2.fecha_envio) = 2 THEN 'Febrero'
								WHEN MONTH(m2.fecha_envio) = 3 THEN 'Marzo'
								WHEN MONTH(m2.fecha_envio) = 4 THEN 'Abril'
								WHEN MONTH(m2.fecha_envio) = 5 THEN 'Mayo'
								WHEN MONTH(m2.fecha_envio) = 6 THEN 'Junio'
								WHEN MONTH(m2.fecha_envio) = 7 THEN 'Julio'
								WHEN MONTH(m2.fecha_envio) = 8 THEN 'Agosto'
								WHEN MONTH(m2.fecha_envio) = 9 THEN 'Septiembre'
								WHEN MONTH(m2.fecha_envio) = 10 THEN 'Octubre'
								WHEN MONTH(m2.fecha_envio) = 11 THEN 'Noviembre'
								WHEN MONTH(m2.fecha_envio) = 12 THEN 'Diciembre' END Nombre_2,
								DAY(LAST_DAY(m2.fecha_envio)) Ultimo_dia
								FROM mensajes m
								INNER JOIN mensajes m2 ON m.id_mensaje = m2.id_mensaje
								INNER JOIN estado_interno e ON m.id_estado_interno = e.id_estado_interno
								WHERE m.id_usuario = ".$id_user." 
								AND m.id_estado_interno = ".$estado." 
								AND m2.fecha_envio IS NOT NULL
								ORDER BY 1 DESC");
		return $result;		
	}
	//retorna el año dependiendo del usuario logueado y de el estado que seleccione
	function periodo($id_user = null, $estado = null)
	{
		$result = mysql_query("SELECT DISTINCT(YEAR(m2.fecha_envio)) anio
								FROM mensajes m
								INNER JOIN mensajes m2 ON m.id_mensaje = m2.id_mensaje
								INNER JOIN estado_interno e ON m.id_estado_interno = e.id_estado_interno
								WHERE m.id_usuario = ".$id_user." 
								AND m.id_estado_interno = ".$estado." 
								AND m2.fecha_envio IS NOT NULL
								ORDER BY 1 DESC");
		return $result;		
	}
?>