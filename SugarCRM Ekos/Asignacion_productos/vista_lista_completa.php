<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$i=1;
$j=1;
$cuenta = '';
/*if($_REQUEST['cuenta'])
{
	$cuenta = $_REQUEST['cuenta'];
}
*/
$resultado.="<script type='text/JavaScript' src='include/javascript/sugarwidgets/SugarYUIWidgets.js'></script> ";
$resultado.="<div id='ajaxStatusDiv' class='dataLabel' style='left: 45%; display: none;'><font size='3'>Cargando...</font></div>
			 <div id='Asignacion_productos_SearchForm_custom' style class='detail view  detail508'>
				<table width='100%' cellspacing='0' cellpadding='0' border ='0'>
					<tbody>
						<tr>
							<td>								
								<input id='buscar' class='button' type='button' value='Buscar' onclick='buscar();'>
								<input id='pendientes' class='button' type='button' value='Ver pendientes' onclick='pendientes();'>
								&nbsp;&nbsp;&nbsp;
								<input id='editar' class='button' type='button' value='Guardar' onclick='guardar();'>
								<div id='combo_cuentas' style='display: block;'></div>								
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id='contenedor_busqueda'></div>
			<div id='contenedor_relacionador'></div>";
			
$resultado.="<script type='text/javascript'>
			var opcion_sector = 'cuentas'; 
			SUGAR.ajaxUI.showLoadingPanel(); 
			YAHOO.util.Connect.asyncRequest(
			'POST',
			'index.php',
			{
				'success':function(result)
				{							
					div_cuentas = document.getElementById('combo_cuentas');
					div_cuentas.innerHTML = result.responseText;
					SUGAR.ajaxUI.hideLoadingPanel();
				},
				'failure':function(result)
				{					
				},
			},
			'module=Asignacion_productos&action=carga_x_sectores&op_carga='+opcion_sector+'&to_pdf=1');";					
				
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
						if(progress < 50)
						{
							progress += 1;
							setTimeout(function(){updateProgress(progress);}, 100);
						}
						else
						{
							document.getElementById('ajaxStatusDiv').style.display = 'none';
							YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Datos Guardados',type:'alert',width: 200, fn: function() {
															SUGAR.ajaxUI.hideLoadingPanel();															
															//buscar();
														}});						
						}
					}
					function buscar() 
					{
						var opcion1 = document.getElementById('cuentas').value; 
						//window.location.href = 'index.php?module=Asignacion_productos&action=vista_lista_completa&cuenta='+opcion1;						
						var opcion_sector = 'matriz';
						SUGAR.ajaxUI.showLoadingPanel(); 
						YAHOO.util.Connect.asyncRequest(
						'POST',
						'index.php',
						{
							'success':function(result2)
							{							
								div_busqueda = document.getElementById('contenedor_busqueda');
								div_busqueda.innerHTML = result2.responseText;
								carga_relaciondores();
								SUGAR.ajaxUI.hideLoadingPanel();								
							},
							'failure':function(result2)
							{	
								alert('Se ha producido un error en la busqueda, por favor refresque la pagina he intente de nuevo.');
							},
						},
						'module=Asignacion_productos&action=carga_x_sectores&op_carga='+opcion_sector+'&id_cuenta='+opcion1+'&to_pdf=1');
					}
					
					function carga_relaciondores() 
					{						
						var opcion_sector = 'relacionadores';
						SUGAR.ajaxUI.showLoadingPanel(); 
						YAHOO.util.Connect.asyncRequest(
						'POST',
						'index.php',
						{
							'success':function(result3)
							{							
								div_relacionador = document.getElementById('contenedor_relacionador');
								div_relacionador.innerHTML = result3.responseText;
								SUGAR.ajaxUI.hideLoadingPanel();
							},
							'failure':function(result3)
							{	
								alert('Se ha producido un error al cargar los relacionadores, por favor refresque la pagina he intente de nuevo.');
							},
						},
						'module=Asignacion_productos&action=carga_x_sectores&op_carga='+opcion_sector+'&to_pdf=1');
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
					{	
						 var id_usuario = document.getElementById('relacionadores').value;
						 var id_cuenta = document.getElementById('cuentas').value;
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
						'module=Asignacion_productos&action=crear_asignacion&id_cuenta='+id_cuenta+'&id_usuario='+id_usuario+'&to_pdf=1');

					}
					function guardar()
					{";					
									global $current_user;
									$id_user = $current_user->id;	
									$cuenta=$_SESSION['cuenta'];
									$cuenta_record = new Account();
									$cuenta_record->retrieve_by_string_fields(array('id'=>$cuenta));
									$nombre_cuenta=$cuenta_record->name;
						$resutlado.="var valor = '';
									var estatus = '';
									alert('".$cuenta."');
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
										$resultado.="var tope_productos = ".$row['productos'].";";
										$db2 =  DBManagerFactory::getInstance(); 
										$query2 = "SELECT count(distinct(u.id)) as usuarios
													FROM users u, acl_roles_users a, acl_roles b, detalle_asig_producto c, detalle_asig_producto_cstm d, product_templates e 
													WHERE u.id = a.user_id 
													AND a.role_id = b.id 
													AND a.deleted = '0' 
													AND u.deleted = '0' 
													AND u.status = 'Active' 
													AND b.name IN('Comercial','Jefe de Ventas') 
													AND u.id <> '1' 
													AND c.id = d.id_c 
													AND d.estatus_c = 'Aprobado' 
													AND c.assigned_user_id = u.id 
													AND e.id = d.producttemplate_id_c";
										$result2 = $db2->query($query2, true, 'Error selecting the count user records');
										if($row2=$db2->fetchByAssoc($result2))
										{ 
											$resultado.="var tope_usuarios = ".$row2['usuarios'].";";
										}
										
									}
								$resultado.="
											 var valida_ap = 0; 
											 var continuar = 0;
											 var j = 1; 
											 var i = 1; 	
												do{		
													var j = 1;														
													valida_ap = 0;
													do{									
														valor = document.getElementById('usuario'+j+'producto'+i);																								
														var producto = '';
														if(valor.hasChildNodes())
														{
															estatus = valor.childNodes[0].nodeValue;											
															if(estatus != '' && estatus != null)
															{	
																producto = document.getElementById('producto'+i).childNodes[0].nodeValue;
																if(estatus == 'Aprobado')
																{																		
																	valida_ap++;		
																} 																
															}
														}																										
													 j++; 
													} while (j <= tope_usuarios); 
													if(valida_ap > 1)
													{	
														continuar = 1;
														alert('Esta intentando APROBAR '+valida_ap+' veces el producto: '+producto+'. Cada producto debe tener un solo vendedor aprobado.');
													} 													
												 i++; 
												} while (i <= tope_productos);	
												
								if(continuar == 0)
								{
									YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Los datos asignados tardaran  unos segundos en guardarse en la base de datos',type:'alert',width: 500, fn: function() 
									{											
									var j = 1; 
									var i = 1; 
									var cadena = '';
										do{		
											var j = 1;  
											
											do{									
												valor = document.getElementById('usuario'+j+'producto'+i);																								
												if(valor.hasChildNodes())
												{
													estatus = valor.childNodes[0].nodeValue;											
													if(estatus != '' && estatus != null)
													{
														var id_tag = document.getElementById('usuario'+j+'producto'+i).id;																
														var producto = document.getElementById('producto'+i).childNodes[0].nodeValue;
														var usuario = document.getElementById('usuario'+j).childNodes[0].nodeValue;
														var id_usuario = document.getElementById('usuario'+j).childNodes[1].childNodes[0].nodeValue;																
														if(estatus == 'Aprobado' || estatus == 'No aprobado')
														{	
																																															
															cadena += id_tag+':'+id_usuario+':'+usuario+':'+producto+':'+estatus;	
															cadena += ';';																	
														} 																
													}
												}																										
											 j++; 
											} while (j <= tope_usuarios); 																			
										 i++; 
										} while (i <= tope_productos);	
										//alert(cadena);
										var id_user = '".$id_user."';												
										var id_cuenta = document.getElementById('cuentas').value;
										guarda_registro(id_cuenta,cadena,id_user);												
									}});																																					
								}							
					}
					
					function guarda_registro(id_cuenta,cadena,id_user)
					{
						SUGAR.ajaxUI.showLoadingPanel();
						YAHOO.util.Connect.asyncRequest(
						'POST',
						'index.php',
						{	
							'success':function(result)
							{														
								//resultado = result.responseText.split('/');																							
								if($.trim(result.responseText) == '1')
								{	
									 SUGAR.ajaxUI.hideLoadingPanel();
									 alert('Datos guardados');
									 buscar();
									 //envio_mail(resultado); 										
								}	
							},
							'failure':function(result)
							{
								SUGAR.ajaxUI.hideLoadingPanel();
								alert('Hubo un error en el guardado de los datos, si el error persiste contactese con el administrador');
							},
						},
						'module=Detalle_asig_producto&action=save&id_cuenta='+id_cuenta+'&id_user='+id_user+'&cadena='+cadena+'&simple=no&to_pdf=1');
					}									
					
		</script>";	
echo $resultado;

?>