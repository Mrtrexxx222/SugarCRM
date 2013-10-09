<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$resultado="";
$id_oportunidad = $_POST['id_oportunidad'];
$id_cuenta = $_POST['id_cuenta'];
$id_usuario = $_POST['id_usuario'];

$db =  DBManagerFactory::getInstance();
$query = "SELECT e.id as contacto_id FROM opportunities a, quotes b, quotes_opportunities c, quotes_contacts d, contacts e WHERE a.id = c.opportunity_id AND b.id = c.quote_id AND b.id = d.quote_id AND c.quote_id = d.quote_id AND d.contact_id = e.id AND a.id = '".$id_oportunidad."'";
$result = $db->query($query, true, 'Error selecting the oportunity record');
if($row=$db->fetchByAssoc($result))
{
	$id_contacto = $row['contacto_id'];
}

$resultado.="	<table id='informacion_contrato' class='panelContainer' cellspacing='0' cellpadding='0'>
					<tbody>";
						$db =  DBManagerFactory::getInstance();
						$query = "SELECT a.*, b.* FROM accounts_cstm a, accounts b WHERE a.id_c = b.id and a.id_c = '".$id_cuenta."'";
						$result = $db->query($query, true, 'Error selecting the account record');
						if($row=$db->fetchByAssoc($result))
						{
				$resultado.="<tr>
								<td><b>CUENTA</b></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Tipo de Identificacion</td>
								<td>".$row['tipo_identificacion_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Identificacion</td>
								<td>".$row['identificacion_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Razon Social</td>
								<td>".$row['name']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Nombre comercial o marca</td>
								<td>".$row['nombre_comercial_marca_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Telefono</td>
								<td>".$row['phone_office']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Ciudad</td>
								<td>".$row['ciudad_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Calle Principal</td>
								<td>".$row['calle_principal_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Numero</td>
								<td>".$row['numero_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Calle Secundaria</td>
								<td>".$row['calle_secundaria']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Edificio</td>
								<td>".$row['edificio_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Piso/Oficina</td>
								<td>".$row['piso_oficina_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Sector</td>
								<td>".$row['sector_c']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Referencia</td>
								<td>".$row['referencia_c']."</td>
								<td></td>
							</tr>";
						}
						$db =  DBManagerFactory::getInstance();
						$query = "SELECT a.*, b.*, d.email_address FROM contacts_cstm a, contacts b, email_addr_bean_rel c, email_addresses d WHERE a.id_c = b.id AND b.id = c.bean_id AND c.email_address_id = d.id AND a.id_c = '".$id_contacto."'";
						$result = $db->query($query, true, 'Error selecting the contact record');
						if($row=$db->fetchByAssoc($result))
						{
				$resultado.="<tr>
								<td><b>CONTACTO</b></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Nombres y Apellidos</td>
								<td>".$row['first_name']." ".$row['last_name']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Cargo</td>
								<td>".$row['title']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Email</td>
								<td>".$row['email_address']."</td>
								<td></td>
							</tr>";
						}
						$db =  DBManagerFactory::getInstance();
						$query = "SELECT b.quote_num, b.payment_terms, TRUNCATE(b.subtotal,2) AS subtotal, TRUNCATE(b.deal_tot,2) AS deal_tot, TRUNCATE(b.tax,2) AS tax, TRUNCATE(b.total,2) AS total FROM quotes_cstm a, quotes b, opportunities c, quotes_opportunities d  WHERE a.id_c = b.id AND c.id = d.opportunity_id AND b.id = d.quote_id AND c.id = '".$id_oportunidad."'";
						$result = $db->query($query, true, 'Error selecting the quotes records');
						while($row=$db->fetchByAssoc($result))
						{
				$resultado.="<tr>
								<td><b>COTIZACION</b></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Codigo</td>
								<td>".$row['quote_num']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Forma de pago</td>
								<td>".$row['payment_terms']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Subtotal</td>
								<td>".$row['subtotal']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Descuento</td>
								<td>".$row['deal_tot']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Iva</td>
								<td>".$row['tax']."</td>
								<td></td>
							</tr>
							<tr>
								<td>Total</td>
								<td>".$row['total']."</td>
								<td></td>
							</tr>";
						}
				$resultado.="<tr>
								<td><b>PRODUCTOS</b></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Producto</td>
								<td>Cantidad</td>
								<td>Precio</td>
							</tr>";
						$db =  DBManagerFactory::getInstance();
						$query = "SELECT d.name, d.quantity, TRUNCATE(d.discount_price,2) AS discount_price FROM opportunities a, quotes b, quotes_opportunities c, products d, product_bundle_quote e, product_bundle_product f, product_bundles g WHERE a.id = c.opportunity_id AND b.id = c.quote_id AND b.id = e.quote_id AND e.bundle_id = g.id AND g.id = f.bundle_id AND f.product_id = d.id AND a.id = '".$id_oportunidad."'";
						$result = $db->query($query, true, 'Error selecting the products records');
						while($row=$db->fetchByAssoc($result))
						{
				$resultado.="<tr>
								<td>".$row['name']."</td>
								<td>".$row['quantity']."</td>
								<td>".$row['discount_price']."</td>
							</tr>";
						}

		$resutlado.="</tbody>
				</table>";

		echo $resultado;
?>