<table id='DEFAULT' width='100%' border='0' cellspacing='0' cellpadding='0' class='list view'>
	<tbody>
		<tr height="40" class="border_bottom">
			<td style='color:#888888; background-color:#F0F0F0;'><font size='2'><b>Nombre</b></font></td>
			<td style='color:#888888; background-color:#F0F0F0;'><font size='2' width='400'><b>Cuenta</b></font></td>
			<td style='color:#888888; background-color:#F0F0F0;'><font size='2'><b>Asignado a la Oportunidad</b></font></td>
			<td style='color:#888888; background-color:#F0F0F0;'><font size='2'><b>Cantidad</b></font></td>
			<td style='color:#888888; background-color:#F0F0F0;'><font size='2'><b>Fecha de creacion</b></font></td>
			<td style='color:#888888; background-color:#F0F0F0;'><font size='2'><b>Fecha de cierre</b></font></td>
		</tr>
<?php
$db =  DBManagerFactory::getInstance();
$parametro = $_REQUEST['parametro'];
$partes = explode("/", $parametro);
if($partes[1] == 'mes')
{
	$anio = $partes[0];
	$mes = $partes[2];
	$meses = explode("-", $partes[2]);
	$relacionadores = explode("-", $partes[3]);
	$productos = explode("-", $partes[4]);
	
	$result_meses.= "AND a.mes_c IN (";
	for($i=0;$i<=count($meses);$i++)
	{
		$result_meses.= "'".$meses[$i]."',";
	}
	$result_meses = substr($result_meses, 0, -4);
	$result_meses.=")";

	$result_relacionadores.= "AND a.usuario_c IN (";
	for($i=0;$i<=count($relacionadores);$i++)
	{
		$result_relacionadores.= "'".$relacionadores[$i]."',";
	}
	$result_relacionadores = substr($result_relacionadores, 0, -4);
	$result_relacionadores.=")";

	$result_productos.= "AND a.producto_c IN (";
	for($i=0;$i<=count($productos);$i++)
	{
		$result_productos.= "'".$productos[$i]."',";
	}
	$result_productos = substr($result_productos, 0, -4);
	$result_productos.=")";

	$query = "SELECT a.*, b.date_entered,b.id, b.date_closed,b.name from m1_oportunidad_productos_cstm a, opportunities b where a.anio_c = '".$anio."' AND b.probability = '100' AND a.oportunidad_c = b.name AND a.estado_c = '1' and b.deleted = '0'";
	$query.= $result_relacionadores;
	$query.= $result_productos;
	$query.= $result_meses;
	$query.="order by b.date_closed ASC";
	$result = $db->query($query, true, 'Error selecting the opportunities record');
}
if($partes[1] == 'producto')
{
	$anio = $partes[0];
	$producto = $partes[2];
	$mes = explode("-", $partes[3]);
	$relacionador = explode("-", $partes[4]);

	$result_relacionadores.= "AND a.usuario_c IN (";
	for($i=0;$i<=count($relacionador);$i++)
	{
		$result_relacionadores.= "'".$relacionador[$i]."',";
	}
	$result_relacionadores = substr($result_relacionadores, 0, -4);
	$result_relacionadores.=")";

	$result_mes.= "AND a.mes_c IN (";
	for($i=0;$i<=count($mes);$i++)
	{
		$result_mes.= "'".$mes[$i]."',";
	}
	$result_mes = substr($result_mes, 0, -4);
	$result_mes.=")";

	$query = "SELECT a.*, b.date_entered,b.id, b.date_closed,b.name from m1_oportunidad_productos_cstm a, opportunities b where a.producto_c = '".$producto."' AND a.anio_c = '".$anio."' AND b.probability = '100' AND a.oportunidad_c = b.name AND a.estado_c = '1' and b.deleted = '0'";
	$query.= $result_relacionadores;
	$query.= $result_mes;
	$query.="order by b.date_closed ASC";
	$result = $db->query($query, true, 'Error selecting the opportunities record');
}
if($partes[1] == 'relacionador')
{
	$anio = $partes[0];
	$relacionador = $partes[2];
	$producto = explode("-", $partes[3]);
	$mes = explode("-", $partes[4]);

	$result_productos.= "AND a.producto_c IN (";
	for($i=0;$i<=count($producto);$i++)
	{
		$result_productos.= "'".$producto[$i]."',";
	}
	$result_productos = substr($result_productos, 0, -4);
	$result_productos.=")";
	
	$result_mes.= "AND a.mes_c IN (";
	for($i=0;$i<=count($mes);$i++)
	{
		$result_mes.= "'".$mes[$i]."',";
	}
	$result_mes = substr($result_mes, 0, -4);
	$result_mes.=")"; 

	$query = "SELECT a.*, b.date_entered,b.id, b.date_closed,b.name from m1_oportunidad_productos_cstm a, opportunities b where a.usuario_c = '".$relacionador."' AND a.anio_c = '".$anio."' AND b.probability = '100' AND a.oportunidad_c = b.name AND a.estado_c = '1' and b.deleted = '0'";
	$query.= $result_productos;
	$query.= $result_mes;
	$query.="order by b.date_closed ASC";
	$result = $db->query($query, true, 'Error selecting the opportunities record');
}
//echo $query;
$total=0;
while($row=$db->fetchByAssoc($result))
{
	$total = $total + $row['valor_prospectado_c'];
	$usuario = new User();
	$usuario->retrieve_by_string_fields(array('id'=>$row['id_usuario_c']));
	$nombres = $usuario->first_name." ".$usuario->last_name;
	$subfecha = explode(" ",$row['date_entered']);
	$fecha_creacion = $subfecha[0];
	
	$query2 = "SELECT account_id FROM accounts_opportunities WHERE opportunity_id = '".$row['id']."'";
	$result2 = $db->query($query2, true, 'Error selecting the account_opportunity record');
	if($row2=$db->fetchByAssoc($result2))
	{
		$cuenta = new Account();
		$cuenta->retrieve_by_string_fields(array('id'=>$row2['account_id']));
		$nombre_cuenta = $cuenta->name;
	}
	setlocale(LC_MONETARY, 'en_US');
	$monto = money_format('%.2n', $row['valor_prospectado_c']);?>
	<tr height="40" class="border_bottom">
		<td onclick="envia('<?php echo $row['id'] ?>');" align="left" valign="top" class=""><a href='#'><?php echo $row['name'] ?></a></td>
		<td align="left" valign="top" class="" width='400'><?php echo $nombre_cuenta ?></td>
		<td align="left" valign="top" class=""><?php echo $nombres ?></td>
		<td align="left" valign="top" class=""><?php echo $monto ?></td>
		<td align="left" valign="top" class=""><?php echo $fecha_creacion ?></td>
		<td align="left" valign="top" class=""><?php echo $row['date_closed'] ?></td>
	</tr>
<?php
}
$total = money_format('%.2n', $total); ?>
	<tr height="40" class="border_bottom">
		<td align="left" valign="top" class=""><b>TOTAL</b></td>
		<td align="left" valign="top" class="" width='400'></td>
		<td align="left" valign="top" class=""></td>
		<td align="left" valign="top" class=""><b><?php echo $total ?></b></td>
		<td align="left" valign="top" class=""></td>
		<td align="left" valign="top" class=""></td>
	</tr>
<?php
$resultado.="</tbody>
		</table>
		<script type='text/JavaScript'>
		function envia(id)
		{
			var url = 'index.php?module=Opportunities&action=DetailView&record='+id;
			window.open(url, '_blank');
		}
		</script>";
echo $resultado;
?>
<style>
tr.border_bottom td {
  border-bottom:1pt solid grey;
}
</style>