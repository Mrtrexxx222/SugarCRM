<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$i=1;
$j=1;
$cont=0;

$resultado.="<script type='text/JavaScript' src='include/javascript/sugarwidgets/SugarYUIWidgets.js'></script> ";
$resultado.="<div id='ajaxStatusDiv' class='dataLabel' style='left: 45%; display: none;'><font size='3'>Cargando...</font></div>
			 <div id='Asignacion_productos_SearchForm_custom' style class='detail view  detail508'>
				<table width='100%' cellspacing='0' cellpadding='0' border ='0'>
					<tbody>
						<tr>
							<td>
								<input id='regresar' class='button' type='button' value='Regresar' onclick='regresar();'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input id='editar' class='button' type='button' value='Aprobar todos' onclick='aprobar_todos();'>
								<input id='editar' class='button' type='button' value='Guardar' onclick='guardar();'>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id='contenedor_busqueda'>";
	$resultado.="<table id='DEFAULT2' width='100%' border='0' cellspacing='0' cellpadding='0' class='edit view'>
					<tbody>
						<tr>
							<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Linea de producto</b></font></td>
							<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Producto</b></font></td>
							<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Cuenta</b></font></td>
							<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Marca</b></font></td>
							<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Usuario</b></font></td>
							<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'><font size='2'><b>Estado</b></font></td>
						</tr>";
						$db =  DBManagerFactory::getInstance();
						//$query = "SELECT a.*, c.first_name, c.last_name FROM detalle_asig_producto_cstm a, detalle_asig_producto b, users c WHERE a.estatus_c = 'Solicitar' AND b.assigned_user_id = c.id AND a.id_c = b.id ORDER BY a.nombre_cuenta_c";
						$query = "SELECT a.*, c.first_name, c.last_name, d.nombre_comercial_marca_c FROM detalle_asig_producto_cstm a, detalle_asig_producto b, users c, accounts_cstm d WHERE a.estatus_c = 'Solicitar' AND b.assigned_user_id = c.id AND a.account_id_c = d.id_c AND a.id_c = b.id ORDER BY a.nombre_cuenta_c";
						
						$result = $db->query($query, true, 'Error selecting the detail product record');
						while($row=$db->fetchByAssoc($result))
						{
				$resultado.="<tr>
								<td id = 'linea".$i."' style='border:1px solid; border-color: #D8D8D8;'>".$row['nombre_linea_c']."</td>
								<td id = 'producto".$i."' style='border:1px solid; border-color: #D8D8D8;'>".$row['nombre_producto_c']."</td>
								<td id = 'cuenta".$i."' style='border:1px solid; border-color: #D8D8D8;'>".$row['nombre_cuenta_c']."</td>
								<td id = 'marca".$i."' style='border:1px solid; border-color: #D8D8D8;'>".$row['nombre_comercial_marca_c']."</td>
								<td id = 'usuario".$i."' style='border:1px solid; border-color: #D8D8D8;'>".$row['first_name']." ".$row['last_name']."</td>
								<td id = 'estatus".$i."' style='border:1px solid; border-color: #D8D8D8;' onclick='toogledisplay(this.id,1);'>
									<p id='parrafo".$i."' name='parrafos'>".$row['estatus_c']."</p>
									<select id='selec".$i."' onblur='cambia(this.id);' style='display:none;'>
										<option>Aprobado</option>
										<option>No aprobado</option>
										<option>Solicitar</option>
									</select>
								</td>
							</tr>";
							$i++;
							$cont++;
						}
		$resultado.="</tbody>
				</table>
			</div>";
$resultado.="<script type='text/javascript'>
				 
		      </script>
			  <script type='text/javascript'>
				    function prepare_progress_bar()
					{
						document.getElementById('ajaxStatusDiv').style.display = 'block';
						var progress = 0;
						updateProgress(progress);
					}
					function updateProgress(progress)
					{
						cont = ".$cont.";
						if(progress < 100)
						{
							progress += 1;
							if(cont >= 1 && cont <= 64)
							{
								setTimeout(function(){updateProgress(progress);}, 200);
							}
							if(cont >= 65 && cont <= 128)
							{
								setTimeout(function(){updateProgress(progress);}, 400);
							}
							if(cont >= 129 && cont <= 256)
							{
								setTimeout(function(){updateProgress(progress);}, 800);
							}
							if(cont >= 257 && cont <= 512)
							{
								setTimeout(function(){updateProgress(progress);}, 1600);
							}
							if(cont >= 513 && cont <= 1024)
							{
								setTimeout(function(){updateProgress(progress);}, 3200);
							}
						}
						else
						{
							document.getElementById('ajaxStatusDiv').style.display = 'none';
							YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Datos Guardados',type:'alert',width: 200, fn: function() {setTimeout(function(){window.location.reload();}, 100);}});
						}
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
					function regresar()
					{
						window.location.href = 'index.php?module=Asignacion_productos&action=vista_lista_completa';
					}
					function aprobar_todos()
					{
						estatus = document.getElementsByName('parrafos');
						for(var i=0;i<estatus.length;i++)
						{
							estatus[i].childNodes[0].nodeValue = 'Aprobado';
						}
					}
					function guardar()
					{
						var cadena = '';";
						$i=1;
						$db =  DBManagerFactory::getInstance();
						$query = "SELECT a.*, c.first_name, c.last_name, d.nombre_comercial_marca_c, b.assigned_user_id FROM detalle_asig_producto_cstm a, detalle_asig_producto b, users c, accounts_cstm d WHERE a.estatus_c = 'Solicitar' AND b.assigned_user_id = c.id AND a.account_id_c = d.id_c AND a.id_c = b.id ORDER BY a.nombre_cuenta_c";
						$result = $db->query($query, true, 'Error selecting the detail product records');
						while($row=$db->fetchByAssoc($result))
						{
					$resultado.="var id_cuenta = '".$row['account_id_c']."';
								var nombre_cuenta = '".$row['nombre_cuenta_c']."';
								if ( nombre_cuenta.indexOf('&') > -1 ) 
								{
									var cuenta=nombre_cuenta.replace('&','/');
								}
								else 
								{
									var cuenta = nombre_cuenta;
								}
								var producto = '".$row['nombre_producto_c']."';
								var usuario = '".$row['first_name']." ".$row['last_name']."';
								var id_usuario = '".$row['assigned_user_id']."';
								var estatus = document.getElementById('parrafo".$i."').childNodes[0].nodeValue;
								var id_producto = '".$row['producttemplate_id_c']."';
								var linea = '".$row['nombre_linea_c']."';
								if(estatus == 'Aprobado' || estatus == 'No aprobado')
								{
									cadena += id_cuenta+'_'+id_usuario+'_'+usuario+'_'+id_producto+'_'+estatus;	
									cadena += '/';
								}";
								$i++;
						}
				$resultado.="guarda_registro(cadena);
					}
					
					function guarda_registro(cadena)
					{
						var id_cuenta='1';
						var id_user = '1';
						SUGAR.ajaxUI.showLoadingPanel();
						YAHOO.util.Connect.asyncRequest(
						'POST',
						'index.php',
						{	
							'success':function(result)
							{																																
								if(result.responseText == '1')
								{	
									 SUGAR.ajaxUI.hideLoadingPanel();
									 alert('Datos guardados');
									 window.location.href = 'index.php?module=Asignacion_productos&action=vista_lista_pendientes';							
								}	
							},
							'failure':function(result)
							{
								SUGAR.ajaxUI.hideLoadingPanel();
								alert('Hubo un error en el guardado de los datos, si el error persiste contactese con el administrador');
							},
						},
						'module=Detalle_asig_producto&action=save&id_cuenta='+id_cuenta+'&id_user='+id_user+'&cadena='+cadena+'&simple=pend&to_pdf=1');
					}
			  </script>";
echo $resultado;

?>