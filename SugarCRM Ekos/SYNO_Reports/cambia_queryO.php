<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$resultado="";
$query = $_POST['query'];
$mes2 = $_POST['mes2'];
$periodo = $_POST['periodo'];
$mes = $_POST['mes'];
$cadena_relacionadores = $_POST['relacionadores'];
$cadena_productos = $_POST['producto'];
$cadena_lineas = $_POST['linea_producto'];
$reporte = $_POST['reporte'];
$tipo = $_POST['tipo'];
$visualizacion = $_POST['visualizacion'];
$cuenta = $_POST['cuenta'];
$cadena_probabilidades = $_POST['probabilidad'];
$ordenar_por = $_POST['ordenar_por'];
$semanal_mensual = $_POST['semanal_mensual'];
$ordenar="";
if($ordenar_por == 'Facturacion Estimada')
{
	$ordenar = '';
}
else if($ordenar_por == 'Mes')
{
	$ordenar = 'ORDER BY a.mes_c ASC';
}
else if($ordenar_por == 'Probabilidad')
{
	$ordenar = 'ORDER BY c.probability DESC';
}
else if($ordenar_por == 'Producto')
{
	$ordenar = 'ORDER BY a.producto_c ASC';
}
else if($ordenar_por == 'Prospeccion')
{
	$ordenar = 'ORDER BY a.valor_prospectado_c DESC';
}
else
{
	$ordenar = 'ORDER BY a.usuario_c ASC';
}

$relacionadores_sin_coma = explode(",",$cadena_relacionadores);

if($reporte == 'Cumplimiento por producto')
{
	$result_relacionadores.="AND a.id_usuario_c IN(";
	$result_productos.="AND a.producto_c IN(";
	$result_relacionadores2.="AND b.assigned_user_id IN(";
	$result_productos2.="AND a.nombre_producto_c IN(";
}
else
{
	if($reporte == 'Cumplimiento por relacionador' || $reporte == 'Pipeline de ventas' || $reporte == 'Mapa de relacionadores' || $reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || $reporte == 'Historico de ventas por relacionador semanal' || $reporte == 'Ranking de Clientes' || $reporte == 'Cuentas asignadas sin actividades')
	{
		if($reporte == 'Pipeline de ventas')
		{
			$result_relacionadores.="AND a.id_usuario_c IN(";
			$result_productos.="AND a.producto_c IN(";
		}
		if($reporte == 'Mapa de relacionadores')
		{
			$result_relacionadores.="AND b.assigned_user_id IN(";
			$result_productos.="AND a.nombre_producto_c IN(";
		}
		if($reporte == 'Cumplimiento por relacionador')
		{
			$result_relacionadores.="AND a.id_usuario_c IN(";
			$result_productos.="AND c.nombre_producto_c IN(";
			$result_relacionadores2.="AND b.assigned_user_id IN(";
			$result_productos2.="AND a.nombre_producto_c IN(";
		}
		if($reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador')
		{
			$result_relacionadores.="AND a.id_usuario_c IN(";
			$result_productos.="AND a.producto_c IN(";
			$result_relacionadores2.="AND b.assigned_user_id IN(";
			$result_productos2.="AND a.nombre_producto_c IN(";
		}
		if($reporte == 'Historico de ventas por relacionador semanal')
		{
			$result_relacionadores.="AND a.id_usuario_c IN(";
			$result_productos.="AND a.producto_c IN(";
			$result_relacionadores2.="AND b.assigned_user_id IN(";
			$result_productos2.="AND a.nombre_producto_c IN(";
		}
		if($reporte == 'Ranking de Clientes')
		{
			$result_relacionadores3.="AND e.id_usuario_c IN(";
			$result_productos3.="AND e.producto_c IN(";
		}
		if($reporte == 'Cuentas asignadas sin actividades')
		{
			$result_relacionadores4.="AND c.assigned_user_id IN(";
			$result_productos4.="AND b.nombre_producto_c IN(";
		}
	}
	else
	{
		if($reporte == 'Cumplimiento por mes' && $tipo == 'distribucion')
		{
			$result_relacionadores.="AND a.id_usuario_c IN(";
			$result_productos.="AND a.producto_c IN(";
			$result_relacionadores2.="AND b.assigned_user_id IN(";
			$result_productos2.="AND a.nombre_producto_c IN(";
		}
		else
		{
			$result_relacionadores.="AND a.id_usuario_c IN(";
			$result_productos.="AND a.producto_c IN(";
			$result_productos2.="AND a.nombre_producto_c IN(";
		}
	}
}

$probabilidades_sin_coma = explode(",",$cadena_probabilidades);
$result_probabilidades.= "AND c.probability IN (";
for($i=0;$i<=count($probabilidades_sin_coma);$i++)
{
	$result_probabilidades.= "'".$probabilidades_sin_coma[$i]."',";
}
$result_probabilidades = substr($result_probabilidades, 0, -4);
$result_probabilidades.=")";

for($i=0;$i<=count($relacionadores_sin_coma);$i++)
{
	$db =  DBManagerFactory::getInstance();
	$query = "SELECT id FROM users WHERE CONCAT(first_name,' ',last_name) = '".$relacionadores_sin_coma[$i]."'";
	$result = $db->query($query, true, 'Error selecting the id user');
	if($row=$db->fetchByAssoc($result))
	{
		$result_relacionadores.="'".$row['id']."',";
		$result_relacionadores2.="'".$row['id']."',";
		$result_relacionadores3.="'".$row['id']."',";
		$result_relacionadores4.="'".$row['id']."',";
	}
}
$result_relacionadores = substr($result_relacionadores, 0, -1);
$result_relacionadores.=")";
$result_relacionadores2 = substr($result_relacionadores2, 0, -1);
$result_relacionadores2.=")";
$result_relacionadores3 = substr($result_relacionadores3, 0, -1);
$result_relacionadores3.=")";
$result_relacionadores4 = substr($result_relacionadores4, 0, -1);
$result_relacionadores4.=")";

$lineas_sin_coma = explode(",",$cadena_lineas);
$result_lineas.="AND a.categoria_c IN(";
$result_lineas2.="AND a.nombre_linea_c IN(";
$result_lineas3.="AND e.categoria_c IN(";
$result_lineas4.="AND b.nombre_linea_c IN(";
for($i=0;$i<=count($lineas_sin_coma);$i++)
{
	//$result_lineas.="'".$lineas_sin_coma[$i]."',";
	if($lineas_sin_coma[$i] == ' Actores y Oportunidades')
	{
		$result_lineas.= "'Grandes Empresas, Actores y Oportunidades',";
		$result_lineas2.= "'Grandes Empresas, Actores y Oportunidades',";
		$result_lineas3.= "'Grandes Empresas, Actores y Oportunidades',";
		$result_lineas4.= "'Grandes Empresas, Actores y Oportunidades',";
	}
	else
	{
		if($lineas_sin_coma[$i] != 'Grandes Empresas')
		{
			$result_lineas.="'".$lineas_sin_coma[$i]."',";
			$result_lineas2.="'".$lineas_sin_coma[$i]."',";
			$result_lineas3.="'".$lineas_sin_coma[$i]."',";
			$result_lineas4.="'".$lineas_sin_coma[$i]."',";
		}
	}
}
$result_lineas = substr($result_lineas, 0, -1);
$result_lineas.=")";
$result_lineas2 = substr($result_lineas2, 0, -1);
$result_lineas2.=")";
$result_lineas3 = substr($result_lineas3, 0, -1);
$result_lineas3.=")";
$result_lineas4 = substr($result_lineas4, 0, -1);
$result_lineas4.=")";

$productos_sin_coma = explode(",",$cadena_productos);
for($i=0;$i<=count($productos_sin_coma);$i++)
{
	if($productos_sin_coma[$i] == ' Actores Y Oportunidades')
	{
		$result_productos.= "'Grandes Empresas, Actores Y Oportunidades',";
		$result_productos2.= "'Grandes Empresas, Actores Y Oportunidades',";
		$result_productos3.= "'Grandes Empresas, Actores Y Oportunidades',";
		$result_productos4.= "'Grandes Empresas, Actores Y Oportunidades',";
	}
	else
	{
		if($productos_sin_coma[$i] != 'Grandes Empresas')
		{
			$result_productos.="'".$productos_sin_coma[$i]."',";
			$result_productos2.="'".$productos_sin_coma[$i]."',";
			$result_productos3.="'".$productos_sin_coma[$i]."',";
			$result_productos4.="'".$productos_sin_coma[$i]."',";
		}
	}
}
$result_productos = substr($result_productos, 0, -1);
$result_productos.=")";
$result_productos2 = substr($result_productos2, 0, -1);
$result_productos2.=")";
$result_productos3 = substr($result_productos3, 0, -1);
$result_productos3.=")";
$result_productos4 = substr($result_productos4, 0, -1);
$result_productos4.=")";

if($reporte == 'Cumplimiento por producto')
{
	$resultado.="(SELECT a.producto_c as Producto, a.anio_c AS Anio, a.mes_c AS Mes, CONCAT(e.first_name,' ',e.last_name) as Relacionador, SUM(valor_prospectado_c) AS Ventas, c.valor_c AS Presupuesto, f.id as id_oportunidad
FROM m1_oportunidad_productos_cstm a, m1_oportunidad_productos b, presupuestos_cstm c, presupuestos d, users e, opportunities f
WHERE a.id_c = b.id
AND c.id_mes_c = a.mes_c
AND c.nombre_periodo_c = a.anio_c
AND c.nombre_producto_c = a.producto_c
AND c.id_c = d.id
AND a.id_usuario_c = d.assigned_user_id
AND a.id_usuario_c = e.id
AND c.tipo_c = 'distribucion'
AND a.estado_c = '1'
AND f.name = a.oportunidad_c
AND f.deleted = '0'
AND a.id_usuario_c = d.assigned_user_id
AND f.probability = '100'";
	$resultado.= "\n AND a.anio_c = '".$periodo."'\n";
	if($mes == '10' || $mes == '11' || $mes == '12')
	{
		if($visualizacion == 'Individual')
		{
			$resultado.= "AND a.mes_c = ".$mes."\n";
		}
		else
		{
			$resultado.= "AND a.mes_c <= ".$mes."\n";
		}
	}
	else
	{
		if($visualizacion == 'Individual')
		{
			$resultado.= "AND a.mes_c = ".$mes."\n";
		}
		else
		{
			$resultado.= "AND a.mes_c <= ".$mes."\n";
		}
	}
	if($result_relacionadores != 'AND a.id_usuario_c IN)')
	{
		$resultado.=$result_relacionadores."\n";
	}
	if($result_lineas != "AND a.categoria_c IN('','')")
	{
		$resultado.=$result_lineas."\n";
	}
	if($result_productos != "AND a.producto_c IN('','')")
	{
		$resultado.=$result_productos."\n";
	}
	$resultado.= "GROUP BY a.anio_c, a.mes_c, a.id_usuario_c, a.id_producto_c)
UNION
(SELECT a.nombre_producto_c as Producto, a.nombre_periodo_c AS Anio, a.id_mes_c AS Mes, CONCAT(e.first_name,' ',e.last_name) AS Relacionador, 0.000000 as Ventas, a.valor_c AS Presupuesto, 0 as id_oportunidad
FROM  presupuestos_cstm a, presupuestos b, users e
WHERE a.id_c = b.id
AND e.id = b.assigned_user_id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'";
$resultado.= "\n AND a.nombre_periodo_c = '".$periodo."'\n";
	if($visualizacion == 'Individual')
	{
		$resultado.= "AND a.id_mes_c = ".$mes."\n";
	}
	else
	{
		$resultado.= "AND a.id_mes_c <= ".$mes."\n";
	}
	if($result_relacionadores2 != 'AND b.assigned_user_id IN)')
	{
		$resultado.=$result_relacionadores2."\n";
	}
	if($result_lineas2 != "AND a.nombre_linea_c IN('','')")
	{
		$resultado.=$result_lineas2."\n";
	}
	if($result_productos2 != "AND a.nombre_producto_c IN('','')")
	{
		$resultado.=$result_productos2."\n";
	}
$resultado.= "GROUP BY a.nombre_periodo_c, a.id_mes_c, b.assigned_user_id, a.producttemplate_id_c)
ORDER BY Producto ASC, Mes+0 Asc, Ventas DESC;";
	$resultado = str_replace("&#039;", "'", $resultado);
}
else if($reporte == 'Cumplimiento por relacionador')
{
	$resultado.="(SELECT a.producto_c as Producto, a.anio_c AS Anio, a.mes_c AS Mes, CONCAT(e.first_name,' ',e.last_name) as Relacionador, SUM(valor_prospectado_c) AS Ventas, c.valor_c AS Presupuesto, f.id as id_oportunidad
FROM m1_oportunidad_productos_cstm a, m1_oportunidad_productos b, presupuestos_cstm c, presupuestos d, users e, opportunities f
WHERE a.id_c = b.id
AND c.id_mes_c = a.mes_c
AND c.nombre_periodo_c = a.anio_c
AND c.nombre_producto_c = a.producto_c
AND c.id_c = d.id
AND a.id_usuario_c = d.assigned_user_id
AND a.id_usuario_c = e.id
AND c.tipo_c = 'distribucion'
AND a.estado_c = '1'
AND f.name = a.oportunidad_c
AND f.deleted = '0'
AND f.probability = '100'
AND a.id_usuario_c = d.assigned_user_id";
	$resultado.= "\n AND a.anio_c = '".$periodo."'\n";
	if($mes == '10' || $mes == '11' || $mes == '12')
	{
		if($visualizacion == 'Individual')
		{
			$resultado.= "AND a.mes_c = ".$mes."\n";
		}
		else
		{
			$resultado.= "AND a.mes_c <= ".$mes."\n";
		}
	}
	else
	{
		if($visualizacion == 'Individual')
		{
			$resultado.= "AND a.mes_c = ".$mes."\n";
		}
		else
		{
			$resultado.= "AND a.mes_c <= ".$mes."\n";
		}
	}
	if($result_relacionadores != 'AND a.id_usuario_c IN)')
	{
		$resultado.=$result_relacionadores."\n";
	}
	if($result_lineas != "AND a.categoria_c IN('','')")
	{
		$resultado.=$result_lineas."\n";
	}
	if($result_productos != "AND a.producto_c IN('','')")
	{
		$resultado.=$result_productos."\n";
	}
	$resultado.= "GROUP BY a.mes_c, a.id_usuario_c, a.id_producto_c)
UNION
(SELECT a.nombre_producto_c as Producto, a.nombre_periodo_c AS Anio, a.id_mes_c AS Mes, CONCAT(e.first_name,' ',e.last_name) AS Relacionador, 0.000000 as Ventas, a.valor_c AS Presupuesto, 0 as id_oportunidad
FROM  presupuestos_cstm a, presupuestos b, users e
WHERE a.id_c = b.id
AND e.id = b.assigned_user_id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'";
$resultado.= "\n AND a.nombre_periodo_c = '".$periodo."'\n";
	if($visualizacion == 'Individual')
	{
		$resultado.= "AND a.id_mes_c = ".$mes."\n";
	}
	else
	{
		$resultado.= "AND a.id_mes_c <= ".$mes."\n";
	}
	if($result_relacionadores2 != 'AND b.assigned_user_id IN)')
	{
		$resultado.=$result_relacionadores2."\n";
	}
	if($result_lineas2 != "AND a.nombre_linea_c IN('','')")
	{
		$resultado.=$result_lineas2."\n";
	}
	if($result_productos2 != "AND a.nombre_producto_c IN('','')")
	{
		$resultado.=$result_productos2."\n";
	}
$resultado.= "GROUP BY a.id_mes_c, b.assigned_user_id, a.producttemplate_id_c)
ORDER BY Producto ASC, Mes+0 Asc, Ventas DESC;";
	$resultado = str_replace("&#039;", "'", $resultado);
}
else if($reporte == 'Cumplimiento por mes')
{
	$resultado.="(SELECT a.anio_c AS Anio, a.mes_c AS Mes, CONCAT(e.first_name,' ',e.last_name) as Relacionador, a.producto_c as Producto, SUM(valor_prospectado_c) AS Ventas, c.valor_c AS Presupuesto, ((SUM(a.valor_prospectado_c)*100)/c.valor_c) AS Porcentaje, f.id as id_oportunidad
FROM m1_oportunidad_productos_cstm a, m1_oportunidad_productos b, presupuestos_cstm c, presupuestos d, users e, opportunities f
WHERE a.id_c = b.id
AND c.id_mes_c = a.mes_c
AND c.nombre_periodo_c = a.anio_c
AND c.nombre_producto_c = a.producto_c
AND c.id_c = d.id
AND c.tipo_c = 'distribucion'
AND a.estado_c = '1'
AND f.name = a.oportunidad_c
AND f.probability = '100'
AND f.deleted = '0'
AND a.id_usuario_c = d.assigned_user_id
AND a.id_usuario_c = e.id";
		$resultado.= "\n AND a.anio_c = '".$periodo."'\n";
		if($mes == '10' || $mes == '11' || $mes == '12')
		{
			$resultado.= "AND a.mes_c <= ".$mes."\n";
		}
		else
		{
			$resultado.= "AND a.mes_c <= ".$mes."\n";
		}
		if($result_relacionadores != 'AND a.id_usuario_c IN)')
		{
			$resultado.=$result_relacionadores."\n";
		}
		if($result_lineas != "AND a.categoria_c IN('','')")
		{
			$resultado.=$result_lineas."\n";
		}
		if($result_productos != "AND a.producto_c IN('','')")
		{
			$resultado.=$result_productos."\n";
		}
		$resultado.= "GROUP BY a.mes_c, a.id_usuario_c, a.id_producto_c)
UNION
(SELECT a.nombre_periodo_c AS Anio, a.id_mes_c AS Mes, CONCAT(e.first_name,' ',e.last_name) AS Relacionador, a.nombre_producto_c as Producto, 0.000000 as Ventas, a.valor_c AS Presupuesto, ((0.000000*100)/a.valor_c) AS Porcentaje, 0 as id_oportunidad
FROM  presupuestos_cstm a, presupuestos b, users e
WHERE a.id_c = b.id
AND e.id = b.assigned_user_id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'";
$resultado.= "\n AND a.nombre_periodo_c = '".$periodo."'\n";
$resultado.= "AND a.id_mes_c <= ".$mes."\n";
if($result_relacionadores2 != 'AND b.assigned_user_id IN)')
{
	$resultado.=$result_relacionadores2."\n";
}
if($result_lineas2 != "AND a.nombre_linea_c IN('','')")
{
	$resultado.=$result_lineas2."\n";
}
if($result_productos2 != "AND a.nombre_producto_c IN('','')")
{
	$resultado.=$result_productos2."\n";
}
$resultado.="GROUP BY a.id_mes_c, b.assigned_user_id, a.producttemplate_id_c)
ORDER BY Mes+0, Producto ASC, Porcentaje DESC, Ventas DESC;";
		$resultado = str_replace("&#039;", "'", $resultado);
}
else if($reporte == 'Pipeline de ventas')
{
	$resultado.="SELECT a.anio_c as Anio, a.mes_c as Mes, a.usuario_c as Relacionador, CONCAT(d.first_name,' ',d.last_name) as Farming, c.name as Oportunidad, a.producto_c as Producto, a.cuenta_c as Cuenta, a.valor_prospectado_c as Prospeccion, c.probability as Probabilidad
FROM m1_oportunidad_productos_cstm a, m1_oportunidad_productos b, opportunities c, users d
WHERE a.oportunidad_c = c.name
AND a.id_c = b.id
AND a.estado_c = '1'
AND d.id = b.assigned_user_id
AND c.deleted = '0'
and c.deleted = '0'";
	$resultado.= "\n AND a.anio_c = '".$periodo."'\n";
	if($result_probabilidades != "AND c.probability IN('','')")
	{
		$resultado.=$result_probabilidades."\n";
	}
	if($mes == '10' || $mes == '11' || $mes == '12')
	{
		if($visualizacion == 'Individual')
		{
			$resultado.= "AND a.mes_c = ".$mes."\n";
		}
		else
		{
			$resultado.= "AND a.mes_c <= ".$mes."\n";
		}
	}
	else
	{
		if($visualizacion == 'Individual')
		{
			$resultado.= "AND a.mes_c = '".$mes."'\n";
		}
		else
		{
			$resultado.= "AND a.mes_c <= '".$mes."'\n";
		}
	}
	if($cuenta != '')
	{
		$resultado.= "AND a.cuenta_c = '".$cuenta."'\n";
	}
	if($result_relacionadores != 'AND a.id_usuario_c IN)')
	{
		$resultado.=$result_relacionadores."\n";
	}
	if($result_lineas != "AND a.categoria_c IN('','')")
	{
		$resultado.=$result_lineas."\n";
	}
	if($result_productos != "AND a.producto_c IN('','')")
	{
		$resultado.=$result_productos."\n";
	}
	$resultado.= "GROUP BY a.usuario_c, a.producto_c, a.cuenta_c, a.oportunidad_c\n";
	$resultado.= $ordenar;
	$resultado = str_replace("&#039;", "'", $resultado);
}
else if($reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador')
{
	$resultado.="CREATE TEMPORARY TABLE temp1
AS (SELECT id_usuario_c AS Relacionador, SUM(a.valor_prospectado_c) AS Prospectado, sum((a.valor_prospectado_c*c.probability)/100) as Estimado
FROM m1_oportunidad_productos_cstm a, opportunities c
WHERE c.name = a.oportunidad_c
AND a.estado_c = '1'
AND c.deleted = '0'";
	$resultado.= "\n AND a.anio_c = '".$periodo."'\n";
	if($result_probabilidades != "AND c.probability IN('','')")
	{
		$resultado.=$result_probabilidades."\n";
	}
	$resultado.= "AND a.mes_c between ".$mes." and ".$mes2."\n";

	if($result_relacionadores != 'AND a.id_usuario_c IN)')
	{
		$resultado.=$result_relacionadores."\n";
	}
	if($result_lineas != "AND a.categoria_c IN('','')")
	{
		$resultado.=$result_lineas."\n";
	}
	if($result_productos != "AND a.producto_c IN('','')")
	{
		$resultado.=$result_productos."\n";
	}
	$resultado.= "GROUP BY a.id_usuario_c";
	if($visualizacion == 'Individual')
	{
		$resultado.= ", c.probability)\n";
	}
	else
	{
		$resultado.= ")\n";
	}
	$resultado.="@";
	$resultado.="CREATE TEMPORARY TABLE temp2
AS (SELECT b.assigned_user_id AS Relacionador, SUM(a.valor_c) AS Presupuesto
FROM presupuestos_cstm a, presupuestos b 
WHERE a.id_c = b.id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'";
	$resultado.= "\n AND a.nombre_periodo_c = '".$periodo."'\n";
	$resultado.= "AND a.id_mes_c between ".$mes." and ".$mes2."\n";

	if($result_relacionadores2 != 'AND b.assigned_user_id IN)')
	{
		$resultado.=$result_relacionadores2."\n";
	}
	if($result_lineas2 != "AND a.nombre_linea_c IN('','')")
	{
		$resultado.=$result_lineas2."\n";
	}
	if($result_productos2 != "AND a.nombre_producto_c IN('','')")
	{
		$resultado.=$result_productos2."\n";
	}
	$resultado.= "GROUP BY b.assigned_user_id)";
	$resultado = str_replace("&#039;", "'", $resultado);
}
else if($reporte == 'Historico de ventas por relacionador semanal')
{
	$resultado.="CREATE TEMPORARY TABLE temp1
AS (SELECT id_usuario_c AS Relacionador, SUM(a.valor_prospectado_c) AS Prospectado, sum((a.valor_prospectado_c*c.probability)/100) as Estimado, MONTH(c.date_entered) AS Mes, WEEK(c.date_entered) AS Semanas
FROM m1_oportunidad_productos_cstm a, opportunities c
WHERE c.name = a.oportunidad_c
AND a.estado_c = '1'
AND c.deleted = '0'";
	$resultado.= "\n AND a.anio_c = '".$periodo."'\n";
	if($result_probabilidades != "AND c.probability IN('','')")
	{
		$resultado.=$result_probabilidades."\n";
	}
	$resultado.= "AND a.mes_c between ".$mes." and ".$mes2."\n";

	if($result_relacionadores != 'AND a.id_usuario_c IN)')
	{
		$resultado.=$result_relacionadores."\n";
	}
	if($result_lineas != "AND a.categoria_c IN('','')")
	{
		$resultado.=$result_lineas."\n";
	}
	if($result_productos != "AND a.producto_c IN('','')")
	{
		$resultado.=$result_productos."\n";
	}
	if($semanal_mensual == 'Semanal')
	{
		$resultado.= "GROUP BY a.id_usuario_c, Semanas)";
	}
	else
	{
		$resultado.= "GROUP BY a.id_usuario_c, Mes)";
	}
	$resultado.="@";
	if($semanal_mensual == 'Semanal')
	{
		$resultado.="CREATE TEMPORARY TABLE temp2
AS (SELECT b.assigned_user_id AS Relacionador, (SUM(a.valor_c)/4) AS Presupuesto, MONTH(CONCAT(a.nombre_periodo_c,'/',a.id_mes_c,'/27')) AS Mes, WEEK(CONCAT(a.nombre_periodo_c,'/',a.id_mes_c,'/27')) AS Semanas
FROM presupuestos_cstm a, presupuestos b 
WHERE a.id_c = b.id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'";
	}
	else
	{
		$resultado.="CREATE TEMPORARY TABLE temp2
AS (SELECT b.assigned_user_id AS Relacionador, SUM(a.valor_c) AS Presupuesto, MONTH(CONCAT(a.nombre_periodo_c,'/',a.id_mes_c,'/27')) AS Mes, WEEK(CONCAT(a.nombre_periodo_c,'/',a.id_mes_c,'/27')) AS Semanas
FROM presupuestos_cstm a, presupuestos b 
WHERE a.id_c = b.id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'";
	}
	$resultado.= "\n AND a.nombre_periodo_c = '".$periodo."'\n";
	$resultado.= "AND a.id_mes_c between ".$mes." and ".$mes2."\n";

	if($result_relacionadores2 != 'AND b.assigned_user_id IN)')
	{
		$resultado.=$result_relacionadores2."\n";
	}
	if($result_lineas2 != "AND a.nombre_linea_c IN('','')")
	{
		$resultado.=$result_lineas2."\n";
	}
	if($result_productos2 != "AND a.nombre_producto_c IN('','')")
	{
		$resultado.=$result_productos2."\n";
	}
	if($semanal_mensual == 'Semanal')
	{
		$resultado.= "GROUP BY b.assigned_user_id, Semanas)";
	}
	else
	{
		$resultado.= "GROUP BY b.assigned_user_id, Mes)";
	}
	$resultado = str_replace("&#039;", "'", $resultado);
}
else if($reporte == 'Mapa de relacionadores')
{
$resultado.="SELECT a.nombre_cuenta_c AS Cuenta, a.nombre_producto_c AS producto, CONCAT(c.first_name,' ',c.last_name) AS Usuario
FROM detalle_asig_producto_cstm a, detalle_asig_producto b, users c
WHERE b.assigned_user_id = c.id
AND b.id = a.id_c
AND a.estatus_c = 'Aprobado'
AND a.nombre_producto_c not in('Dolce Vita','Libro Inmobiliario')\n";
	if($result_productos != "AND a.nombre_producto_c IN('','')")
	{
		$resultado.=$result_productos."\n";
	}
	if($result_relacionadores != 'AND b.assigned_user_id IN)')
	{
		$resultado.=$result_relacionadores."\n";
	}
	$resultado.= "GROUP BY a.nombre_cuenta_c, a.nombre_producto_c
ORDER BY a.nombre_producto_c, a.nombre_cuenta_c";
	$resultado = str_replace("&#039;", "'", $resultado);
}
else if($reporte == 'Presupuesto mensual por producto')
{
	$resultado.="SELECT a.nombre_producto_c as Producto, a.id_mes_c, a.valor_c
FROM presupuestos_cstm a, presupuestos b, product_templates c
WHERE a.nombre_producto_c = c.name
AND a.estatus_c = 'Aprobado'
AND a.id_c = b.id
AND a.tipo_c = 'totales'
AND c.deleted = '0'";
$resultado.= "\nAND a.nombre_periodo_c = '".$periodo."'\n";
$resultado.= "ORDER BY a.num_ordena_c\n";
	
}
else if($reporte == 'Presupuesto mensual por relacionador')
{
		$resultado.="SELECT CONCAT(d.first_name,' ',d.last_name) AS Relacionador, a.id_mes_c, sum(a.valor_c)
FROM presupuestos_cstm a, presupuestos b, product_templates c, users d
WHERE a.nombre_producto_c = c.name
AND b.assigned_user_id = d.id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'
AND a.id_c = b.id
AND c.deleted = '0'";
$resultado.= "\nAND a.nombre_periodo_c = '".$periodo."'\n";
$resultado.= "GROUP BY a.id_mes_c, CONCAT(d.first_name,' ',d.last_name)
ORDER BY a.num_ordena_c, CONCAT(d.first_name,' ',d.last_name) asc\n";
}
else if($reporte == 'Presupuesto por relacionador por producto')
{
		$resultado.="SELECT CONCAT(c.first_name,' ',c.last_name) AS Relacionador, a.nombre_producto_c, sum(a.valor_c)
FROM presupuestos_cstm a, presupuestos b, users c
WHERE b.assigned_user_id = c.id
AND a.estatus_c = 'Aprobado'
AND a.tipo_c = 'distribucion'
AND a.id_c = b.id";
$resultado.= "\nAND a.nombre_periodo_c = '".$periodo."'\n";
$resultado.= "GROUP BY a.nombre_producto_c, CONCAT(c.first_name,' ',c.last_name) ASC\n";
}
else if($reporte == 'Presupuesto por producto por relacionador por mes')
{
		$resultado.="SELECT nombre_producto_c
FROM presupuestos_cstm
WHERE nombre_producto_c NOT IN('Dolce Vita','Libro Inmobiliario')
AND valor_c <> ''
AND valor_c IS NOT NULL";
$resultado.= "\nAND nombre_periodo_c = '".$periodo."'\n";
$resultado.= "GROUP BY nombre_producto_c
ORDER BY nombre_producto_c ASC\n";
}
else if($reporte == 'Ranking de Clientes')
{
		$resultado.="SELECT b.name as Empresa, SUM(e.valor_prospectado_c) AS Ventas, e.usuario_c as Relacionador, c.calle_principal_c as Direccion, b.phone_office as Telefono, c.ciudad_c as Ciudad
FROM opportunities a, accounts b, accounts_cstm c, accounts_opportunities d, m1_oportunidad_productos_cstm e
WHERE a.id = d.opportunity_id
AND b.id = d.account_id
AND b.id = c.id_c
AND e.oportunidad_c = a.name
AND e.estado_c = '1'
AND a.deleted = '0'
AND a.probability = '100'";
$resultado.= "\nAND e.anio_c = '".$periodo."'\n";
$resultado.= "AND e.mes_c between ".$mes." and ".$mes2."\n";
if($result_relacionadores3 != 'AND e.id_usuario_c IN)')
{
	$resultado.=$result_relacionadores3."\n";
}
if($result_lineas3 != "AND a.categoria_c IN('','')")
{
	$resultado.=$result_lineas3."\n";
}
if($result_productos3 != "AND a.producto_c IN('','')")
{
	$resultado.=$result_productos3."\n";
}
$resultado.= "GROUP BY b.id
ORDER BY Ventas DESC\n";
}
else if($reporte == 'Cuentas asignadas sin actividades')
{
		$resultado.="SELECT DISTINCT(a.name) AS Empresa, a.date_entered, a.date_modified
FROM accounts a, detalle_asig_producto_cstm b, detalle_asig_producto c
WHERE b.account_id_c = a.id
AND b.id_c = c.id
AND b.estatus_c = 'Aprobado'
AND a.deleted = '0'
AND a.id NOT IN(SELECT account_id FROM accounts_opportunities WHERE deleted = '0')\n";
if($result_relacionadores4 != 'AND c.assigned_user_id IN)')
{
	$resultado.=$result_relacionadores4."\n";
}
if($result_lineas4 != "AND b.nombre_linea_c IN('','')")
{
	$resultado.=$result_lineas4."\n";
}
if($result_productos4 != "AND b.nombre_producto_c IN('','')")
{
	$resultado.=$result_productos4."\n";
}
$resultado.= "ORDER BY a.name ASC\n";
}
else
{}

echo $resultado;
?>