<?php
$db = DBManagerFactory::getInstance();
//abro el archivo solo lectura que contiene el query
$nombre = "custom/modules/Opportunities/Array_detalle.txt";
$fp     = fopen($nombre,"r"); 
$sql_txt  = fread($fp,filesize($nombre));
fclose($fp);
//OBTIENE LOS DATOS NECESARIOS PARA MOSTRAR LOS DATOS
$parametro = $_REQUEST['sel'];
$datosPipe = explode(",", $parametro);
//REEMPLAZA CARACTERES ESPECIALES EN EL QUERY  
$sql_reemplaza = str_replace("&#039;","'",$sql_txt); 
$query = str_replace("&lt;","<",$sql_reemplaza); 

?>

<table id='DEFAULT' width='100%' border='0' cellspacing='0' cellpadding='0' class='edit view'>
	<tbody>
        <tr >
			<th colspan='10' style='color:#888888; background-color:#FFFFFF;' align='left'><font size='3'><?php echo $datosPipe[0];?> - DETALLE</font></th>
		</tr>
		<tr height="40" class="border_bottom">
			<th style='color:#888888; background-color:#F0F0F0;'><font size='2'>A&ntilde;o</font></th>
			<th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Mes</font></th>
			<th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Relcionador</font></th>
			<th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Farming</font></th>
			<th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Oportunidad</font></th>
			<th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Produto</font></th>
            <th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Cuenta</font></th>
            <th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Prospeccion</font></th>
            <th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Probabilidad</font></th>
            <th style='color:#888888; background-color:#F0F0F0;'><font size='2'>Facturacion Estimada</font></th>
		</tr>
<?php
$result = $db->query($query, true, 'Error selecting the opportunities record');
$total=0;
$valor=0;
$probabilidad=0;
$total_presupuestado = 0;
$total_facturado = 0;
setlocale(LC_MONETARY, 'en_US');
while($row=$db->fetchByAssoc($result))
{   
    if($row['Probabilidad']==$datosPipe[2])
    {
	?>
	   <tr height="40" class="border_bottom">
		<td align="left" valign="top" class=""><?php echo $row['Anio'] ?></td>
        <td align="left" valign="top" class="">
        <?php 
        $value = $row['Mes'];  
        if($value == 1)
		{
			$value = "Enero";
		}
		else if($value == 2)
		{
			$value = "Febrero";
		}
		else if($value == 3)
		{
			$value = "Marzo";
		}
		else if($value == 4)
		{
			$value = "Abril";
		}
		else if($value == 5)
		{
			$value = "Mayo";
		}
		else if($value == 6)
		{
			$value = "Junio";
		}
		else if($value == 7)
		{
			$value = "Julio";
		}
		else if($value == 8)
		{
			$value = "Agosto";
		}
		else if($value == 9)
		{
			$value = "Septiembre";
		}
		else if($value == 10)
		{
			$value = "Octubre";
		}
		else if($value == 11)
		{
			$value = "Noviembre";
		}
		else if($value == 12)
		{
			$value = "Diciembre";
		}
        echo $value;
        ?></td>
        <td align="left" valign="top" class=""><?php echo $row['Relacionador'] ?></td>
        <td align="left" valign="top" class=""><?php echo $row['Farming'] ?></td>  
        <td onclick="envia('<?php echo $row['id_Op'] ?>');" align="left" valign="top" class=""><a href='#'><?php echo $row['Oportunidad'] ?></a></td>
		<td align="left" valign="top" class=""><?php echo $row['Producto'] ?></td>		
		<td align="left" valign="top" class=""><?php echo $row['Cuenta'] ?></td>
        <td align="right" valign="top" class="">
        <?php         
        $valor = $row['Prospeccion'];				
		$total_presupuestado = $total_presupuestado + $valor;
        $valor2 = money_format('%.2n', $valor);        
        echo  $valor2;        
        ?></td>
        <td align="center" valign="top" class=""><?php echo $row['Probabilidad'] ?>%</td>
        <td align="right" valign="top" class="">
        <?php 
        
        $multi = $valor*$row['Probabilidad'];
    	$facturacion = $multi/100;
    	$total_facturado = $total_facturado + $facturacion;    	
    	$facturacion = money_format('%.2n', $facturacion);
        echo $facturacion;
        ?></td>
	</tr>
    
<?php
    }
}
$total_presupuestado = money_format('%.2n', $total_presupuestado);
$total_facturado = money_format('%.2n', $total_facturado);
?>
	<tr height="40" class="border_bottom">
		<td align="left" valign="top" class=""><b>TOTAL</b></td>
		<td align="left" valign="top" class=""></td>
		<td align="left" valign="top" class=""></td>
        <td align="left" valign="top" class=""></td>
		<td align="left" valign="top" class=""></td>
        <td align="left" valign="top" class=""></td>
		<td align="left" valign="top" class=""></td>
		<td align="right" valign="top" class=""><b><?php echo $total_presupuestado ?></b></td>
		<td align="left" valign="top" class=""></td>		
        <td align="right" valign="top" class=""><b><?php echo $total_facturado ?></b></td>
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