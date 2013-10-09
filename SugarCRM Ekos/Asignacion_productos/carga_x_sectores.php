<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$resultado 	= "";
$op_carga	= $_POST['op_carga'];
$db =  DBManagerFactory::getInstance();

//CARGA COMBO CON LAS CUENTAS
if($op_carga == 'cuentas')
{
	//$id_cuenta 	= $_POST['id_cuenta'];
	$query = "select id, name from accounts where deleted = '0' order by name ASC";
	$result = $db->query($query, true, 'Error selecting the user record');
	$resultado.= "<select id='cuentas'>";
	while($row=$db->fetchByAssoc($result))
	{
		
			$resultado.= "<option value='".$row['id']."' id='".$row['id']."'>".trim($row['name'])."</option>";    
		
	}
	$resultado.= "</select>";	
}
//CARGA TABLA MATRIZ DE ASIGNACIONES
if($op_carga == 'matriz')
{
	$cuenta = $_POST['id_cuenta'];
	$_SESSION['cuenta'] = $cuenta;
	$i=1;
	$j=1;
	$resultado.="<table id='DEFAULT2' width='100%' border='0' cellspacing='0' cellpadding='0' class='edit view'>
			<tbody>
				<tr>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Linea de Producto</b></font></td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Productos/Usuarios</b></font></td>";
					$cuenta_record = new Account();
					$cuenta_record->retrieve_by_string_fields(array('id'=>$cuenta));
					$id=$cuenta_record->id;
					$db =  DBManagerFactory::getInstance();
					$query = "SELECT u.id, u.first_name, u.last_name FROM users u, acl_roles_users a, acl_roles b, detalle_asig_producto c, detalle_asig_producto_cstm d, product_templates e WHERE u.id = a.user_id AND a.role_id = b.id AND a.deleted = '0' AND u.deleted = '0' AND u.status = 'Active' AND b.name IN('Comercial','Jefe de Ventas') AND u.id <> '1' AND c.id = d.id_c AND d.estatus_c = 'Aprobado' AND c.assigned_user_id = u.id AND e.id = d.producttemplate_id_c GROUP BY u.id ORDER BY u.last_name";
					$result = $db->query($query, true, 'Error selecting the user record');
					while($row=$db->fetchByAssoc($result))
					{
						$resultado.="<td id = 'usuario".$i."' style='border:1px solid; border-color: #D8D8D8;'>".$row['first_name']." ".$row['last_name']."<p style='display:none;'>".$row['id']."</p></td>";
						$i++;
					}
					$i=1;
	$resultado.="</tr>";
					$query = "SELECT a.id AS id_producto, a.name AS name_producto, a.category_id AS id_categoria, b.name AS name_categoria FROM product_templates a, product_categories b WHERE a.category_id = b.id and a.deleted = 0 and b.deleted = '0' ORDER BY b.name ASC, a.name ASC";
					$result = $db->query($query, true, 'Error selecting the user record');
					while($row=$db->fetchByAssoc($result))
					{
	$resultado.="<tr>
					<td id ='linea".$j."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row['name_categoria']."</td>
					<td id = 'producto".$j."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row['name_producto']."</td>";
						$db2 =  DBManagerFactory::getInstance();
						$query2 = "SELECT u.id, u.first_name, u.last_name FROM users u, acl_roles_users a, acl_roles b, detalle_asig_producto c, detalle_asig_producto_cstm d, product_templates e WHERE u.id = a.user_id AND a.role_id = b.id AND a.deleted = '0' AND u.deleted = '0' AND u.status = 'Active' AND b.name IN('Comercial','Jefe de Ventas') AND u.id <> '1' AND c.id = d.id_c AND d.estatus_c = 'Aprobado' AND c.assigned_user_id = u.id AND e.id = d.producttemplate_id_c GROUP BY u.id ORDER BY u.last_name";
						$result2 = $db2->query($query2, true, 'Error selecting the product record');
						while($row2=$db2->fetchByAssoc($result2))
						{
							$resultado.="<td id = '".$row['id_producto']."_".$row2['id']."' style='border:1px solid; border-color:#eee;white-space: nowrap;' onclick='toogledisplay(this.id,1);'>";
							$det_asig_prod = new Detalle_asig_producto();
							$det_asig_prod->retrieve_by_string_fields(array('assigned_user_id'=>$row2['id'],'account_id_c'=>$id,'producttemplate_id_c'=>$row['id_producto']));
							if($det_asig_prod->id)
							{
								if($det_asig_prod->estatus_c == 'Solicitar')
								{
									$resultado.="<p id='usuario".$i."producto".$j."'>Por aprobar</p>";
								}
								else if($det_asig_prod->estatus_c == 'No aprobado')
								{
									$resultado.="<p id='usuario".$i."producto".$j."'>No aprobado</p>";
								}
								else
								{
									$resultado.="<p id='usuario".$i."producto".$j."'>Aprobado</p>";
								}
					$resultado.="<select id='select".$i."_".$j."' onblur='cambia(this.id);' style='display:none;'>
									<option>Aprobado</option>
									<option>No aprobado</option>
								</select>";
							}
							else
							{
								$resultado.="<p id='usuario".$i."producto".$j."'> </p>
								<select id='select".$i."_".$j."' onblur='cambia(this.id);' style='display:none;'>
									<option> </option>
									<option>Aprobado</option>
									<option>No aprobado</option>
								</select>";
							}
		$resultado.="</td>";
							$i++;
						}
						$j++;
						$i=1;
	$resultado.="</tr>";
					}
	$resultado.="</tbody>";
	$resultado.="</table>";	
}
//CARGA SECTOR PARA LA CREACION DE ASIGNACION
if($op_carga == 'relacionadores')
{
	$query = "SELECT u.id, u.first_name, u.last_name FROM users u, acl_roles_users a, acl_roles b, detalle_asig_producto c, detalle_asig_producto_cstm d, product_templates e WHERE u.id = a.user_id AND a.role_id = b.id AND a.deleted = '0' AND u.deleted = '0' AND u.status = 'Active' AND b.name IN('Comercial','Jefe de Ventas') AND u.id <> '1' AND c.id = d.id_c AND d.estatus_c = 'Aprobado' AND c.assigned_user_id = u.id AND e.id = d.producttemplate_id_c GROUP BY u.id ORDER BY u.last_name";
	$result = $db->query($query, true, 'Error selecting the user record');
	$resultado.= "<table width='100%' border='0' cellspacing='0' cellpadding='0' class='edit view'><tbody><tr><td>";
	$resultado.= "<select id='relacionadores'>";
	while($row=$db->fetchByAssoc($result))
	{	
		$resultado.= "<option value='".$row['id']."' id='".$row['id']."'>".trim($row['first_name'].' '.$row['last_name'])."</option>";    
	}
	$resultado.= "</select>";
	$resultado.= "<input id='crear_asignacion' class='button' type='button' value='Crear Asignacion' onclick='crear_asignacion();'>";	
	$resultado.= "</td></tr></tbody></table>";
}

echo $resultado;
?>