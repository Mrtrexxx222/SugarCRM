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
									if($nombre_reporte !=  'Cumplimiento por mes' && $nombre_reporte !=  'Pipeline de ventas' && $nombre_reporte !=  'Consolidado de Presupuestos y Cumplimiento por relacionador' && $nombre_reporte !=  'Historico de ventas por relacionador semanal' && $nombre_reporte !=  'Ranking de Clientes' && $nombre_reporte !=  'Cuentas asignadas sin actividades')
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
										document.getElementById('mes2_c_label').style.display = 'none';
										document.getElementById('mes2_c').parentNode.style.display = 'none';";
									}
									if($nombre_reporte ==  'Cumplimiento por mes')
									{
										$resultado.="document.getElementById('cuenta_c').parentNode.style.display = 'none';
										document.getElementById('cuenta_c_label').style.display = 'none';
										document.getElementById('probabilidad_c').parentNode.style.display = 'none';
										document.getElementById('probabilidad_c_label').style.display = 'none';
										document.getElementById('ordenar_por_c').parentNode.style.display = 'none';
										document.getElementById('ordenar_por_c_label').style.display = 'none';
										document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
										document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
										document.getElementById('mes2_c_label').style.display = 'none';
										document.getElementById('mes2_c').parentNode.style.display = 'none';";
									}
									if($nombre_reporte ==  'Pipeline de ventas')
									{
										$resultado.="document.getElementById('tipo_cumplimiento_c_label').style.display = 'none';
													 document.getElementById('tipo_cumplimiento_c').parentNode.style.display = 'none';
													 document.getElementById('mes2_c_label').style.display = 'none';
													 document.getElementById('mes2_c').parentNode.style.display = 'none';";
										if($id_user != '1' && $id_user != '85e2aa06-3b0b-76a5-6559-50d1cd9c583a' && $id_user != 'b5460ac0-da52-1c20-a245-50d1cece89bd' )
										{
											$resultado.="document.getElementById('cuenta_c').parentNode.style.display = 'none';
														 document.getElementById('cuenta_c_label').style.display = 'none';
														 document.getElementById('mes2_c_label').style.display = 'none';
														 document.getElementById('mes2_c').parentNode.style.display = 'none';";
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
								$('#cuenta_c').keyup({param1: 'cuenta', param2: document.getElementById('cuenta_c')},cambia_query8);
								$('#probabilidad_c').keyup({param1: 'probabilidad', param2: document.getElementById('probabilidad_c')},cambia_query9);
								$('#ordenar_por_c').keyup({param1: 'ordenar', param2: document.getElementById('ordenar_por_c')},cambia_query10);
								$('#mes2_c').keyup({param1: 'hasta', param2: document.getElementById('mes2_c')},cambia_query11);
								$('#semanal_mensual_c').keyup({param1: 'semanal_mensual', param2: document.getElementById('semanal_mensual_c')},cambia_query12);
								
								$('#periodo_c').click({param1: 'periodo', param2: document.getElementById('periodo_c')},cambia_query1);
								$('#mes_c').click({param1: 'mes', param2: document.getElementById('mes_c')},cambia_query2);
								$('#relacionador_c').click({param1: 'relacionador', param2: document.getElementById('relacionador_c')},cambia_query3);
								$('#linea_de_producto_c').click({param1: 'linea_producto', param2: document.getElementById('linea_de_producto_c')},cambia_query4);
								$('#producto_c').click({param1: 'producto', param2: document.getElementById('producto_c')},cambia_query5);
								$('#tipo_cumplimiento_c').click({param1: 'tipo_cumplimiento', param2: document.getElementById('tipo_cumplimiento_c')},cambia_query6);
								$('#tipo_visualizacion_c').click({param1: 'tipo_visualizacion', param2: document.getElementById('tipo_visualizacion_c')},cambia_query7);
								$('#cuenta_c').click({param1: 'cuenta', param2: document.getElementById('cuenta_c')},cambia_query8);
								$('#probabilidad_c').click({param1: 'probabilidad', param2: document.getElementById('probabilidad_c')},cambia_query9);
								$('#ordenar_por_c').click({param1: 'ordenar', param2: document.getElementById('ordenar_por_c')},cambia_query10);
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
								var ordenar_por = document.getElementById('ordenar_por_c').label;
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
								function cambia_query8(event)
								{
									var reporte = '".$nombre_reporte."';
									window.query1 = document.getElementById('query1_c').value;
									window.query2 = document.getElementById('query2_c').value;
									window.query = document.getElementById('description').value;
									var campo = event.data.param2;
									window.cuenta = campo.value;
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
											alert('Error al tratar aniadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar aniadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
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
											alert('Error al tratar añadir el filtro, por favor vuelva a intentar');
										},
									},
									'module=SYNO_Reports&action=cambia_query&ordenar_por='+window.ordenar_por+'&probabilidad='+window.probabilidades+'&cuenta='+window.cuenta+'&visualizacion='+window.tipo_visualizacion+'&tipo='+window.tipo_cumplimiento+'&reporte='+reporte+'&query='+window.query1+'&periodo='+window.periodo+'&mes='+window.mes+'&mes2='+window.mes2+'&relacionadores='+window.relacionadores+'&producto='+window.productos+'&linea_producto='+window.lineas_producto+'&semanal_mensual='+window.semanal_mensual+'&to_pdf=1');
								}
						</script>";
			echo $resultado;
			}
		}
		if($_REQUEST['action']=='DetailView')
		{
			$id_record = $GLOBALS['FOCUS']->id;
			$nombre_reporte = $GLOBALS['FOCUS']->name;
			$resultado.="<script type='text/javascript'>
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
				}
				if(reporte == 'Pipeline de ventas')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					var nuevo_td = document.createElement('td');
					var nuevo_td2 = document.createElement('td');
					contenedor.childNodes[1].childNodes[4].childNodes[1].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].childNodes[3].style.display = 'none';
					contenedor.childNodes[1].childNodes[4].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[4].appendChild(nuevo_td2);
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
				}
				if(reporte == 'Cumplimiento por relacionador' || reporte == 'Cumplimiento por producto' || reporte == 'Cumplimiento por mes')
				{
					var contenedor = document.getElementById('LBL_DETAILVIEW_PANEL1');
					var nuevo_td = document.createElement('td');
					var nuevo_td2 = document.createElement('td');
					contenedor.childNodes[1].childNodes[4].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].childNodes[5].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].childNodes[7].style.display = 'none';
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td);
					contenedor.childNodes[1].childNodes[6].appendChild(nuevo_td2);
					contenedor.childNodes[1].childNodes[8].style.display = 'none';
				}
			}
			
			function reload()
			{
				window.location.reload();
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