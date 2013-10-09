<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$i=1;
$j=1;
$cuenta='';
if($_REQUEST['cuenta'])
{
	$cuenta = $_REQUEST['cuenta'];
}
$resultado.="<script type='text/JavaScript' src='include/javascript/sugarwidgets/SugarYUIWidgets.js'></script> ";
$resultado.="<div id='ajaxStatusDiv' class='dataLabel' style='left: 45%; display: none;'><font size='3'>Cargando...</font></div>
			 <div id='Asignacion_productos_SearchForm_custom' style class='detail view  detail508'>
				<table width='100%' cellspacing='0' cellpadding='0' border ='0'>
					<tbody>
						<tr>
							<td>
								<select id='cuentas'></select>
								<input id='buscar' class='button' type='button' value='Buscar' onclick='buscar();'>
								<input id='pendientes' class='button' type='button' value='Ver pendientes' onclick='pendientes();'>
								&nbsp;&nbsp;&nbsp;
								<input id='editar' class='button' type='button' value='Guardar' onclick='guardar();'>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id='contenedor_busqueda'>";
			if($_REQUEST['cuenta'])
			{
	$resultado.="<table id='DEFAULT2' width='100%' border='0' cellspacing='0' cellpadding='0' class='edit view'>
					<tbody>
						<tr>
							<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Linea de Producto</b></font></td>
							<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Productos/Usuarios</b></font></td>";
							$cuenta_record = new Account();
							$cuenta_record->retrieve_by_string_fields(array('id'=>$cuenta));
							$id=$cuenta_record->id;
							$db =  DBManagerFactory::getInstance();
							$query = "SELECT u.id, u.first_name, u.last_name FROM users u, acl_roles_users a, acl_roles b WHERE u.id = a.user_id AND a.role_id = b.id and b.name in('Comercial','Jefe de Ventas') AND u.status = 'Active' AND u.id <> '1' order by u.last_name";
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
								$query2 = "SELECT u.id, u.first_name, u.last_name FROM users u, acl_roles_users a, acl_roles b WHERE u.id = a.user_id AND a.role_id = b.id and b.name in('Comercial','Jefe de Ventas') AND u.status = 'Active' AND u.id <> '1' order by u.last_name";
								$result2 = $db2->query($query2, true, 'Error selecting the product record');
								while($row2=$db2->fetchByAssoc($result2))
								{
									$resultado.="<td id = '".$row['id_producto']."_".$row2['id']."' style='border:1px solid; border-color: #eee;' onclick='toogledisplay(this.id,1);'>";
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
		$resultado.="<tr>
						<table width='100%' border='0' cellspacing='0' cellpadding='0' class='edit view'>
							<tbody>
								<tr>
									<td>
										<select id='relacionadores'></select>
										<input id='crear_asignacion' class='button' type='button' value='Crear Asignacion' onclick='crear_asignacion();'>
									</td>
								</tr>
							</tbody>
						</table>
					</tr>
					</tbody>
				</table>";
			}
$resultado.="</div>
			<script type='text/javascript'>";
				$db =  DBManagerFactory::getInstance();
				$query = "select id, name from accounts";
				$result = $db->query($query, true, 'Error selecting the user record');
				while($row=$db->fetchByAssoc($result))
				{
					$resultado.= "var select = document.getElementById('cuentas');
								  var option = document.createElement('option');						  
								  option.text='".$row['name']."';
								  option.id='".$row['id']."';
								  option.value='".$row['id']."';
								  if('".$row['id']."' == '".$cuenta."')
								  {
									  option.selected = true;
								  }
								  select.add(option,null);";
				}
				if($_REQUEST['cuenta'])
				{
					$query = "SELECT a.id, a.first_name, a.last_name FROM users a, acl_roles b, acl_roles_users c WHERE b.id = c.role_id AND a.id = c.user_id AND b.name IN('Comercial','Jefe de Ventas') and a.id <> '1' order by first_name";
					$result = $db->query($query, true, 'Error selecting the user record');
					while($row=$db->fetchByAssoc($result))
					{
						$resultado.= "var select1 = document.getElementById('relacionadores');
									  var option1 = document.createElement('option');
									  option1.text='".$row['first_name']." ".$row['last_name']."';
									  option1.id='".$row['id']."';
									  option1.value='".$row['id']."';
									  select1.add(option1,null);";
					}
				}
				if($_REQUEST['action']=='EditView')
				{
		$resultado.="var element = document.getElementById('EditView');
					 element.parentNode.removeChild(element);";
				}
				if($_REQUEST['action']=='index')
				{
		$resultado.="var element = document.getElementById('MassUpdate');
					 element.parentNode.removeChild(element);
					 element = document.getElementById('search_form');
					 element.parentNode.removeChild(element);";
				}
 $resultado.="</script>
			  <script type='text/javascript'>
				    function prepare_progress_bar()
					{
						document.getElementById('ajaxStatusDiv').style.display = 'block';
						var progress = 0;
						updateProgress(progress);
					}
					function updateProgress(progress)
					{
						if(progress < 100)
						{
							progress += 1;
							setTimeout(function(){updateProgress(progress);}, 200);
						}
						else
						{
							document.getElementById('ajaxStatusDiv').style.display = 'none';
							YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Datos Guardados',type:'alert',width: 200, fn: function() {setTimeout(function(){window.location.reload();}, 100);}});
						}
					}
					function buscar()
					{
						var opcion1 = document.getElementById('cuentas').value;
						window.location.href = 'index.php?module=Asignacion_productos&action=vista_lista_completa&cuenta='+opcion1;
					}
					function toogledisplay(me,num)
					{
						var padre = document.getElementById(me);
						var parrafo = document.getElementById(me).getElementsByTagName('p');
						var selec = document.getElementById(me).getElementsByTagName('select');
						var opcion = selec[0].value;
						if(num == 1)
						{
							parrafo[0].style.display = 'none';
							selec[0].style.display = 'block';
						}
						else
						{
							selec[0].style.display = 'none';
							parrafo[0].style.display = 'block';
						}
					}
					function cambia(me)
					{
						var padre = document.getElementById(me).parentNode;
						var parrafo = document.getElementById(padre.id).getElementsByTagName('p');
						var selec = document.getElementById(padre.id).getElementsByTagName('select');
						var opcion = selec[0].value;
						var texto = document.createTextNode(opcion);
						parrafo[0].removeChild(parrafo[0].firstChild);
						parrafo[0].appendChild(texto);
						toogledisplay(padre.id,0);
					}
					function pendientes()
					{
						window.location.href = 'index.php?module=Asignacion_productos&action=vista_lista_pendientes';
					}
					function crear_asignacion()
					{";
						 $cuenta_record = new Account();
						 $cuenta_record->retrieve_by_string_fields(array('id'=>$cuenta));
						 $nombre_cuenta=$cuenta_record->name;
						 $resultado.="var id_usuario = document.getElementById('relacionadores').value;
						 var id_cuenta = '".$cuenta."';
						 var nombre_cuenta = '".$nombre_cuenta."';
						 if ( nombre_cuenta.indexOf('&') > -1 ) 
						 {
							 var cuenta=nombre_cuenta.replace('&','/');
						 }
						 else 
						 {
							 var cuenta = nombre_cuenta;
						 }
						 YAHOO.util.Connect.asyncRequest(
						'POST',
						'index.php',
						{
							'success':function(result)
							{
								alert(result.responseText);
							},
							'failure':function(result)
							{
								alert('Hubo un error en el guardado de los datos, si el error persiste contactese con el administrador');
							},
						},
						'module=Asignacion_productos&action=crear_asignacion&cuenta='+cuenta+'&id_cuenta='+id_cuenta+'&id_usuario='+id_usuario+'&to_pdf=1');

					}
					function guardar()
					{";
						$cuenta_record = new Account();
						$cuenta_record->retrieve_by_string_fields(array('id'=>$cuenta));
						$nombre_cuenta=$cuenta_record->name;
			$resutlado.="var valor = '';
						var estatus = '';
						var nombre_cuenta = '".$nombre_cuenta."';
						if ( nombre_cuenta.indexOf('&') > -1 ) 
						{
							var cuenta=nombre_cuenta.replace('&','/');
						}
						else 
						{
							var cuenta = nombre_cuenta;
						}";
						$db =  DBManagerFactory::getInstance();
						$query = "select count(id) as productos from product_templates where deleted = 0";
						$result = $db->query($query, true, 'Error selecting the count product records');
						if($row=$db->fetchByAssoc($result))
						{
							$db2 =  DBManagerFactory::getInstance(); 
							$query2 = "SELECT count(u.id) as usuarios FROM users u, acl_roles_users a, acl_roles b WHERE u.id = a.user_id AND a.role_id = b.id and b.name in('Comercial','Jefe de Ventas') AND u.status = 'Active' AND u.id <> '1'";
							$result2 = $db2->query($query2, true, 'Error selecting the count user records');
							if($row2=$db2->fetchByAssoc($result2))
							{
					$resultado.="for(var i=1; i<=".$row['productos']."; i++)
								{
									j=1;
									for(var j=1; j<=".$row2['usuarios']."; j++)
									{
										valor = document.getElementById('usuario'+j+'producto'+i);
										if(valor.hasChildNodes())
										{
											estatus = valor.childNodes[0].nodeValue;
											if(estatus != '' && estatus != null)
											{
												var id_tag = document.getElementById('usuario'+j+'producto'+i).id;
												var id_cuenta = '".$cuenta."';
												var producto = document.getElementById('producto'+i).childNodes[0].nodeValue;
												var usuario = document.getElementById('usuario'+j).childNodes[0].nodeValue;
												var id_usuario = document.getElementById('usuario'+j).childNodes[1].childNodes[0].nodeValue;
												if(estatus == 'Aprobado' || estatus == 'No aprobado')
												{
													YAHOO.util.Connect.asyncRequest(
													'POST',
													'index.php',
													{
														'success':function(result)
														{
															resultado = result.responseText.split('/');
															if(resultado[0] == '1')
															{
																YAHOO.util.Connect.asyncRequest('POST','index.php',{'success':function(result){},'failure':function(result){},},'module=Detalle_asig_producto&action=enviar_mail&cuenta='+resultado[4]+'&id_usuario='+resultado[1]+'&producto='+resultado[3]+'&estatus='+resultado[5]+'&simple=no&to_pdf=1');
															}
														},
														'failure':function(result)
														{
															alert('Hubo un error en el guardado de los datos, si el error persiste contactese con el administrador');
														},
													},
													'module=Detalle_asig_producto&action=save&id_tag='+id_tag+'&estatus='+estatus+'&usuario='+usuario+'&id_cuenta='+id_cuenta+'&producto='+producto+'&id_usuario='+id_usuario+'&simple=no&to_pdf=1');
												}
											}
										}
									}
								}";
							}
						}
						$resultado.="YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Los datos asignados tardaran  unos segundos en guardarse en la base de datos',type:'alert',width: 500, fn: function() {setTimeout(function(){prepare_progress_bar();}, 100);}});";
		$resultado .="}
			  </script>";
echo $resultado;

?>