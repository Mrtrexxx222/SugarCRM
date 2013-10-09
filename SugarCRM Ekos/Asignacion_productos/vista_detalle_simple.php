<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$i=0;
$flag="0";
$cont=0;
$id_record = $GLOBALS['FOCUS']->id;
global $current_user;
$id_user = $current_user->id;
$nombres_user = $current_user->first_name." ".$current_user->last_name;
$id_cuenta = $GLOBALS['FOCUS']->account_id_c;
$cuenta = new Account();
$cuenta->retrieve_by_string_fields(array('id'=>$id_cuenta));
$nombre_cuenta = $cuenta->name;

$det_asig_prod = new Detalle_asig_producto();
$det_asig_prod->retrieve_by_string_fields(array('asignacion_productos_id_c'=>$id_record,'assigned_user_id'=>$id_user,'account_id_c'=>$id_cuenta));

$resultado.="<script type='text/javascript' src='include/javascript/sugarwidgets/SugarYUIWidgets.js'></script>
			<div id='ajaxStatusDiv' class='dataLabel' style='left: 45%; display: none;'><font size='3'>Cargando...</font></div>
			<div id='contenedor_mayor'>
				<input title='Guardar' accessKey='S' class='button primary' onclick='guardar();' type='button' name='button' value='Guardar' />";
				if($det_asig_prod->id)
				{
					$flag="1";
					$resultado.="<input type='button' id='limpiar' name='limpiar' value='Limpiar' onclick='limpiar_existe();' />";
				}
				else
				{
					$resultado.="<input type='button' id='limpiar' name='limpiar' value='Limpiar' onclick='limpiar_noexiste();' />";
				}
$resultado.="</div>
	 <div id='contenedor_menor' class='detail view  detail508 '>
		 <table id='DEFAULT2' class='panelContainer' cellspacing='0'>
			 <tbody>
				<tr>
					<td width='12.5%' scope='col'><b>LINEA DE PRODUCTO</b></td>
					<td width='12.5%' scope='col'><b>PRODUCTOS</b></td>
					<td width='37.5%' class='sugar_field'><b>ESTATUS DE APROBACION</b></td>
				</tr>";
				$db =  DBManagerFactory::getInstance();
				$query = "SELECT a.id AS id_producto, a.name AS name_producto, a.category_id AS id_categoria, b.name AS name_categoria FROM product_templates a, product_categories b WHERE a.category_id = b.id and a.deleted = 0 and b.deleted = '0' ORDER BY b.name ASC, a.name ASC";
				$result = $db->query($query, true, 'Error selecting the product record');
				while($row=$db->fetchByAssoc($result))
				{
	$resultado.="<tr>
					<td id ='linea".$i."' width='12.5%' scope='col'>".$row['name_categoria']."</td>
					<td id ='producto".$i."' width='12.5%' scope='col'>".$row['name_producto']."</td>";
					$det_asig_prod2 = new Detalle_asig_producto();
					$det_asig_prod2->retrieve_by_string_fields(array('asignacion_productos_id_c'=>$id_record,'assigned_user_id'=>$id_user,'account_id_c'=>$id_cuenta,'producttemplate_id_c'=>$row['id_producto']));
					if($det_asig_prod2->id)
					{
						if($det_asig_prod2->estatus_c == 'Aprobado')
						{
							$resultado.= "<td id='".$i."' width='12.5%' class='sugar_field'>
											<p id='parrafo".$i."'>".$det_asig_prod2->estatus_c."</p>";
						}
						else
						{
							$resultado.= "<td id='".$i."' width='12.5%' onclick='toogledisplay(this.id,1);' class='sugar_field'>
											<p id='parrafo".$i."'>".$det_asig_prod2->estatus_c."</p>";
						}
					}
					else
					{
						$resultado.="<td id='".$i."' width='12.5%' onclick='toogledisplay(this.id,1);' class='sugar_field'>
										<p id='parrafo".$i."'>No definido</p>";
					}
					$resultado.= "<select id='selec".$i."' onblur='cambia(this.id);' style='display:none;'>
										<option>Solicitar</option>
								</select>
						</td>";
						
		$resultado.="</tr>";
						$i++;
						$cont++;
					}
$resultado.="</tbody>
		</table>
	</div>
<script type='text/javascript'>
	var contenedor_padre = document.getElementById('Asignacion_productos_detailview_tabs');
	var contenedor_mayor = document.getElementById('contenedor_mayor');
	var contenedor_menor = document.getElementById('contenedor_menor');
	contenedor_padre.appendChild(contenedor_mayor);
	contenedor_padre.appendChild(contenedor_menor);
	document.getElementById('btn_view_change_log').disabled =true;
	document.getElementById('duplicate_button').parentNode.style.display = 'none';
	$('.paginationWrapper').hide();
	
</script>
<script type='text/javascript'>
	var flag = '0';
	function prepare_progress_bar()
	{
		document.getElementById('ajaxStatusDiv').style.display = 'block';
		var progress = 0;
		updateProgress(progress);
	}
	function updateProgress(progress)
	{
		cont = ".$cont.";
		if(progress < ".$cont.")
		{
			if(window.flag == '2')
			{
				cont = 10;
			}
			progress += 1;
			if(cont >= 1 && cont <= 10)
			{
				setTimeout(function(){updateProgress(progress);}, 100);
			}
			if(cont >= 11 && cont <= 64)
			{
				setTimeout(function(){updateProgress(progress);}, 150);
			}
			if(cont >= 65 && cont <= 128)
			{
				setTimeout(function(){updateProgress(progress);}, 300);
			}
			if(cont >= 129 && cont <= 256)
			{
				setTimeout(function(){updateProgress(progress);}, 400);
			}
			if(cont >= 257 && cont <= 512)
			{
				setTimeout(function(){updateProgress(progress);}, 800);
			}
			if(cont >= 513 && cont <= 1024)
			{
				setTimeout(function(){updateProgress(progress);}, 1600);
			}
		}
		else
		{
			if(window.flag == '1')
			{
				window.flag = '2';
				var nombre_cuenta = '".$nombre_cuenta."';
				var nombres_usuario = '".$nombres_user."';
				YAHOO.util.Connect.asyncRequest(
				'POST',
				'index.php',
				{
					'success':function(result)
					{},
					'failure':function(result)
					{},
				},
				'module=Detalle_asig_producto&action=enviar_mail&nombre_cuenta='+nombre_cuenta+'&nombres_usuario='+nombres_usuario+'&simple=si&to_pdf=1');
				YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Datos Guardados, ahora se va a enviar el correo de notificacion',type:'alert',width: 400, fn: function() {setTimeout(function(){prepare_progress_bar();}, 100);}});
			}
			else
			{
				if(window.flag == '2')
				{
					YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Correo enviado',type:'alert',width: 200, fn: function() {setTimeout(function(){window.location.reload();}, 100);}});
				}
				else
				{
					YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'Datos guardados',type:'alert',width: 200, fn: function() {setTimeout(function(){window.location.reload();}, 100);}});
				}
				document.getElementById('ajaxStatusDiv').style.display = 'none';
			}
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
	function guardar()
	{
		var cuenta = '".$nombre_cuenta."';
		if ( cuenta.indexOf('&') > -1 ) 
		{
			var nombre_cuenta=cuenta.replace('&','/');
		}
		else 
		{
			var nombre_cuenta = cuenta;
		}
		var parrafos = document.getElementById('DEFAULT2').getElementsByTagName('p');		
		for(var i=0; i<parrafos.length; i++)
		{
			var id_tag = parrafos[i].id;
			var estatus = parrafos[i].childNodes[0].nodeValue;
			var producto = document.getElementById('producto'+i).childNodes[0].nodeValue;
			var id_record = '".$id_record."';
			var id_user = '".$id_user."';
			var id_cuenta = '".$id_cuenta."';
			var nombres_usuario = '".$nombres_user."';
			var linea_producto = document.getElementById('linea'+i).childNodes[0].nodeValue;
			if(estatus == 'Solicitar')
			{
				YAHOO.util.Connect.asyncRequest(
				'POST',
				'index.php',
				{
					'success':function(result)
					{
						resultado = result.responseText.split('/');
						if(resultado[0] != '')
						{
							alert(resultado[0]);
						}
						if(resultado[1] == '1')
						{
							window.flag = '1';
						}
					},
					'failure':function(result)
					{
						alert('Hubo un error en el guardado de los datos, si el error persiste contactese con el administrador');
					},
				},
				'module=Detalle_asig_producto&action=save&id_tag='+id_tag+'&estatus='+estatus+'&id_record='+id_record+'&id_user='+id_user+'&id_cuenta='+id_cuenta+'&producto='+producto+'&linea_producto='+linea_producto+'&nombre_cuenta='+nombre_cuenta+'&nombres_usuario='+nombres_usuario+'&simple=si&to_pdf=1');
			}
		}
		YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'De click en Aceptar y espere a que los datos sean guardados en base de datos',type:'alert',width: 500, fn: function() {setTimeout(function(){prepare_progress_bar();}, 100);}});
	}";
	if($flag == "1")
	{
		$resultado.="function limpiar_existe()
					{
						var parrafos = document.getElementById('DEFAULT2').getElementsByTagName('p');
						for(var i=0; i<parrafos.length; i++)
						{
							parrafos[i].childNodes[0].nodeValue = 'No definido';
						}";
						$query = "select a.id_html_tag_c, estatus_c from detalle_asig_producto_cstm a, detalle_asig_producto b where a.asignacion_productos_id_c = '".$id_record."' and b.assigned_user_id = '".$id_user."' and a.account_id_c = '".$id_cuenta."' AND b.id = a.id_c";
						$result = $db->query($query, true, 'Error selecting the detail product record');
						while($row=$db->fetchByAssoc($result))
						{
							$id_html_num = strstr($row['id_html_tag_c'], 'producto');
							$partes = explode('producto',$id_html_num);
							if(strlen($partes[1]) != 0)
							{
								$resultado.="document.getElementById('parrafo".$partes[1]."').childNodes[0].nodeValue = '".$row['estatus_c']."';";
							}
							else
							{
								$resultado.="document.getElementById('".$row['id_html_tag_c']."').childNodes[0].nodeValue = '".$row['estatus_c']."';";
							}
						}
		$resultado.="}";
	}
	else
	{
		$resultado.="function limpiar_noexiste()
					{
						var parrafos = document.getElementById('DEFAULT2').getElementsByTagName('p');
						for(var i=0; i<parrafos.length; i++)
						{
							parrafos[i].childNodes[0].nodeValue = 'No definido';
						}
					}";
	}
	$resultado.="
</script>";
echo $resultado;

?>

