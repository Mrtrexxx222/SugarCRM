<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$resultado="";
$i=1;
$resultado.="<table id='productos' class='panelContainer' cellspacing='0' cellpadding='0'>
				<tbody>
					<tr>
						<td><b>LINEA</b></td>
						<td><b>PRODUCTO</b></td>
						<td><b>VALOR PROSPECTADO<b></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><b>FORMA DE PAGO<b></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><b>DESCRIPCION<b></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><b>RELACIONADOR<b></td>
					</tr>";
					$db =  DBManagerFactory::getInstance();
					$query = "SELECT a.id AS id_producto, a.name AS name_producto, a.category_id AS id_categoria, b.name AS name_categoria FROM product_templates a, product_categories b WHERE a.category_id = b.id AND a.deleted = 0 and b.deleted = '0' ORDER BY b.name asc, a.name ASC";
					$result = $db->query($query, true, 'Error selecting the product record');
					while($row=$db->fetchByAssoc($result))
					{
						$resultado.="<tr>
										<td name='categoria' id='".$row['id_categoria']."'>".$row['name_categoria']."</td>
										<td name='producto' id='".$row['id_producto']."'>".$row['name_producto']."</td>
										<td><input type='text' name='prospecto' id='valor_".$row['id_producto']."' onblur='habilita();' onchange='calcula();'/></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><input type='text' name='forma_pago' id='forma_pago_".$row['id_producto']."' /></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><input type='text' name='descripcion' id='descripcion_".$row['id_producto']."' /></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td name='relacionador' id='".$i."'></td>
									</tr>";
						$i++;
					}
	$resutlado.="</tbody>
			</table>";
		echo $resultado;
?>