<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

class clase
{
    function funcion($event, $arguments)
	{
		if($_REQUEST['action']=='DetailView')
        {
			require_once("custom/modules/Asignacion_productos/vista_detalle_simple.php");
        }
		else if($_REQUEST['action']=='EditView')
		{
			global $current_user; 
			$id = $current_user->id; 
			$db =  DBManagerFactory::getInstance(); 
			$query = "select role_id from acl_roles_users where user_id = '".$id."' and deleted = '0'";
			$result = $db->query($query, true, 'Error selecting the role_user record');
			if($row=$db->fetchByAssoc($result))
			{
				$db2 =  DBManagerFactory::getInstance();
				$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
				$result2 = $db2->query($query2, true, 'Error selecting the role name record');
				if($row2=$db2->fetchByAssoc($result2))
				{
					if($row2['name'] == 'Supervisor Operativo' || $row2['name'] == 'Administrador')
					{
						$resultado.="<script type='text/javascript'>
						 var element = document.getElementById('content');
						 element.parentNode.removeChild(element);
						 window.location.href = 'index.php?module=Asignacion_productos&action=vista_lista_completa';
						</script>";
						echo $resultado;
					}
					else if($row2['name'] == 'Comercial' || $row2['name'] == 'Jefe de Ventas')
					{
						$resultado.="<script type='text/javascript'>
							var cuenta_llena = document.getElementById('id_cuenta_c').value;
							if(cuenta_llena != '')
							{
								document.getElementById('id_cuenta_c').disabled =true;
								document.getElementById('btn_id_cuenta_c').disabled =true;
								document.getElementById('btn_clr_id_cuenta_c').disabled =true;
							}
							var oldValue = document.getElementById('id_cuenta_c').value;
							function checkIfValueChanged() 
							{
								var actual = document.getElementById('id_cuenta_c').value;
								if(actual != oldValue)
								{
									if ($('#id_cuenta_c').is(':focus'))
									{}
									else
									{
										document.getElementById('name').value = actual;
										//clearInterval(checker);
									}
								}
							}
							var checker = setInterval('checkIfValueChanged()', 500);
							document.getElementById('name').parentNode.style.display = 'none';
							document.getElementById('name_label').style.display = 'none';
							document.getElementById('assigned_user_name').parentNode.parentNode.style.display = 'none';
							document.getElementById('SAVE_FOOTER').parentNode.style.display = 'none';
							document.getElementById('SAVE_HEADER').value = 'Realizar Solicitud';
							document.getElementById('id_cuenta_c').autocomplete = 'on';
							document.getElementById('id_cuenta_c').onkeypress = agranda;
							function agranda()
							{
								document.getElementById('EditView_id_cuenta_c_results').onmouseover = agranda2;
								document.getElementById('EditView_id_cuenta_c_results').childNodes[0].style.width = '500px';
							}
							function agranda2()
							{
								document.getElementById('EditView_id_cuenta_c_results').childNodes[0].style.width = '500px';
							}
					     </script>";
						 echo $resultado;
					}
					else
					{
						$resultado.="<script type='text/JavaScript' src='include/javascript/sugarwidgets/SugarYUIWidgets.js'></script>
								 <script type='text/javascript'>
									var element = document.getElementById('main');
									element.parentNode.removeChild(element);
									YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'No tiene permisos para acceder a este modulo',type:'alert',width: 500, fn: function() { window.location.href='index.php';}});
								 </script>";
						echo $resultado;
					}
				}
			}
		}
		else if($_REQUEST['action']=='index')
		{
			global $current_user; 
			$id = $current_user->id;
			$db =  DBManagerFactory::getInstance(); 
			$query = "select role_id from acl_roles_users where user_id = '".$id."' and deleted = '0'";
			$result = $db->query($query, true, 'Error selecting the detail product record');
			if($row=$db->fetchByAssoc($result))
			{
				$db2 =  DBManagerFactory::getInstance();
				$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
				$result2 = $db2->query($query2, true, 'Error selecting the detail product record');
				if($row2=$db2->fetchByAssoc($result2))
				{
					if($row2['name'] == 'Supervisor Operativo' || $row2['name'] == 'Administrador')
					{
						$resultado.="<script type='text/javascript'>
						 var element = document.getElementById('content');
						 element.parentNode.removeChild(element);
						 window.location.href = 'index.php?module=Asignacion_productos&action=vista_lista_completa';
						</script>";
						echo $resultado;
					}
					else if($row2['name'] == 'Comercial' || $row2['name'] == 'Jefe de Ventas')
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
						</script>";
						echo $resultado;
					}
					else
					{
						$resultado.="<script type='text/JavaScript' src='include/javascript/sugarwidgets/SugarYUIWidgets.js'></script>
								 <script type='text/javascript'>
									var element = document.getElementById('main');
									element.parentNode.removeChild(element);
									YAHOO.SUGAR.MessageBox.show({title: 'Mensaje de Sugar',msg: 'No tiene permisos para acceder a este modulo',type:'alert',width: 500, fn: function() { window.location.href='index.php';}});
								 </script>";
						echo $resultado;
					}
				}
			}
		}
		else if($_REQUEST['action']=='vista_lista_pendientes')
		{}
		else
		{}
	}
}
?>