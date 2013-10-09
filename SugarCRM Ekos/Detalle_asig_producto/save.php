<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
$resultado = ""; 
$tipo_vista = @$_POST['simple']; 
$id_cuenta = @$_POST['id_cuenta']; 
$response = '';
//SELECCIONA EL TIPO DE VISTA QUE SE VA A UTILIZAR 

if($tipo_vista == 'si')
{
	$id_tag = $_POST['id_tag'];
	$estatus = $_POST['estatus'];
	$id_cuenta = $_POST['id_cuenta'];
	$producto = $_POST['producto'];	 
	
	
	$db =  DBManagerFactory::getInstance(); 
	
		$id_record = $_POST['id_record']; 
		$id_user = $_POST['id_user']; 
		$nombre_cuenta = $_POST['nombre_cuenta'];	
		if(strpos($nombre_cuenta,"/") !== false)
		{
			$nombre_cuenta = str_replace("/", "&", $nombre_cuenta);
		}
		$nombres_usuario = $_POST['nombres_usuario'];
		$linea_producto = $_POST['linea_producto'];

		$product = new ProductTemplate(); 
		$product->retrieve_by_string_fields(array('name'=>$producto));
		$id_product = $product->id; 
		$name_product = $product->name; 

		$catgegory = new ProductCategory();
		$catgegory->retrieve_by_string_fields(array('name'=>$linea_producto));
		$id_category = $catgegory->id;

		$det_asig_prod = new Detalle_asig_producto();
		$det_asig_prod->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_product,'assigned_user_id'=>$id_user,'account_id_c'=>$id_cuenta));

		if($det_asig_prod->id)
		{
			if($det_asig_prod->estatus_c == 'Solicitar')
			{
				$resultado.="El producto ".$name_product." ya lo solicito, por favor espere a que el supervisor Operativo le apruebe o niegue la solicitud";
			}
			else if($det_asig_prod->estatus_c == 'No aprobado')
			{
				$det_asig_prod2 = new Detalle_asig_producto();
				$det_asig_prod2->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_product,'account_id_c'=>$id_cuenta,'estatus_c'=>'Solicitar'));
				if($det_asig_prod2->id)
				{
					$resultado.="El producto ".$name_product." ya lo solicito otro relacionador";
				}
				else
				{
					$det_asig_prod3 = new Detalle_asig_producto();
					$det_asig_prod3->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_product,'account_id_c'=>$id_cuenta,'estatus_c'=>'Aprobado'));
					if($det_asig_prod3->id)
					{
						$resultado.="El producto ".$name_product." le fue aprobado a otro relacionador";
					}
					else
					{
						$resultado.="El producto ".$name_product." ya lo solicito, y le fue negado por el Supervisor de Operativo, la solicitud se volvera a realizar";
						$id_det_asig_pro_record = $det_asig_prod->id;					
						$focus = BeanFactory::getBean('Detalle_asig_producto'); 
						valida_auditoria_det_asig($id_det_asig_pro_record->id, $id_user, $estatus); 						
						$query1 = "UPDATE detalle_asig_producto
									SET date_modified = NOW()							
									WHERE id = '".$id_det_asig_pro_record."'"; 
						$result1 = $db->query($query1, true, 'Error selecting the user record');					
						$query2 = "UPDATE detalle_asig_producto_cstm 
									SET	estatus_c = '".$estatus."' 					
									WHERE id_c = '".$id_det_asig_pro_record."'";
						$result2 = $db->query($query2, true, 'Error selecting the user record');
						/*
						$row=$db->fetchByAssoc($result)
						$detalle_asig_producto = $focus->retrieve($id_det_asig_pro_record);
						$detalle_asig_producto->estatus_c = $estatus;
						$detalle_asig_producto->nombre_producto_c = $producto;
						$detalle_asig_producto->nombre_cuenta_c = $nombre_cuenta;
						//$detalle_asig_producto->nombre_usuario_c = $nombres_usuario;
						$detalle_asig_producto->nombre_linea_c = $linea_producto;
						$detalle_asig_producto->save();
						*/
						$resultado.="/1";
					}
				}
			}
			else
			{
				 $resultado.="El producto ".$name_product." ya lo solicito, y le fue aprobado por el Supervisor Operativo";
			}
		}
		else
		{
			$det_asig_prod4 = new Detalle_asig_producto();
			$det_asig_prod4->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_product,'account_id_c'=>$id_cuenta,'estatus_c'=>'Solicitar'));
			if($det_asig_prod4->id)
			{
				 $resultado.="El producto ".$name_product." ya lo solicito otro relacionador";
			}
			else
			{
				$det_asig_prod5 = new Detalle_asig_producto();
				$det_asig_prod5->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_product,'account_id_c'=>$id_cuenta,'estatus_c'=>'Aprobado'));
				if($det_asig_prod5->id)
				{
					  $resultado.="El producto ".$name_product." le fue aprobado a otro relacionador";
				}
				else
				{
					$id_nuevo_detalle = md5(create_guid3());
					$sql_1 = "INSERT INTO detalle_asig_producto 
							(id, date_entered, date_modified, modified_user_id, created_by, deleted, team_id, team_set_id, assigned_user_id)
							 VALUES('".$id_nuevo_detalle."', 
									NOW(), 
									NOW(), 
									'".$id_user."', 
									'".$id_user."', 
									'0', 
									'1', 
									'1', 
									'".$id_user."')";
					$resultSQL_1 = $db->query($sql_1, true, 'Error selecting the user record');
					$sql_2 = "INSERT INTO detalle_asig_producto_cstm 
								(id_c, estatus_c, id_html_tag_c, nombre_cuenta_c, nombre_producto_c, asignacion_productos_id_c, account_id_c, producttemplate_id_c, id_linea_c, nombre_linea_c)
								 VALUES('".$id_nuevo_detalle."', 
										'".$estatus."', 
										'".$id_tag."', 
										'".$nombre_cuenta."', 
										'".$producto."', 
										'".$id_record."', 
										'".$id_cuenta."', 
										'".$id_product."', 
										'".$id_category."', 
										'".$linea_producto."')";
					$resultSQL_2 = $db->query($sql_2, true, 'Error selecting the user record');
					/*
					$focus = new Detalle_asig_producto();
					$focus->asignacion_productos_id_c = $id_record;
					$focus->id_html_tag_c = $id_tag;
					$focus->estatus_c = $estatus;
					$focus->assigned_user_id = $id_user;
					$focus->account_id_c = $id_cuenta;
					$focus->producttemplate_id_c = $id_product;
					$focus->nombre_producto_c = $producto;
					$focus->nombre_cuenta_c = $nombre_cuenta;
					//$focus->nombre_usuario_c = $nombres_usuario;
					$focus->nombre_linea_c = $linea_producto;
					$focus->id_linea_c = $id_category;
					$focus->save();*/
					$resultado.="/1";
				}
			}
		}
	
	echo $resultado;
}

if($tipo_vista == 'no')
{
	$cadena = $_POST['cadena'];
	$id_user_log = $_POST['id_user'];
	$segmentos = explode(";", $cadena);	
	for($i=0;$i < count($segmentos)-1 ;$i++)
	{	
		$sub_seg = explode(":",$segmentos[$i]);		
		$id_tag 	= $sub_seg[0];		
		$id_usuario = $sub_seg[1];	
		$usuario	= $sub_seg[2];
		$producto 	= $sub_seg[3];		
		$estatus 	= $sub_seg[4];
		$response = grabar_registros($tipo_vista,$id_cuenta,$id_tag,$id_usuario,$usuario,$producto,$estatus,$id_user_log);				
		//echo $response;
	}	
	echo ' 1';	
}

if($tipo_vista == 'pend')
{
	$cadena = $_POST['cadena'];
	$id_user_log = $_POST['id_user'];
	$segmentos = explode("/", $cadena);	
	for($i=0;$i < count($segmentos)-1 ;$i++)
	{	
		$sub_seg = explode("_",$segmentos[$i]);		
		$id_cuenta 	= $sub_seg[0];		
		$id_usuario = $sub_seg[1];	
		$usuario	= $sub_seg[2];
		$id_producto = $sub_seg[3];		
		$estatus 	= $sub_seg[4];
		$response = actualizar_registros($id_cuenta,$id_usuario,$usuario,$id_producto,$estatus);				
		//echo $response;
	}	
	echo '1';	
}

function actualizar_registros($id_cuenta,$id_usuario,$usuario,$id_producto,$estatus)	
{
	$resultado = ""; 
	$db =  DBManagerFactory::getInstance();
	
	$product = new ProductTemplate(); 
	$product->retrieve_by_string_fields(array('id'=>$id_producto)); 
		
	$det_asig_prod = new Detalle_asig_producto();
	$det_asig_prod->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario,'estatus_c'=>'Solicitar'));
	if($det_asig_prod->id)
	{
		$query1 = "UPDATE detalle_asig_producto SET date_modified = NOW() WHERE id = '".$det_asig_prod->id."'"; 
		$result1 = $db->query($query1, true, 'Error selecting the user record');
	
		$query2 = "UPDATE detalle_asig_producto_cstm SET estatus_c = '".$estatus."' WHERE id_c = '".$det_asig_prod->id."'";
		$result2 = $db->query($query2, true, 'Error selecting the user record');
	}
	$resultado.="1/".$id_usuario."/".$usuario."/".$product->name."/".$det_asig_prod->nombre_cuenta_c."/".$estatus."/".$det_asig_prod->id;

	$parametros = explode("/", $resultado);
	if($parametros[0] == '1')
	{								
		$mail = enviar_mail($parametros);
		if($mail == '1')
		{
			return '1';
		}
		else
		{
			return '0';
		}			
	}
}

function grabar_registros($simple,$id_cuenta,$id_tag,$id_usuario,$usuario,$producto,$estatus,$id_user_log)
{
	$resultado = ""; 
	$db =  DBManagerFactory::getInstance(); 
	if($simple == "no")
	{
		//$usuario = $_POST['usuario'];
		//$id_usuario = $_POST['id_usuario'];

		$product = new ProductTemplate(); 
		$product->retrieve_by_string_fields(array('name'=>$producto)); 
		$id_producto = $product->id;
		$id_linea = $product->category_id;

		$det_asig_prod = new Detalle_asig_producto();
		$det_asig_prod->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario,'estatus_c'=>'Solicitar'));

		if($det_asig_prod->id)
		{
			valida_auditoria_det_asig($det_asig_prod->id, $id_user_log, $estatus); 
			if($estatus == 'No aprobado' || $estatus == 'Aprobado')
			{	
				$query1 = "UPDATE detalle_asig_producto
							SET date_modified = NOW()							
							WHERE id = '".$det_asig_prod->id."'"; 
				$result1 = $db->query($query1, true, 'Error selecting the user record');
				
				$query2 = "UPDATE detalle_asig_producto_cstm 
							SET	estatus_c = '".$estatus."' 						
							WHERE id_c = '".$det_asig_prod->id."'";
				$result2 = $db->query($query2, true, 'Error selecting the user record');
				/*
				$focus = BeanFactory::getBean('Detalle_asig_producto');
				$detalle_asig_producto = $focus->retrieve($det_asig_prod->id);
				$detalle_asig_producto->estatus_c = $estatus;
				$detalle_asig_producto->save();*/
				$resultado.="1/".$id_usuario."/".$usuario."/".$product->name."/".$det_asig_prod->nombre_cuenta_c."/".$estatus."/".$det_asig_prod->id;				
			}
		}
		else
		{
			$det_asig_prod2 = new Detalle_asig_producto();
			$det_asig_prod2->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario,'estatus_c'=>'Aprobado'));
			if($det_asig_prod2->id)
			{
				if($estatus == 'No aprobado')
				{
					valida_auditoria_det_asig($det_asig_prod2->id, $id_user_log, $estatus); 
					$query1 = "UPDATE detalle_asig_producto
							SET date_modified = NOW()							
							WHERE id = '".$det_asig_prod2->id."'"; 
					$result1 = $db->query($query1, true, 'Error selecting the user record');
					
					$query2 = "UPDATE detalle_asig_producto_cstm 
								SET	estatus_c = '".$estatus."' 						
								WHERE id_c = '".$det_asig_prod2->id."'";
					$result2 = $db->query($query2, true, 'Error selecting the user record');
					/*
					$focus = BeanFactory::getBean('Detalle_asig_producto');
					$detalle_asig_producto = $focus->retrieve($det_asig_prod2->id);
					$detalle_asig_producto->estatus_c = $estatus;
					$detalle_asig_producto->save();
					*/
					$resultado.="1/".$id_usuario."/".$usuario."/".$product->name."/".$det_asig_prod2->nombre_cuenta_c."/".$estatus."/".$det_asig_prod2->id;
				}
			}
			else
			{ 
				$det_asig_prod3 = new Detalle_asig_producto();
				$det_asig_prod3->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario,'estatus_c'=>'No aprobado'));
				if($det_asig_prod3->id)
				{		
					//VALIDA QUE NINGUN OTRO VENDEDOR TENGA EL PRODUCTO APROBADO PARA PODER GRABAR 
					/*$det_asig_prod3_1 = new Detalle_asig_producto();
					$det_asig_prod3_1->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'estatus_c'=>'Aprobado'));
					if($det_asig_prod3_1->id)
					{
						//no guarda, por que ya esta aprobado a otro cliente
						$resultado.="El producto ".$producto." ya esta aprobado a otro relacionador";
					}
					else
					{*/
						if($estatus == 'Aprobado')
						{
							valida_auditoria_det_asig($det_asig_prod3->id, $id_user_log, $estatus); 
							$query1 = "UPDATE detalle_asig_producto
										SET date_modified = NOW()							
										WHERE id = '".$det_asig_prod3->id."'"; 
							$result1 = $db->query($query1, true, 'Error selecting the user record');
							
							$query2 = "UPDATE detalle_asig_producto_cstm 
										SET	estatus_c = '".$estatus."' 						
										WHERE id_c = '".$det_asig_prod3->id."'";
							$result2 = $db->query($query2, true, 'Error selecting the user record');
							/*
							$focus = BeanFactory::getBean('Detalle_asig_producto');
							$detalle_asig_producto = $focus->retrieve($det_asig_prod3->id);
							$detalle_asig_producto->estatus_c = $estatus;
							$detalle_asig_producto->save();
							*/
							$resultado.="1/".$id_usuario."/".$usuario."/".$product->name."/".$det_asig_prod3->nombre_cuenta_c."/".$estatus."/".$det_asig_prod3->id;
							//$resultado.= " - entro 03";
						}
					/*}*/					
				}
				else
				{
					$det_asig_prod4 = new Detalle_asig_producto();
					$det_asig_prod4->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'estatus_c'=>'Aprobado'));
					if($det_asig_prod4->id)
					{
						if($estatus == 'Aprobado')
						/*{
							//no guarda, por que ya esta aprobado a otro cliente
							$resultado.="El producto ".$producto." ya esta aprobado a otro relacionador";
						}
						else*/
						{
							$account = new Account();
							$account->retrieve_by_string_fields(array('id'=>$id_cuenta));

							$catgegory = new ProductCategory();
							$catgegory->retrieve_by_string_fields(array('id'=>$id_linea));

							$asig_prod = new Asignacion_productos();
							$asig_prod->retrieve_by_string_fields(array('assigned_user_id'=>$id_usuario,'account_id_c'=>$id_cuenta));
							if($asig_prod->id)
							{
								$id_nuevo_detalle = md5(create_guid3());
								$sql_1 = "INSERT INTO detalle_asig_producto 
										(id, date_entered, date_modified, modified_user_id, created_by, deleted, team_id, team_set_id, assigned_user_id)
										VALUES('".$id_nuevo_detalle."', 
												NOW(), 
												NOW(), 
												'".$id_usuario."', 
												'".$id_usuario."', 
												'0', 
												'1', 
												'1', 
												'".$id_usuario."')";
								$resultSQL_1 = $db->query($sql_1, true, 'Error selecting the user record');
								$sql_2 = "INSERT INTO detalle_asig_producto_cstm 
										(id_c, estatus_c, id_html_tag_c, nombre_cuenta_c, nombre_producto_c, asignacion_productos_id_c, account_id_c, producttemplate_id_c, id_linea_c, nombre_linea_c)
										VALUES('".$id_nuevo_detalle."', 
												'".$estatus."', 
												'".$id_tag."', 
												'".$account->name."', 
												'".$producto."', 
												'".$asig_prod->id."', 
												'".$id_cuenta."', 
												'".$id_producto."', 
												'".$catgegory->id."', 
												'".$catgegory->name."')";
								$resultSQL_2 = $db->query($sql_2, true, 'Error selecting the user record');
								/*
								$focus2 = new Detalle_asig_producto();
								$focus2->date_entered = date("Y-m-d H:i:s");
								$focus2->date_modified = date("Y-m-d H:i:s");
								$focus2->modified_user_id = $id_usuario;
								$focus2->created_by = $id_usuario;
								$focus2->team_id = '1';
								$focus2->team_set_id = '1';
								$focus2->asignacion_productos_id_c = $asig_prod->id;
								$focus2->id_html_tag_c = $id_tag;
								$focus2->estatus_c = $estatus;
								$focus2->assigned_user_id = $id_usuario;
								$focus2->account_id_c = $id_cuenta;
								$focus2->producttemplate_id_c = $id_producto;
								$focus2->nombre_producto_c = $producto;
								$focus2->nombre_cuenta_c = $account->name;
								$focus2->nombre_linea_c = $catgegory->name;
								$focus2->id_linea_c = $catgegory->id;
								$focus2->save();*/
								
							}
						}
					}
					else
					{
						$account = new Account();
						$account->retrieve_by_string_fields(array('id'=>$id_cuenta));

						$catgegory = new ProductCategory();
						$catgegory->retrieve_by_string_fields(array('id'=>$id_linea));

						$asig_prod = new Asignacion_productos();
						$asig_prod->retrieve_by_string_fields(array('assigned_user_id'=>$id_usuario,'account_id_c'=>$id_cuenta));
						if($asig_prod->id)
						{	
							$id_nuevo_detalle = md5(create_guid3());
							$sql_1 = "INSERT INTO detalle_asig_producto 
									(id, date_entered, date_modified, modified_user_id, created_by, deleted, team_id, team_set_id, assigned_user_id)
									VALUES('".$id_nuevo_detalle."', 
											NOW(), 
											NOW(), 
											'".$id_usuario."', 
											'".$id_usuario."', 
											'0', 
											'1', 
											'1', 
											'".$id_usuario."')";
							$resultSQL_1 = $db->query($sql_1, true, 'Error selecting the user record');
							$sql_2 = "INSERT INTO detalle_asig_producto_cstm 
									(id_c, estatus_c, id_html_tag_c, nombre_cuenta_c, nombre_producto_c, asignacion_productos_id_c, account_id_c, producttemplate_id_c, id_linea_c, nombre_linea_c)
									VALUES('".$id_nuevo_detalle."', 
											'".$estatus."', 
											'".$id_tag."', 
											'".$account->name."', 
											'".$producto."', 
											'".$asig_prod->id."', 
											'".$id_cuenta."', 
											'".$id_producto."', 
											'".$catgegory->id."', 
											'".$catgegory->name."')";
							$resultSQL_2 = $db->query($sql_2, true, 'Error selecting the user record');
							/*
							$focus2 = new Detalle_asig_producto();
							$focus2->date_entered = date("Y-m-d H:i:s");
							$focus2->date_modified = date("Y-m-d H:i:s");
							$focus2->modified_user_id = $id_usuario;
							$focus2->created_by = $id_usuario;
							$focus2->team_id = '1';
							$focus2->team_set_id = '1';
							$focus2->asignacion_productos_id_c = $asig_prod->id;
							$focus2->id_html_tag_c = $id_tag;
							$focus2->estatus_c = $estatus;
							$focus2->assigned_user_id = $id_usuario;
							$focus2->account_id_c = $id_cuenta;
							$focus2->producttemplate_id_c = $id_producto;
							$focus2->nombre_producto_c = $producto;
							$focus2->nombre_cuenta_c = $account->name;
							$focus2->nombre_linea_c = $catgegory->name;
							$focus2->id_linea_c = $catgegory->id;
							$focus2->save();
							*/
						}
						$resultado.="/1";
					}
				}
			}
		}
		//return '1';
		$parametros = explode("/", $resultado);
		if($parametros[0] == '1')
		{								
			$mail = enviar_mail($parametros);
			if($mail == '1')
			{
				return '1';
			}
			else
			{
				return '0';
			}			
		}
	}	
}

function enviar_mail($parametros)
{ 
	require_once("modules/Administration/Administration.php");
	require_once("include/SugarPHPMailer.php");

	$mail=new SugarPHPMailer();
	$admin = new Administration();
	$admin->retrieveSettings();
	$mail->isHTML(true);
	$mail->CharSet = "UTF-8";

	$resultado="";

		$cuenta = $parametros[4];
		$id_usuario = $parametros[1];
		$producto = $parametros[3];
		$estatus = $parametros[5];

		$current_user = new User();
		$current_user->retrieve_by_string_fields(array('id'=>$id_usuario));
		$nombres = $current_user->first_name." ".$current_user->last_name;

		$user=BeanFactory::getBean('Users',$id_usuario);
		$primary_email=$user->emailAddress->getPrimaryAddress($user); 

		$mail->AddAddress($primary_email, $nombres);
		//$mail->AddCC("spachano@plus-projects.com","Sebastian Pachano");
		$mail->From     = $admin->settings['notify_fromaddress']; 
		$mail->FromName = $admin->settings['notify_fromname'];
		$mail->Subject = "Aprobacion/Negacion de solicitud para asignacion de producto";
		$mail->Body = "<html><body><p>Estimado(a): <b>".$nombres."</b></p></br>
		<p>El producto: <b>".$producto."</b> le ha sido <b>".$estatus."</b></p></br>
		<p>La cuenta es: <b>".$cuenta."</b></p></br>
		<p>Por favor revise en el modulo de asignaciones de productos en SugarCRM</p></br></body></html>";
		$mail->prepForOutbound();
		$mail->setMailerForSystem();
		if (!$mail->Send())
		{
			$resultado.="No se pudo enviar el mail ".$mail->ErrorInfo;
		}
		else
		{
			//mail enviado
			$resultado.="1";
		}
	return $resultado;
}

//FUNCIONES PARA GENERAR IDS	
function create_guid3()
{ 
	$microTime = microtime(); 
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = dechex($a_dec* 1000000);
	$sec_hex = dechex($a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section3(3);
	$guid .= '-';
	$guid .= create_guid_section3(4);
	$guid .= '-';
	$guid .= create_guid_section3(4);
	$guid .= '-';
	$guid .= create_guid_section3(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section3(6);

	return $guid;
}

function create_guid_section3($characters)
{
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= dechex(mt_rand(0,15));
	}
	return $return;
}

function ensure_length3(&$string, $length) 
{
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
}

function valida_auditoria_det_asig($parent_id, $assigned_user_id, $estatus_c)
{
	$db =  DBManagerFactory::getInstance();
	$SQL_campos =	"SELECT d_c.estatus_c
					FROM detalle_asig_producto_cstm d_c
					INNER JOIN  detalle_asig_producto d ON d_c.id_c = d.id
					WHERE d.id = '".$parent_id."'";
	$result_SQL_campos = $db->query($SQL_campos, true, 'Error selecting the opportunity record');
	$row_SQL_campos = $db->fetchByAssoc($result_SQL_campos);
	//VALIDACION DE CAMPOS
	//echo $row_SQL_campos['estatus_c'] .'-'. $estatus_c;
		if($row_SQL_campos['estatus_c'] != $estatus_c && $estatus_c != '')
		{				
			graba__auditoria_det_asig($parent_id,$assigned_user_id,'estatus_c', 'varchar', $row_SQL_campos['estatus_c'], $estatus_c);
			//echo($parent_id.'-'.$assigned_user_id.'-'.'estatus_c'.'-'.'varchar'.'-'.$row_SQL_campos['estatus_c'].'-'.$estatus_c);
		}		
}	

function graba__auditoria_det_asig($parent_id,$assigned_user_id,$field_name,$data_type,$campo_base,$campo_input)
{	
	$db =  DBManagerFactory::getInstance();
	$id_det_asig_audit = md5(create_guid3()); 
	$SQL_audit ="INSERT INTO detalle_asig_producto_audit 
				(id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string)
				VALUES('".$id_det_asig_audit."', '".$parent_id."', NOW(), '".$assigned_user_id."', 
				'".$field_name."', 
				'".$data_type."', 
				'".$campo_base."', 
				'".$campo_input."')";
	$res_SQL_audit = $db->query($SQL_audit, true, 'Error selecting the opportunity record');
	//echo $SQL_audit;
}	

?>