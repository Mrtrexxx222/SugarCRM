<?php
class clase
{
    function funcion($event, $arguments)
	{
		if($_REQUEST['action']=='EditView')
		{
			global $current_user;
			$id_user = $current_user->id;
			$usuario = $current_user->name;
			if($GLOBALS['FOCUS']->id)
			{ 
				$id_record = $GLOBALS['FOCUS']->id;
				$account_id = $GLOBALS['FOCUS']->account_id;
				$name = $GLOBALS['FOCUS']->name;
			} 
			else 
			{
				$name='';
				$id_record = ''; 
				$account_id = '';
			}

			$user_id = $GLOBALS['FOCUS']->assigned_user_id;
			$resultado.="<div id='nombre' style='display:none;'></div>
						<div id='ext_detailpanel_3' style class='detail view  detail508'></div>
						<script type='text/javascript'>
							
							$(function() {
								$('input').bind('focus', false);
							});
							
							SUGAR.ajaxUI.showLoadingPanel();
							var duplicado = 0;
							var cuenta;
							var guarda_o_no = 2;
							document.getElementById('btn_contacto_c').onclick = envia;
							var oldValue = document.getElementById('sales_stage').value;
							var old_cuenta = document.getElementById('account_name').value;
							var checker_estado = setInterval('checkIfEstadoChanged()', 500);
							var checker_cuenta = setInterval('checkIfCuentaChanged()', 500);
							var checker_panel_prod = setInterval('checkIfIspanelprod()', 500);
							var checkercarga_inicial = setInterval('checkIfIsCarga_inicial()', 500);
							function envia()
							{
								open_popup('Contacts', 600, 400, '&account_id_advanced='+this.form.account_id.value+'&account_name_advanced='+this.form.account_name.value+'', true, false, {'call_back_function':'set_return','form_name':'EditView','field_to_name_array':{'id':'contact_id_c','name':'contacto_c'}}, 'single', true);
							}
							function checkIfEstadoChanged() 
							{
								var actual = document.getElementById('sales_stage').value;
								if(actual != window.oldValue)
								{
									valida_estado(window.oldValue,actual);
								}
								window.oldValue =  document.getElementById('sales_stage').value;
							}
							
							function checkIfCuentaChanged()
							{
								var actual_cuenta = document.getElementById('account_name').value;
								if(actual_cuenta != window.old_cuenta)
								{
									if ($('#account_name').is(':focus'))
									{}
									else
									{
										muestra_relacionadores(actual_cuenta);
										window.old_cuenta = document.getElementById('account_name').value;
										deshabilita_campos();
									}
								}
							}
							
							function checkIfIsCarga_inicial() 
							{
								var prods = document.getElementsByName('prospecto');
								var resps = isInDocument(prods[0]);
								if(!resps)
								{
								}
								else
								{
									setTimeout(function(){carga_inicial();},5000);
									clearInterval(checkercarga_inicial);
								}
							}
							
							function checkIfIspanelprod() 
							{
								var panel_prod = document.getElementById('detailpanel_3');
								var resps = isInDocument(panel_prod);
								if(!resps)
								{
								}
								else
								{
									cuenta = document.getElementById('account_name').value;
									setTimeout(function(){productos();},1000);					
									setTimeout(function(){oculta();},2000);
									var campo = document.getElementById('name');
									var oportunidad = campo.value;
									if(oportunidad == '')
									{
										document.getElementById('name').readOnly = false;
										setTimeout(function(){deshabilita_campos();},3000);
										setTimeout(function(){valida_estado_inicial();},4000);
										setTimeout(function(){muestra_relacionadores(cuenta);},5000);
										//document.getElementById('SAVE_HEADER').disabled = true;
										//document.getElementById('SAVE_FOOTER').disabled = true;
										//document.getElementById('guarda_oportunidad').disabled = true;
									}
									else
									{
										var resps2 = isInDocument2(document.getElementsByName('duplicateSave'));
										if(resps2)
										{
											var campos = document.getElementsByName('duplicateSave');
											if(campos[0].value == 'true')
											{
												window.duplicado = 1;
												document.getElementById('name').value = document.getElementById('name').value + '_dup';
											}
										}
										document.getElementById('name').disabled = true;
										document.getElementById('sales_stage').onblur = valida_estado;
										setTimeout(function(){valida_estado_inicial();},3000);
										setTimeout(function(){muestra_relacionadores(cuenta);},5000);
										//setTimeout(function(){valida_cerrado();},4000);
										setTimeout(function(){contrato();},6000);
									}
									
									nombre = document.getElementById('nombre');
									campo.parentNode.appendChild(nombre);
									campo.onblur = valida_nombre;
									document.getElementById('amount_label').style.color = 'Grey';
									document.getElementById('amount').readOnly = true;
									document.getElementById('description').onkeyup = valida_descripcion;
									clearInterval(checker_panel_prod);
								}
							}
							
							document.getElementById('account_name').autocomplete = 'on';
							document.getElementById('account_name').onkeypress = agranda;
							function agranda()
							{
								document.getElementById('EditView_account_name_results').onmouseover = agranda2;
								document.getElementById('EditView_account_name_results').childNodes[0].style.width = '500px';
							}
							function agranda2()
							{
								document.getElementById('EditView_account_name_results').childNodes[0].style.width = '500px';
							}
							//document.getElementById('contacto_c').autocomplete = 'on';
							//document.getElementById('contacto_c').onkeypress = agranda3;
							$('#contacto_c').attr('readonly', true);
							function agranda3()
							{
								document.getElementById('EditView_contacto_c_results').onmouseover = agranda4;
								document.getElementById('EditView_contacto_c_results').childNodes[0].style.width = '500px';
							}
							function agranda4()
							{
								document.getElementById('EditView_contacto_c_results').onmouseover = agranda2;
								document.getElementById('EditView_contacto_c_results').childNodes[0].style.width = '500px';
							}
														
							function deshabilita_campos()
							{
								var resps = isInDocument(document.getElementById('productos'));
								if(resps)
								{
									var oportunidad = document.getElementById('name').value;
									var cuenta = document.getElementById('account_name').value;
									if(oportunidad == '' || cuenta == '')
									{
										campos = document.getElementsByName('prospecto');
										numero = campos.length;
										for(var i=0;i<numero;i++)
										{
											campos[i].readOnly = true;
										}
										campos2 = document.getElementsByName('forma_pago');
										numero2 = campos2.length;
										for(var j=0;j<numero2;j++)
										{
											campos2[j].readOnly = true;
										}
										campos3 = document.getElementsByName('descripcion');
										numero3 = campos3.length;
										for(var k=0;k<numero3;k++)
										{
											campos3[k].readOnly = true;
										}
									}
									else
									{
										if(document.getElementById('nombre').style.display == 'none')
										{
											campos = document.getElementsByName('prospecto');
											numero = campos.length;
											for(var i=0;i<numero;i++)
											{
												campos[i].readOnly = false;
											}
											campos2 = document.getElementsByName('forma_pago');
											numero2 = campos2.length;
											for(var j=0;j<numero2;j++)
											{
												campos2[j].readOnly = false;
											}
											campos3 = document.getElementsByName('descripcion');
											numero3 = campos3.length;
											for(var k=0;k<numero3;k++)
											{
												campos3[k].readOnly = false;
											}
										}
										else
										{
											campos = document.getElementsByName('prospecto');
											numero = campos.length;
											for(var i=0;i<numero;i++)
											{
												campos[i].readOnly = true;
											}
											campos2 = document.getElementsByName('forma_pago');
											numero2 = campos2.length;
											for(var j=0;j<numero2;j++)
											{
												campos2[j].readOnly = true;
											}
											campos3 = document.getElementsByName('descripcion');
											numero3 = campos3.length;
											for(var k=0;k<numero3;k++)
											{
												campos3[k].readOnly = true;
											}
										}
									}
								}
							}
							
							function deshabilita_campos2()
							{
								var resps = isInDocument(document.getElementById('productos'));
								if(resps)
								{
									campos = document.getElementsByName('prospecto');
									numero = campos.length;
									for(var i=0;i<numero;i++)
									{
										campos[i].readOnly = true;
									}
									campos2 = document.getElementsByName('forma_pago');
									numero2 = campos2.length;
									for(var j=0;j<numero2;j++)
									{
										campos2[j].readOnly = true;
									}
									campos3 = document.getElementsByName('descripcion');
									numero3 = campos3.length;
									for(var k=0;k<numero3;k++)
									{
										campos3[k].readOnly = true;
									}
								}
							}
							
							function isInDocument(el)
							{
								var html = document.body.parentNode;
								while (el)
								{
									if (el === html)
									{
										return true;
									}
									el = el.parentNode;
								}
								return false;
							}
							
							function isInDocument2(nodes)
							{
								el = nodes[0];
								var html = document.body.parentNode;
								while (el)
								{
									if (el === html)
									{
										return true;
									}
									el = el.parentNode;
								}
								return false;
							}
							
							function oculta()
							{
								var panel_prod = document.getElementById('productos');
								var resps = isInDocument(panel_prod);
								if(resps)
								{
									document.getElementById('detailpanel_2').style.display = 'none';
									document.getElementById('LBL_EDITVIEW_PANEL4').style.display = 'none';
									//document.getElementById('assigned_user_name_label').style.display = 'none';
									//document.getElementById('assigned_user_name').style.display = 'none';
									//document.getElementById('btn_assigned_user_name').style.display = 'none';
									//document.getElementById('btn_clr_assigned_user_name').style.display = 'none';		
									document.getElementById('SAVE_FOOTER').parentNode.style.display = 'none';
									document.getElementById('SAVE_HEADER').style.display = 'none';
								}
								else
								{
									setTimeout(function(){oculta();},1000);
								}
							}
							function carga_relacionadores()
							{
								window.guarda_o_no = 1;
								var actual_cuenta = document.getElementById('account_name').value;
								if ( actual_cuenta.indexOf('&') > -1 ) 
								{
								  var cuenta_sin_epacios=actual_cuenta.replace('&','/');
								}
								else 
								{
									cuenta_sin_epacios = actual_cuenta;
								}
								var nombre = '';
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText != '')
										{
											var grupos = result.responseText.split('/');
											var num_usuario_producto = grupos.length - 1;
											for(var i=0;i<num_usuario_producto;i++)
											{
												var usuario_producto = grupos[i].split('_');
												var usuario = usuario_producto[0];
												var producto = usuario_producto[1];
												tr_padre =document.getElementById('valor_'+producto).parentNode.parentNode;
												tr_padre.childNodes[41].innerHTML = usuario;
											}
										}
										SUGAR.ajaxUI.hideLoadingPanel();
									},
									'failure':function(result)
									{
									},
								},
								'module=Opportunities&action=relacionadores&cuenta='+cuenta_sin_epacios+'&nombre='+nombre+'&to_pdf=1');
							}
							
							function muestra_relacionadores(actual_cuenta)
							{
								if ( actual_cuenta.indexOf('&') > -1 )
								{
								  var cuenta_sin_epacios=actual_cuenta.replace('&','/');
								}
								else 
								{
									cuenta_sin_epacios = actual_cuenta;
								}
								var nombre_oportunidad = document.getElementById('name').value;
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText != '')
										{
											grupos = result.responseText.split('/');
											num_usuario_producto = grupos.length - 1;
											for(var i=0;i<num_usuario_producto;i++)
											{
												usuario_producto = grupos[i].split('_');
												usuario = usuario_producto[0];
												producto = usuario_producto[1];
												tr_padre =document.getElementById(producto).parentNode;
												tr_padre.childNodes[41].innerHTML = usuario;
											}
										}
									},
									'failure':function(result)
									{
									},
								},
								'module=Opportunities&action=relacionadores&cuenta='+cuenta_sin_epacios+'&nombre='+nombre_oportunidad+'&to_pdf=1');
								window.cuenta = actual_cuenta;
								if(nombre != '')
								{
									muestra_nuevos(window.cuenta);
								}
							}
							
							function muestra_nuevos(actual_cuenta)
							{
								var vez = 1;
								if ( actual_cuenta.indexOf('&') > -1 ) 
								{
								  var cuenta_sin_epacios=actual_cuenta.replace('&','/');
								}
								else 
								{
									cuenta_sin_epacios = actual_cuenta;
								}
								var elements = document.getElementsByName('name');
								var nombre = elements[0].value;
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText != '')
										{
											var grupos = result.responseText.split('/');
											var num_usuario_producto = grupos.length - 1;
											for(var i=0;i<num_usuario_producto;i++)
											{
												var usuario_producto = grupos[i].split('_');
												var usuario = usuario_producto[0];
												var producto = usuario_producto[1];";
												$db =  DBManagerFactory::getInstance(); 
												$total_productos='';
												$sql_prod = "SELECT COUNT(a.name) productos
															FROM product_templates a, product_categories b 
															WHERE a.category_id = b.id AND a.deleted = '0' AND b.deleted = '0'";
												$result_prod = $db->query($sql_prod, true, 'Error selecting the role_user record');
												if($row_prod=$db->fetchByAssoc($result_prod))
												{
													$total_productos=$row_prod['productos'];
												}
									$resultado.="var total_prod = ".$total_productos.";
												for(var j=1;j<=total_prod;j++)
												{
													var padre = document.getElementById(j).parentNode;
													var duenio_producto = padre.childNodes[3].childNodes[0].nodeValue;
													if(producto == duenio_producto)
													{
														var resps = isInDocument(document.getElementById(j).childNodes[0]);
														if(!resps)
														{}
														else
														{
															if(usuario == document.getElementById(j).childNodes[0].nodeValue)
															{
															}
															else
															{
																if(vez == 1)
																	YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Hay nuevos asignados a los productos, desea cargarlos?',type:'confirm',width: 400, fn: function(confirm){if(confirm == 'yes'){carga_relacionadores();}if(confirm == 'no'){window.guarda_o_no = 0;}}});
																vez++;
															}
														}
													}
												}
											}
										}
										SUGAR.ajaxUI.hideLoadingPanel();
									},
									'failure':function(result)
									{
									},
								},
								'module=Opportunities&action=asignados&cuenta='+cuenta_sin_epacios+'&nombre='+nombre+'&to_pdf=1');
							}
							
							function valida_estado_inicial()
							{
								etapa = document.getElementById('sales_stage').value;
								if(etapa == 'Needs Analysis')
								{
									var nombre_oportunindad = document.getElementById('name').value;
									if(nombre_oportunindad == '')
									{
										document.getElementById('sales_stage').disabled = true;
									}
									else
									{
										document.getElementById('sales_stage').disabled = false;
									}
									document.getElementById('revisado_c').disabled = true;
								}
								else if(etapa == 'Quote')
								{";
									$db =  DBManagerFactory::getInstance(); 
									$rol='';
									$query = "select role_id from acl_roles_users where user_id = '".$id."'";
									$result = $db->query($query, true, 'Error selecting the role_user record');
									if($row=$db->fetchByAssoc($result))
									{
										$db2 =  DBManagerFactory::getInstance();
										$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
										$result2 = $db2->query($query2, true, 'Error selecting the role name record');
										if($row2=$db2->fetchByAssoc($result2))
										{
											$rol = $row2['name'];
										}
									}
									if($id_user == '1' || $rol == 'Administrador')
									{
							$resultado.="document.getElementById('revisado_c').disabled = false;
										 document.getElementById('sales_stage').disabled = false;";
									}
									else
									{
							$resultado.="document.getElementById('revisado_c').disabled = true;
										 document.getElementById('sales_stage').disabled = false;";
									}
					$resultado.="}
								else if(etapa == 'Perception Analysis')
								{
									document.getElementById('revisado_c').disabled = true;
								}
								else if(etapa == 'Closed Lost')
								{
									document.getElementById('revisado_c').disabled = true;";
									if($id_user != '1')
									{
										$resultado.="document.getElementById('sales_stage').disabled = true;";
									}
					$resultado.="}
								else
								{
									if(etapa == 'Closed Won')
									{";
										$db =  DBManagerFactory::getInstance(); 
										$rol='';
										$query = "select role_id from acl_roles_users where user_id = '".$id."'";
										$result = $db->query($query, true, 'Error selecting the role_user record');
										if($row=$db->fetchByAssoc($result))
										{
											$db2 =  DBManagerFactory::getInstance();
											$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
											$result2 = $db2->query($query2, true, 'Error selecting the role name record');
											if($row2=$db2->fetchByAssoc($result2))
											{
												$rol = $row2['name'];
											}
										}
										if($id_user == '1' || $rol == 'Administrador')
										{
								$resultado.="document.getElementById('revisado_c').disabled = false;
											 document.getElementById('sales_stage').disabled = false;
											 //document.getElementById('name').readOnly = false;
											 document.getElementById('name').disabled = false;";
										}
										else
										{
								$resultado.="document.getElementById('revisado_c').disabled = true;
											 document.getElementById('sales_stage').disabled = true;";
										}
						$resultado.="}
								}
							}
							
							function valida_cerrado()
							{
								etapa = document.getElementById('sales_stage').value;
								if(etapa == 'Closed Lost' || etapa == 'Closed Won')
								{
									//document.getElementById('SAVE_HEADER').disabled = true;
									//document.getElementById('SAVE_FOOTER').disabled = true;
									document.getElementById('guarda_oportunidad').disabled = true;
									document.getElementById('sales_stage').disabled = true;
								}";
								$db6 =  DBManagerFactory::getInstance();
								$query6 = "select role_id from acl_roles_users where user_id = '".$id_user."'";
								$result6 = $db6->query($query6, true, 'Error selecting the role_user record');
								if($row6=$db6->fetchByAssoc($result6))
								{
									$db7 =  DBManagerFactory::getInstance();
									$query7 = "select name from acl_roles where id = '".$row6['role_id']."'";
									$result7 = $db7->query($query7, true, 'Error selecting the role name record');
									if($row7=$db7->fetchByAssoc($result7))
									{
										if($row7['name'] == 'Supervisor Operativo' || $row7['name'] == 'Administrador')
										{}
										else
										{
											$resultado.="document.getElementById('revisado_c').disabled = true;";
										}
									}
								}
			   $resultado.="}
							
							function insiste()
							{
								document.getElementById('sales_stage').selectedIndex  = 2;
							}
							
							function valida_estado(viejo,nuevo)
							{
								if(viejo == 'Closed Lost')
								{";
									if($id_user != '1')
									{
										$resultado.="if(nuevo == 'Needs Analysis')
													{
														document.getElementById('sales_stage').value = 'Closed Lost';
													}
													if(nuevo == 'Perception Analysis')
													{
														document.getElementById('sales_stage').value = 'Closed Lost';
													}
													if(nuevo == 'Quote')
													{
														document.getElementById('sales_stage').value = 'Closed Lost';
													}
													if(nuevo == 'Closed Won')
													{
														document.getElementById('sales_stage').value = 'Closed Lost';
													}
													document.getElementById('guarda_oportunidad').disabled = true;";
									}
									else
									{
										$resultado.="if(nuevo == 'Closed Won')
													{
														SUGAR.ajaxUI.showLoadingPanel();
														 var nombre_oportunidad = document.getElementById('name').value;
														 var usuario = '".$id_user."';
														 var id_oportunidad = '".$id_record."';
														 var guarda_o_no = window.guarda_o_no;
														 var cuenta = document.getElementById('account_name').value;
														 if ( cuenta.indexOf('&') > -1 ) 
														 {
														    var cuenta_sin_epacios=cuenta.replace('&','/');
														 }
														 else 
														 {
															var cuenta_sin_epacios=cuenta;
														 }
														 var duenio = document.getElementById('assigned_user_name').value;
														 YAHOO.util.Connect.asyncRequest(
														'POST',
														'index.php',
														{
															'success':function(result)
															{
																if(result.responseText == '1')
																{
																	alert('Todos los productos de la oportunidad tienen presupuestos y asignados');
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
																else
																{
																	alert('Hay productos sin asignar o sin presupuestos en la oportunidad');
																	document.getElementById('sales_stage').value = 'Closed Lost';
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},2000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Opportunities&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');
													}";
									}
					$resultado.="}
								if(viejo == 'Needs Analysis')
								{";
									if($id_user != '1')
									{
										$resultado.="if(nuevo == 'Perception Analysis')
										{
											var resp = valida_descripcion2();
											if(resp == '0')
											{
												alert('Debe agregar una descripcion de la oportunidad');
												document.getElementById('sales_stage').value = 'Needs Analysis';
											}
											else
											{
												document.getElementById('sales_stage').onchange = insiste;
											}
										}
										if(nuevo == 'Quote')
										{
											alert('No puede saltar un paso de la etapa de ventas');
											document.getElementById('sales_stage').value = 'Needs Analysis';
										}
										if(nuevo == 'Closed Won')
										{
											alert('No tiene permisos para cerrar la oportunidad');
											document.getElementById('sales_stage').value = 'Needs Analysis';
										}";
									}
									else
									{
										$resultado.="if(nuevo == 'Closed Won')
													{
														SUGAR.ajaxUI.showLoadingPanel();
														 var nombre_oportunidad = document.getElementById('name').value;
														 var usuario = '".$id_user."';
														 var id_oportunidad = '".$id_record."';
														 var guarda_o_no = window.guarda_o_no;
														 var cuenta = document.getElementById('account_name').value;
														 if ( cuenta.indexOf('&') > -1 ) 
														 {
														    var cuenta_sin_epacios=cuenta.replace('&','/');
														 }
														 else 
														 {
															var cuenta_sin_epacios=cuenta;
														 }
														 var duenio = document.getElementById('assigned_user_name').value;
														 YAHOO.util.Connect.asyncRequest(
														'POST',
														'index.php',
														{
															'success':function(result)
															{
																if(result.responseText == '1')
																{
																	alert('Todos los productos de la oportunidad tienen presupuestos y asignados');
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
																else
																{
																	alert('Hay productos sin asignar o sin presupuestos en la oportunidad');
																	document.getElementById('sales_stage').value = 'Needs Analysis';
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},2000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Opportunities&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');
													}";
									}
					$resultado.="}
								if(viejo == 'Perception Analysis')
								{";
									if($id_user != '1')
									{
										$resultado.="if(nuevo == 'Needs Analysis')
										{
											alert('No puede retroceder la etapa de ventas');
											document.getElementById('sales_stage').value = 'Perception Analysis';
										}
										if(nuevo == 'Quote')
										{
											var resp = valida_descripcion2();
											if(resp == '0')
											{
												alert('Debe agregar una descripcion de la oportunidad');
												document.getElementById('sales_stage').value = 'Perception Analysis';
											}
										}
										if(nuevo == 'Closed Won')
										{
											alert('No tiene permisos para cerrar la oportunidad');
											document.getElementById('sales_stage').value = 'Perception Analysis';
										}";
									}
									else
									{
										$resultado.="if(nuevo == 'Closed Won')
													{
														SUGAR.ajaxUI.showLoadingPanel();
														 var nombre_oportunidad = document.getElementById('name').value;
														 var usuario = '".$id_user."';
														 var id_oportunidad = '".$id_record."';
														 var guarda_o_no = window.guarda_o_no;
														 var cuenta = document.getElementById('account_name').value;
														 if ( cuenta.indexOf('&') > -1 ) 
														 {
														    var cuenta_sin_epacios=cuenta.replace('&','/');
														 }
														 else 
														 {
															var cuenta_sin_epacios=cuenta;
														 }
														 var duenio = document.getElementById('assigned_user_name').value;
														 YAHOO.util.Connect.asyncRequest(
														'POST',
														'index.php',
														{
															'success':function(result)
															{
																if(result.responseText == '1')
																{
																	alert('Todos los productos de la oportunidad tienen presupuestos y asignados');
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
																else
																{
																	alert('Hay productos sin asignar o sin presupuestos en la oportunidad');
																	document.getElementById('sales_stage').value = 'Perception Analysis';
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},2000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Opportunities&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');
													}";
									}
					$resultado.="}
								if(viejo == 'Quote')
								{
									if(nuevo == 'Needs Analysis')
									{";
										if($id_user != '1')
										{
											$resultado.="alert('No puede retroceder la etapa de ventas');
											document.getElementById('sales_stage').value = 'Quote';";
										}
						$resultado.="}
									if(nuevo == 'Perception Analysis')
									{";
										if($id_user != '1')
										{
											$resultado.="alert('No puede retroceder la etapa de ventas');
											document.getElementById('sales_stage').value = 'Quote';";
										}
						$resultado.="}
									if(nuevo == 'Closed Won')
									{";
										$db =  DBManagerFactory::getInstance(); 
										$rol='';
										$query = "select role_id from acl_roles_users where user_id = '".$id."'";
										$result = $db->query($query, true, 'Error selecting the role_user record');
										if($row=$db->fetchByAssoc($result))
										{
											$db2 =  DBManagerFactory::getInstance();
											$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
											$result2 = $db2->query($query2, true, 'Error selecting the role name record');
											if($row2=$db2->fetchByAssoc($result2))
											{
												$rol = $row2['name'];
											}
										}
										if($id_user == '1' || $rol == 'Administrador')
										{
											$resultado.="SUGAR.ajaxUI.showLoadingPanel();
														 var nombre_oportunidad = document.getElementById('name').value;
														 var usuario = '".$id_user."';
														 var id_oportunidad = '".$id_record."';
														 var guarda_o_no = window.guarda_o_no;
														 var cuenta = document.getElementById('account_name').value;
														 if ( cuenta.indexOf('&') > -1 ) 
														 {
														    var cuenta_sin_epacios=cuenta.replace('&','/');
														 }
														 else 
														 {
															var cuenta_sin_epacios=cuenta;
														 }
														 var duenio = document.getElementById('assigned_user_name').value;
														 YAHOO.util.Connect.asyncRequest(
														'POST',
														'index.php',
														{
															'success':function(result)
															{
																if(result.responseText == '1')
																{
																	alert('Todos los productos de la oportunidad tienen presupuestos y asignados');
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
																else
																{
																	alert('Hay productos sin asignar o sin presupuestos en la oportunidad');
																	document.getElementById('sales_stage').value = 'Quote';
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},2000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Opportunities&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');";
										}
										else
										{
								$resultado.="alert('No tiene permisos para cerrar la oportunidad');
											 document.getElementById('sales_stage').value = 'Quote';";
										}
						$resultado.="}
								}
							}

							function productos()
							{
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if($.trim(result.responseText) == '1')
										{}
										else
										{
											padre = document.getElementById('detailpanel_3');
											div = document.createElement('div');
											div.innerHTML = result.responseText;
											padre.appendChild(div);
											
											boton = document.createElement('input');
											boton.setAttribute('type','button');
											boton.setAttribute('id','guarda_oportunidad');
											boton.setAttribute('value','Guardar Oportunidad');
											boton.setAttribute('onclick','valida_nombre_al_guardar();');
											padre2 = document.getElementById('SAVE_HEADER').parentNode;
											padre2.appendChild(boton);
										}
									},
									'failure':function(result)
									{},
								},
								'module=Opportunities&action=productos&to_pdf=1');	
							}
							
							function calcula()
							{
								var prob =  (document.getElementById('probability').innerHTML);
								var valor = parseFloat('0');
								var fact = parseFloat('0');
								var prob_total = parseFloat('0');
								var total = parseFloat('0');
								var actual = parseFloat('0');
								var inputs = document.getElementsByName('prospecto');
								var numero = inputs.length;
								for(var i=0;i<numero;i++)
								{
									if(inputs[i].value != '')
									{
										puntos = inputs[i].value.search('.');
										if(puntos == -1)
										{
											actual = parseFloat(inputs[i].value);
											total = total + actual;
											inputs[i].value = formatCurrency2(actual);
										}
										else
										{
											var partes = inputs[i].value.split('.');
											var sin_comas=partes[0].replace(',','');
											var precio_sin_format=sin_comas+'.'+partes[1];
											actual = parseFloat(precio_sin_format);
											total = total + actual;
											inputs[i].value = formatCurrency2(actual);
										}
									}
								}
								document.getElementById('amount').value = formatCurrency2(total);
							}

							function valida_nombre_al_guardar()
							{
								var nombre_oportunidad = document.getElementById('name').value;
								if(nombre_oportunidad != '') 
								{
									if(window.duplicado == 1)
									{
										YAHOO.util.Connect.asyncRequest(
										'POST',
										'index.php',
										{
											'success':function(result)
											{
												if($.trim(result.responseText) == '1')
												{
													//document.getElementById('SAVE_HEADER').disabled = true;
													//document.getElementById('SAVE_FOOTER').disabled = true;
													document.getElementById('guarda_oportunidad').disabled =true;
													document.getElementById('nombre').innerHTML = 'Ya existe una oportunidad con este nombre';
													document.getElementById('nombre').style.color = 'red';
													cambia(1);
													deshabilita_campos();
													alert('Ya existe una oportunidad con este nombre, por favor renombrela e intente de nuevo.');
													document.getElementById('name').disabled = false;
												}
												else
												{
													cambia(0);
													habilita_campos();
													habilita();
													guarda_productos();
												}
											},
											'failure':function(result)
											{},
										},
										'module=Opportunities&action=valida_nombre_repetido&nombre_oportunidad='+nombre_oportunidad+'&to_pdf=1');
									}
									else
									{
										guarda_productos();
									}
								}
								else
								{
									//document.getElementById('SAVE_HEADER').disabled = true;
									//document.getElementById('SAVE_FOOTER').disabled = true;
									document.getElementById('guarda_oportunidad').disabled =true;
								}
							}

							function guarda_productos()
							{													
							 //VARIABLES DE USO GENERAL
								var oportunidad = document.getElementsByName('name');
								var usuario = '".$usuario."';
								var id_usuario = '".$id_user."';
								var fecha_cierre = document.getElementById('date_closed').value;
								var cuenta = document.getElementById('account_name').value;
								var id_contact = document.getElementById('contact_id_c').value;
								var duplicad = 0;
								if(window.duplicado == 1)
								{
									duplicad = 'x'; 
									//alert('si');
								}
								else 
								{
									duplicad = '".$id_record."'; 									
									//alert('no');
								}
								if ( cuenta.indexOf('&') > -1 ) 
									{ 
										var cuenta_sin_epacios = cuenta.replace('&','/'); 
									} 
									else 
									{ 
										var cuenta_sin_epacios = cuenta; 
									} 
								var guarda_o_no = window.guarda_o_no;
								var duenio = document.getElementById('assigned_user_name').value;
								
							 //CABECERA OPORTUNIDAD
								var _form = document.getElementById('EditView');
								disableOnUnloadEditView(); 
								_form.action.value='Save'; 
								if(check_form('EditView'))
								{									
									var seccion = 'C';
									var description = document.getElementById('description').value;
									var contacto = document.getElementById('contacto_c').value;
									var etapa = document.getElementById('sales_stage').options[document.getElementById('sales_stage').selectedIndex].value;
									var total_op1 = document.getElementById('amount').value;
									var total_op = total_op1.replace(',',''); 
									total_op = total_op.replace(',',''); 
									var check = 0;
									var elemento_chk = document.getElementById('revisado_c').checked;
									if (elemento_chk == true) 
									{ check = 1; }
									else 
									{ check = 0; } 
																		
									document.getElementById('guarda_oportunidad').disabled = true; 
									var campos = document.getElementsByName('prospecto');			
									var string_campos = ''; 																
									for(var i = 0;i<campos.length;i++)
									{										
										var partes = campos[i].id.split('_');								
										var valor = document.getElementById('valor_'+partes[1]).value;	
										var producto = partes[1]; 
										var forma_pago = document.getElementById('forma_pago_'+partes[1]).value;
										var descripcion = document.getElementById('descripcion_'+partes[1]).value;
										var estatus = '';									
										if(valor != '' && valor != '0.00' && valor != '0'){ 
											var estatus = '1';															
										} 
										else { 														
											valor = '0';
											forma_pago = '0';
											descripcion = '0';
											estatus = '0';	
										}	
										string_campos += producto+':'+valor+':'+forma_pago+':'+descripcion+':'+estatus+';';																								
									}										
									var dupli_id = 0;
									if(window.duplicado == 1)
									{									
										//alert('si'); 
										var dupli_id = '".$id_record."'; 																		
									}
									else 
									{
										//alert('no'); 
										var dupli_id = 'NO'; 
									}
									SUGAR.ajaxUI.showLoadingPanel();
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{																								
											var retorno = $.trim(result.responseText);
											var param = retorno.split('/');											
											if(param[0] == '1') 
											{				
												SUGAR.ajaxUI.hideLoadingPanel();  
												alert('Los datos se guardaron correctamente.');				
												var url = 'index.php?module=Opportunities&action=DetailView&record='+param[1]; 
												window.open(url, '_self');											
											}
											else
											{
												SUGAR.ajaxUI.hideLoadingPanel();  
												alert('Se produjo un error, Por favor informe a su Administrador de Sugar.');				
											}
										},
										'failure':function(result)
										{ 
											//alert('Ha ocurrio un Error, por favor intentelo de nuevo.');
										},
									},									
									'module=Opportunities&action=guarda_producto&id_usuario='+id_usuario+'&usuario='+usuario+'&cuenta='+cuenta_sin_epacios+'&oportunidad='+oportunidad[0].value+'&descripcion1='+description+'&duenio='+duenio+'&seccion='+seccion+'&contacto='+contacto+'&etapa='+etapa+'&total_op='+total_op+'&fecha_cierre='+fecha_cierre+'&id_contact='+id_contact+'&check='+check+'&duplicado='+duplicad+'&datos='+string_campos+'&id_op_old='+dupli_id+'&guarda_o_no='+guarda_o_no+'&to_pdf=1');																		
								}
								else
								{												
									SUGAR.ajaxUI.hideLoadingPanel();  							
								}
							}							
													
														
							function formatCurrency2(num)
							{
								num = num.toString().replace(/\$|\,/g, '');
								if (isNaN(num)) num = '0';
								sign = (num == (num = Math.abs(num)));
								num = Math.floor(num * 100 + 0.50000000001);
								cents = num % 100;
								num = Math.floor(num / 100).toString();
								if (cents < 10) cents = '0' + cents;
								for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
								num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
								return (((sign) ? '' : '-') + num + '.' + cents);
							}
							
							function habilita_campos()
							{
								campos = document.getElementsByName('prospecto');
								numero = campos.length;
								for(var i=0;i<numero;i++)
								{
									campos[i].readOnly = false;
								}
							}
							
							function habilita()
							{
								var elegido = '0';
								var campos = document.getElementsByName('prospecto');
								for(var i=0;i<campos.length;i++)
								{
									var valor = campos[i].value;
									if(valor != '' && valor != '0.00' && valor != '0')
									{
										elegido = '1';
									}
								}
								if(elegido == '0')
								{
									//document.getElementById('SAVE_HEADER').disabled = true;
									//document.getElementById('SAVE_FOOTER').disabled = true;
									document.getElementById('guarda_oportunidad').disabled = true;
								}
								else
								{
									var estado = document.getElementById('nombre').style.display;
									if(estado == 'none')
									{
										//document.getElementById('SAVE_HEADER').disabled = false;
										//document.getElementById('SAVE_FOOTER').disabled = false;
										etapa = document.getElementById('sales_stage').value;
										if(etapa == 'Closed Lost')
										{";
											if($id_user != '1')
											{
												$resultado.="document.getElementById('guarda_oportunidad').disabled = true;";
											}
							$resultado.="}
										else
										{
											document.getElementById('guarda_oportunidad').disabled = false;
										}
									}
									else
									{
										//document.getElementById('SAVE_HEADER').disabled = true;
										//document.getElementById('SAVE_FOOTER').disabled = true;
										document.getElementById('guarda_oportunidad').disabled = true;
									}
								}
							}
							
							function carga_inicial()
							{
								var elegido = '0';";
								$db =  DBManagerFactory::getInstance();
								$query = "SELECT id FROM product_templates where deleted = 0";
								$result = $db->query($query, true, 'Error selecting the oportunity record');
								while($row=$db->fetchByAssoc($result))
								{
									$query2 = "SELECT a.estado_c, a.valor_prospectado_c, a.forma_pago_c, a.descripcion_c FROM m1_oportunidad_productos_cstm a, m1_oportunidad_productos b where a.oportunidad_c = '".$name."' and a.id_producto_c = '".$row['id']."' and a.id_c = b.id";
									$result2 = $db->query($query2, true, 'Error selecting the oportunity record');
									if($row2=$db->fetchByAssoc($result2))
									{
										if($row2['estado_c'] == '0')
										{
										}
										else
										{
								$resultado.="document.getElementById('valor_".$row['id']."').value = formatCurrency2('".$row2['valor_prospectado_c']."');
											 document.getElementById('forma_pago_".$row['id']."').value = '".$row2['forma_pago_c']."';
											 document.getElementById('descripcion_".$row['id']."').value = '".$row2['descripcion_c']."';
											 elegido = '1';";
										}
									}
								}
					$resultado.="if(elegido == '0')
								{
									//document.getElementById('SAVE_HEADER').disabled = true;
									//document.getElementById('SAVE_FOOTER').disabled = true;
									document.getElementById('guarda_oportunidad').disabled = true;
								}
								else
								{
									var etapa = document.getElementById('sales_stage').value;
									if(etapa != 'Closed Won' && etapa != 'Closed Lost')
									{
										//document.getElementById('SAVE_HEADER').disabled = false;
										//document.getElementById('SAVE_FOOTER').disabled = false;
										document.getElementById('guarda_oportunidad').disabled = false;
									}
									else
									{";
										if($id_user != '1')
										{
								$resultado.="//document.getElementById('SAVE_HEADER').disabled = true;
											//document.getElementById('SAVE_FOOTER').disabled = true;
											document.getElementById('guarda_oportunidad').disabled = true;
											document.getElementById('contacto_c').disabled = true;
											document.getElementById('btn_contacto_c').disabled = true;
											document.getElementById('btn_clr_contacto_c').disabled = true;
											document.getElementById('date_closed').disabled = true;
											document.getElementById('date_closed_trigger').style.display = 'none';
											document.getElementById('account_name').disabled = true;
											document.getElementById('btn_account_name').disabled = true;
											document.getElementById('btn_clr_account_name').disabled = true;
											deshabilita_campos2();";
										}
						$resultado.="}
								}
								SUGAR.ajaxUI.hideLoadingPanel();
							}
							
							function contrato()
							{
								var id_usuario = '".$user_id."';
								var id_oportunidad = '".$id_record."';
								var id_cuenta = '".$account_id."';
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText == '1')
										{}
										else
										{
											padre = document.getElementById('detailpanel_4');
											div = document.createElement('div');
											div.innerHTML = result.responseText;
											padre.appendChild(div);
										}
									},
									'failure':function(result)
									{},
								},
								'module=Opportunities&action=informacion_contrato&id_oportunidad='+id_oportunidad+'&id_cuenta='+id_cuenta+'&id_usuario='+id_usuario+'&to_pdf=1');
							}

							function valida_descripcion()
							{";
								if($id_record != '')
								{
									$resultado.="descripcion = document.getElementById('description').value;
									if(descripcion != '')
									{
										vista = document.getElementById('nombre').style.display;
										if(vista == 'none')
										{
											//document.getElementById('SAVE_HEADER').disabled =false;
											//document.getElementById('SAVE_FOOTER').disabled =false;
											document.getElementById('guarda_oportunidad').disabled =false;
										}
										if(document.getElementById('sales_stage').value == 'Needs Analysis')
										{
											document.getElementById('sales_stage').value = 'Perception Analysis';
										}
									}
									else
									{
										//document.getElementById('SAVE_HEADER').disabled =true;
										//document.getElementById('SAVE_FOOTER').disabled =true;
										document.getElementById('guarda_oportunidad').disabled =true;
									}";
								}
				$resultado.="}
							
							function valida_descripcion2()
							{
								descripcion = document.getElementById('description').value;
								etapa = document.getElementById('sales_stage').value;
								if(descripcion != '')
								{
									vista = document.getElementById('nombre').style.display;
									if(vista == 'none')
									{
										//document.getElementById('SAVE_HEADER').disabled =false;
										//document.getElementById('SAVE_FOOTER').disabled =false;
										document.getElementById('guarda_oportunidad').disabled =false;
										return '1';
									}
									else
									{
										//document.getElementById('SAVE_HEADER').disabled =true;
										//document.getElementById('SAVE_FOOTER').disabled =true;
										document.getElementById('guarda_oportunidad').disabled =true;
										return '0';
									}
								}
								else
								{
									//document.getElementById('SAVE_HEADER').disabled =true;
									//document.getElementById('SAVE_FOOTER').disabled =true;
									document.getElementById('guarda_oportunidad').disabled =true;
									return '0';
								}
							}

							function valida_nombre()
							{
								var nombre_oportunidad = document.getElementById('name').value;
								if(nombre_oportunidad != '')
								{
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(result.responseText == '1')
											{
												//document.getElementById('SAVE_HEADER').disabled = true;
												//document.getElementById('SAVE_FOOTER').disabled = true;
												document.getElementById('guarda_oportunidad').disabled =true;
												document.getElementById('nombre').innerHTML = 'Ya existe una oportunidad con este nombre';
												document.getElementById('nombre').style.color = 'red';
												cambia(1);
												deshabilita_campos();
											}
											else
											{
												cambia(0);
												habilita_campos();
												habilita();
											}
										},
										'failure':function(result)
										{},
									},
									'module=Opportunities&action=valida_nombre_repetido&nombre_oportunidad='+nombre_oportunidad+'&to_pdf=1');
								}
								else
								{
									//document.getElementById('SAVE_HEADER').disabled = true;
									//document.getElementById('SAVE_FOOTER').disabled = true;
									document.getElementById('guarda_oportunidad').disabled =true;
								}
							}

							function cambia(num)
							{
								var valida = document.getElementById('nombre');
								if(num=='1')
								{
									valida.style.display = 'block';
								}
								else
								{
									valida.style.display = 'none';
								}
							}
						</script>";
			echo $resultado;
		}
		else if($_REQUEST['action']=='DetailView')
		{
			$resultado="";
			global $current_user;
			$id_user = $current_user->id;
			if($GLOBALS['FOCUS']->id)
			{
				$id_record = $GLOBALS['FOCUS']->id;
				$account_id = $GLOBALS['FOCUS']->account_id;
				$name = $GLOBALS['FOCUS']->name;
			}
			else
			{
				$name='';
				$id_record = '';
				$account_id = '';
			}
			$resultado.="
						<style>
						.wrapper
						{
							width:22%;
						}
						.right
						{
							float:right;
							width:88%;
						}
						</style>
						<script type='text/javascript'>
							var checker_countdown = 1;
							function checkIfIsProdu_panel() 
							{
								var panel = document.getElementById('detailpanel_3');
								var resps = isInDocument(panel);
								if(!resps)
								{
								}
								else
								{
									setTimeout(function(){productos();},1000);
									setTimeout(function(){contrato();},2000);
									clearInterval(checker_panel_product_detail);
									if(document.getElementById('sales_stage').value != 'Closed Won')
									{
										document.getElementById('duplicate_button').style.display = 'none';
									}
								}
							}
							var checker_panel_product_detail = setInterval('checkIfIsProdu_panel()', 500);
							
							function checkIfIsCarga_inicial_detail() 
							{
								var prods = document.getElementsByName('prospecto');
								var resps = isInDocument(prods[0]);
								if(!resps)
								{
								}
								else
								{
									if(checker_countdown >= 1)
									{
										setTimeout(function(){titulo();},2000);
										setTimeout(function(){carga_inicial();},3000);
										var cuenta = document.getElementById('account_id').innerHTML;
										setTimeout(function(){muestra_relacionadores(cuenta);},4000);
										setTimeout(function(){oculta();},1000);
										checker_countdown = checker_countdown - 1;
									}
									else
									{
										clearInterval(checkercarga_inicial_detail);
									}
								}
							}
							var checkercarga_inicial_detail = setInterval('checkIfIsCarga_inicial_detail();', 500);
							
							function oculta()
							{
								$('.paginationWrapper').hide();
								document.getElementById('insideViewDiv').style.display = 'none';
								document.getElementById('whole_subpanel_contacts').style.display = 'none';	
								document.getElementById('Activities_nuevatarea_button').style.display = 'none';
								var padre = document.getElementById('formquotes_opportunities').parentNode;
								padre.style.display = 'none';
								//document.getElementById('duplicate_button').parentNode.style.display = 'none';
								document.getElementById('History_nuevanotaoadjunto_button').style.display = 'none';
								
								var filas = document.getElementById('list_subpanel_history').getElementsByClassName('listViewTdToolsS1');								
								var numero1 = filas.length;
								for(var i=0;i<numero1;i++)
								{
									filas[i].parentNode.parentNode.style.display = 'none';
								}
								
								var filas2 = document.getElementById('list_subpanel_activities').getElementsByClassName('listViewTdToolsS1');								
								var numero1 = filas2.length;
								for(var i=0;i<numero1;i++)
								{
									if(filas2[i].childNodes[0].nodeValue == 'quitar')
									{
										filas2[i].style.display = 'none';
									}
								}
							}
							function titulo()
							{
								var padre_td = document.getElementById('formformTasks').parentNode.parentNode.parentNode;
								padre_td.setAttribute('class','wrapper');
								var titulos = document.createElement('p');
								titulos.setAttribute('class','right');
								titulos.innerHTML = 'REUNION, LLAMADA, CORREO';
								padre_td.appendChild(titulos);
							}

							function checkIfValueChanged() 
							{
								var resp = isInDocument(document.getElementById('Meetings_subpanel_full_form_button'));
								if(resp)
								{
									var formularios = document.getElementsByName('Meetings_subpanel_full_form_button');
									for(var i=0;i<formularios.length;i++)
									{
										formularios[i].style.display= 'none';
									}
									document.getElementById('reminder_checked').parentNode.childNodes[5].innerHTML = 'Activar';
									var padre = document.getElementById('email_reminder_checked').parentNode;
									padre.childNodes[5].style.display = 'none';
									document.getElementById('email_reminder_checked').style.display= 'none';
									//document.getElementById('assigned_user_name_label').style.display= 'none';
									//document.getElementById('assigned_user_name').style.display= 'none';
									//document.getElementById('btn_assigned_user_name').style.display= 'none';
									//document.getElementById('btn_clr_assigned_user_name').style.display= 'none';
									
									var reunion = isInDocument(document.getElementById('titulo_reunion'));
									if(!reunion)
									{
										var newElement = document.createElement('tr');
										newElement.setAttribute('id','titulo_reunion');
										var newtd1 = document.createElement('td');
										var newtd2 = document.createElement('td');
										var newtd3 = document.createElement('b');
										newtd3.innerHTML = 'PROGRAMAR UNA REUNI\u00D3N';
										newtd2.appendChild(newtd3);
										newElement.appendChild(newtd1);
										newElement.appendChild(newtd2);
										$('.action_buttons').after(newElement);
									}
									var grabares = document.getElementsByName('Meetings_subpanel_save_button');
									grabares[0].onmouseup = recarga;
									grabares[1].onmouseup = recarga;
								}
								var resp2 = isInDocument(document.getElementById('Calls_subpanel_full_form_button'));
								if(resp2)
								{
									var formularios = document.getElementsByName('Calls_subpanel_full_form_button');
									for(var i=0;i<formularios.length;i++)
									{
										formularios[i].style.display= 'none';
									}
									document.getElementById('reminder_checked').parentNode.childNodes[5].innerHTML = 'Activar';
									var padre = document.getElementById('date_start_label').innerHTML = 'Fecha/Hora Llamada';
									var padre2 = document.getElementById('duration_hours_label').parentNode;
									padre2.childNodes[3].style.display = 'none';
									document.getElementById('duration_hours_label').style.display = 'none';
									
									var padre = document.getElementById('email_reminder_checked').parentNode;
									padre.childNodes[5].style.display = 'none';
									document.getElementById('email_reminder_checked').style.display= 'none';
									//document.getElementById('assigned_user_name_label').style.display= 'none';
									//document.getElementById('assigned_user_name').style.display= 'none';
									//document.getElementById('btn_assigned_user_name').style.display= 'none';
									//document.getElementById('btn_clr_assigned_user_name').style.display= 'none';
									
									var llamada = isInDocument(document.getElementById('titulo_llamada'));
									if(!llamada)
									{
										var newElement = document.createElement('tr');
										newElement.setAttribute('id','titulo_llamada');
										var newtd1 = document.createElement('td');
										var newtd2 = document.createElement('td');
										var newtd3 = document.createElement('b');
										newtd3.innerHTML = 'PROGRAMAR UNA LLAMADA';
										newtd2.appendChild(newtd3);
										newElement.appendChild(newtd1);
										newElement.appendChild(newtd2);
										$('.action_buttons').after(newElement);
									}
									var grabares = document.getElementsByName('Calls_subpanel_save_button');
									grabares[0].onmouseup = recarga;
									grabares[1].onmouseup = recarga;
								}
								var resp3 = isInDocument(document.getElementById('addressFrom0'));
								if(resp3)
								{
									var botones = document.getElementById('composeHeaderTable0').getElementsByTagName('button');
									for(var i=0;i<botones.length;i++)
									{
										if(i==3)
										{
											botones[i].style.display = 'none';
											document.getElementById('divOptions0').style.display = 'none';
											var select = document.getElementById('data_parent_type0');
											for(var j=0;j<select.options.length;j++)
											{
												if(select.options[j].value != 'Accounts' && select.options[j].value != 'Contacts' && select.options[j].value != 'Opportunities')
												{
													select.options[j] = null;
												}
											}
											var td_padre = document.getElementById('addedDocuments0').parentNode;
											var tr_padre = td_padre.parentNode;
											var tabla = tr_padre.parentNode;
											tabla.childNodes[6].style.display = 'none';
											tabla.childNodes[8].style.display = 'none';
										}
									}
								}
							}
							var checker = setInterval('checkIfValueChanged();', 500);
							
							function recarga()
							{
								var estatus = document.getElementById('ajaxStatusDiv').style.display;
								if(estatus == 'none')
								{
									setTimeout(function(){window.location.reload();}, 1000);
								}
								else
								{
									setTimeout(function(){recarga();},1000);
								}
							}

							function isInDocument(el)
							{
								var html = document.body.parentNode;
								while (el)
								{
									if (el === html)
									{
										return true;
									}
									el = el.parentNode;
								}
								return false;
							}

							function productos()
							{
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText == '1')
										{}
										else
										{
											padre = document.getElementById('detailpanel_2');
											div = document.createElement('div');
											div.innerHTML = result.responseText;
											padre.appendChild(div);
										}
									},
									'failure':function(result)
									{},
								},
								'module=Opportunities&action=productos&to_pdf=1');
							}

							function carga_inicial()
							{
								campos = document.getElementsByName('prospecto');
								numero = campos.length;
								for(var i=0;i<numero;i++)
								{
									campos[i].disabled = true;
								}";
								$db =  DBManagerFactory::getInstance();
								$query = "SELECT id FROM product_templates where deleted = 0";
								$result = $db->query($query, true, 'Error selecting the oportunity record');
								while($row=$db->fetchByAssoc($result))
								{
									$query2 = "SELECT a.estado_c, a.valor_prospectado_c, forma_pago_c, descripcion_c FROM m1_oportunidad_productos_cstm a, m1_oportunidad_productos b where a.oportunidad_c = '".$name."' and a.id_producto_c = '".$row['id']."' and a.id_c = b.id";
									$result2 = $db->query($query2, true, 'Error selecting the oportunity record');
									if($row2=$db->fetchByAssoc($result2))
									{
										if($row2['estado_c'] == '0')
										{
										}
										else
										{
								$resultado.="document.getElementById('valor_".$row['id']."').value = formatCurrency2('".$row2['valor_prospectado_c']."');
											 document.getElementById('forma_pago_".$row['id']."').value = '".$row2['forma_pago_c']."';
											 document.getElementById('descripcion_".$row['id']."').value = '".$row2['descripcion_c']."';
											 elegido = '1';
											 deshabilita_campos();";
										}
									}
								}
				$resultado.="}
				
							function muestra_relacionadores(actual_cuenta)
							{
								if ( actual_cuenta.indexOf('&amp;') > -1 ) 
								{
								  var cuenta_sin_epacios=actual_cuenta.replace('&amp;','/');
								}
								else 
								{
									cuenta_sin_epacios = actual_cuenta;
								}
								var nombre_oportunidad = document.getElementById('name').childNodes[0].nodeValue;
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText != '')
										{
											grupos = result.responseText.split('/');
											num_usuario_producto = grupos.length - 1;
											for(var i=0;i<num_usuario_producto;i++)
											{
												usuario_producto = grupos[i].split('_');
												usuario = usuario_producto[0];
												producto = usuario_producto[1];
												tr_padre =document.getElementById(producto).parentNode;
												tr_padre.childNodes[41].innerHTML = usuario;
											}
										}
									},
									'failure':function(result)
									{
									},
								},
								'module=Opportunities&action=relacionadores&cuenta='+cuenta_sin_epacios+'&nombre='+nombre_oportunidad+'&to_pdf=1');
							}
				
							function formatCurrency2(num)
							{
								num = num.toString().replace(/\$|\,/g, '');
								if (isNaN(num)) num = '0';
								sign = (num == (num = Math.abs(num)));
								num = Math.floor(num * 100 + 0.50000000001);
								cents = num % 100;
								num = Math.floor(num / 100).toString();
								if (cents < 10) cents = '0' + cents;
								for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
								num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
								return (((sign) ? '' : '-') + num + '.' + cents);
							}
							
							function deshabilita_campos()
							{
								var resps = isInDocument(document.getElementById('productos'));
								if(resps)
								{
									campos = document.getElementsByName('prospecto');
									numero = campos.length;
									for(var i=0;i<numero;i++)
									{
										campos[i].readOnly = true;
									}
									campos2 = document.getElementsByName('forma_pago');
									numero2 = campos2.length;
									for(var j=0;j<numero2;j++)
									{
										campos2[j].readOnly = true;
									}
									campos3 = document.getElementsByName('descripcion');
									numero3 = campos3.length;
									for(var k=0;k<numero3;k++)
									{
										campos3[k].readOnly = true;
									}
								}
							}

							function contrato()
							{
								var id_usuario = '".$user_id."';
								var id_oportunidad = '".$id_record."';
								var id_cuenta = '".$account_id."';
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText == '1')
										{}
										else
										{
											padre = document.getElementById('detailpanel_3');
											div = document.createElement('div');
											div.innerHTML = result.responseText;
											padre.appendChild(div);
										}
									},
									'failure':function(result)
									{},
								},
								'module=Opportunities&action=informacion_contrato&id_oportunidad='+id_oportunidad+'&id_cuenta='+id_cuenta+'&id_usuario='+id_usuario+'&to_pdf=1');
							}
						</script>";
			echo $resultado;
		}
		else
		{
			if($_REQUEST['action']=='index')
			{
				$resultado.="<script type='text/javascript'>
								document.getElementById('massall_top').parentNode.parentNode.parentNode.style.display = 'none';
								document.getElementById('massall_bottom').parentNode.parentNode.parentNode.style.display = 'none';
								var checks = document.getElementsByClassName('checkbox');
								var numero = checks.length;
								for(var i=0;i<numero;i++)
								{
									checks[i].style.display = 'none';
								}								
								var filas_claras = document.getElementsByClassName('oddListRowS1');
								var numero2 = filas_claras.length;
								for(var j=0;j<numero2;j++)
								{																		
									imgs1 = filas_claras[j].getElementsByTagName('img');
									var numero3 = imgs1.length;
									for(var k=0;k<numero3;k++)
									{
										imgs1[k].style.display = 'none';
									}
								}
								var filas_pardas = document.getElementsByClassName('evenListRowS1');
								var numero4 = filas_pardas.length;
								for(var k=0;k<numero4;k++)
								{
									imgs2 = filas_pardas[k].getElementsByTagName('img');
									var numero5 = imgs2.length;
									for(var l=0;l<numero5;l++)
									{
										imgs2[l].style.display = 'none';
									}
								}
								var editor = document.getElementsByClassName('quickEdit');
								var numero1 = editor.length;
								for(var m=0;m<numero1;m++)
								{									
									editor[m].style.display = 'none'; 
								}
							</script>";
							echo $resultado;
			}
		}
	}
}