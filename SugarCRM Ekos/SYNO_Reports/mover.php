<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

class clase
{
    function funcion($event, $arguments)
	{
		global $current_user;
		$id_user = $current_user->id;
		$user_name = $current_user->user_name;
		$resultado = "";
		if($_REQUEST['action']=='EditView')
		{
			$id_record = $GLOBALS['FOCUS']->id;
			if($id_record != '')
			{
				$nombre_reporte = $GLOBALS['FOCUS']->name;
			$resultado.="<script type='text/javascript'>
							setTimeout(function(){oculta();},1000);
							function oculta()
							{
								var resp6 = isInDocument(document.getElementById('name'));
								if(resp6)
								{
									document.getElementById('SAVE_HEADER').value = 'Visualizar Reporte';
									document.getElementById('SAVE_FOOTER').parentNode.style.display = 'none';
									document.getElementById('assigned_user_name').parentNode.style.display = 'none';
									document.getElementById('assigned_user_name_label').style.display = 'none';
									document.getElementById('syno_reports_type').parentNode.style.display = 'none';
									document.getElementById('syno_reports_type_label').style.display = 'none';
									document.getElementById('name').disabled = true;";
									if($nombre_reporte != 'Historico de ventas por relacionador semanal')
									{
										$resultado.="document.getElementById('semanal_mensual_c_label').style.display = 'none';
													 document.getElementById('semanal_mensual_c').parentNode.style.display = 'none';";
									}
									if($nombre_reporte !=  'Cumplimiento por mes' && $nombre_reporte !=  'Cumplimiento por producto' && $nombre_reporte !=  'Cumplimiento por relacionador' && $nombre_reporte !=  'Pipeline de ventas' && $nombre_reporte !=  'Consolidado de Presupuestos y Cumplimiento por relacionador' && $nombre_reporte !=  'Historico de ventas por relacionador semanal' && $nombre_reporte !=  'Ranking de Clientes' && $nombre_reporte !=  'Cuentas asignadas sin actividades')
									{
										$resultado.="
										document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
										document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
										document.getElementById('cuenta_c').parentNode.style.display = 'none';
										document.getElementById('cuenta_c_label').style.display = 'none';
										document.getElementById('probabilidad_c').parentNode.style.display = 'none';
										document.getElementById('probabilidad_c_label').style.display = 'none';
										document.getElementById('ordenar_por_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_c_label').style.display = 'none';
										document.getElementById('ordenar_por_2_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_2_c_label').style.display = 'none';
										document.getElementById('ordenar_por_3_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_3_c_label').style.display = 'none';
										document.getElementById('ordenar_quemado_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_quemado_c_label').style.display = 'none';
										document.getElementById('mes2_c_label').style.display = 'none';
										document.getElementById('mes2_c').parentNode.style.display = 'none';";
									}
									if($nombre_reporte ==  'Cumplimiento por mes' || $nombre_reporte ==  'Cumplimiento por producto' || $nombre_reporte ==  'Cumplimiento por relacionador')
									{
										$resultado.="document.getElementById('cuenta_c').parentNode.style.display = 'none';
										document.getElementById('cuenta_c_label').style.display = 'none';
										document.getElementById('probabilidad_c').parentNode.style.display = 'none';
										document.getElementById('probabilidad_c_label').style.display = 'none';
										document.getElementById('ordenar_por_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_c_label').style.display = 'none';
										document.getElementById('ordenar_por_2_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_2_c_label').style.display = 'none';
										document.getElementById('ordenar_por_3_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_3_c_label').style.display = 'none';
										document.getElementById('ordenar_quemado_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_quemado_c_label').style.display = 'none';
										document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
										document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
										document.getElementById('mes_c_label').childNodes[0].nodeValue = 'Desde:';";
										if($nombre_reporte ==  'Cumplimiento por producto' || $nombre_reporte ==  'Cumplimiento por relacionador')
										{
											$resultado.="document.getElementById('tipo_visualizacion_c').parentNode.style.display = 'none';
														 document.getElementById('tipo_visualizacion_c_label').style.display = 'none';";
										}
									}
									if($nombre_reporte ==  'Pipeline de ventas')
									{
										$resultado.="document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
													 document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
													 document.getElementById('ordenar_quemado_c').disabled = true;
													 document.getElementById('tipo_visualizacion_c_label').style.display = 'none';
													 document.getElementById('tipo_visualizacion_c').parentNode.style.display = 'none';
													 document.getElementById('mes_c_label').childNodes[0].nodeValue = 'Desde:';";
										if($id_user != '1' && $id_user != '85e2aa06-3b0b-76a5-6559-50d1cd9c583a' && $id_user != 'b5460ac0-da52-1c20-a245-50d1cece89bd' )
										{
											$resultado.="document.getElementById('ordenar_quemado_c').disabled = true;
														 document.getElementById('tipo_visualizacion_c_label').style.display = 'none';
														 document.getElementById('tipo_visualizacion_c').parentNode.style.display = 'none';
														 document.getElementById('mes_c_label').childNodes[0].nodeValue = 'Desde:';";
										}
									}
									if($nombre_reporte ==  'Consolidado de Presupuestos y Cumplimiento por relacionador' || $nombre_reporte ==  'Historico de ventas por relacionador semanal')
									{
										$resultado.="document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
													 document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
													 document.getElementById('cuenta_c').parentNode.style.display = 'none';
													 document.getElementById('cuenta_c_label').style.display = 'none';
													 document.getElementById('ordenar_por_c').parentNode.style.display = 'none';
													 document.getElementById('ordenar_por_c_label').style.display = 'none';
													 document.getElementById('ordenar_por_2_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_por_2_c_label').style.display = 'none';
													document.getElementById('ordenar_por_3_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_por_3_c_label').style.display = 'none';
													document.getElementById('ordenar_quemado_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_quemado_c_label').style.display = 'none';
													 document.getElementById('mes_c_label').childNodes[0].nodeValue = 'Desde:';";
									}
									if($nombre_reporte ==  'Mapa de relacionadores')
									{
										$resultado.="document.getElementById('periodo_c').parentNode.parentNode.style.display = 'none';
										document.getElementById('linea_de_producto_c').parentNode.style.display = 'none';
										document.getElementById('linea_de_producto_c_label').style.display = 'none';
										document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_c_label').style.display = 'none';
										document.getElementById('ordenar_por_2_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_2_c_label').style.display = 'none';
										document.getElementById('ordenar_por_3_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_3_c_label').style.display = 'none';
										document.getElementById('ordenar_quemado_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_quemado_c_label').style.display = 'none';
										document.getElementById('tipo_visualizacion_c').parentNode.parentNode.style.display = 'none';
										document.getElementById('mes2_c_label').style.display = 'none';
										document.getElementById('mes2_c').parentNode.style.display = 'none';";
									}
									if($nombre_reporte ==  'Presupuesto mensual por producto' || $nombre_reporte ==  'Presupuesto mensual por relacionador' || $nombre_reporte ==  'Presupuesto por relacionador por producto' || $nombre_reporte ==  'Presupuesto por producto por relacionador por mes')
									{
										$resultado.="document.getElementById('mes_c').parentNode.style.display = 'none';
										document.getElementById('mes_c_label').style.display = 'none';
										document.getElementById('linea_de_producto_c').parentNode.style.display = 'none';
										document.getElementById('linea_de_producto_c_label').style.display = 'none';
										document.getElementById('producto_c').parentNode.style.display = 'none';
										document.getElementById('producto_c_label').style.display = 'none';
										document.getElementById('relacionador_c').parentNode.style.display = 'none';
										document.getElementById('relacionador_c_label').style.display = 'none';
										document.getElementById('tipo_cumplimiento_c').style.display = 'none';
										document.getElementById('mes2_c_label').style.display = 'none';
										document.getElementById('mes2_c').parentNode.style.display = 'none';
										document.getElementById('tipo_visualizacion_c').parentNode.parentNode.style.display = 'none';";
									}
									if($nombre_reporte ==  'Ranking de Clientes')
									{
										$resultado.="document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
													 document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
													 document.getElementById('cuenta_c').parentNode.style.display = 'none';
													 document.getElementById('cuenta_c_label').style.display = 'none';
													 document.getElementById('ordenar_por_c').parentNode.style.display = 'none';
													 document.getElementById('ordenar_por_c_label').style.display = 'none';
													 document.getElementById('ordenar_por_2_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_por_2_c_label').style.display = 'none';
													document.getElementById('ordenar_por_3_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_por_3_c_label').style.display = 'none';
													document.getElementById('ordenar_quemado_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_quemado_c_label').style.display = 'none';
													 document.getElementById('mes_c_label').childNodes[0].nodeValue = 'Desde:';
													 document.getElementById('probabilidad_c').parentNode.style.display = 'none';
													 document.getElementById('probabilidad_c_label').style.display = 'none';
													 document.getElementById('tipo_visualizacion_c').parentNode.parentNode.style.display = 'none';";
									}
									if($nombre_reporte ==  'Cuentas asignadas sin actividades')
									{
										$resultado.="document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
													 document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
													 document.getElementById('cuenta_c').parentNode.style.display = 'none';
													 document.getElementById('cuenta_c_label').style.display = 'none';
													 document.getElementById('ordenar_por_c').parentNode.style.display = 'none';
													 document.getElementById('ordenar_por_c_label').style.display = 'none';
													 document.getElementById('ordenar_por_2_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_por_2_c_label').style.display = 'none';
													document.getElementById('ordenar_por_3_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_por_3_c_label').style.display = 'none';
													document.getElementById('ordenar_quemado_c').parentNode.style.display = 'none';
													document.getElementById('ordenar_quemado_c_label').style.display = 'none';
													 document.getElementById('mes_c_label').childNodes[0].nodeValue = 'Desde:';
													 document.getElementById('probabilidad_c').parentNode.style.display = 'none';
													 document.getElementById('probabilidad_c_label').style.display = 'none';
													 document.getElementById('tipo_visualizacion_c').parentNode.parentNode.style.display = 'none';
													 document.getElementById('periodo_c').parentNode.style.display = 'none';
													 document.getElementById('periodo_c_label').style.display = 'none';
													 document.getElementById('mes_c').parentNode.style.display = 'none';
													 document.getElementById('mes_c_label').style.display = 'none';
													 document.getElementById('mes2_c').parentNode.style.display = 'none';
													 document.getElementById('mes2_c_label').style.display = 'none';";
									}
					$resultado.="}
								else
								{
									setTimeout(function(){oculta();},1000);
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
							var usuarios = new Array();
							var remover = new Array();";
		
				$resultado.="var reporte = '".$nombre_reporte."';
							
								$('#periodo_c').keyup({param1: 'periodo', param2: document.getElementById('periodo_c')},cambia_query1);
								$('#mes_c').keyup({param1: 'mes', param2: document.getElementById('mes_c')},cambia_query2);
								$('#relacionador_c').keyup({param1: 'relacionador', param2: document.getElementById('relacionador_c')},cambia_query3);
								$('#linea_de_producto_c').keyup({param1: 'linea_producto', param2: document.getElementById('linea_de_producto_c')},cambia_query4);
								$('#producto_c').keyup({param1: 'producto', param2: document.getElementById('producto_c')},cambia_query5);
								$('#tipo_cumplimiento_c').keyup({param1: 'tipo_cumplimiento', param2: document.getElementById('tipo_cumplimiento_c')},cambia_query6);
								$('#tipo_visualizacion_c').keyup({param1: 'tipo_visualizacion', param2: document.getElementById('tipo_visualizacion_c')},cambia_query7);
								$('#probabilidad_c').keyup({param1: 'probabilidad', param2: document.getElementById('probabilidad_c')},cambia_query9);
								$('#ordenar_por_c').keyup({param1: 'ordenar', param2: document.getElementById('ordenar_por_c')},cambia_query10);
								$('#ordenar_por_2_c').keyup({param1: 'ordenar', param2: document.getElementById('ordenar_por_2_c')},cambia_query13);
								$('#ordenar_por_3_c').keyup({param1: 'ordenar', param2: document.getElementById('ordenar_por_3_c')},cambia_query14);
								$('#mes2_c').keyup({param1: 'hasta', param2: document.getElementById('mes2_c')},cambia_query11);
								$('#semanal_mensual_c').keyup({param1: 'semanal_mensual', param2: document.getElementById('semanal_mensual_c')},cambia_query12);
								
								$('#periodo_c').click({param1: 'periodo', param2: document.getElementById('periodo_c')},cambia_query1);
								$('#mes_c').click({param1: 'mes', param2: document.getElementById('mes_c')},cambia_query2);
								$('#relacionador_c').click({param1: 'relacionador', param2: document.getElementById('relacionador_c')},cambia_query3);
								$('#linea_de_producto_c').click({param1: 'linea_producto', param2: document.getElementById('linea_de_producto_c')},cambia_query4);
								$('#producto_c').click({param1: 'producto', param2: document.getElementById('producto_c')},cambia_query5);
								$('#tipo_cumplimiento_c').click({param1: 'tipo_cumplimiento', param2: document.getElementById('tipo_cumplimiento_c')},cambia_query6);
								$('#tipo_visualizacion_c').click({param1: 'tipo_visualizacion', param2: document.getElementById('tipo_visualizacion_c')},cambia_query7);
								$('#cuenta_c').blur({param1: 'cuenta', param2: document.getElementById('cuenta_c')},cambia_query8);
								document.getElementById('btn_cuenta_c').setAttribute('onclick','clicka();');
								document.getElementById('btn_clr_cuenta_c').setAttribute('onclick','clicka2();');
								$('#probabilidad_c').click({param1: 'probabilidad', param2: document.getElementById('probabilidad_c')},cambia_query9);
								$('#ordenar_por_c').click({param1: 'ordenar', param2: document.getElementById('ordenar_por_c')},cambia_query10);
								$('#ordenar_por_2_c').click({param1: 'ordenar', param2: document.getElementById('ordenar_por_2_c')},cambia_query13);
								$('#ordenar_por_3_c').click({param1: 'ordenar', param2: document.getElementById('ordenar_por_3_c')},cambia_query14);
								$('#mes2_c').click({param1: 'hasta', param2: document.getElementById('mes2_c')},cambia_query11);
								$('#semanal_mensual_c').click({param1: 'semanal_mensual', param2: document.getElementById('semanal_mensual_c')},cambia_query12);
								
								var periodo = document.getElementById('periodo_c').value;
								var mes = document.getElementById('mes_c').value;
								var mes2 = document.getElementById('mes2_c').value;
								var cuenta = document.getElementById('cuenta_c').value;
								var tipo_cumplimiento = document.getElementById('tipo_cumplimiento_c').value;
								var query = document.getElementById('description').value;
								var query1 = document.getElementById('query1_c').value;
								var query2 = document.getElementById('query2_c').value;
								var tipo_visualizacion = document.getElementById('tipo_visualizacion_c').value;
								var a = document.getElementById('ordenar_por_c');
								var ordenar_por = a.options[a.selectedIndex].label;
								var b = document.getElementById('ordenar_por_2_c');
								var ordenar_por_2 = b.options[b.selectedIndex].label;
								var c = document.getElementById('ordenar_por_3_c');
								var ordenar_por_3 = c.options[c.selectedIndex].label;
								var relacionadores = new Array();
								var relacionador_campo = document.getElementById('relacionador_c');
								var semanal_mensual = document.getElementById('semanal_mensual_c').value;
								for(var i=0;i<relacionador_campo.length;i++)
								{
									if(relacionador_campo[i].selected == true)
									{  
										relacionadores.push(relacionador_campo[i].label);
									}
									else
									{
										relacionadores.splice(i,1);
									}
								}
								var lineas_producto = new Array();
								var linea_campo = document.getElementById('linea_de_producto_c');
								for(var j=0;j<linea_campo.length;j++)
								{
									if(linea_campo[j].selected == true)
									{  
										lineas_producto.push(linea_campo[j].label);
									}
									else
									{
										lineas_producto.splice(j,1);
									}
								}
								var productos = new Array();
								var producto_campo = document.getElementById('producto_c');
								for(var k=0;k<producto_campo.length;k++)
								{
									if(producto_campo[k].selected == true)
									{  
										productos.push(producto_campo[k].label);
									}
									else
									{
										productos.splice(k,1);
									}
								}
								var probabilidades = new Array();
								var probabilidad_campo = document.getElementById('probabilidad_c');
								for(var k=0;k<probabilidad_campo.length;k++)
								{
									if(probabilidad_campo[k].selected == true)
									{  
										probabilidades.push(probabilidad_campo[k].label);
									}
									else
									{
										probabilidades.splice(k,1);
									}
								}
								
								function clicka()
								{
									open_popup('Accounts', 600, 400, '', true, false, {'call_back_function':'set_return2','form_name':'EditView','field_to_name_array':{'id':'account_id_c','name':'cuenta_c'}}, 'single', true);
								}
								function clicka2()
								{
									document.getElementById('cuenta_c').value = '';
									document.getElementById('account_id_c').value = ''; 
									cambia_query8_1();
								}
								function set_return2(popup_reply_data)
								{
									from_popup_return = true;
									var form_name = popup_reply_data.form_name;
									var name_to_value_array = popup_reply_data.name_to_value_array;
									if(typeof name_to_value_array != 'undefined' && name_to_value_array['account_id'])
									{
										var label_str = '';
										var label_data_str = '';
										var current_label_data_str = '';
										var popupConfirm = popup_reply_data.popupConfirm;
										for (var the_key in name_to_value_array)
										{
											if(the_key == 'toJSON')
											{
												/* just ignore */
											}
											else
											{
												var displayValue=replaceHTMLChars(name_to_value_array[the_key]);
												if(window.document.forms[form_name] && document.getElementById(the_key+'_label') && !the_key.match(/account/)) {
													var data_label = document.getElementById(the_key+'_label').innerHTML.replace(/\\n/gi,'').replace(/<\/?[^>]+(>|$)/g, '');
													label_str += data_label + ' \\n';
													label_data_str += data_label  + ' ' + displayValue + '\\n';
													if(window.document.forms[form_name].elements[the_key]) {
														current_label_data_str += data_label + ' ' + window.document.forms[form_name].elements[the_key].value +'\\n';
													}
												}
											}
										}

										if(label_data_str != label_str && current_label_data_str != label_str){
											// Bug 48726 Start
											if (typeof popupConfirm != 'undefined')
											{
												if (popupConfirm > -1) {
													set_return_basic(popup_reply_data,/\S/);
												} else {
													set_return_basic(popup_reply_data,/account/);
												}
											}
											// Bug 48726 End
											else if(confirm(SUGAR.language.get('app_strings', 'NTC_OVERWRITE_ADDRESS_PHONE_CONFIRM') + '\\n\\n' + label_data_str))
											{
												set_return_basic(popup_reply_data,/\S/);
											}
											else
											{
												set_return_basic(popup_reply_data,/account/);
											}
										}else if(label_data_str != label_str && current_label_data_str == label_str){
											set_return_basic(popup_reply_data,/\S/);
										}else if(label_data_str == label_str){
											set_return_basic(popup_reply_data,/account/);
										}
									}else{
										set_return_basic(popup_reply_data,/\S/);
									}
									cambia_query8_1();
								}
								
								function cambia_query8(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.cuenta = document.getElementById('account_id_c').value;
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
											
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query8_1()
								{
									SUGAR.ajaxUI.showLoadingPanel();
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									window.cuenta = document.getElementById('account_id_c').value;
									
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
												SUGAR.ajaxUI.hideLoadingPanel(); 
											}
											else
											{
												document.getElementById('description').value = result.responseText;
												SUGAR.ajaxUI.hideLoadingPanel(); 
											}
											
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query9(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.probabilidades.splice(0);
									for(var j=0;j<campo.length;j++)
									{
										if(campo[j].selected == true)
										{
											window.probabilidades.push(campo[j].label);
										}
										else
										{
											window.probabilidades.splice(j,1);
										}
									}

									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query10(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.ordenar_por = campo.value;
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query13(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.ordenar_por_2 = campo.value;
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query14(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.ordenar_por_3 = campo.value;
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query1(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.periodo = campo.value;
									//window.relacionadores.splice(0);
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query2(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.mes = campo.value;
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query11(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.mes2 = campo.value;
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								
								function cambia_query3(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.relacionadores.splice(0);
									for(var j=0;j<campo.length;j++)
									{
										if(campo[j].selected == true)
										{
											window.relacionadores.push(campo[j].label);
										}
										else
										{
											window.relacionadores.splice(j,1);
										}
									}
									
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								function cambia_query4(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.lineas_producto.splice(0);
									for(var j=0;j<campo.length;j++)
									{
										if(campo[j].selected == true)
										{
											window.lineas_producto.push(campo[j].label);
										}
										else
										{
											window.lineas_producto.splice(j,1);
										}
									}

									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								function cambia_query5(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.productos.splice(0);
									for(var j=0;j<campo.length;j++)
									{
										if(campo[j].selected == true)
										{
											window.productos.push(campo[j].label);
										}
										else
										{
											window.productos.splice(j,1);
										}
									}

									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								function cambia_query6(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.tipo_cumplimiento = campo.value;
									//window.relacionadores.splice(0);
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								function cambia_query7(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.tipo_visualizacion = campo.value;
									//window.relacionadores.splice(0);
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
								function cambia_query12(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.semanal_mensual = campo.value;
									//window.relacionadores.splice(0);
									YAHOO.util.Connect.asyncRequest(
									'POST',
									'index.php',
									{
										'success':function(result)
										{
											if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
											{
												var partes = result.responseText.split('@');
												document.getElementById('query1_c').value = partes[0];
												document.getElementById('query2_c').value = partes[1];
											}
											else
											{
												document.getElementById('description').value = result.responseText;
											}
										},
										'failure':function(result)
										{
											alert('Problemas con la conexion, recarge la pagina por favor');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&ordenar_por_2='+window.ordenar_por_2+'&ordenar_por_3='+window.ordenar_por_3+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
						</script>";
			echo $resultado;
			}
		}
		if($_REQUEST['action']=='DetailView')
		{
			$id_record = $GLOBALS['FOCUS']->id;
			$nombre_reporte = $GLOBALS['FOCUS']->name;
			$resultado.="<input type='hidden' value='".$GLOBALS['FOCUS']->description."' id='query' />
						<script type='text/javascript'>
			setTimeout(function(){oculta();},1000);
			function oculta()
			{
				var padre = document.getElementById('edit_button_old').parentNode;
				padre.childNodes[0].childNodes[0].nodeValue = 'Editar Filtros';
				document.getElementById('detail_header_action_menu').childNodes[0].childNodes[4].style.display = 'none';
				var reporte = '".$nombre_reporte."';
				if(reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador' || reporte == 'Historico de ventas por relacionador semanal')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					contenedor.childNodes[1].childNodes[2].childNodes[1].childNodes[0].nodeValue = 'Desde:';
					contenedor.childNodes[1].childNodes[10].style.display = 'none';
					contenedor.childNodes[1].childNodes[12].style.display = 'none';
					contenedor.childNodes[1].childNodes[14].style.display = 'none';
					contenedor.childNodes[1].childNodes[16].style.display = 'none';
				}
				if(reporte != 'Historico de ventas por relacionador semanal')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					contenedor.childNodes[1].childNodes[8].style.display = 'none';
				}
				if(reporte == 'Cuentas asignadas sin actividades')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					contenedor.childNodes[1].childNodes[2].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].childNodes[5].childNodes[0].nodeValue = '';
					contenedor.childNodes[1].childNodes[8].style.display = 'none';
					contenedor.childNodes[1].childNodes[10].style.display = 'none';
					contenedor.childNodes[1].childNodes[12].style.display = 'none';
					contenedor.childNodes[1].childNodes[14].style.display = 'none';
					contenedor.childNodes[1].childNodes[16].style.display = 'none';
				}
				if(reporte == 'Mapa de relacionadores')
				{				
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					var nuevo_td = document.createElement('td');
					var nuevo_td2 = document.createElement('td');
					var nuevo_td3 = document.createElement('td');
					var nuevo_td4 = document.createElement('td');
					contenedor.childNodes[1].childNodes[0].childNodes[1].style.display = 'none';
					contenedor.childNodes[1].childNodes[0].childNodes[3].style.display = 'none';
					contenedor.childNodes[1].childNodes[0].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[0].appendChild(nuevo_td2);
					contenedor.childNodes[1].childNodes[2].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].childNodes[5].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].childNodes[7].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td3);
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td4);
					contenedor.childNodes[1].childNodes[8].style.display = 'none';
					contenedor.childNodes[1].childNodes[10].style.display = 'none';
					contenedor.childNodes[1].childNodes[12].style.display = 'none';
					contenedor.childNodes[1].childNodes[14].style.display = 'none';
					contenedor.childNodes[1].childNodes[16].style.display = 'none';
				}
				if(reporte == 'Pipeline de ventas')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					var nuevo_td = document.createElement('td');
					var nuevo_td2 = document.createElement('td');
					contenedor.childNodes[1].childNodes[4].childNodes[5].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].childNodes[7].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[4].appendChild(nuevo_td2);
					contenedor.childNodes[1].childNodes[2].childNodes[1].childNodes[0].nodeValue = 'Desde:';
					var reload_grey = document.getElementById('reload_grey');
					reload_grey.setAttribute('onclick','reload_pipe()');
				}
				if(reporte == 'Ranking de Clientes')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					var nuevo_td = document.createElement('td');
					contenedor.childNodes[1].childNodes[4].childNodes[5].childNodes[0].nodeValue = '';
					contenedor.childNodes[1].childNodes[4].childNodes[7].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[6].childNodes[5].childNodes[0].nodeValue = '';
					contenedor.childNodes[1].childNodes[6].childNodes[7].childNodes[0].nodeValue = '';
					contenedor.childNodes[1].childNodes[10].style.display = 'none';
					contenedor.childNodes[1].childNodes[12].style.display = 'none';
					contenedor.childNodes[1].childNodes[14].style.display = 'none';
					contenedor.childNodes[1].childNodes[16].style.display = 'none';
					contenedor.childNodes[1].childNodes[2].childNodes[1].childNodes[0].nodeValue = 'Desde:';
				}
				if(reporte == 'Presupuesto mensual por producto' || reporte == 'Presupuesto por relacionador por producto' || reporte == 'Presupuesto por producto por relacionador por mes' || reporte == 'Presupuesto mensual por relacionador')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					contenedor.childNodes[1].childNodes[0].style.display = 'none';
					var nuevo_td = document.createElement('td');
					var nuevo_td2 = document.createElement('td');
					contenedor.childNodes[1].childNodes[2].childNodes[1].style.display = 'none';
					contenedor.childNodes[1].childNodes[2].childNodes[3].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].style.display = 'none';
					contenedor.childNodes[1].childNodes[2].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[2].appendChild(nuevo_td2);
					contenedor.childNodes[1].childNodes[8].style.display = 'none';
					contenedor.childNodes[1].childNodes[10].style.display = 'none';
					contenedor.childNodes[1].childNodes[12].style.display = 'none';
					contenedor.childNodes[1].childNodes[14].style.display = 'none';
					contenedor.childNodes[1].childNodes[16].style.display = 'none';
				}
				if(reporte == 'Cumplimiento por mes')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					var nuevo_td = document.createElement('td');
					var nuevo_td2 = document.createElement('td');
					contenedor.childNodes[1].childNodes[6].childNodes[5].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].childNodes[7].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td2);
					contenedor.childNodes[1].childNodes[8].style.display = 'none';
					contenedor.childNodes[1].childNodes[10].style.display = 'none';
					contenedor.childNodes[1].childNodes[12].style.display = 'none';
					contenedor.childNodes[1].childNodes[14].style.display = 'none';
					contenedor.childNodes[1].childNodes[16].style.display = 'none';
					contenedor.childNodes[1].childNodes[2].childNodes[1].childNodes[0].nodeValue = 'Desde:';
				}
				if(reporte == 'Cumplimiento por relacionador' || reporte == 'Cumplimiento por producto')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					var nuevo_td = document.createElement('td');
					var nuevo_td2 = document.createElement('td');
					var nuevo_td3 = document.createElement('td');
					var nuevo_td4 = document.createElement('td');
					contenedor.childNodes[1].childNodes[4].childNodes[5].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].childNodes[7].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[4].appendChild(nuevo_td2);
					contenedor.childNodes[1].childNodes[6].childNodes[5].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].childNodes[7].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td3);
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td4);
					contenedor.childNodes[1].childNodes[8].style.display = 'none';
					contenedor.childNodes[1].childNodes[10].style.display = 'none';
					contenedor.childNodes[1].childNodes[12].style.display = 'none';
					contenedor.childNodes[1].childNodes[14].style.display = 'none';
					contenedor.childNodes[1].childNodes[16].style.display = 'none';
					contenedor.childNodes[1].childNodes[2].childNodes[1].childNodes[0].nodeValue = 'Desde:';
				}
			}
			
			function reload_pipe()
			{
				//location.reload(true);
				var query = document.getElementById('query').value;				
				var query = query.replace('&lt;','<');	
				$('#loading').show();
				$('#chart2').hide();				
				YAHOO.util.Connect.asyncRequest(
				'POST',
				'index.php',
				{
					'success':function(result)
					{					
						//alert(result.responseText);										
						var datos = eval(result.responseText);							
						reloadCanvas(datos);
					},
					'failure':function(result)
					{
						alert('Problemas con la conexion, recarge la pagina por favor');
					},
				},
				'module=SYNO_Reports&action=embudo&query='+query+'&to_pdf=1');
			}
			
			function reloadCanvas(datos)
			{				
				$('#loading').hide();
				$('#chart2').show();					
				//VACIA EL DIV QUE CONTIENE AL GRAFICO Y BORRA TODOS LOS LISTENERS QUE TENGA, PARA EVITAR LA PROPAGACION DE LOS EVENTOS
				$('#chart2').empty();
				$('#chart2').unbind('jqplotDataClick');
				$('#chart2').unbind('jqplotDataHighlight');
				$('#chart2').unbind('jqplotDataUnhighlight');
								
				//OPCIONES Y PROPIEDADES
				var opciones = {
								'grid':{
									'gridLineColor':'#ffffff','background':'rgba(0,0,0,0)','borderWidth':0,'drawBorder':false,'shadow':false
								},
								'legend':{
									'show':true,'location':'s','placement':'insideGrid','rendererOptions':{
										'numberColumns':datos.length
									}
								},'animate':true,'animateReplot':true,'axesDefaults':[
									
								],'seriesDefaults':{
									'renderer':$.jqplot.FunnelRenderer,'rendererOptions':{
										'showDataLabels':true,'widthRatio':0.1,'sectionMargin':1,'dataLabels':'percent'
									}
								},'seriesColors':[
									'#588A78','#CD5200','#2B5D8C','#366D21','#8C2B2B'
								]
							}
				
				//ASIGNACION DE DATOS
				var data = [];
				data.push(datos);
				//ENVIO DE DATOS PARA CREACION DE GRAFICO				
				$.jqplot.config.enablePlugins = true;
				$.jqplot.config.defaultHeight = 660;
				$.jqplot.config.defaultWidth  = 550;
				plot = $.jqplot('chart2', data, opciones );
								
				//FUNCIONES EXTRAS: DRILLDOWN - MOUSEOVER - MOUSEOUT
				$('#chart2').bind('jqplotDataClick', function (event, seriesIndex, pointIndex, data) { 						      
					var url = 'index.php?module=Opportunities&action=listaPipe&sel='+data;                            
					window.open(url, '_blank');					
					}
				);
				$('#chart2').bind('jqplotDataHighlight', function (ev, seriesIndex, pointIndex, data) {	
					margin=15;
					tempX = ev.pageX;
					tempY = ev.pageY;
					$(this).css('cursor','pointer');
					$('#texto').html(' - '+data[0]+': - Total Prospectado: '+data[3]+', -  Total Facturacion Estimada: '+data[4]+'.	Click to drilldown');	
					$('#info_pipe').css({'top': tempY+margin, 'left': tempX+margin});
					$('#info_pipe').css('display','block');
					return;							
					}
				);
				$('#chart2').bind('jqplotDataUnhighlight',function (ev) {
					$(this).css('cursor','auto');  
					$('#info_pipe').hide();
					}
				);
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
			</script>";
			echo $resultado;
		}
		
		if($_REQUEST['action']=='index')
		{
			$id_record = $GLOBALS['FOCUS']->id;
			$name = $GLOBALS['FOCUS']->name;
			$resultado.="<script type='text/javascript'>
			document.getElementById('select_actions_disabled_top').parentNode.style.display = 'none';
			document.getElementById('select_actions_disabled_bottom').parentNode.style.display = 'none';
			
			var checks = document.getElementsByClassName('checkbox');
			var numero = checks.length;
			for(var j=0;j<numero;j++)
			{
				checks[j].style.display = 'none';
			}
			var editor = document.getElementsByClassName('quickEdit');
			var numero1 = editor.length;
			for(var m=0;m<numero1;m++)
			{									
				editor[m].style.display = 'none'; 
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
			</script>";
			echo $resultado;
		}
	}
}
?>