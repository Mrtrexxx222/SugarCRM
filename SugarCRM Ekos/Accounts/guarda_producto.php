<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
//instancia de la base
$db =  DBManagerFactory::getInstance();
//variables que se usan en los dos casos
$seccion = @$_POST['seccion'];
$oportunidad = $_POST['oportunidad'];
$usuario = @$_POST['usuario'];
$id_usuario = @$_POST['id_usuario'];
$cuenta = @$_POST['cuenta'];
$id_oportunidad = '';
$id_cuenta_oportunidad = '';
$oportunidad_nueva='';
//VERIFICA SI EXISTE UNA OPORTUNIDAD
	$oport = new Opportunity();
	$oport->retrieve_by_string_fields(array('name'=>$oportunidad));
	if($oport->id)
	{
		$id_oportunidad = $oport->id;
	}
	else
	{
		$id_oportunidad = '';
	}
//CARECTER ESPECIAL EN CUENTAS 		
	if(strpos($cuenta,"/") !== false)
	{
		$cuenta = str_replace("/", "&", $cuenta);
	}
//BUSCA LA CUENTA POR SU NOMBRE
	$cuenta_bean = new Account(); 
	$cuenta_bean->retrieve_by_string_fields(array('name'=>$cuenta));
	
		
//SECCION CABECERA --------------------------------------------------------
if($seccion == 'C')
{
	$descripcion1 = $_POST['descripcion1'];
	$duenio = $_POST['duenio']; 
	$contacto = $_POST['contacto'];
	$total_op = $_POST['total_op']; 
	$fecha_cierre = $_POST['fecha_cierre']; 
	$etapa = $_POST['etapa']; 
	$id_contact = $_POST['id_contact'];	
	$probability = '';	
	$check = $_POST['check'];
	if($etapa=='Closed Lost')
	{	$probability = 0;	}
	if($etapa=='Needs Analysis')
	{	$probability = 25;	}
	if($etapa=='Perception Analysis')
	{	$probability = 50;	}
	if($etapa=='Quote')
	{	$probability = 75;	}
	if($etapa=='Closed Won')
	{	$probability = 100;	}
	//EXTRACCION DEL ID DEL USUARIO ASIGNADO MEDIANTE SU NOMBRE Y APELLIDO
	$SQL_0 = "SELECT id FROM users where CONCAT(first_name,' ',last_name) = '".$duenio."'";
	$resultSQL_0 = $db->query($SQL_0, true, 'Error selecting the opportunity record');
	$row0=$db->fetchByAssoc($resultSQL_0);
		
	if($id_oportunidad == '') 
	{
		$id_oportunidad = md5(create_guid2()); 
		$id_cuenta_oportunidad = md5(create_guid2()); 		
	//INSERT DE UN NUEVO REGISTRO EN LA TABLA opportunities 
		$SQL_1 = "insert into opportunities(id, name, date_entered, date_modified, modified_user_id, created_by, description, 
				  deleted, assigned_user_id, team_id, team_set_id, amount, amount_usdollar, currency_id, date_closed, sales_stage, probability) 
				  values('".$id_oportunidad."','".$oportunidad."',NOW(), NOW(), '".$id_usuario."', '".$id_usuario."', '".$descripcion1."', 0, '".$row0['id']."', '1', '1', 	
				  ".$total_op.", ".$total_op.", '-99', STR_TO_DATE('".$fecha_cierre."','%d/%m/%Y'), '".$etapa."', ".$probability.")";
		$resultSQL_1 = $db->query($SQL_1, true, 'Error selecting the opportunity record');
	//INSERT DE UN NUEVO REGISTRO EN LA TABLA accounts_opportunities 
		$SQL_2 = "INSERT INTO opportunities_cstm (id_c,revisado_c,contact_id_c)
				  VALUES('".$id_oportunidad."','0','".$id_contact."');";	
		$resultSQL_2 = $db->query($SQL_2, true, 'Error selecting the opportunity record');		  
	//INSERT DE UN NUEVO REGISTRO EN LA TABLA accounts_opportunities PARA CREAR LA RELACION 
		$SQL_3 = "INSERT INTO accounts_opportunities(id,opportunity_id,account_id,date_modified,deleted)
				  VALUES('".$id_cuenta_oportunidad."','".$id_oportunidad."','".$cuenta_bean->id."',NOW(),'0')";				
		$resultSQL_3 = $db->query($SQL_3, true, 'Error selecting the opportunity record');
		$oportunidad_nueva='1';
	}
	else
	{ 		
	auditoria_oportunidades($id_oportunidad,$row0['id'],$total_op,$fecha_cierre,$etapa,$probability);
	
	//UPDATE EN LA TABLA opportunities
		$UP_SQL_1 = "UPDATE opportunities
					SET	 
					date_modified = NOW(), 
					modified_user_id = '".$id_usuario."' , 
					description = '".$descripcion1."' , 
					assigned_user_id = '".$row0['id']."',
					amount = ".$total_op." , 
					amount_usdollar = ".$total_op.", 	
					date_closed = STR_TO_DATE('".$fecha_cierre."','%d/%m/%Y') , 
					sales_stage = '".$etapa."', 
					probability = ".$probability.",
					name = '".$oportunidad."'
					WHERE
					id = '".$id_oportunidad."'"; 
		$resultUP_SQL_1 = $db->query($UP_SQL_1, true, 'Error selecting the opportunity record');
	
	//UPDATE EN LA TABLA opportunities_cstm		
		$UP_SQL_2 ="UPDATE opportunities_cstm 
					SET	
					revisado_c = '".$check."' , 
					contact_id_c = '".$id_contact."'	
					WHERE
					id_c = '".$id_oportunidad."'";
		$resultUP_SQL_2 = $db->query($UP_SQL_2, true, 'Error selecting the opportunity record');
		//echo .$id_oportunidad; 		
	}
	//echo '1/'.$id_oportunidad; 
	$seccion = 'D';
}


//SECCION DETALLE --------------------------------------------------------
if($seccion == 'D')
{
	$cadena = $_POST['datos'];
	$id_op = $id_oportunidad;			 	
	$fecha_cierre = $_POST['fecha_cierre'];		
	$guarda_o_no = $_POST['guarda_o_no']; 	
	$duenio = $_POST['duenio']; 
		
	$response = '';
	$acumulador = '';
	$segmentos = explode(";", $cadena);	
	for($i=0;$i < count($segmentos)-1;$i++)
	{	
		$sub_seg 		= explode(":",$segmentos[$i]);	
		$id_producto	= $sub_seg[0];	
		$valor_prosp	= $sub_seg[1];	
		$forma_pago		= $sub_seg[2];	
		$descripcion	= $sub_seg[3];	
		$estatus		= $sub_seg[4];			
		$response 	.= save_productos($id_op,$id_producto,$fecha_cierre,$descripcion,$guarda_o_no,$forma_pago,$estatus,$duenio,$valor_prosp,$cuenta_bean->id,$cuenta); 				
		if($response != '')
		{
			$acumulador .= $response;
			$acumulador	.= '/'; 
		}
		$response	 = ''; 		
	}	
	if($acumulador == '')
	{
		$seccion = 'V';		
	}
	else
	{
		//echo $acumulador;	
		$validador = valida_asignacion($oportunidad,$id_usuario,$cuenta,$guarda_o_no,$duenio,$acumulador);			
		if($validador == '1' || $validador == '0')
		{
			$seccion = 'V';			
		}
	}
} 

function save_productos($id_oportunidad,$id_producto,$fecha_cierre,$descripcion,$guarda_o_no,$forma_pago,$estatus,$duenio,$valor_prosp,$id_cta,$cuenta)
{
	$db =  DBManagerFactory::getInstance();
	
	$valor = str_replace(",", "", $valor_prosp); 
	$categoria=""; 
	$total =0;	
	$resultado=""; 
	$distintos=0;	
	$a_validar = '';
	$SQL_1 = "SELECT name FROM opportunities WHERE id = '".$id_oportunidad."'";
	$resultSQL_1 = $db->query($SQL_1, true, 'Error selecting the opportunity record');
	$row_SQL_1	 = $db->fetchByAssoc($resultSQL_1);
	$oportunidad = $row_SQL_1['name'];
	
	$partes = explode("/",$fecha_cierre);
	$mes = $partes[1];
	$anio = $partes[2];
	//$mes = date('m');
	if($mes == '01')
	{ $mes = '1'; }
	if($mes == '02')
	{ $mes = '2'; }
	if($mes == '03')
	{ $mes = '3'; }
	if($mes == '04')
	{ $mes = '4'; }
	if($mes == '05')
	{ $mes = '5'; }
	if($mes == '06')
	{ $mes = '6'; }
	if($mes == '07')
	{ $mes = '7'; }
	if($mes == '08')
	{ $mes = '8'; }
	if($mes == '09')
	{ $mes = '9'; }
	//$anio = date('Y');	
	/*instancia de la base AQUI*/
	$usuario = $_POST['usuario'];
	if($usuario == $duenio)
	{
		$id_usuario = $_POST['id_usuario'];
	}
	else
	{
		$query0 = "SELECT id FROM users where CONCAT(first_name,' ',last_name) = '".$duenio."'";
		$result0 = $db->query($query0, true, 'Error selecting the opportunity record');
		if($row0=$db->fetchByAssoc($result0))
		{
			$id_usuario = $row0['id'];
			$usuario = $duenio;
			$distintos = 1;
		}	
	}
	
	$query = "SELECT b.name as categoria, a.name as producto FROM product_templates a, product_categories b where a.category_id = b.id and a.id = '".$id_producto."' and a.deleted = 0";
	$result = $db->query($query, true, 'Error selecting the category record');
		if($row=$db->fetchByAssoc($result))
		{
			valida_auditoria_dt_op($id_oportunidad,$id_producto,$row0['id'],$estatus,$valor,$oportunidad,$mes,$anio,$id_usuario,$usuario,$id_cta,$cuenta, $forma_pago, $descripcion);
			$categoria = $row['categoria'];	
			if($id_oportunidad == '')
			{
				$query2 = "SELECT name, probability FROM opportunities where name = '".$oportunidad."'";
			}
			else
			{		
				$query2 = "SELECT name, probability FROM opportunities where id = '".$id_oportunidad."'";			 
			}
			$result2 = $db->query($query2, true, 'Error selecting the opportunity record');
			if($row2=$db->fetchByAssoc($result2))//SI LA OPORTUNIDAD SI EXISTE INGRESA
			{				
				//VALIDA EN CASO DE QUE EL PRODUCTO DE LA OPORTUNIDAD EXISTA PERO TENGA VACIO EL CAMPO DE RELACION (DETALLE-OPORTUNIDAD) => id_oportunidad_c
				//Y LO ACTUALIZA CON EL ID CORRESPONDIENTE
				$sql_valida = "SELECT id_c,id_oportunidad_c FROM m1_oportunidad_productos_cstm where oportunidad_c = '".$row2['name']."' and id_producto_c = '".$id_producto."'"; 
				$result_SQL = $db->query($sql_valida, true, 'Error selecting the opportunity record');				
				//SI EXISTE EL PRODUCTO EN LA OPORTUNIDAD, SE ACTUALIZA EL id_oportunidad_c, CREANDO LA RELACION (DETALLE-OPORTUNIDAD)
				if($row_val=$db->fetchByAssoc($result_SQL)) 
				{
					if($row_val['id_oportunidad_c'] == null || $row_val['id_oportunidad_c'] == '')
					{
						$relacion_sql = "UPDATE m1_oportunidad_productos_cstm 
										SET 
										id_oportunidad_c = '".$id_oportunidad."',
										oportunidad_c = '".$oportunidad."' 
										WHERE
										id_c = '".$row_val['id_c']."'"; 
						$ejecuta_relacion = $db->query($relacion_sql,true, 'Error al crear la relacion'); 									
					}
					else
					{
						//ya tiene el id de la oportunidad en el producto, no hace el proceso de relacion por que ya esta.
						$relacion_sql = "UPDATE m1_oportunidad_productos_cstm 
										SET 
										oportunidad_c = '".$oportunidad."' 
										WHERE
										id_c = '".$row_val['id_c']."'"; 
						$ejecuta_relacion = $db->query($relacion_sql,true, 'Error al crear la relacion'); 
					}								
				} 
				//CONTINUA EL PROCESO NORMALMENTE				
				if($id_oportunidad == '')
				{
					$query3 = "SELECT id_c FROM m1_oportunidad_productos_cstm where oportunidad_c = '".$oportunidad."' and id_producto_c = '".$id_producto."'";
				}
				else
				{
					$query3 = "SELECT id_c FROM m1_oportunidad_productos_cstm where id_oportunidad_c = '".$id_oportunidad."' and id_producto_c = '".$id_producto."'";
				}
				$result3 = $db->query($query3, true, 'Error selecting the opportunity record');
				if($row3=$db->fetchByAssoc($result3))//SI EL PRODUCTO DE UNA OPORTUNIDAD EXISTE EN LA TABLA m1_oportunidad_productos_cstm INGRESA
				{//UPDATE
					//$focus = BeanFactory::getBean('m1_Oportunidad_productos');
					//$opor_prod_bean = $focus->retrieve($row3['id_c']);									
					if($row2['probability'] != '100')
					{
						if($guarda_o_no == 1)
						{
							$up_query_1 = "UPDATE m1_oportunidad_productos
											SET
											assigned_user_id = '".$id_usuario."'	
											WHERE
											id = '".$row3['id_c']."'";

							$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
											SET 
											id_usuario_c = '".$id_usuario."', 
											usuario_c = '".$usuario."'
											WHERE
											id_c = '".$row3['id_c']."'"; 	
							$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
							$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record'); 																							
							$a_validar	= $row3['id_c'];
						}
						else
						{
							//VERIFICA QUE EL PRODUCTO TENGA UN ASIGNADO EN ESA CUENTA.						
							$sql_val_producto = "SELECT estatus_c, CONCAT(u.first_name,' ',u.last_name) usuario, a.assigned_user_id
													FROM detalle_asig_producto_cstm b
													INNER JOIN detalle_asig_producto a ON b.id_c = a.id
													INNER JOIN users u ON a.assigned_user_id = u.id
													WHERE b.producttemplate_id_c = '".$id_producto."'
													AND estatus_c IN ('Aprobado','Solicitar')
													AND nombre_cuenta_c = '".$cuenta."'"; 
							$res_val_producto = $db->query($sql_val_producto, true, 'Error al validar el poducto');
							//EN EL CASO DE QUE SI TENGA INGRESA A VALIDAR EL RELACIONADOR ANTERIOR PARA SABES SI LO ACTUALIZA O NO
							if($row_val_producto = $db->fetchByAssoc($res_val_producto))
							{
								//CONTROLA QUE SE GUARDEN CON EL MISMO RELACIONADOR QUE ESTABA ANTERIORMENTE EN EL PRODUCTO CON ESTADO ACTIVO 
								$sql_val_exist = "SELECT id_c,id_usuario_c,usuario_c FROM m1_oportunidad_productos_cstm 
													WHERE id_c = '".$row3['id_c']."' 
													AND estado_c = '1'";										
								$res_val_exist = $db->query($sql_val_exist, true, 'Error selecting the opportunity record');
								if($row_val_exist = $db->fetchByAssoc($res_val_exist))
								{																		
											$up_query_1 = "UPDATE m1_oportunidad_productos
															SET
															assigned_user_id = '".$row_val_exist['id_usuario_c']."'	
															WHERE
															id = '".$row3['id_c']."'";	

											$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
															SET 
															id_usuario_c = '".$row_val_exist['id_usuario_c']."', 
															usuario_c = '".$row_val_exist['usuario_c']."'
															WHERE 
															id_c = '".$row3['id_c']."'"; 								
											$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
											$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record');												
								}								
								else
								{
										$up_query_1 = "UPDATE m1_oportunidad_productos
														SET
														assigned_user_id = '".$id_usuario."'	
														WHERE
														id = '".$row3['id_c']."'";
	
										$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
														SET 
														id_usuario_c = '".$id_usuario."', 
														usuario_c = '".$usuario."'
														WHERE 
														id_c = '".$row3['id_c']."'"; 								
										$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
										$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record'); 
										if($estatus == '1')
										{
											$a_validar	= $row3['id_c'];
										}
										else
										{
											$a_validar	= '';
										}
								}								
							}
							else
							{
								$up_query_1 = "UPDATE m1_oportunidad_productos
												SET
												assigned_user_id = '".$id_usuario."'	
												WHERE
												id = '".$row3['id_c']."'";

								$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
												SET 
												id_usuario_c = '".$id_usuario."', 
												usuario_c = '".$usuario."'
												WHERE 
												id_c = '".$row3['id_c']."'"; 								
								$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
								$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record'); 
							}
						}						
					}
					else 
					{
						if($guarda_o_no == 1)
						{
							$up_query_1 = "UPDATE m1_oportunidad_productos
											SET
											assigned_user_id = '".$id_usuario."'	
											WHERE
											id = '".$row3['id_c']."'";

							$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
											SET 
											id_usuario_c = '".$id_usuario."', 
											usuario_c = '".$usuario."'
											WHERE
											id_c = '".$row3['id_c']."'"; 								
							$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
							$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record');
							$a_validar	= $row3['id_c'];
						}		
						else
						{
							//VERIFICA QUE EL PRODUCTO TENGA UN ASIGNADO EN ESA CUENTA.						
							$sql_val_producto = "SELECT estatus_c, CONCAT(u.first_name,' ',u.last_name) usuario, a.assigned_user_id
													FROM detalle_asig_producto_cstm b
													INNER JOIN detalle_asig_producto a ON b.id_c = a.id
													INNER JOIN users u ON a.assigned_user_id = u.id
													WHERE b.producttemplate_id_c = '".$id_producto."'
													AND estatus_c IN ('Aprobado','Solicitar')
													AND nombre_cuenta_c = '".$cuenta."'"; 
							$res_val_producto = $db->query($sql_val_producto, true, 'Error al validar el poducto');
							//EN EL CASO DE QUE SI TENGA INGRESA A VALIDAR EL RELACIONADOR ANTERIOR PARA SABES SI LO ACTUALIZA O NO
							if($row_val_producto = $db->fetchByAssoc($res_val_producto))
							{
								//CONTROLA QUE SE GUARDEN CON EL MISMO RELACIONADOR QUE ESTABA ANTERIORMENTE EN EL PRODUCTO CON ESTADO ACTIVO 
								$sql_val_exist = "SELECT id_c,id_usuario_c,usuario_c FROM m1_oportunidad_productos_cstm 
													WHERE id_c = '".$row3['id_c']."' 
													AND estado_c = '1'";										
								$res_val_exist = $db->query($sql_val_exist, true, 'Error selecting the opportunity record');
								if($row_val_exist = $db->fetchByAssoc($res_val_exist))
								{																		
											$up_query_1 = "UPDATE m1_oportunidad_productos
															SET
															assigned_user_id = '".$row_val_exist['id_usuario_c']."'	
															WHERE
															id = '".$row3['id_c']."'";	

											$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
															SET 
															id_usuario_c = '".$row_val_exist['id_usuario_c']."', 
															usuario_c = '".$row_val_exist['usuario_c']."'
															WHERE 
															id_c = '".$row3['id_c']."'"; 								
											$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
											$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record');												
								}								
								else
								{
										$up_query_1 = "UPDATE m1_oportunidad_productos
														SET
														assigned_user_id = '".$id_usuario."'	
														WHERE
														id = '".$row3['id_c']."'";
	
										$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
														SET 
														id_usuario_c = '".$id_usuario."', 
														usuario_c = '".$usuario."'
														WHERE 
														id_c = '".$row3['id_c']."'"; 								
										$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
										$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record'); 
										if($estatus == '1')
										{
											$a_validar	= $row3['id_c'];
										}
										else
										{
											$a_validar	= '';
										}
								}								
							}
							else
							{
								$up_query_1 = "UPDATE m1_oportunidad_productos
												SET
												assigned_user_id = '".$id_usuario."'	
												WHERE
												id = '".$row3['id_c']."'";

								$up_query_2 = "UPDATE m1_oportunidad_productos_cstm 
												SET 
												id_usuario_c = '".$id_usuario."', 
												usuario_c = '".$usuario."'
												WHERE 
												id_c = '".$row3['id_c']."'"; 								
								$result_up_query_1 = $db->query($up_query_1, true, 'Error selecting the opportunity record'); 
								$result_up_query_2 = $db->query($up_query_2, true, 'Error selecting the opportunity record'); 
							}
						}				
					}					
					$up_query_3 = "	UPDATE m1_oportunidad_productos 
									SET 
									date_modified = NOW(), 
									modified_user_id = '".$id_usuario."' 		
									WHERE
									id = '".$row3['id_c']."'";
					$result_up_query_3 = $db->query($up_query_3, true, 'Error selecting the opportunity record');
					
					$up_query_4 = "	UPDATE m1_oportunidad_productos_cstm 
									SET
									oportunidad_c = '".$oportunidad."', 
									valor_prospectado_c = ".$valor.", 
									forma_pago_c = '".$forma_pago."',
									descripcion_c = '".$descripcion."' ,
									mes_c = '".$mes."' , 
									anio_c = '".$anio."' ,									
									estado_c = '".$estatus."' ,
									cuenta_c = '".$cuenta."' , 
									id_cuenta_c = '".$id_cta."'												
									WHERE
									id_c = '".$row3['id_c']."'";
					
					$result_up_query_4 = $db->query($up_query_4, true, 'Error selecting the opportunity record');									

				}
				else 
				{//INSERT 
					$id_m1_oportunidad = md5(create_guid2());
					$in_query_1 = "INSERT INTO m1_oportunidad_productos(id,name,date_entered,date_modified,modified_user_id,created_by,deleted,team_id,team_set_id,assigned_user_id)
									VALUES
									('".$id_m1_oportunidad."', 
									'', 
									NOW(), 
									NOW(), 
									'".$id_usuario."', 
									'".$id_usuario."', 									
									0, 
									'1', 
									'1', 
									'".$id_usuario."'
									)"; 
					$result_in_query_1 = $db->query($in_query_1, true, 'Error selecting the opportunity record');
					
					$in_query_2 = "INSERT INTO m1_oportunidad_productos_cstm 
									(id_c, id_producto_c, estado_c, categoria_c, valor_prospectado_c, oportunidad_c, mes_c, anio_c, producto_c, id_usuario_c, usuario_c, id_cuenta_c, cuenta_c, forma_pago_c, descripcion_c, id_oportunidad_c)
									VALUES
									('".$id_m1_oportunidad."', 
									'".$id_producto."', 
									'".$estatus."', 
									'".$categoria."', 
									".$valor.", 									
									'".$oportunidad."', 
									'".$mes."', 
									'".$anio."', 
									'".$row['producto']."', 
									'".$id_usuario."', 
									'".$usuario."', 
									'".$id_cta."', 
									'".$cuenta."', 
									'".$forma_pago."', 
									'".$descripcion."', 
									'".$id_oportunidad."'
									)";					
					$result_in_query_2 = $db->query($in_query_2, true, 'Error selecting the opportunity record');
					if($estatus == '1')
					{
						$a_validar	= $id_m1_oportunidad;
					}
					else
					{
						$a_validar	= '';
					}
				}
			}		
		}
		return $a_validar; 
}

function valida_asignacion($nombre_oportunidad,$id_usuario_actual,$nombre_cuenta,$guarda_o_no,$duenio,$ids_validar)
{
	$db =  DBManagerFactory::getInstance();
	$resultado		= ""; 	
	$probabilidad	= '0'; 
	$id_oportunidad	= ''; 
	$distintos 	= 0; 
	$oport = new Opportunity(); 
	$oport->retrieve_by_string_fields(array('name'=>$nombre_oportunidad)); 
	
	if($oport->id) 
	{ 
		$id_oportunidad = $oport->id; 
	} 
	else 
	{ 
		$id_oportunidad = '';  
	} 	

	$cadena = '';
	$segmentos = explode("/", $ids_validar);	
		for($i=0; $i < count($segmentos)-1; $i++)
		{			
			$cadena .= "'".$segmentos[$i]."'";
			if($i < count($segmentos)-2)
			{
				$cadena .= ",";
			}
		}

	$total=0; 
	$cont=0; 
	$anio = date("Y"); 	
	$usuario = new User(); 
	$usuario->retrieve_by_string_fields(array('id'=>$id_usuario_actual)); 
	$nombres_usuario = $usuario->first_name." ".$usuario->last_name; 
	$db =  DBManagerFactory::getInstance(); 
	if($duenio == $nombres_usuario) 
	{} 
	else 
	{ 
		$query0 = "SELECT id FROM users where CONCAT(first_name,' ',last_name) = '".$duenio."'"; 
		$result0 = $db->query($query0, true, 'Error selecting the opportunity record'); 
		if($row0=$db->fetchByAssoc($result0)) 
		{ 
			$id_usuario_actual = $row0['id']; 
			$nombres_usuario = $duenio; 
			$distintos = 1; 
		} 
	} 

	$cuenta = new Account();
	$cuenta->retrieve_by_string_fields(array('name'=>$nombre_cuenta));
	$id_cuenta = $cuenta->id;

	if($id_oportunidad == '')
	{
		$query6 = "select * FROM opportunities where name = '".$nombre_oportunidad."'";
	}
	else
	{
		$query6 = "select * FROM opportunities where id = '".$id_oportunidad."'";
	}
	$result6 = $db->query($query6, true, 'Error selecting the product record');
	if($row6=$db->fetchByAssoc($result6))
	{
		$probabilidad = $row6['probability'];
	}
	else
	{
		$probabilidad = '0';
	}
		$query3 = "select count(id_producto_c) as total from m1_oportunidad_productos_cstm where id_c in (".$cadena.") and estado_c = '1'";
	
	$result3 = $db->query($query3, true, 'Error selecting the product record');
	if($row3=$db->fetchByAssoc($result3))
	{
		$total = $row3['total'];
	}

	$query2 = "select id_producto_c from m1_oportunidad_productos_cstm where id_c in (".$cadena.") and estado_c = '1'";

	$result2 = $db->query($query2, true, 'Error selecting the product record'); 
	while($row2=$db->fetchByAssoc($result2)) 
	{
		$id_producto = $row2['id_producto_c'];
		$det_asig_prod = new Detalle_asig_producto();
		$det_asig_prod->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario_actual,'estatus_c'=>'Aprobado'));
		if($det_asig_prod->id)
		{		
			// se contabiliza que el producto si puede
			$cont++;
			$query4 = "SELECT id_c FROM m1_oportunidad_productos_cstm where oportunidad_c = '".$nombre_oportunidad."' and id_producto_c = '".$id_producto."' and id_cuenta_c = '".$id_cuenta."'";
			$result4 = $db->query($query4, true, 'Error selecting the oportunity record');
			if($row4=$db->fetchByAssoc($result4))
			{
				if($probabilidad != '100')
				{
					if($guarda_o_no == 1)
					{	
						$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario_actual."' , usuario_c = '".$nombres_usuario."' 
									WHERE id_c = '".$row4['id_c']."'";
						$result = $db->query($query, true, 'Error selecting the user record'); 
					}
					else
					{
						$query = "UPDATE m1_oportunidad_productos_cstm
							SET id_usuario_c = '".$id_usuario_actual."' , usuario_c = '".$nombres_usuario."' 
							WHERE id_c = '".$row4['id_c']."'";
						$result = $db->query($query, true, 'Error selecting the user record'); 												
					}
				}
				else
				{
					if($guarda_o_no == 1)
					{
						$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario_actual."' , usuario_c = '".$nombres_usuario."' 
									WHERE id_c = '".$row4['id_c']."'";
						$result = $db->query($query, true, 'Error selecting the user record'); 
					}
					else
					{
						if($distintos == 1)
						{
							$query = "UPDATE m1_oportunidad_productos_cstm
							SET id_usuario_c = '".$id_usuario2."', usuario_c = '".$nombres_usuario2."' 
							WHERE id_c = '".$row5['id_c']."'";
							$result = $db->query($query, true, 'Error selecting the user record'); 
						}
					}
				}
			}		
		}
		else
		{//CUANDO EL USUARIO VENDE UN PRODUCTO ASIGNADO A OTRO USUARIO
			$det_asig_prod2 = new Detalle_asig_producto();
			$det_asig_prod2->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'estatus_c'=>'Aprobado'));
			if($det_asig_prod2->id)
			{
				//El producto ya esta asignado a otro usuario
				$usuario2 = new User();
				$usuario2->retrieve_by_string_fields(array('id'=>$det_asig_prod2->assigned_user_id));
				$nombres_usuario2 = $usuario2->first_name." ".$usuario2->last_name;
				$id_usuario2 = $det_asig_prod2->assigned_user_id;	
				//el producto esta para otro usuario pero igual cumple
				$cont++;
				$query5 = "SELECT id_c FROM m1_oportunidad_productos_cstm where oportunidad_c = '".$nombre_oportunidad."' and id_producto_c = '".$id_producto."' and id_cuenta_c = '".$id_cuenta."'";
				$result5 = $db->query($query5, true, 'Error selecting the opportunity record');
				if($row5=$db->fetchByAssoc($result5))
				{
					if($probabilidad != '100')
					{
						if($guarda_o_no == 1)
						{
							$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario2."' , usuario_c = '".$nombres_usuario2."' 
									WHERE id_c = '".$row5['id_c']."'";
							$result = $db->query($query, true, 'Error selecting the user record'); 							

						}
						else
						{							
							$query = "UPDATE m1_oportunidad_productos_cstm
							SET id_usuario_c = '".$id_usuario2."', usuario_c = '".$nombres_usuario2."' 
							WHERE id_c = '".$row5['id_c']."'";
							$result = $db->query($query, true, 'Error selecting the user record'); 
						}
					}
					else
					{
						if($guarda_o_no == 1)
						{		
							$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario2."', usuario_c = '".$nombres_usuario2."' 
									WHERE id_c = '".$row5['id_c']."'";
							$result = $db->query($query, true, 'Error selecting the user record'); 
						}
						else
						{
							if($distintos == 1)
							{
								$query = "UPDATE m1_oportunidad_productos_cstm
								SET id_usuario_c = '".$id_usuario2."', usuario_c = '".$nombres_usuario2."' 
								WHERE id_c = '".$row5['id_c']."'";
								$result = $db->query($query, true, 'Error selecting the user record'); 
							}
						}	
					}
				}																
			}
		}
	}

	if($total == $cont)
	{		
		return '1';
	}
	else
	{		
		return '0';
	}	
}

//SECCION VALIDACION --------------------------------------------------------
if($seccion == 'V')
{	
	$VAL_SQL_0 = "SELECT IF((SELECT op.amount FROM opportunities op WHERE op.id = '".$id_oportunidad."') = (SELECT SUM(valor_prospectado_c) valor_prospectado_c FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."'), 1, 0) val";	
	$resultVAL_SQL_0 = $db->query($VAL_SQL_0, true, 'Error selecting the opportunity record');
	$row_val_0=$db->fetchByAssoc($resultVAL_SQL_0);		
	//CREA/ACTUALIZA LA COTIZACION
	$id_contact = $_POST['id_contact'];
	$fecha_cierre = $_POST['fecha_cierre'];
	$duenio = $_POST['duenio'];
	$id_duenio="";
	$db =  DBManagerFactory::getInstance(); 
	$query = "select id from users where CONCAT(first_name,' ',last_name) = '".$duenio."'";
	$result = $db->query($query, true, 'Error selecting the user record');
	if($row=$db->fetchByAssoc($result))
	{
		$id_duenio = $row['id'];
	}
	$resp = crea_cotizacion($id_oportunidad,$oportunidad,$fecha_cierre,$id_duenio,$cuenta_bean->id,$id_contact,$oportunidad_nueva);
	$resp2 = envia_mail();
	$resp3 = guardafeed($id_oportunidad,$oportunidad,$cuenta_bean->id,$cuenta_bean->name);
	echo $row_val_0['val'];	
}

//FUNCIONES PARA GENERAR IDS	
function create_guid2()
{
	$microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = dechex($a_dec* 1000000);
	$sec_hex = dechex($a_sec);

	ensure_length2($dec_hex, 5);
	ensure_length2($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section2(3);
	$guid .= '-';
	$guid .= create_guid_section2(4);
	$guid .= '-';
	$guid .= create_guid_section2(4);
	$guid .= '-';
	$guid .= create_guid_section2(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section2(6);

	return $guid;
}

function create_guid_section2($characters)
{
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= dechex(mt_rand(0,15));
	}
	return $return;
}

function ensure_length2(&$string, $length)
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
//AUDITORIA A TABLA OPORTUNIDADES ////////////////////////
function auditoria_oportunidades($parent_id,$assigned_user_id,$amount_usdollar,$date_closed,$sales_stage,$probability)
{
	$db =  DBManagerFactory::getInstance();
	$SQL_campos ="SELECT amount_usdollar,DATE_FORMAT(STR_TO_DATE(date_closed,'%Y-%m-%d'),'%d/%m/%Y') date_closed,probability,sales_stage,assigned_user_id 
					FROM opportunities
					WHERE id = '".$parent_id."'";
	$result_SQL_campos = $db->query($SQL_campos, true, 'Error selecting the opportunity record');
	$row_SQL_campos = $db->fetchByAssoc($result_SQL_campos);
	
	//01 validacion campo:amount_usdollar
		if($row_SQL_campos['amount_usdollar'] != $amount_usdollar)
		{
			$id_op_audit = md5(create_guid2()); 
			$SQL_audit ="INSERT INTO opportunities_audit 
						(id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string)
						VALUES('".$id_op_audit."', '".$parent_id."', NOW(), '".$assigned_user_id."', 
						'amount_usdollar', 
						'currency', 
						'".$row_SQL_campos['amount_usdollar']."', 
						'".$amount_usdollar."')";
			$res_SQL_audit = $db->query($SQL_audit, true, 'Error selecting the opportunity record');				
		}
	//02 validacion campo:date_closed
		if($row_SQL_campos['date_closed'] != $date_closed)
		{
			$id_op_audit = md5(create_guid2()); 
			$SQL_audit ="INSERT INTO opportunities_audit 
						(id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string)
						VALUES('".$id_op_audit."', '".$parent_id."', NOW(), '".$assigned_user_id."', 
						'date_closed', 
						'date', 
						STR_TO_DATE('".$row_SQL_campos['date_closed']."','%d/%m/%Y'), 
						STR_TO_DATE('".$date_closed."','%d/%m/%Y'))";
			$res_SQL_audit = $db->query($SQL_audit, true, 'Error selecting the opportunity record');				
		}
	//03 validacion campo:probability
		if($row_SQL_campos['probability'] != $probability)
		{
			$id_op_audit = md5(create_guid2()); 
			$SQL_audit ="INSERT INTO opportunities_audit 
						(id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string)
						VALUES('".$id_op_audit."', '".$parent_id."', NOW(), '".$assigned_user_id."', 
						'probability', 
						'int', 
						'".$row_SQL_campos['probability']."', 
						'".$probability."')";
			$res_SQL_audit = $db->query($SQL_audit, true, 'Error selecting the opportunity record');				
		}
	//04 validacion campo:sales_stage
		if($row_SQL_campos['sales_stage'] != $sales_stage)
		{
			$id_op_audit = md5(create_guid2()); 
			$SQL_audit ="INSERT INTO opportunities_audit 
						(id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string)
						VALUES('".$id_op_audit."', '".$parent_id."', NOW(), '".$assigned_user_id."', 
						'sales_stage', 
						'enum', 
						'".$row_SQL_campos['sales_stage']."', 
						'".$sales_stage."')";
			$res_SQL_audit = $db->query($SQL_audit, true, 'Error selecting the opportunity record');				
		}	
	//05 validacion campo:assigned_user_id
		if($row_SQL_campos['assigned_user_id'] != $assigned_user_id)
		{
			$id_op_audit = md5(create_guid2()); 
			$SQL_audit ="INSERT INTO opportunities_audit 
						(id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string)
						VALUES('".$id_op_audit."', '".$parent_id."', NOW(),'".$assigned_user_id."', 
						'assigned_user_id', 
						'relate', 
						'".$row_SQL_campos['assigned_user_id']."', 
						'".$assigned_user_id."')";
			$res_SQL_audit = $db->query($SQL_audit, true, 'Error selecting the opportunity record');				
		}	
}

//AUDITORIA A TABLA DETALLE OPORTUNIDADES ////////////////
function valida_auditoria_dt_op($parent_id,$id_producto, $assigned_user_id, $estado_c, $valor_prospectado_c , $oportunidad_c, $mes_c, $anio_c, $id_usuario_c, $usuario_c, $id_cuenta_c, $cuenta_c, $forma_pago_c, $descripcion_c)
{
	$db =  DBManagerFactory::getInstance();
	$SQL_campos =	"SELECT m1.assigned_user_id,
						m1c.estado_c, 
						m1c.valor_prospectado_c , 
						m1c.oportunidad_c, 
						m1c.mes_c, 
						m1c.anio_c, 
						m1c.id_usuario_c, 
						m1c.usuario_c, 
						m1c.id_cuenta_c, 
						m1c.cuenta_c, 
						m1c.forma_pago_c, 
						m1c.descripcion_c		
					FROM m1_oportunidad_productos_cstm m1c
					INNER JOIN m1_oportunidad_productos m1 ON m1c.id_c = m1.id
					WHERE id_oportunidad_c = '".$parent_id."' AND id_producto_c = '".$id_producto."'";
	$result_SQL_campos = $db->query($SQL_campos, true, 'Error selecting the opportunity record');
	$row_SQL_campos = $db->fetchByAssoc($result_SQL_campos);
	
	//VALIDACION DE CAMPOS
		if($row_SQL_campos['assigned_user_id'] != $assigned_user_id && $assigned_user_id != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'assigned_user_id','relate',$row_SQL_campos['assigned_user_id'],$assigned_user_id);				
		}	
		if($row_SQL_campos['estado_c'] != $estado_c && $estado_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'estado_c','varchar',$row_SQL_campos['estado_c'],$estado_c);				
		}	
		if($row_SQL_campos['valor_prospectado_c'] != $valor_prospectado_c && $valor_prospectado_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'valor_prospectado_c','currency',$row_SQL_campos['valor_prospectado_c'],$valor_prospectado_c);				
		}	
		if($row_SQL_campos['oportunidad_c'] != $oportunidad_c && $oportunidad_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'oportunidad_c','varchar',$row_SQL_campos['oportunidad_c'],$oportunidad_c);				
		}	
		if($row_SQL_campos['mes_c'] != $mes_c && $mes_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'mes_c','enum',$row_SQL_campos['mes_c'],$mes_c);				
		}	
		if($row_SQL_campos['anio_c'] != $anio_c && $anio_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'anio_c','varchar',$row_SQL_campos['anio_c'],$anio_c);				
		}	
		if($row_SQL_campos['id_usuario_c'] != $id_usuario_c && $id_usuario_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'id_usuario_c','varchar',$row_SQL_campos['id_usuario_c'],$id_usuario_c);				
		}	
		if($row_SQL_campos['usuario_c'] != $usuario_c && $usuario_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'usuario_c','varchar',$row_SQL_campos['usuario_c'],$usuario_c);				
		}	
		if($row_SQL_campos['id_cuenta_c'] != $id_cuenta_c && $id_cuenta_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'id_cuenta_c','varchar',$row_SQL_campos['id_cuenta_c'],$id_cuenta_c);				
		}	
		if($row_SQL_campos['cuenta_c'] != $cuenta_c && $cuenta_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'cuenta_c','varchar',$row_SQL_campos['cuenta_c'],$cuenta_c);				
		}	
		if($row_SQL_campos['forma_pago_c'] != $forma_pago_c && $forma_pago_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'forma_pago_c','varchar',$row_SQL_campos['forma_pago_c'],$forma_pago_c);				
		}	
		if($row_SQL_campos['descripcion_c'] != $descripcion_c && $descripcion_c != '')
		{				
			graba__auditoria_det_op($id_producto,$assigned_user_id,'descripcion_c','varchar',$row_SQL_campos['descripcion_c'],$descripcion_c);				
		}			
}
function graba__auditoria_det_op($parent_id,$assigned_user_id,$field_name,$data_type,$campo_base,$campo_input)
{
	$db =  DBManagerFactory::getInstance();
	$id_det_op_audit = md5(create_guid2()); 
	$SQL_audit ="INSERT INTO m1_oportunidad_productos_audit 
				(id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string)
				VALUES('".$id_det_op_audit."', '".$parent_id."', NOW(), '".$assigned_user_id."', 
				'".$field_name."', 
				'".$data_type."', 
				'".$campo_base."', 
				'".$campo_input."')";
	$res_SQL_audit = $db->query($SQL_audit, true, 'Error selecting the opportunity record');
}

function crea_cotizacion($id_oportunidad,$oportunidad,$fecha_cierre,$id_user,$id_cuenta,$id_contacto,$oportunidad_nueva)
{
	$db =  DBManagerFactory::getInstance(); 
	$total = 0;
	$impuesto = 0;
	$total_total = 0;
	$impuesto_grupo = 0;
	$total_grupo = 0;
	$grupos = Array();
	$matriz_grupos;
	$i = 0;
	$j = 0;
	$bundle_quote = 0;
	$bundle_product = 1;
	$actual="";
	$pasada="";
	$categoria_actual="";
	$categoria_pasada="";
	$valor1="";
	$valor2="";
	$id_cotizacion="";
	if($oportunidad_nueva == '')
	{
		$grupos_actuales = array();
		$grupos_cotizacion = array();
		$query2 = "SELECT quote_id FROM quotes_opportunities WHERE opportunity_id = '".$id_oportunidad."'";
		$result2 = $db->query($query2, true, 'Error selecting the opportunity products number2 record');
		if($row2=$db->fetchByAssoc($result2))
		{
			$id_cotizacion = $row2['quote_id'];
		}
		//FLUJO PARA ACTUALIZAR LOS GRUPOS O CATEGORIAS Y PRODUCTOS DE LA COTIZACION
		$query3 = "SELECT categoria_c FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."' and estado_c = '1' GROUP BY categoria_c";
		$result3 = $db->query($query3, true, 'Error selecting the opportunity products number2 record');
		while($row3=$db->fetchByAssoc($result3))
		{
			$nombre = $row3['categoria_c'];
			$grupos_actuales[$nombre] = $row3['categoria_c'];
		}
		$query4 = "SELECT bundle_id FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."'";
		$result4 = $db->query($query4, true, 'Error selecting the opportunity products number2 record');
		while($row4=$db->fetchByAssoc($result4))
		{
			$query5 = "SELECT name FROM product_bundles WHERE id = '".$row4['bundle_id']."'";
			$result5 = $db->query($query5, true, 'Error selecting the opportunity products number2 record');
			if($row5=$db->fetchByAssoc($result5))
			{
				$nombre = $row5['name'];
				$grupos_cotizacion[$nombre] = $row5['name'];
			}
		}
		$bandera1=0;
		$bandera2=0;
		foreach($grupos_actuales as $valor1)
		{
			$categoria_actual = $valor1;
			foreach($grupos_cotizacion as $valor2)
			{
				if($valor1 == $valor2)
				{
					//no pasa nada
					$bandera1=1;
				}
			}
			if($bandera1==0)
			{
				//no esta en la cotizacion hay que crear
				$query6 = "SELECT SUM(valor_prospectado_c) as total,categoria_c FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."' and estado_c = '1' and categoria_c = '".$valor1."' GROUP BY categoria_c";
				$result6 = $db->query($query6, true, 'Error selecting the opportunity products number2 record');
				while($row6=$db->fetchByAssoc($result6))
				{
					$date_entered_group = date('Y-m-d H:i:s');
					$date_modified_group = date('Y-m-d H:i:s');
					$impuesto_grupo = $row6['total']*(0.12);
					$total_grupo = $row6['total'] + $impuesto_grupo;
					$id_grupo = md5(create_guid2());
					$query7 = "insert into product_bundles(team_id,team_set_id,id,deleted,date_entered,date_modified,modified_user_id,created_by,name,bundle_stage,description,tax,tax_usdollar,total,total_usdollar,subtotal_usdollar,shipping_usdollar,deal_tot,deal_tot_usdollar,new_sub,new_sub_usdollar,subtotal,shipping,currency_id) values('1','1','".$id_grupo."',0,'".$date_entered_group."','".$date_modified_group."','".$id_user."','".$id_user."','".$row6['categoria_c']."','Closed Accepted','',".$impuesto_grupo.",".$impuesto_grupo.",".$total_grupo.",".$total_grupo.",".$row6['total'].",0.000000,0.00,0.00,".$row6['total'].",".$row6['total'].",".$row6['total'].",0.000000,'-99')";
					$result7 = $db->query($query7, true, 'Error creating the group record...');
					$grupos[$i] = $id_grupo;
					$matriz_grupos[$i][0] = $id_grupo;
					$matriz_grupos[$i][1] = $row6['categoria_c'];
					$i++;
					$query8 = "SELECT MAX(bundle_index) as bundle_index FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."' ";
					$result8 = $db->query($query8, true, 'Error creating the quote group record...');
					if($row8=$db->fetchByAssoc($result8))
					{
						if($categoria_actual == $categoria_pasada)
						{
							$bundle_quote = $row8['bundle_index'];
						}
						else
						{
							$bundle_quote = $row8['bundle_index'] + 1;
						}
					}
					//7) crea la relacion entre la cotizacion y los grupos que van siendo creados
					$id_ctz_grupo = md5(create_guid2());
					$query9 = "insert into product_bundle_quote(id,date_modified,deleted,bundle_id,quote_id,bundle_index) values('".$id_ctz_grupo ."','".$date_modified_group."',0,'".$id_grupo."','".$id_cotizacion."',".$bundle_quote.")";
					$result9 = $db->query($query9, true, 'Error creating the quote group record...');							
				}
				//8) crea las lineas de detalle de la cotizacion, estos son los productos
				$query10 = "SELECT valor_prospectado_c, producto_c, id_producto_c, categoria_c, descripcion_c FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."' and estado_c = '1' and categoria_c = '".$valor1."' order by categoria_c";
				$result10 = $db->query($query10, true, 'Error selecting the opportunity products number3 record');
				while($row10=$db->fetchByAssoc($result10))
				{
					$actual=$row10['categoria_c'];
					$date_entered_product = date('Y-m-d H:i:s');
					$date_modified_product = date('Y-m-d H:i:s');
					$id_producto = md5(create_guid2());
					$query11 = "insert into products(id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,team_id,team_set_id,product_template_id,account_id,contact_id,type_id,quote_id,discount_price,discount_usdollar,currency_id,tax_class,quantity) values('".$id_producto."','".$row10['producto_c']."','".$date_entered_product."','".$date_modified_product."','".$id_user."','".$id_user."','".$row10['descripcion_c']."',0,'1','1','".$row10['id_producto_c']."','".$id_cuenta."','".$id_contacto."','','".$id_cotizacion."',".$row10['valor_prospectado_c'].",".$row10['valor_prospectado_c'].",'-99','Taxable',1)";
					$result11 = $db->query($query11, true, 'Error creating the product record...');
					
					//9) crea las la relacion entre los productos y los grupos
					foreach($matriz_grupos as $item)
					{
						if($item[1] == $row10['categoria_c'])
						{
							if($actual == $pasada)
							{
								$bundle_product = $bundle_product + 1;
								$id_grp_prod = md5(create_guid2());
								$query12 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
								$result12 = $db->query($query12, true, 'Error creating the group product record...');
								
							}
							else
							{
								if($j==0)
								{
									$id_grp_prod = md5(create_guid2());
									$query12 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
									$result12 = $db->query($query12, true, 'Error creating the group product record...');
								}
								else
								{
									$bundle_product = $bundle_product + 2;
									$id_grp_prod = md5(create_guid2());
									$query12 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
									$result12 = $db->query($query12, true, 'Error creating the group product record...');
								}
							}
						}
					}
					$pasada = $row10['categoria_c'];
					$j++;
				}
				$categoria_pasada = $categoria_actual;
			}
			else
			{
				$subtotal_grupo = 0;
				//ya esta en la cotizacion se actualiza los valores
				$query6 = "SELECT bundle_id FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."'";
				$result6 = $db->query($query6, true, 'Error selecting the opportunity products number2 record');
				while($row6=$db->fetchByAssoc($result6))
				{
					$query7 = "SELECT id, name, subtotal_usdollar FROM product_bundles WHERE id = '".$row6['bundle_id']."'";
					$result7 = $db->query($query7, true, 'Error selecting the opportunity products number2 record');
					if($row7=$db->fetchByAssoc($result7))
					{
						//restaura el grupo
						$query7x = "update product_bundles set deleted = '0' where id = '".$row7['id']."'";
						$result7x = $db->query($query7x, true, 'Error restoring the product_bundles record...');
						
						//restaura la relacion del grupo con la cotizacion
						$query7xx = "update product_bundle_quote set deleted = '0' where bundle_id = '".$row7['id']."' and quote_id = '".$id_cotizacion."'";
						$result7xx = $db->query($query7xx, true, 'Error restoring the relation product_bundle_quote record...');
						
						//restaura la relacion del producto con el grupo
						$query7xxx = "update product_bundle_product set deleted = '0' where bundle_id = '".$row7['id']."'";
						$result7xxx = $db->query($query7xxx, true, 'Error restoring the relation product_bundle_product record...');
						
						if($row7['name'] == $valor1)
						{
							$query8 = "SELECT SUM(valor_prospectado_c) as total,categoria_c FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."' and estado_c = '1' and categoria_c = '".$valor1."' GROUP BY categoria_c";
							$result8 = $db->query($query8, true, 'Error selecting the opportunity products number2 record');
							if($row8=$db->fetchByAssoc($result8))
							{
								$date_modified_group = date('Y-m-d H:i:s');
								$impuesto_grupo = $row8['total']*(0.12);
								$total_grupo = $row8['total'] + $impuesto_grupo;
								$query9 = "update product_bundles set date_modified = '".$date_modified_group."', tax = ".$impuesto_grupo.", tax_usdollar = ".$impuesto_grupo.", total = ".$total_grupo.", total_usdollar = ".$total_grupo.", subtotal_usdollar = ".$row8['total'].", shipping_usdollar = 0.000000, deal_tot = 0.00, deal_tot_usdollar = 0.00, new_sub = ".$row8['total'].", new_sub_usdollar = ".$row8['total'].", subtotal = ".$row8['total'].", shipping = 0.000000 where id = '".$row6['bundle_id']."'";
								$result9 = $db->query($query9, true, 'Error creating the group record...');
							}
							//8) actualiza las lineas de detalle de la cotizacion, estos son los productos
							$query10 = "SELECT valor_prospectado_c, producto_c, id_producto_c, categoria_c, descripcion_c FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."' and estado_c = '1' and categoria_c = '".$valor1."'";
							$result10 = $db->query($query10, true, 'Error selecting the opportunity products number3 record');
							while($row10=$db->fetchByAssoc($result10))
							{
								$query11 = "SELECT id, product_template_id FROM products WHERE product_template_id = '".$row10['id_producto_c']."' and quote_id = '".$id_cotizacion."'";
								$result11 = $db->query($query11, true, 'Error selecting the opportunity products number3 record');
								if($row11=$db->fetchByAssoc($result11))
								{
									//el producto ya esta se actualiza los valores en la cotizacion
									$date_modified_product = date('Y-m-d H:i:s');
									$query12 = "update products set deleted = '0', date_modified = '".$date_modified_product."', product_template_id = '".$row10['id_producto_c']."', account_id = '".$id_cuenta."', contact_id = '".$id_contacto."', discount_price = ".$row10['valor_prospectado_c'].", discount_usdollar = ".$row10['valor_prospectado_c'].", tax_class = 'Taxable' where quote_id = '".$id_cotizacion."' and product_template_id = '".$row10['id_producto_c']."'";
									$result12 = $db->query($query12, true, 'Error creating the product record...');
								}
								else
								{
									//el producto se acaba de agregar en la oportunidad, hay que agregarlo en la cotizacion
									$date_modified_product = date('Y-m-d H:i:s');
									$id_prod_new = md5(create_guid2());
									$query12 = "insert into products(id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,team_id,team_set_id,product_template_id,account_id,contact_id,type_id,quote_id,discount_price,discount_usdollar,currency_id,tax_class,quantity) values('".$id_prod_new."','".$row10['producto_c']."','".$date_modified_product."','".$date_modified_product."','".$id_user."','".$id_user."','".$row10['descripcion_c']."',0,'1','1','".$row10['id_producto_c']."','".$id_cuenta."','".$id_contacto."','','".$id_cotizacion."',".$row10['valor_prospectado_c'].",".$row10['valor_prospectado_c'].",'-99','Taxable',1)";
									$result12 = $db->query($query12, true, 'Error creating the product record...');
									
									$subtotal_grupo = $row7['subtotal_usdollar'] + $row10['valor_prospectado_c'];
									$impuesto_grupo = $subtotal_grupo*(0.12);
									$total_grupo = $subtotal_grupo + $impuesto_grupo;
									//$query13 = "update product_bundles set deleted = '0', date_modified = '".$date_modified_product."', tax = ".$impuesto_grupo.", tax_usdollar = ".$impuesto_grupo.", total = ".$total_grupo.", total_usdollar = ".$total_grupo.", subtotal_usdollar = ".$subtotal_grupo.", shipping_usdollar = 0.000000, deal_tot = 0.00, deal_tot_usdollar = 0.00, new_sub = ".$subtotal_grupo.", new_sub_usdollar = ".$subtotal_grupo.", subtotal = ".$subtotal_grupo.", shipping = 0.000000 where id = '".$row7['id']."'";
									//$result13 = $db->query($query13, true, 'Error adding the relation product_bundles record...');
									
									$query14 = "SELECT max(product_index) as maximo FROM product_bundle_product WHERE bundle_id = '".$row7['id']."' and deleted = '0'";
									$result14 = $db->query($query14, true, 'Error selecting the opportunity products number3 record');
									if($row14=$db->fetchByAssoc($result14))
									{
										$bundle_index_max = $row14['maximo'] + 1;
										$id_grp_prod = md5(create_guid2());
										$query15 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$row7['id']."','".$id_prod_new."',".$bundle_index_max.")";
										$result15 = $db->query($query15, true, 'Error creating the group product record...');
									}
								}
							}
						}
					}
				}
			}
			$bandera1=0;
		}
		
		foreach($grupos_cotizacion as $valor3)
		{
			foreach($grupos_actuales as $valor4)
			{
				if($valor3 == $valor4)
				{
					//no pasa nada
					$bandera2=1;
				}
			}
			
			if($bandera2==0)
			{
				//no esta en la tabla de oportunidad productos, se elimina el grupo y su producto (esto es para grupos con un solo producto)
				$query12 = "SELECT bundle_id FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."'";
				$result12 = $db->query($query12, true, 'Error selecting the opportunity products number2 record');
				while($row12=$db->fetchByAssoc($result12))
				{
					$query13 = "SELECT id, name FROM product_bundles WHERE id = '".$row12['bundle_id']."'";
					$result13 = $db->query($query13, true, 'Error selecting the opportunity products number2 record');
					if($row13=$db->fetchByAssoc($result13))
					{
						if($valor3 == $row13['name'])
						{
							//elimina el grupo
							$query14 = "update product_bundles set deleted = '1' where id = '".$row13['id']."'";
							$result14 = $db->query($query14, true, 'Error deleting the quote group record...');
							
							//elimina la relacion del grupo con la cotizacion
							$query15 = "update product_bundle_quote set deleted = '1' where bundle_id = '".$row13['id']."' and quote_id = '".$id_cotizacion."'";
							$result15 = $db->query($query15, true, 'Error deleting the relation quote group record...');
							
							//elimina la relacion del producto con el grupo
							$query16 = "update product_bundle_product set deleted = '1' where bundle_id = '".$row13['id']."'";
							$result16 = $db->query($query16, true, 'Error deleting the relation quote product record2...');
						}
					}
				}
			}
			else
			{
				$tot_deleteds = 0;
				//verifica los grupos que tienen mas de un producto, y elimina los productos que fueron eliminados de la oportunidad
				$query12 = "SELECT id_producto_c FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."' and categoria_c = '".$valor3."' and estado_c = '0'";
				$result12 = $db->query($query12, true, 'Error selecting the opportunity products number2 record');
				while($row12=$db->fetchByAssoc($result12))
				{
					$query13 = "SELECT id, discount_price FROM products WHERE product_template_id = '".$row12['id_producto_c']."' and quote_id = '".$id_cotizacion."'";
					$result13 = $db->query($query13, true, 'Error selecting the opportunity products number2 record');
					if($row13=$db->fetchByAssoc($result13))
					{
						$tot_deleteds = $tot_deleteds + $row13['discount_price'];
						$query14 = "update products set deleted = '1' where id = '".$row13['id']."'";
						$result14 = $db->query($query14, true, 'Error deleting the relation quote product record3...');
					}
				}

				/*$query12 = "SELECT bundle_id FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."' and deleted = '0'";
				$result12 = $db->query($query12, true, 'Error selecting the opportunity products number2 record');
				while($row12=$db->fetchByAssoc($result12))
				{
					$query13 = "SELECT id, name, subtotal_usdollar FROM product_bundles WHERE id = '".$row12['bundle_id']."' and name = '".$valor3."' and deleted = '0'";
					$result13 = $db->query($query13, true, 'Error selecting the opportunity products number2 record');
					if($row13=$db->fetchByAssoc($result13))
					{
						$subtotal_grupo = $row13['subtotal_usdollar'];
						$date_modified_group = date('Y-m-d H:i:s');
						$impuesto_grupo = $subtotal_grupo*(0.12);
						$total_grupo = $subtotal_grupo + $impuesto_grupo;
						$query15 = "update product_bundles set date_modified = '".$date_modified_group."', tax = ".$impuesto_grupo.", tax_usdollar = ".$impuesto_grupo.", total = ".$total_grupo.", total_usdollar = ".$total_grupo.", subtotal_usdollar = ".$subtotal_grupo.", shipping_usdollar = 0.000000, deal_tot = 0.00, deal_tot_usdollar = 0.00, new_sub = ".$subtotal_grupo.", new_sub_usdollar = ".$subtotal_grupo.", subtotal = ".$subtotal_grupo.", shipping = 0.000000 where id = '".$row13['id']."'";
						$result15 = $db->query($query15, true, 'Error deleting the relation quote product record1...');
					}
				}*/
			}
			$bandera2=0;
		}
		//actualiza el total de la cotizacion
		$query17 = "SELECT SUM(valor_prospectado_c) as total FROM m1_oportunidad_productos_cstm WHERE id_oportunidad_c = '".$id_oportunidad."' and estado_c = '1'";
		$result17 = $db->query($query17, true, 'Error selecting the opportunity products number2 record');
		if($row17=$db->fetchByAssoc($result17))
		{
			$date_modified = date('Y-m-d H:i:s');
			$impuesto_quote = $row17['total']*(0.12);
			$totall = $row17['total'] + $impuesto_quote;
			$query18 = "update quotes set date_modified = '".$date_modified."', modified_user_id = '".$id_user."', subtotal = ".$row17['total'].", subtotal_usdollar = ".$row17['total'].", new_sub = ".$row17['total'].", new_sub_usdollar = ".$row17['total'].", tax = ".$impuesto_quote.", tax_usdollar = ".$impuesto_quote.", total = ".$totall.", total_usdollar = ".$totall." where id = '".$id_cotizacion."'";
			$result18 = $db->query($query18, true, 'Error updating the quote record...');
		}
	}
	else
	{
		//la oportunidad es nueva, aun no esta en BD
		//1) consulta los valores de la tabla oportunidad_productos para ingresarlos en la cotizacion
		$query2 = "select a.* from m1_oportunidad_productos_cstm a, m1_oportunidad_productos b where a.oportunidad_c = '".$oportunidad."' and a.id_c = b.id and a.estado_c = '1'";
		$result2 = $db->query($query2, true, 'Error selecting the opportunity products record');
		while($row2=$db->fetchByAssoc($result2))
		{
			$total = $total + $row2['valor_prospectado_c'];
		}
		$impuesto = $total*(0.12);
		$total_total = $total + $impuesto;
		//2) crea la cotizacion
		$date_entered = date('Y-m-d H:i:s');
		$date_modified = date('Y-m-d H:i:s');
		$id_cotizacion = md5(create_guid2());
		$query3 = "insert into quotes(id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,assigned_user_id,team_id,team_set_id,shipper_id,currency_id,taxrate_id,show_line_nums,calc_grand_total,quote_type,date_quote_expected_closed,subtotal,subtotal_usdollar,shipping,shipping_usdollar,discount,deal_tot,deal_tot_usdollar,new_sub,new_sub_usdollar,tax,tax_usdollar,total,total_usdollar,system_id) values('".$id_cotizacion."','CTZ-".$oportunidad."','".$date_entered."','".$date_modified."','".$id_user."','".$id_user."','',0,'".$id_user."','1','1','','-99','f4cd05d3-6c7e-aa05-e2db-51391234b87d',1,1,'Quotes','".$fecha_cierre."',".$total.",".$total.",0.000000,0.000000,0,0.00,0.00,".$total.",".$total.",".$impuesto.",".$impuesto.",".$total_total.",".$total_total.",1)";
		$result3 = $db->query($query3, true, 'Error creating the quote record...');
		
		//3) crea la relacion entre la cotizacion y la oportunidad
		$id_relacion = md5(create_guid2());
		$query12 = "insert into quotes_opportunities(id,opportunity_id,quote_id) values('".$id_relacion."','".$id_oportunidad."','".$id_cotizacion."')";
		$result12 = $db->query($query12, true, 'Error creating the quote oportunity record...');
		
		//4)crea la relacion entre la cotizacion y la cuenta
		$id_ctz_cta = md5(create_guid2());
		$query4 = "insert into quotes_accounts(id,quote_id,account_id,account_role) values('".$id_ctz_cta."','".$id_cotizacion."','".$id_cuenta."','Bill to')";
		$result4 = $db->query($query4, true, 'Error creating the quote account record...');
		
		//5)crea la relacion entre la cotizacion y el contacto
		$id_ctz_cto = md5(create_guid2());
		$query5 = "insert into quotes_contacts(id,quote_id,contact_id,contact_role) values('".$id_ctz_cto."','".$id_cotizacion."','".$id_contacto."','Bill To')";
		$result5 = $db->query($query5, true, 'Error creating the quote contact record...');
		
		//6) crea los grupos de la cotizacion
		$query6 = "SELECT SUM(valor_prospectado_c) as total,categoria_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$oportunidad."' and estado_c = '1' GROUP BY categoria_c";
		$result6 = $db->query($query6, true, 'Error selecting the opportunity products number2 record');
		while($row6=$db->fetchByAssoc($result6))
		{
			$date_entered_group = date('Y-m-d H:i:s');
			$date_modified_group = date('Y-m-d H:i:s');
			$impuesto_grupo = $row6['total']*(0.12);
			$total_grupo = $row6['total'] + $impuesto_grupo;
			$id_grupo = md5(create_guid2());
			$query7 = "insert into product_bundles(team_id,team_set_id,id,deleted,date_entered,date_modified,modified_user_id,created_by,name,bundle_stage,description,tax,tax_usdollar,total,total_usdollar,subtotal_usdollar,shipping_usdollar,deal_tot,deal_tot_usdollar,new_sub,new_sub_usdollar,subtotal,shipping,currency_id) values('1','1','".$id_grupo."',0,'".$date_entered_group."','".$date_modified_group."','".$id_user."','".$id_user."','".$row6['categoria_c']."','Closed Accepted','',".$impuesto_grupo.",".$impuesto_grupo.",".$total_grupo.",".$total_grupo.",".$row6['total'].",0.000000,0.00,0.00,".$row6['total'].",".$row6['total'].",".$row6['total'].",0.000000,'-99')";
			$result7 = $db->query($query7, true, 'Error creating the group record...');
			$grupos[$i] = $id_grupo;
			$matriz_grupos[$i][0] = $id_grupo;
			$matriz_grupos[$i][1] = $row6['categoria_c'];
			$i++;
			//7) crea la relacion entre la cotizacion y los grupos que van siendo creados
			$id_ctz_grupo = md5(create_guid2());
			$query8 = "insert into product_bundle_quote(id,date_modified,deleted,bundle_id,quote_id,bundle_index) values('".$id_ctz_grupo ."','".$date_modified_group."',0,'".$id_grupo."','".$id_cotizacion."',".$bundle_quote.")";
			$result8 = $db->query($query8, true, 'Error creating the quote group record...');
			$bundle_quote++;
		}
		//8) crea las lineas de detalle de la cotizacion, estos son los productos
		$query9 = "SELECT valor_prospectado_c, producto_c, id_producto_c, categoria_c, descripcion_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$oportunidad."' and estado_c = '1' order by categoria_c";
		$result9 = $db->query($query9, true, 'Error selecting the opportunity products number3 record');
		while($row9=$db->fetchByAssoc($result9))
		{
			$actual=$row9['categoria_c'];
			$date_entered_product = date('Y-m-d H:i:s');
			$date_modified_product = date('Y-m-d H:i:s');
			$id_producto = md5(create_guid2());
			$query10 = "insert into products(id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,team_id,team_set_id,product_template_id,account_id,contact_id,type_id,quote_id,discount_price,discount_usdollar,currency_id,tax_class,quantity) values('".$id_producto."','".$row9['producto_c']."','".$date_entered_product."','".$date_modified_product."','".$id_user."','".$id_user."','".$row9['descripcion_c']."',0,'1','1','".$row9['id_producto_c']."','".$id_cuenta."','".$id_contacto."','','".$id_cotizacion."',".$row9['valor_prospectado_c'].",".$row9['valor_prospectado_c'].",'-99','Taxable',1)";
			$result10 = $db->query($query10, true, 'Error creating the product record...');
			
			//9) crea las la relacion entre los productos y los grupos
			foreach($matriz_grupos as $item)
			{
				if($item[1] == $row9['categoria_c'])
				{
					if($actual == $pasada)
					{
						$bundle_product = $bundle_product + 1;
						$id_grp_prod = md5(create_guid2());
						$query11 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
						$result11 = $db->query($query11, true, 'Error creating the group product record...');
					}
					else
					{
						if($j==0)
						{
							$id_grp_prod = md5(create_guid2());
							$query11 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
							$result11 = $db->query($query11, true, 'Error creating the group product record...');
						}
						else
						{
							$bundle_product = $bundle_product + 2;
							$id_grp_prod = md5(create_guid2());
							$query11 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
							$result11 = $db->query($query11, true, 'Error creating the group product record...');
						}
					}
				}
			}
			$pasada = $row['categoria_c'];
			$j++;
		}
	}
	return 1;
}

function envia_mail()
{
	require_once("modules/Administration/Administration.php");
	require_once("include/SugarPHPMailer.php");
	
	$check = $_POST['check'];
	$etapa = $_POST['etapa'];
	$duenio = $_POST['duenio'];
	$oportunidad = $_POST['oportunidad'];
	$total_op = $_POST['total_op']; 
	$cuenta = @$_POST['cuenta'];
	$primary_email="";
	$nombres="";
	$id_duenio="";
	$id_usuario = @$_POST['id_usuario'];
	$mail=new SugarPHPMailer();
	$admin = new Administration();
	$admin->retrieveSettings();
	$mail->isHTML(true);
	$mail->CharSet = "UTF-8";

	$db =  DBManagerFactory::getInstance(); 
	$query = "select id from users where CONCAT(first_name,' ',last_name) = '".$duenio."'";
	$result = $db->query($query, true, 'Error selecting the user record');
	if($row=$db->fetchByAssoc($result))
	{
		$id_duenio = $row['id'];
	}

	if($etapa == "Quote")
	{
		if($id_usuario != '1' && ($check == '0' || $check == '1'))
		{
			$db =  DBManagerFactory::getInstance(); 
			$query = "select user_id, role_id from acl_roles_users";
			$result = $db->query($query, true, 'Error selecting the detail product record');
			while($row=$db->fetchByAssoc($result))
			{
				$db2 =  DBManagerFactory::getInstance();
				$query2 = "select name from acl_roles where id = '".$row['role_id']."'";
				$result2 = $db2->query($query2, true, 'Error selecting the detail product record');
				if($row2=$db2->fetchByAssoc($result2))
				{
					if($row2['name'] == 'Supervisor Operativo')
					{
						$current_user = new User();
						$current_user->retrieve_by_string_fields(array('id'=>$row['user_id']));
						$nombres = $current_user->first_name." ".$current_user->last_name;
						$id_user = $current_user->id;

						$user=BeanFactory::getBean('Users',$id_user);
						$primary_email=$user->emailAddress->getPrimaryAddress($user);
					}
				}
			}
			$mail->AddAddress($primary_email, $nombres);
			//$mail->AddAddress("walcivar@plus-projects.com", "Wilmer Alcivar");
			//$mail->AddCC("spachano@plus-projects.com","Sebastian Pachano");
			$mail->From     = $admin->settings['notify_fromaddress']; 
			$mail->FromName = $admin->settings['notify_fromname'];
			$mail->Subject = "Oportunidad al 75%";
			$mail->Body = "<html><body><p>Estimado(a): ".$nombres."</p></br>
			<p>El usuario comercial <b>".$duenio."</b> ha actualizado una oportunidad al 75%</p></br>
			<p>La oportunidad es: <b>".$oportunidad."</b></p></br> 
			<p>El valor de la oportunidad es: <b>".$total_op."</b></p></br> 
			<p>La cuenta es: <b>".$cuenta."</b></p></br></br>
			<p>Por favor revise este registro en el módulo de Oportunidades de SugarCRM</p></br></body></html>";
			$mail->prepForOutbound();
			$mail->setMailerForSystem();
			$mail->Send();
		}
		else
		{		
			$user=BeanFactory::getBean('Users',$id_duenio);
			$primary_email=$user->emailAddress->getPrimaryAddress($user);
						
			$mail->AddAddress($primary_email, $duenio);
			//$mail->AddAddress("walcivar@plus-projects.com", "Wilmer Alcivar");
			//$mail->AddCC("spachano@plus-projects.com","Sebastian Pachano");
			$mail->From     = $admin->settings['notify_fromaddress']; 
			$mail->FromName = $admin->settings['notify_fromname'];
			$mail->Subject = "Oportunidad revisada sigue en 75%";
			$mail->Body = "<html><body><p>Estimado(a): ".$duenio."</p></br>
			<p>El Supervisor Operativo ha revisado la oportunidad y no la ha actualizado al 100% por que faltan datos importantes para el contrato.</p></br>
			<p>La oportunidad es: <b>".$oportunidad."</b></p></br> 
			<p>El valor de la oportunidad es: <b>".$total_op."</b></p></br> 
			<p>La cuenta es: <b>".$cuenta."</b></p></br></br>
			<p>Por favor revise este registro en el módulo de Oportunidades de SugarCRM</p></br></body></html>";
			$mail->prepForOutbound();
			$mail->setMailerForSystem();
			$mail->Send();
		}
	}
	if($etapa == "Closed Won")
	{
		$user=BeanFactory::getBean('Users',$id_duenio);
		$primary_email=$user->emailAddress->getPrimaryAddress($user);

		$mail->AddAddress($primary_email, $duenio);
		//$mail->AddAddress("walcivar@plus-projects.com", "Wilmer Alcivar");
		//$mail->AddCC("spachano@plus-projects.com","Sebastian Pachano");
		$mail->From     = $admin->settings['notify_fromaddress']; 
		$mail->FromName = $admin->settings['notify_fromname'];
		$mail->Subject = "Oportunidad revisada al 100%";
		$mail->Body = "<html><body><p>Estimado(a): ".$duenio."</p></br>
		<p>El Supervisor Operativo ha revisado la oportunidad y la ha actualizado al 100%</p></br>
		<p>La oportunidad es: <b>".$oportunidad."</b></p></br> 
		<p>El valor de la oportunidad es: <b>".$total_op."</b></p></br> 
		<p>La cuenta es: <b>".$cuenta."</b></p></br></br>
		<p>Si desea revisar este registro, por favor ingrese al módulo de oportunidades de SugarCRM</p></br></body></html>";
		$mail->prepForOutbound();
		$mail->setMailerForSystem();
		$mail->Send();
	}

	return 1;
}

function guardafeed($id_oportunidad,$oportunidad,$cuenta_id,$cuenta_name)
{
	$db =  DBManagerFactory::getInstance();
	$duenio = $_POST['duenio'];
	$id_creador = "";
	$query = "SELECT id FROM users where CONCAT(first_name,' ',last_name) = '".$duenio."'";
	$result = $db->query($query, true, 'Error selecting the opportunity record');
	if($row=$db->fetchByAssoc($result))
	{
		$id_creador = $row['id'];
	}
	$oportfeed = new Opportunity();
	$oportfeed->retrieve_by_string_fields(array('id'=>$id_oportunidad));
	if($oportfeed->id)
	{
		if($oportfeed->sales_stage == 'Needs Analysis')
		{
			$id_feed = md5(create_guid2());
			$amount = $oportfeed->amount;
			setlocale(LC_MONETARY, 'en_US');
			$total = money_format("%i", $amount);
			$name = "<b>{this.CREATED_BY}</b> {SugarFeed.CREATED_OPPORTUNITY} [Opportunities:".$id_oportunidad.":".$oportunidad."] {SugarFeed.WITH} [Accounts:".$cuenta_id.":".$cuenta_name."] {SugarFeed.FOR} ".$total."";
			$query = "insert into sugarfeed values('".$id_feed."','".$name."',NOW(),'','".$id_creador."','".$id_creador."','','0','1','1','".$id_creador."','Opportunities','".$id_oportunidad."','','')";
			$result = $db->query($query, true, 'Error creating the sugar feed record...');
		}
		if($oportfeed->sales_stage == 'Closed Won')
		{
			$id_feed = md5(create_guid2());
			$amount = $oportfeed->amount;
			setlocale(LC_MONETARY, 'en_US');
			$total = money_format("%i", $amount);
			$name = "<b>{this.CREATED_BY}</b> {SugarFeed.WON_OPPORTUNITY} [Opportunities:".$id_oportunidad.":".$oportunidad."] {SugarFeed.WITH} [Accounts:".$cuenta_id.":".$cuenta_name."] {SugarFeed.FOR} ".$total."";
			$query = "insert into sugarfeed values('".$id_feed."','".$name."',NOW(),'','".$id_creador."','".$id_creador."','','0','1','1','".$id_creador."','Opportunities','".$id_oportunidad."','','')";
			$result = $db->query($query, true, 'Error creating the sugar feed record...');
		}
	}
	return 1;
}
?>










