<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
class clase
{
    function funcion($event, $arguments)
	{		
		if($_REQUEST['action']=='EditView')
		{			
			$id_record = $GLOBALS['FOCUS']->id;
			$rol='';
			$resultado.="<div id='valida' style='display:none;'>
						</div>
						<script type='text/javascript'>
						$('.paginationWrapper').hide();";
						global $current_user;
						$id = $current_user->id;
						$db =  DBManagerFactory::getInstance(); 
						$query = "select role_id from acl_roles_users where user_id = '".$id."'";
						$result = $db->query($query, true, 'Error selecting the role_user record');
						if($row=$db->fetchByAssoc($result))
						{
							$db2 =  DBManagerFactory::getInstance();
							$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
							$result2 = $db2->query($query2, true, 'Error selecting the role name record');
							if($row2=$db2->fetchByAssoc($result2))
							{
								if($row2['name'] != 'Base de datos' && $row2['name'] != 'Supervisor Operativo' && $row2['name'] != 'Administrador')
								{
									$resultado.="document.getElementById('entrega_especial_c_label').innerHTML = '';
									document.getElementById('detailpanel_3').style.display = 'none';";
								}
								if($row2['name'] == 'Base de datos' || $row2['name'] == 'Administrador')
								{
									$rol = $row2['name'];
								}
							}
						}
						if($id_record != '')
						{
							if($id == '1' || $rol == 'Base de datos' || $rol == 'Administrador')
							{
								$resultado.="document.getElementById('name').readOnly = false;";
							}
							else
							{
								$resultado.="document.getElementById('name').readOnly = true;";
							}
						}
			$resultado.="var siono = '';
						var tipo = '';
						//document.getElementById('SAVE_HEADER').disabled =true;
						//document.getElementById('SAVE_FOOTER').disabled =true;
						document.getElementById('name').onkeydown = function(event) {
							if(event.shiftKey==true)
							{
								event.returnValue = false;
							}
							else if(event.keyCode == 127 || event.keyCode == 86 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 ||event.keyCode == 39 ||event.keyCode == 40 || event.keyCode == 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122) || (event.keyCode >= 48 && event.keyCode <= 57))  
							{ 
								event.returnValue = true; 
							} 
							else 
							{  
								event.returnValue = false; 
							}
						};
						document.getElementById('tipo_identificacion_c').onchange = validar;
						var campo = document.getElementById('identificacion_c');
						campo.onkeydown = function(event) {
							if(event.keyCode ==8 ||  event.keyCode ==9 || event.keyCode ==13 || event.keyCode ==37 ||event.keyCode ==38 ||event.keyCode ==39 ||event.keyCode ==40 || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode == 127 || event.keyCode == 86)  
							{ 
								event.returnValue = true; 
							} 
							else 
							{  
								event.returnValue = false; 
							}
						};
						valida = document.getElementById('valida');
						campo.parentNode.appendChild(valida);
						campo.onblur = validar;
						
						$('#phone_alternate').blur({param: 'convencional', param2:  document.getElementById('phone_alternate')},validafono);
						$('#phone_office').blur({param: 'convencional', param2: document.getElementById('phone_office')},validafono);
						
						function validafono(event)
						{
							var tipo = event.data.param;
							var valor = event.data.param2;
							var cadena = valor.value;
							var campo = valor.id;
							YAHOO.util.Connect.asyncRequest(
							'POST',
							'index.php',
							{
								'success':function(result)
								{
									if(result.responseText == 'ph_failure_1')
									{
										alert('Longitud de telefono no valida Se requiere 9 numeros');
										document.getElementById(campo).value = '';
									}
									else
									{
										if(result.responseText == 'ph_failure_2')
										{
											alert('No se debe repetir el mismo numero 9 veces');
											document.getElementById(campo).value = '';
										}
										else
										{
											if(result.responseText == 'ph_failure_3')
											{
												alert('Solo se adimiten numeros');
												document.getElementById(campo).value = '';
											}
											else
											{
												if(result.responseText == 'cph_failure_1')
												{
													alert('Solo se podra ingresar numeros iniciados en 09');
													document.getElementById(campo).value = '';
												}
												else
												{
													if(result.responseText == 'cph_failure_2')
													{
														alert('Longitud de celular no valida (total 10 numeros incluidos 09)');
														document.getElementById(campo).value = '';
													}
													else
													{
														if(result.responseText == 'cph_failure_3')
														{
															alert('No se debe repetir el mismo numero 8 veces (despues de 09)');
															document.getElementById(campo).value = '';
														}
														else
														{
															if(result.responseText == 'cph_failure_4')
															{
																alert('Solo se adimiten numeros');
																document.getElementById(campo).value = '';
															}
															else
															{
																//Todo Ok;
															}
														}				
													}
												}	
											}
										}
									}
								},
								'failure':function(result)
								{
									//alert('Error en la aplicacion');
								},
							},
							'module=Accounts&action=validafono&tipo='+tipo+'&cadena='+cadena+'&to_pdf=1');
						}
						
						function validar()
						{
							var tipo = document.getElementById('tipo_identificacion_c').value;
							if(tipo == 'otro')
							{
								document.getElementById('SAVE_HEADER').disabled =false;
								document.getElementById('SAVE_FOOTER').disabled =false;
								document.getElementById('valida').style.display = 'none';
							}
							else
							{
								validar2();
							}
						}

						function validar2()
						{
							SUGAR.ajaxUI.showLoadingPanel();
							window.siono = 'si';
							window.tipo = document.getElementById('tipo_identificacion_c').value;
							var ruc = document.getElementById('identificacion_c');
							numero = ruc.value;
							var suma = 0;
							var residuo = 0;
							var pri = false;
							var pub = false;
							var nat = false;
							var numeroProvincias = 22;
							var modulo = 11;

							/* Aqui almacenamos los digitos de la cedula en variables. */
							d1 = numero.substr(0,1);
							d2 = numero.substr(1,1);
							d3 = numero.substr(2,1);
							d4 = numero.substr(3,1);
							d5 = numero.substr(4,1);
							d6 = numero.substr(5,1);
							d7 = numero.substr(6,1);
							d8 = numero.substr(7,1);
							d9 = numero.substr(8,1);
							d10 = numero.substr(9,1);

							/* El tercer digito es: */
							/* 9 para sociedades privadas y extranjeros */
							/* 6 para sociedades publicas */
							/* menor que 6 (0,1,2,3,4,5) para personas naturales */

							if (d3==7 || d3==8)
							{
								window.siono = 'no';
								document.getElementById('valida').innerHTML = 'El tercer digito ingresado es invalido';
								document.getElementById('valida').style.color = '#FF0000';
								cambia(1);	
							}

							/* Solo para personas naturales (modulo 10) */
							if (d3 < 6)
							{
								nat = true;
								p1 = d1 * 2; if (p1 >= 10) p1 -= 9;
								p2 = d2 * 1; if (p2 >= 10) p2 -= 9;
								p3 = d3 * 2; if (p3 >= 10) p3 -= 9;
								p4 = d4 * 1; if (p4 >= 10) p4 -= 9;
								p5 = d5 * 2; if (p5 >= 10) p5 -= 9;
								p6 = d6 * 1; if (p6 >= 10) p6 -= 9;
								p7 = d7 * 2; if (p7 >= 10) p7 -= 9;
								p8 = d8 * 1; if (p8 >= 10) p8 -= 9;
								p9 = d9 * 2; if (p9 >= 10) p9 -= 9;
								modulo = 10;
							}

							/* Solo para sociedades publicas (modulo 11) */
							/* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
							else 
							{
								if(d3 == 6)
								{
									pub = true;
									p1 = d1 * 3;
									p2 = d2 * 2;
									p3 = d3 * 7;
									p4 = d4 * 6;
									p5 = d5 * 5;
									p6 = d6 * 4;
									p7 = d7 * 3;
									p8 = d8 * 2;
									p9 = 0;
								}
								else
								{
									/* Solo para entidades privadas (modulo 11) */
									if(d3 == 9)
									{
										pri = true;
										p1 = d1 * 4;
										p2 = d2 * 3;
										p3 = d3 * 2;
										p4 = d4 * 7;
										p5 = d5 * 6;
										p6 = d6 * 5;
										p7 = d7 * 4;
										p8 = d8 * 3;
										p9 = d9 * 2;
									}
								}
							}
							suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
							residuo = suma % modulo;

							/* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
							digitoVerificador = residuo==0 ? 0: modulo - residuo;

							/* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
							if (pub==true)
							{
								if (digitoVerificador != d9)
								{
									window.siono = 'no';
									document.getElementById('valida').innerHTML = 'El ruc de la empresa del sector publico es incorrecto.';
									document.getElementById('valida').style.color = '#FF0000';
									cambia(1);
								}
								/* El ruc de las empresas del sector publico terminan con 0001*/
								if ( numero.substr(9,4) != '0001' )
								{
									window.siono = 'no';
									document.getElementById('valida').innerHTML = 'El ruc de la empresa del sector publico debe terminar con 0001';
									document.getElementById('valida').style.color = '#FF0000';
									cambia(1);
								}
							}
							else
							{
								if(pri == true)
								{
									if (digitoVerificador != d10)
									{
										window.siono = 'no';
										document.getElementById('valida').innerHTML = 'El ruc de la empresa del sector privado es incorrecto.';
										document.getElementById('valida').style.color = '#FF0000';
										cambia(1);
									}
									if ( numero.substr(10,3) != '001' )
									{
										window.siono = 'no';
										document.getElementById('valida').innerHTML = 'El ruc de la empresa del sector privado debe terminar con 001';
										document.getElementById('valida').style.color = '#FF0000';
										cambia(1);
									}
								}
								else
								{
									if(nat == true)
									{
										if (digitoVerificador != d10)
										{
											window.siono = 'no';
											document.getElementById('valida').innerHTML = 'El numero de cedula de la persona natural es incorrecto.';
											document.getElementById('valida').style.color = '#FF0000';
											cambia(1);
										}
										if (numero.length >10 && numero.substr(10,3) != '001' )
										{
											window.siono = 'no';
											document.getElementById('valida').innerHTML = 'El ruc de la persona natural debe terminar con 001';
											document.getElementById('valida').style.color = '#FF0000';
											cambia(1);
										}
									}
								}
							}
							if(window.tipo == 'cedula')
							{
								if(numero.length != 10)
								{
									window.siono = 'no';
									document.getElementById('valida').innerHTML = 'El numero de cedula debe contener 10 digitos';
									document.getElementById('valida').style.color = '#FF0000';
									cambia(1);
									guarda();
								}
								else
								{
									comprobar(numero);
								}
							}
							else
							{
								if(window.tipo == 'ruc')
								{
									if(numero.length != 13)
									{
										window.siono = 'no';
										document.getElementById('valida').innerHTML = 'El numero de ruc debe contener 13 digitos';
										document.getElementById('valida').style.color = '#FF0000';
										cambia(1);
										guarda();
										setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},2000);
									}
									else
									{
										comprobar(numero);
									}
								}
							}
						}

						function comprobar(numero)
						{
							YAHOO.util.Connect.asyncRequest(
							'POST',
							'index.php',
							{
								'success':function(result)
								{
									resultado = result.responseText;
									if(resultado == '0')
									{
										if(window.siono == 'si')
										{
											cambia(0);
											guarda();
										}
										else
										{
											guarda();
										}
									}
									else
									{
										if(resultado == '1')
										{
											window.siono = 'no';
											document.getElementById('valida').innerHTML = 'El numero de identificacion ya existe en la base de datos';
											document.getElementById('valida').style.color = '#FF0000';
											cambia(1);
											guarda();
										}
										else
										{
											if(window.siono == 'no')
											{
												guarda();
											}
										}
									}
									setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},2000);
								},
								'failure':function(result)
								{
								},
							},
							'module=Accounts&action=comprueba&numero='+numero+'&to_pdf=1');
						}

						function guarda()
						{
							var valida = document.getElementById('valida');
							if(valida.style.display == 'block')
							{
								document.getElementById('SAVE_HEADER').disabled =true;
								document.getElementById('SAVE_FOOTER').disabled =true;
							}
							else
							{
								document.getElementById('SAVE_HEADER').disabled =false;
								document.getElementById('SAVE_FOOTER').disabled =false;
							}
						}

						function cambia(num)
						{
							var valida = document.getElementById('valida');
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
			$name = $GLOBALS['FOCUS']->name;
			global $current_user;
			$id_user = $current_user->id;
			$usuario = $current_user->name;
			$cuenta = $GLOBALS['FOCUS']->name;
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
							var oldValue;
							var ordena = '0';
							var carga_una_vez = 0;
							var checkIfIspanels_charged_Countdown = 1;	
							var checkIfopportunities_subpanel_Countdown = 1;
							var edit_opportunity_buttons_count_down = 1;
							var guarda_o_no = 0;
							
							var checkIfIspanels_charged = function(){
								var panel_quitar = document.getElementById('whole_subpanel_quotes');
								var resps = isInDocument(panel_quitar);
								if(!resps)
								{		
								}
								else
								{
									if(checkIfIspanels_charged_Countdown <= 0)
									{
										clearInterval(checkIfIspanels_charged);
									}
									else
									{
										oculta();
										titulo();
										checkIfIspanels_charged_Countdown --;
									}
								}
							};
														
							function oculta()
							{
								$('.paginationWrapper').hide();
								document.getElementById('insideViewDiv').style.display = 'none';
								document.getElementById('History_nuevanotaoadjunto_button').style.display = 'none';
								document.getElementById('ArchivarCorreo_button').style.display = 'none';
								document.getElementById('whole_subpanel_quotes').style.display = 'none';
								document.getElementById('formformTasks').style.display = 'none';
								var padre = document.getElementById('accounts_contacts_select_button').parentNode.parentNode.parentNode;
								padre.childNodes[2].style.display = 'none';
								document.getElementById('duplicate_button').parentNode.style.display = 'none';
								var obtener = document.getElementsByName('merge_connector');
								obtener[0].parentNode.style.display = 'none';
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

							var checkIfMeetings_subpanel = function(){
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
									grabares[0].onmouseup = recarga2;
									grabares[1].onmouseup = recarga2;
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
									grabares[0].onmouseup = recarga2;
									grabares[1].onmouseup = recarga2                                                                                                                                                                                                                                                                                                                                                                                                                                     ;
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
								clearInterval(checkIfMeetings_subpanel);
							};
							
							var checkIfcontacts_subpanel = function(){
								var resp4 = isInDocument(document.getElementById('first_name_label'));
								if(resp4)
								{
									var saludos = document.getElementsByName('salutation');
									if(saludos.length == 2)
									{
										var td = document.getElementById('first_name_label').parentNode;
										var tr = td.parentNode;
										var campo = tr.childNodes[2].childNodes[3].childNodes[1];
										var td2 = document.getElementById('salutation_label').parentNode;
										var tr2 = td2.parentNode;
										tr2.childNodes[2].childNodes[3].appendChild(campo);
										tr.childNodes[2].childNodes[3].removeChild(campo);
										
										document.getElementById('Contacts0_email_widget_add').onmouseup = quita;
										
										padre1 = document.getElementById('Contacts0emailAddressOptOutFlag0').parentNode;
										padre1.childNodes[0].style.display='none';
										padre2 = document.getElementById('Contacts0emailAddressInvalidFlag0').parentNode;
										padre2.childNodes[0].style.display='none';
										
										correo = document.getElementById('ContactsemailAddressesTable0');
										var rehusado = correo.childNodes[2].childNodes[0].childNodes[7].parentNode;
										var obted = correo.childNodes[2].childNodes[0].childNodes[9].parentNode;
										rehusado.childNodes[7].style.display='none';
										obted.childNodes[9].style.display='none';
										//document.getElementById('assigned_user_name_label').style.display= 'none';
										//document.getElementById('assigned_user_name').style.display= 'none';
										//document.getElementById('btn_assigned_user_name').style.display= 'none';
										//document.getElementById('btn_clr_assigned_user_name').style.display= 'none';
										
										document.getElementById('account_name').autocomplete = 'on';
										document.getElementById('account_name').onkeypress = agranda;
										function agranda()
										{
											document.getElementById('form_SubpanelQuickCreate_Contacts_account_name_results').onmouseover = agranda2;
											document.getElementById('form_SubpanelQuickCreate_Contacts_account_name_results').childNodes[0].style.width = '500px';
										}
										function agranda2()
										{
											document.getElementById('form_SubpanelQuickCreate_Contacts_account_name_results').childNodes[0].style.width = '500px';
										}
										$('#phone_work').blur({param: 'convencional', param2:  document.getElementById('phone_work')},validafono);
										$('#phone_mobile').blur({param: 'celular', param2: document.getElementById('phone_mobile')},validafono);
									}
									var formularios = document.getElementsByName('Contacts_subpanel_full_form_button');
									for(var i=0;i<formularios.length;i++)
									{
										formularios[i].style.display= 'none';
									}
								}
								clearInterval(checkIfcontacts_subpanel);
							};
							
							function quita()
							{
								for(var i=0;i<100;i++)
								{
									var resp8 = isInDocument(document.getElementById('Contacts0emailAddressOptOutFlag'+i));
									if(resp8)
									{
										padre1 = document.getElementById('Contacts0emailAddressOptOutFlag'+i).parentNode;
										padre1.childNodes[0].style.display='none';
										padre2 = document.getElementById('Contacts0emailAddressInvalidFlag'+i).parentNode;
										padre2.childNodes[0].style.display='none';
									}									
								}
							}
							
							
							 //document.getElementById('accounts_opportunities_nuevo_button').onclick = reinicia;
							 $(document).ready(function(){
							   for(var i=1;i<10;i++)
							   {
									var resp9 = isInDocument(document.getElementById('opportunities_edit_'+i));
									if(resp9)
									{
										document.getElementById('opportunities_edit_'+i).parentNode.onmouseup = reinicia;
									}
							   }
							 });
							 
							  var edit_opportunity_buttons = function (){
								if(window.edit_opportunity_buttons_count_down >= 1)
								{
									var resps = isInDocument(document.getElementById('accounts_opportunities_nuevo_button'));
									if(resps)
									{
										document.getElementById('accounts_opportunities_nuevo_button').onmouseup = limpia;
										var filas3 = document.getElementById('list_subpanel_opportunities').getElementsByClassName('listViewTdToolsS1');								
										var numero2 = filas3.length;
										for(var i=0;i<numero2;i++)
										{
											var resp9 = isInDocument(filas3[i]);
											if(resp9)
											{
												filas3[i].onmouseup = limpia;
											}
										}
										window.edit_opportunity_buttons_count_down --;
									}
								}
								else
								{
									
								}
							 };
							 
							 function envia()
							{
								open_popup('Contacts', 600, 400, '&account_id_advanced='+this.form.account_id.value+'&account_name_advanced='+this.form.account_name.value+'', true, false, {'call_back_function':'set_return','form_name':'form_SubpanelQuickCreate_Opportunities','field_to_name_array':{'id':'contact_id_c','name':'contacto_c'}}, 'single', true);
							}							
																												
							var checkIfopportunities_subpanel = function(){
								var resp5 = isInDocument(document.getElementById('amount'));
								if(resp5)
								{
									var resp10 = isInDocument(document.getElementById('form_SubpanelQuickCreate_Opportunities_tabs'));
									if(resp10)
									{
										if(window.checkIfopportunities_subpanel_Countdown <= 0)
										{
											
										}
										else
										{
											SUGAR.ajaxUI.showLoadingPanel();
											var oldvalue;
											var formularios = document.getElementsByName('Opportunities_subpanel_full_form_button');
											for(var i=0;i<formularios.length;i++)
											{
												formularios[i].style.display= 'none';
											}
											window.guarda_o_no = 0;
											var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
											var arriba = grabares[0];
											var abajo = grabares[1];
											//arriba.onmouseup = recarga;
											//abajo.onmouseup = recarga;
											arriba.style.display = 'none';
											abajo.parentNode.style.display = 'none';
											var elements = document.getElementsByName('name');
											var nombre = elements[0];
											nombre.onblur = valida_nombre;
											nombre.onkeydown = function(event) {
												if(event.shiftKey==true)
												{
												    event.returnValue = false;
												}
												else if(event.keyCode == 127 || event.keyCode == 86 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 ||event.keyCode == 39 ||event.keyCode == 40 || event.keyCode == 32 || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122) || (event.keyCode >= 48 && event.keyCode <= 57))  
												{ 
													event.returnValue = true; 
												} 
												else 
												{  
													event.returnValue = false; 
												}
											};
											document.getElementById('amount').readOnly= true;
											document.getElementById('btn_contacto_c').onclick = envia;
											//document.getElementById('contacto_c').autocomplete = 'on';
											//document.getElementById('contacto_c').onkeypress = agranda;
											$('#contacto_c').attr('readonly', true);
											
											
											var resp6 = isInDocument(document.getElementById('productos'));
											if(resp6)
											{}
											else
											{
												if(nombre.value == '')
												{
													//grabares[0].disabled = true;
													//grabares[1].disabled = true;
													var mensaje =  document.createElement('div');
													mensaje.setAttribute('id','nombre');
													mensaje.setAttribute('style','color: red;');
													nombre.parentNode.appendChild(mensaje);
													padre = document.getElementById('form_SubpanelQuickCreate_Opportunities_tabs');
													div = document.createElement('div');
													div.setAttribute('class','yui3-skin-sam edit view panelContainer');
													YAHOO.util.Connect.asyncRequest(
													'POST',
													'index.php',
													{
														'success':function(result)
														{														
															div.innerHTML = result.responseText;
															padre.appendChild(div);
															
															boton = document.createElement('input');
															boton.setAttribute('type','button');
															boton.setAttribute('id','guardar_productos');
															boton.setAttribute('value','Guardar Oportunidad');
															boton.setAttribute('onclick','guarda_productos();');
															arriba.parentNode.appendChild(boton);
															
															document.getElementById('sales_stage').disabled = true;
															setTimeout(function(){deshabilita_campos();},3000);
															document.getElementById('revisado_c').disabled = true;
															document.getElementById('guardar_productos').disabled = true;
														},
														'failure':function(result)
														{},
													},
													'module=Accounts&action=productos&to_pdf=1');
												}
												else
												{
													etapa = document.getElementById('sales_stage').value;
													if(etapa == 'Closed Lost')
													{";
														if($id_user != '1')
														{
															$resultado.="document.getElementById('sales_stage').disabled = true;";
														}
										$resultado.="}
													window.oldValue = document.getElementById('sales_stage').value;
													var checker3 = setInterval('cambiaono();', 500);
													nombre.readOnly = true;
													setTimeout(function(){valida_estado_inicial();},4000);
													//setTimeout(function(){valida_cerrado();},5000);
													var mensaje =  document.createElement('div');
													mensaje.setAttribute('id','nombre');
													mensaje.setAttribute('style','color: red;');
													nombre.parentNode.appendChild(mensaje);
													padre = document.getElementById('form_SubpanelQuickCreate_Opportunities_tabs');
													div = document.createElement('div');
													div.setAttribute('class','yui3-skin-sam edit view panelContainer');
													YAHOO.util.Connect.asyncRequest(
													'POST',
													'index.php',
													{
														'success':function(result)
														{
															div.innerHTML = result.responseText;
															padre.appendChild(div);															
															boton = document.createElement('input');
															boton.setAttribute('type','button');
															boton.setAttribute('id','guardar_productos');
															boton.setAttribute('value','Guardar Oportunidad');
															boton.setAttribute('onclick','guarda_productos();');
															arriba.parentNode.appendChild(boton);
														},
														'failure':function(result)
														{},
													},
													'module=Accounts&action=productos&to_pdf=1');
												}
												document.getElementById('amount_label').style.color = 'Grey';
												document.getElementById('sales_stage').onchange = valida_estado;
												document.getElementById('description').onkeyup = valida_descripcion;
												document.getElementById('account_name').disabled = true;
												document.getElementById('btn_account_name').disabled = true;
												document.getElementById('btn_clr_account_name').disabled = true;
												cuenta = document.getElementById('account_name').value;
												document.getElementById('probability_label').parentNode.style.display = 'none';
											}
											window.checkIfopportunities_subpanel_Countdown --;
										}
									}
								}
								else
								{
									window.edit_opportunity_buttons_count_down = 1;
									window.checkIfopportunities_subpanel_Countdown = 1;
								}
							};
							
							function agranda()
							{
								document.getElementById('form_SubpanelQuickCreate_Opportunities_contacto_c_results').onmouseover = agranda2;
								document.getElementById('form_SubpanelQuickCreate_Opportunities_contacto_c_results').childNodes[0].style.width = '500px';
							}
							function agranda2()
							{
								document.getElementById('form_SubpanelQuickCreate_Opportunities_contacto_c_results').childNodes[0].style.width = '500px';
							}
							
							function limpia()
							{
								window.carga_una_vez = 0;
							}
							
							function recarga()
							{
								if(document.getElementById('ajaxStatusDiv').style.display == 'none')
								{
									setTimeout(function(){window.location.reload();}, 1000);
								}
								else
								{
									setTimeout(function(){recarga();},1000);
								}
							}
							
							function recarga2()
							{
								var estatus = document.getElementById('ajaxStatusDiv').style.display;
								if(estatus == 'none')
								{
									setTimeout(function(){window.location.reload();}, 1000);
								}
								else
								{
									setTimeout(function(){recarga2();},1000);
								}
							}
							
							function reinicia()
							{
								//window.checkIfopportunities_subpanel_Countdown = 1;
							}
							
							function habilita_campos()
							{
								campos = document.getElementsByName('prospecto');
								numero = campos.length;
								for(var i=0;i<numero;i++)
								{
									campos[i].disabled = false;
								}
							}
							
							function deshabilita_campos()
							{
								var panel_prod = document.getElementById('productos');
								var resp11 = isInDocument(document.getElementById('form_SubpanelQuickCreate_Opportunities_tabs'));
								if(resp11)
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
							
							var checkIfIsProducts_are_charged = function(){
								var productos = document.getElementsByName('prospecto');
								var resps = isInDocument(productos[0]);
								if(!resps)
								{
									reinicia();
								}
								else
								{
									var elements = document.getElementsByName('name');
									var nombre = elements[0];
									if(nombre != '')
									{
										if(carga_una_vez == 0)
										{	
											carga_inicial();
											//setTimeout(function(){carga_inicial();},4000);
											window.carga_una_vez = 1;
											//setTimeout(function(){muestra_relacionadores(cuenta);},5000);
											muestra_relacionadores(cuenta);
										}
										else
										{
											clearInterval(checkIfIsProducts_are_charged);
										}
									}
									else
									{
										clearInterval(checkIfIsProducts_are_charged);
									}
								}
							};
							
							$(document).ready(function(){
								 setInterval(checkIfIspanels_charged, 500);
							});
							$(document).ready(function(){
								 setInterval(checkIfMeetings_subpanel, 500);
							});
							$(document).ready(function(){
								 setInterval(checkIfcontacts_subpanel, 500);
							});
							$(document).ready(function(){
								 setInterval(checkIfopportunities_subpanel, 500);
							});
							$(document).ready(function(){
								 setInterval(checkIfIsProducts_are_charged, 500);
							});
							$(document).ready(function(){
								 setInterval(edit_opportunity_buttons, 500);
							});
							
							
							function carga_inicial()
							{
								var productos = document.getElementsByName('prospecto');
								var resps = isInDocument(productos[0]);
								var elegido = '0';								
								if(!resps)
								{
								}
								else
								{";
									$oportunidad="";
									$nombre="";
									$db =  DBManagerFactory::getInstance();
									$account = new Account(); 
									$account->retrieve($_REQUEST['record']); 
									$contacts = $account->get_linked_beans('opportunities','Opportunity'); 
									foreach ( $contacts as $contact ) 
									{ 
										$nombre = $contact->name;
										$resultado.=" var elements = document.getElementsByName('name');
										var nombre_op = elements[0].value;
										if(nombre_op == '".$nombre."')
										{";
											$query = "SELECT id FROM product_templates where deleted = 0";
											$result = $db->query($query, true, 'Error selecting the oportunity record');
											while($row=$db->fetchByAssoc($result))
											{
												$query2 = "SELECT estado_c, valor_prospectado_c, forma_pago_c, descripcion_c FROM m1_oportunidad_productos_cstm where oportunidad_c = '".$nombre."' and id_producto_c = '".$row['id']."'";
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
												//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
												//grabares[0].disabled = true;
												//grabares[1].disabled = true;
												document.getElementById('guardar_productos').disabled = true;
											}
											else
											{
												var etapa = document.getElementById('sales_stage').value;
												if(etapa != 'Closed Won' && etapa != 'Closed Lost')
												{
													//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
													//grabares[0].disabled = false;
													//grabares[1].disabled = false;
													document.getElementById('guardar_productos').disabled = false;
													
												}
												else
												{
													//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
													//grabares[0].disabled = true;
													//grabares[1].disabled = true;
													document.getElementById('guardar_productos').disabled = true;
													document.getElementById('contacto_c').disabled = true;
													document.getElementById('btn_contacto_c').disabled = true;
													document.getElementById('btn_clr_contacto_c').disabled = true;
													document.getElementById('date_closed').disabled = true;
													document.getElementById('date_closed_trigger').style.display = 'none';
													deshabilita_campos();
												}
											}";
							$resultado.="}";
									}
					$resultado.="}
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
								'module=Accounts&action=relacionadores&cuenta='+cuenta_sin_epacios+'&nombre='+nombre+'&to_pdf=1');
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
												var producto = usuario_producto[1];
												tr_padre =document.getElementById('valor_'+producto).parentNode.parentNode;
												tr_padre.childNodes[41].innerHTML = usuario;
											}
										}
										SUGAR.ajaxUI.hideLoadingPanel();
										if(nombre != '')
										{
											muestra_nuevos(actual_cuenta);
										}
									},
									'failure':function(result)
									{
									},
								},
								'module=Accounts&action=relacionadores&cuenta='+cuenta_sin_epacios+'&nombre='+nombre+'&to_pdf=1');
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
								'module=Accounts&action=asignados&cuenta='+cuenta_sin_epacios+'&nombre='+nombre+'&to_pdf=1');
							}
				
							function cambiaono() 
							{
								var resp7 = isInDocument(document.getElementById('sales_stage'));
								if(!resp7)
								{}
								else
								{
									var actual = document.getElementById('sales_stage').value;
									if(actual != window.oldValue)
									{
										valida_estado(window.oldValue,actual);
									}
									window.oldValue =  document.getElementById('sales_stage').value;
								}
							}
														
							function valida_descripcion()
							{
								var sihay = 0;";
								$db =  DBManagerFactory::getInstance();
								$account = new Account(); 
								$account->retrieve($_REQUEST['record']); 
								$contacts = $account->get_linked_beans('opportunities','Opportunity'); 
								foreach ( $contacts as $contact ) 
								{ 
									$nombre = $contact->name;
									$resultado.=" var elements = document.getElementsByName('name');
									var nombre_op = elements[0].value;
									if(nombre_op == '".$nombre."')
									{
										sihay = 1;
									}";
								}
					$resultado.="if(sihay == 1)
								{
									descripcion = document.getElementById('description').value;
									//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
									if(descripcion != '')
									{
										vista = document.getElementById('nombre').style.display;
										if(vista == 'none')
										{
											//grabares[0].disabled = false;
											//grabares[1].disabled = false;
											document.getElementById('guardar_productos').disabled = false;
										}
										if(document.getElementById('sales_stage').value == 'Needs Analysis')
										{
											document.getElementById('sales_stage').value = 'Perception Analysis';
										}
										habilita();
									}
									else
									{
										//grabares[0].disabled = true;
										//grabares[1].disabled = true;
										document.getElementById('guardar_productos').disabled = true;
									}
								}
							}
							
							function valida_descripcion2()
							{
								descripcion = document.getElementById('description').value;
								etapa = document.getElementById('sales_stage').value;
								//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
								if(descripcion != '')
								{
									var oportunidad =  document.getElementsByName('name');
									if(oportunidad == '')
									{
										vista = document.getElementById('nombre').style.display;
										if(vista == 'none')
										{
											//grabares[0].disabled = false;
											//grabares[1].disabled = false;	
											document.getElementById('guardar_productos').disabled = false;											
											return '1';
										}
										else
										{
											//grabares[0].disabled = true;
											//grabares[1].disabled = true;
											document.getElementById('guardar_productos').disabled = true;
											return '0';
										}
									}
								}
								else
								{
									//grabares[0].disabled = true;
									//grabares[1].disabled = true;
									document.getElementById('guardar_productos').disabled = true;
									return '0';
								}
							}
							
							function valida_cerrado()
							{
								var productos = document.getElementsByName('prospecto');
								var resps = isInDocument(productos[0]);
								if(!resps)
								{
								}
								else
								{
									etapa = document.getElementById('sales_stage').value;
									if(etapa == 'Closed Lost' || etapa == 'Closed Won')
									{
										//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
										//var arriba = grabares[0].disabled = true;
										//var abajo = grabares[1].disabled = true;
										document.getElementById('guardar_productos').disabled = true;
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
								SUGAR.ajaxUI.hideLoadingPanel();
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
									$query = "select role_id from acl_roles_users where user_id = '".$id_user."'";
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
									else
									{
										$resultado.="document.getElementById('sales_stage').disabled = false;";
									}
					$resultado.="}
								else
								{
									if(etapa == 'Closed Won')
									{";
										$db =  DBManagerFactory::getInstance(); 
										$rol='';
										$query = "select role_id from acl_roles_users where user_id = '".$id_user."'";
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
											 document.getElementById('sales_stage').disabled = true;";
										}
						$resultado.="}
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
								var _form = document.getElementById('form_SubpanelQuickCreate_Opportunities');
								disableOnUnloadEditView(); 
								_form.action.value='Save'; 
								if(check_form('form_SubpanelQuickCreate_Opportunities'))
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
									document.getElementById('guardar_productos').disabled = true;
									 //DETALLE OPORTUNIDAD
									var campos = document.getElementsByName('prospecto');		
									var string_campos = ''; 	 					
									for(var i = 0;i<campos.length;i++)
									{	
										var partes = campos[i].id.split('_');								
										var valor = document.getElementById('valor_'+partes[1]).value;	
										var producto = partes[1]; 
										var forma_pago = document.getElementById('forma_pago_'+partes[1]).value;
										var descripcion = document.getElementById('descripcion_'+partes[1]).value;									
											if(valor != '' && valor != '0.00' && valor != '0')
											{ 
													var estatus = '1';															
											} 
											else 
											{ 														
													valor = '0';
													forma_pago = '0';
													descripcion = '0';
													estatus = '0';																	
											}
										string_campos += producto+':'+valor+':'+forma_pago+':'+descripcion+':'+estatus+';';																								
									}
									SUGAR.ajaxUI.showLoadingPanel();
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result0)
										{																								
											var retorno = $.trim(result0.responseText);											
											if($.trim(result0.responseText) == '1')
											{															
												SUGAR.ajaxUI.hideLoadingPanel(); 
												alert('Los datos se guardaron correctamente.'); 
												recarga();	
											} 
											else 
											{ 
												SUGAR.ajaxUI.hideLoadingPanel();
												alert('No se pudo Grabar la oportunidad, Si el error continua informe al Administrador de Sugar.');
											} 												
										},
										'failure':function(result0)
										{ 
											alert('Ha ocurrio un Error, por favor intentelo de nuevo.');
										},
									},
'module=Accounts&action=guarda_producto&id_usuario='+id_usuario+'&usuario='+usuario+'&cuenta='+cuenta_sin_epacios+'&oportunidad='+oportunidad[0].value+'&descripcion1='+description+'&duenio='+duenio+'&seccion='+seccion+'&contacto='+contacto+'&etapa='+etapa+'&total_op='+total_op+'&fecha_cierre='+fecha_cierre+'&id_contact='+id_contact+'&check='+check+'&datos='+string_campos+'&guarda_o_no='+guarda_o_no+'&to_pdf=1');																									
								}
								else
								{												
									SUGAR.ajaxUI.hideLoadingPanel();
								}
							}																																														
							
							function guarda_producto(campo)
							{
								var partes = campo.id.split('_');
								var valor = document.getElementById('valor_'+partes[1]).value;
								var elements = document.getElementsByName('name');
								var oportunidad = elements[0].value;
								var partes2 = campo.id.split('_');
								var producto = partes2[1];
								var estado = campo.checked;
								var usuario = '".$usuario."';
								var id_usuario = '".$id_user."';
								var cuenta = '".$cuenta."';
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
									},
									'failure':function(result)
									{
										alert('No se ha podido guardar el valor en base de datos, por favor espere un momento y vuelva a intentar');
									},
								},
								'module=Accounts&action=guarda_producto&id_usuario='+id_usuario+'&usuario='+usuario+'&cuenta='+cuenta+'&producto='+producto+'&oportunidad='+oportunidad+'&estado='+estado+'&valor='+valor+'&to_pdf=1');
								var valida = document.getElementById('nombre');
								if(valida.style.display == 'none')
								{
									habilita();
								}
								else
								{}
							}
							
							function habilita_campos()
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
							
							function habilita()
							{
								var elegido = '0';
								//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
								//var arriba = grabares[0];
								//var abajo = grabares[1];
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
									//arriba.disabled = true;
									//abajo.disabled = true;
									document.getElementById('guardar_productos').disabled = true;
								}
								else
								{
									//arriba.disabled = false;
									//abajo.disabled = false;
									etapa = document.getElementById('sales_stage').value;
									if(etapa == 'Closed Lost')
									{";
										if($id_user != '1')
										{
											$resultado.="document.getElementById('guardar_productos').disabled = true;";
										}
						$resultado.="}
									else
									{
										document.getElementById('guardar_productos').disabled = false;
									}
								}
							}
							
							function calcula()
							{
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
							
							function valida_nombre()
							{
								var elements = document.getElementsByName('name');
								var nombre_oportunidad = elements[0].value;
								//var grabares = document.getElementsByName('Opportunities_subpanel_save_button');
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
												//grabares[0].disabled = true;
												//grabares[1].disabled = true;
												document.getElementById('guardar_productos').disabled = true;
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
									//grabares[0].disabled = true;
									//grabares[1].disabled = true;
									document.getElementById('guardar_productos').disabled = true;
									deshabilita_campos();
								}
							}
							
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
													document.getElementById('guardar_productos').disabled = true;";
									}
									else
									{
										$resultado.="if(nuevo == 'Closed Won')
													{
														SUGAR.ajaxUI.showLoadingPanel();
														 var elements = document.getElementsByName('name');
														 var nombre_oportunidad = elements[0].value;
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
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Accounts&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');
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
														 var elements = document.getElementsByName('name');
														 var nombre_oportunidad = elements[0].value;
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
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Accounts&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');
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
														 var elements = document.getElementsByName('name');
														 var nombre_oportunidad = elements[0].value;
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
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Accounts&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');
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
										$query = "select role_id from acl_roles_users where user_id = '".$id_user."'";
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
														 var elements = document.getElementsByName('name');
														 var nombre_oportunidad = elements[0].value;
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
																	setTimeout(function(){SUGAR.ajaxUI.hideLoadingPanel();},3000);
																}
															},
															'failure':function(result)
															{
															},
														},
														'module=Accounts&action=valida_presupuestos&id_usuario='+usuario+'&oportunidad='+nombre_oportunidad+'&cuenta='+cuenta_sin_epacios+'&duenio='+duenio+'&guarda_o_no='+guarda_o_no+'&id_oportunidad='+id_oportunidad+'&to_pdf=1');";
										}
										else
										{
								$resultado.="alert('No tiene permisos para cerrar la oportunidad');
											 document.getElementById('sales_stage').value = 'Quote';";
										}
						$resultado.="}
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
							
							function validafono(event)
							{
								var tipo = event.data.param;
								var valor = event.data.param2;
								var cadena = valor.value;
								var campo = valor.id;
								YAHOO.util.Connect.asyncRequest(
								'POST',
								'index.php',
								{
									'success':function(result)
									{
										if(result.responseText == 'ph_failure_1')
										{
											alert('Longitud de telefono no valida Se requiere 9 numeros');
											document.getElementById(campo).value = '';
										}
										else
										{
											if(result.responseText == 'ph_failure_2')
											{
												alert('No se debe repetir el mismo numero 9 veces');
												document.getElementById(campo).value = '';
											}
											else
											{
												if(result.responseText == 'ph_failure_3')
												{
													alert('Solo se adimiten numeros');
													document.getElementById(campo).value = '';
												}
												else
												{
													if(result.responseText == 'cph_failure_1')
													{
														alert('Solo se podra ingresar numeros iniciados en 09');
														document.getElementById(campo).value = '';
													}
													else
													{
														if(result.responseText == 'cph_failure_2')
														{
															alert('Longitud de celular no valida (total 10 numeros incluidos 09)');
															document.getElementById(campo).value = '';
														}
														else
														{
															if(result.responseText == 'cph_failure_3')
															{
																alert('No se debe repetir el mismo numero 8 veces (despues de 09)');
																document.getElementById(campo).value = '';
															}
															else
															{
																if(result.responseText == 'cph_failure_4')
																{
																	alert('Solo se adimiten numeros');
																	document.getElementById(campo).value = '';
																}
																else
																{
																	//Todo Ok;
																}
															}				
														}
													}	
												}
											}
										}
									},
									'failure':function(result)
									{
										//alert('Error en la aplicacion');
									},
								},
								'module=Accounts&action=validafono&tipo='+tipo+'&cadena='+cadena+'&to_pdf=1');
							}
						</script>";
			echo $resultado;
		}
		if($_REQUEST['action']=='index')
		{
			$resultado.="<script type='text/javascript'>
							$('.ab').hide();
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
						 </script>";
						 echo $resultado;
		}
	}
}
?>