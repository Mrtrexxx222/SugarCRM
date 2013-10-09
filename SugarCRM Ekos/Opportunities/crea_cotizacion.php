<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

class clase
{
    function funcion($bean, $event, $arguments)
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
		$query = "select id from opportunities where id = '".$bean->id."'";
		$result = $db->query($query, true, 'Error selecting the opportunity record');
		if($row=$db->fetchByAssoc($result))
		{
			$grupos_actuales = array();
			$grupos_cotizacion = array();
			$query2 = "SELECT quote_id FROM quotes_opportunities WHERE opportunity_id = '".$bean->id."'";
			$result2 = $db->query($query2, true, 'Error selecting the opportunity products number2 record');
			if($row2=$db->fetchByAssoc($result2))
			{
				$id_cotizacion = $row2['quote_id'];
			}
			/*FLUJO PARA ACTUALIZAR LOS GRUPOS O CATEGORIAS Y PRODUCTOS DE LA COTIZACION*/
			$query3 = "SELECT categoria_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' GROUP BY categoria_c";
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
				$bandera1=0;
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
					$query6 = "SELECT SUM(valor_prospectado_c) as total,categoria_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' and categoria_c = '".$valor1."' GROUP BY categoria_c";
					$result6 = $db->query($query6, true, 'Error selecting the opportunity products number2 record');
					while($row6=$db->fetchByAssoc($result6))
					{
						$date_entered_group = date('Y-m-d H:i:s');
						$date_modified_group = date('Y-m-d H:i:s');
						$impuesto_grupo = $row6['total']*(0.12);
						$total_grupo = $row6['total'] + $impuesto_grupo;
						$id_grupo = md5($this->create_guid());
						$query7 = "insert into product_bundles(team_id,team_set_id,id,deleted,date_entered,date_modified,modified_user_id,created_by,name,bundle_stage,description,tax,tax_usdollar,total,total_usdollar,subtotal_usdollar,shipping_usdollar,deal_tot,deal_tot_usdollar,new_sub,new_sub_usdollar,subtotal,shipping,currency_id) values('1','1','".$id_grupo."',0,'".$date_entered_group."','".$date_modified_group."','".$bean->assigned_user_id."','".$bean->assigned_user_id."','".$row6['categoria_c']."','Closed Accepted','',".$impuesto_grupo.",".$impuesto_grupo.",".$total_grupo.",".$total_grupo.",".$row6['total'].",0.000000,0.00,0.00,".$row6['total'].",".$row6['total'].",".$row6['total'].",0.000000,'-99')";
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
						$id_ctz_grupo = md5($this->create_guid());
						$query9 = "insert into product_bundle_quote(id,date_modified,deleted,bundle_id,quote_id,bundle_index) values('".$id_ctz_grupo ."','".$date_modified_group."',0,'".$id_grupo."','".$id_cotizacion."',".$bundle_quote.")";
						$result9 = $db->query($query9, true, 'Error creating the quote group record...');							
					}
					//8) crea las lineas de detalle de la cotizacion, estos son los productos
					$query10 = "SELECT valor_prospectado_c, producto_c, id_producto_c, categoria_c, descripcion_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' and categoria_c = '".$valor1."' order by categoria_c";
					$result10 = $db->query($query10, true, 'Error selecting the opportunity products number3 record');
					while($row10=$db->fetchByAssoc($result10))
					{
						$actual=$row10['categoria_c'];
						$date_entered_product = date('Y-m-d H:i:s');
						$date_modified_product = date('Y-m-d H:i:s');
						$id_producto = md5($this->create_guid());
						$query11 = "insert into products(id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,team_id,team_set_id,product_template_id,account_id,contact_id,type_id,quote_id,discount_price,discount_usdollar,currency_id,tax_class,quantity) values('".$id_producto."','".$row10['producto_c']."','".$date_entered_product."','".$date_modified_product."','".$bean->assigned_user_id."','".$bean->assigned_user_id."','".$row10['descripcion_c']."',0,'1','1','".$row10['id_producto_c']."','".$bean->account_id."','".$bean->contact_id_c."','','".$id_cotizacion."',".$row10['valor_prospectado_c'].",".$row10['valor_prospectado_c'].",'-99','Taxable',1)";
						$result11 = $db->query($query11, true, 'Error creating the product record...');
						
						//9) crea las la relacion entre los productos y los grupos
						foreach($matriz_grupos as $item)
						{
							if($item[1] == $row10['categoria_c'])
							{
								if($actual == $pasada)
								{
									$bundle_product = $bundle_product + 1;
									$id_grp_prod = md5($this->create_guid());
									$query12 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
									$result12 = $db->query($query12, true, 'Error creating the group product record...');
									
								}
								else
								{
									if($j==0)
									{
										$id_grp_prod = md5($this->create_guid());
										$query12 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
										$result12 = $db->query($query12, true, 'Error creating the group product record...');
									}
									else
									{
										$bundle_product = $bundle_product + 2;
										$id_grp_prod = md5($this->create_guid());
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
					//ya esta en la cotizacion se actualiza los valores
					$query6 = "SELECT bundle_id FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."'";
					$result6 = $db->query($query6, true, 'Error selecting the opportunity products number2 record');
					while($row6=$db->fetchByAssoc($result6))
					{
						$query7 = "SELECT name FROM product_bundles WHERE id = '".$row6['bundle_id']."'";
						$result7 = $db->query($query7, true, 'Error selecting the opportunity products number2 record');
						if($row7=$db->fetchByAssoc($result7))
						{
							if($row7['name'] == $valor1)
							{
								$query8 = "SELECT SUM(valor_prospectado_c) as total,categoria_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' and categoria_c = '".$row7['name']."' GROUP BY categoria_c";
								$result8 = $db->query($query8, true, 'Error selecting the opportunity products number2 record');
								if($row8=$db->fetchByAssoc($result8))
								{
									$date_modified_group = date('Y-m-d H:i:s');
									$impuesto_grupo = $row8['total']*(0.12);
									$total_grupo = $row8['total'] + $impuesto_grupo;
									$query9 = "update product_bundles set date_modified = '".$date_modified_group."', tax = ".$impuesto_grupo.", tax_usdollar = ".$impuesto_grupo.", total = ".$total_grupo.", total_usdollar = ".$total_grupo.", subtotal_usdollar = ".$row8['total'].", shipping_usdollar = 0.000000, deal_tot = 0.00, deal_tot_usdollar = 0.00, new_sub = ".$row8['total'].", new_sub_usdollar = ".$row8['total'].", subtotal = ".$row8['total'].", shipping = 0.000000 where id = '".$row6['bundle_id']."'";
									$result9 = $db->query($query9, true, 'Error creating the group record...');
								}
							}
						}
					}
					//8) actualiza las lineas de detalle de la cotizacion, estos son los productos
					$query10 = "SELECT valor_prospectado_c, producto_c, id_producto_c, categoria_c, descripcion_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' order by categoria_c";
					$result10 = $db->query($query10, true, 'Error selecting the opportunity products number3 record');
					while($row10=$db->fetchByAssoc($result10))
					{
						$date_modified_product = date('Y-m-d H:i:s');
						$query10 = "update products set date_modified = '".$date_modified_product."', product_template_id = '".$row10['id_producto_c']."', account_id = '".$bean->account_id."', contact_id = '".$bean->contact_id_c."', discount_price = ".$row10['valor_prospectado_c'].", discount_usdollar = ".$row10['valor_prospectado_c'].", tax_class = 'Taxable' where quote_id = '".$id_cotizacion."'";
						$result10 = $db->query($query10, true, 'Error creating the product record...');
					}
				}
			}
			
			foreach($grupos_cotizacion as $valor1)
			{
				foreach($grupos_actuales as $valor2)
				{
					if($valor1 == $valor2)
					{
						//no pasa nada
						$bandera2=1;
					}
				}
				if($bandera2==1)
				{
					//ya esta en la cotizacion se actualiza los valores
					$query6 = "SELECT bundle_id FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."'";
					$result6 = $db->query($query6, true, 'Error selecting the opportunity products number2 record');
					while($row6=$db->fetchByAssoc($result6))
					{
						$query7 = "SELECT name FROM product_bundles WHERE id = '".$row6['bundle_id']."'";
						$result7 = $db->query($query7, true, 'Error selecting the opportunity products number2 record');
						if($row7=$db->fetchByAssoc($result7))
						{
							if($row7['name'] == $valor1)
							{
								$query8 = "SELECT SUM(valor_prospectado_c) as total,categoria_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' and categoria_c = '".$row7['name']."' GROUP BY categoria_c";
								$result8 = $db->query($query8, true, 'Error selecting the opportunity products number2 record');
								if($row8=$db->fetchByAssoc($result8))
								{
									$date_modified_group = date('Y-m-d H:i:s');
									$impuesto_grupo = $row8['total']*(0.12);
									$total_grupo = $row8['total'] + $impuesto_grupo;
									$query9 = "update product_bundles set date_modified = '".$date_modified_group."', tax = ".$impuesto_grupo.", tax_usdollar = ".$impuesto_grupo.", total = ".$total_grupo.", total_usdollar = ".$total_grupo.", subtotal_usdollar = ".$row8['total'].", shipping_usdollar = 0.000000, deal_tot = 0.00, deal_tot_usdollar = 0.00, new_sub = ".$row8['total'].", new_sub_usdollar = ".$row8['total'].", subtotal = ".$row8['total'].", shipping = 0.000000 where id = '".$row6['bundle_id']."'";
									$result9 = $db->query($query9, true, 'Error creating the group record...');
								}
							}
						}
					}
					//8) actualiza las lineas de detalle de la cotizacion, estos son los productos
					$query10 = "SELECT valor_prospectado_c, producto_c, id_producto_c, categoria_c, descripcion_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' and categoria_c = '".$valor1."' order by categoria_c";
					$result10 = $db->query($query10, true, 'Error selecting the opportunity products number3 record');
					while($row10=$db->fetchByAssoc($result10))
					{
						$date_modified_product = date('Y-m-d H:i:s');
						$query11 = "update products set date_modified = '".$date_modified_product."', product_template_id = '".$row10['id_producto_c']."', account_id = '".$bean->account_id."', contact_id = '".$bean->contact_id_c."', discount_price = ".$row10['valor_prospectado_c'].", discount_usdollar = ".$row10['valor_prospectado_c'].", tax_class = 'Taxable' where quote_id = '".$id_cotizacion."' and name = '".$row10['producto_c']."'";
						$result11 = $db->query($query10, true, 'Error creating the product record...');
					}
				}
				else
				{
					//no esta en la tabla de oportunidad productos, se elimina
					$query12 = "SELECT bundle_id FROM product_bundle_quote WHERE quote_id = '".$id_cotizacion."'";
					$result12 = $db->query($query12, true, 'Error selecting the opportunity products number2 record');
					while($row12=$db->fetchByAssoc($result12))
					{
						$query13 = "SELECT id, name FROM product_bundles WHERE id = '".$row12['bundle_id']."'";
						$result13 = $db->query($query13, true, 'Error selecting the opportunity products number2 record');
						if($row13=$db->fetchByAssoc($result13))
						{
							if($valor1 == $row13['name'])
							{
								//$query14 = "delete from product_bundles where id = '".$row13['id']."'";
								//$result14 = $db->query($query14, true, 'Error creating the quote group record...');
								
								$query15 = "delete from product_bundle_quote where bundle_id = '".$row13['id']."'";
								$result15 = $db->query($query15, true, 'Error creating the quote group record...');
							}
						}
					}
				}
				$bandera2=0;
			}
		}
		else
		{
			//la oportunidad es nueva, aun no esta en BD
			//1) consulta los valores de la tabla oportunidad_productos para ingresarlos en la cotizacion
			$query2 = "select a.* from m1_oportunidad_productos_cstm a, m1_oportunidad_productos b where a.oportunidad_c = '".$bean->name."' and a.id_c = b.id and a.estado_c = '1'";
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
			$id_cotizacion = md5($this->create_guid());
			$query3 = "insert into quotes(id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,assigned_user_id,team_id,team_set_id,shipper_id,currency_id,taxrate_id,show_line_nums,calc_grand_total,quote_type,date_quote_expected_closed,subtotal,subtotal_usdollar,shipping,shipping_usdollar,discount,deal_tot,deal_tot_usdollar,new_sub,new_sub_usdollar,tax,tax_usdollar,total,total_usdollar,system_id) values('".$id_cotizacion."','CTZ-".$bean->name."','".$date_entered."','".$date_modified."','".$bean->assigned_user_id."','".$bean->assigned_user_id."','',0,'".$bean->assigned_user_id."','1','1','','-99','f4cd05d3-6c7e-aa05-e2db-51391234b87d',1,1,'Quotes','".$bean->date_closed."',".$total.",".$total.",0.000000,0.000000,0,0.00,0.00,".$total.",".$total.",".$impuesto.",".$impuesto.",".$total_total.",".$total_total.",1)";
			$result3 = $db->query($query3, true, 'Error creating the quote record...');
			
			//3) crea la relacion entre la cotizacion y la oportunidad
			$id_relacion = md5($this->create_guid());
			$query12 = "insert into quotes_opportunities(id,opportunity_id,quote_id) values('".$id_relacion."','".$bean->id."','".$id_cotizacion."')";
			$result12 = $db->query($query12, true, 'Error creating the quote oportunity record...');
					
			//4)crea la relacion entre la cotizacion y la cuenta
			$id_ctz_cta = md5($this->create_guid());
			$query4 = "insert into quotes_accounts(id,quote_id,account_id,account_role) values('".$id_ctz_cta."','".$id_cotizacion."','".$bean->account_id."','Bill to')";
			$result4 = $db->query($query4, true, 'Error creating the quote account record...');
			
			//5)crea la relacion entre la cotizacion y el contacto
			$id_ctz_cto = md5($this->create_guid());
			$query5 = "insert into quotes_contacts(id,quote_id,contact_id,contact_role) values('".$id_ctz_cto."','".$id_cotizacion."','".$bean->contact_id_c."','Bill To')";
			$result5 = $db->query($query5, true, 'Error creating the quote contact record...');
			
			//6) crea los grupos de la cotizacion
			$query6 = "SELECT SUM(valor_prospectado_c) as total,categoria_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' GROUP BY categoria_c";
			$result6 = $db->query($query6, true, 'Error selecting the opportunity products number2 record');
			while($row6=$db->fetchByAssoc($result6))
			{
				$date_entered_group = date('Y-m-d H:i:s');
				$date_modified_group = date('Y-m-d H:i:s');
				$impuesto_grupo = $row6['total']*(0.12);
				$total_grupo = $row6['total'] + $impuesto_grupo;
				$id_grupo = md5($this->create_guid());
				$query7 = "insert into product_bundles(team_id,team_set_id,id,deleted,date_entered,date_modified,modified_user_id,created_by,name,bundle_stage,description,tax,tax_usdollar,total,total_usdollar,subtotal_usdollar,shipping_usdollar,deal_tot,deal_tot_usdollar,new_sub,new_sub_usdollar,subtotal,shipping,currency_id) values('1','1','".$id_grupo."',0,'".$date_entered_group."','".$date_modified_group."','".$bean->assigned_user_id."','".$bean->assigned_user_id."','".$row6['categoria_c']."','Closed Accepted','',".$impuesto_grupo.",".$impuesto_grupo.",".$total_grupo.",".$total_grupo.",".$row6['total'].",0.000000,0.00,0.00,".$row6['total'].",".$row6['total'].",".$row6['total'].",0.000000,'-99')";
				$result7 = $db->query($query7, true, 'Error creating the group record...');
				$grupos[$i] = $id_grupo;
				$matriz_grupos[$i][0] = $id_grupo;
				$matriz_grupos[$i][1] = $row6['categoria_c'];
				$i++;
				//7) crea la relacion entre la cotizacion y los grupos que van siendo creados
				$id_ctz_grupo = md5($this->create_guid());
				$query8 = "insert into product_bundle_quote(id,date_modified,deleted,bundle_id,quote_id,bundle_index) values('".$id_ctz_grupo ."','".$date_modified_group."',0,'".$id_grupo."','".$id_cotizacion."',".$bundle_quote.")";
				$result8 = $db->query($query8, true, 'Error creating the quote group record...');
				$bundle_quote++;
			}
			//8) crea las lineas de detalle de la cotizacion, estos son los productos
			$query9 = "SELECT valor_prospectado_c, producto_c, id_producto_c, categoria_c, descripcion_c FROM m1_oportunidad_productos_cstm WHERE oportunidad_c = '".$bean->name."' and estado_c = '1' order by categoria_c";
			$result9 = $db->query($query9, true, 'Error selecting the opportunity products number3 record');
			while($row9=$db->fetchByAssoc($result9))
			{
				$actual=$row9['categoria_c'];
				$date_entered_product = date('Y-m-d H:i:s');
				$date_modified_product = date('Y-m-d H:i:s');
				$id_producto = md5($this->create_guid());
				$query10 = "insert into products(id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,team_id,team_set_id,product_template_id,account_id,contact_id,type_id,quote_id,discount_price,discount_usdollar,currency_id,tax_class,quantity) values('".$id_producto."','".$row9['producto_c']."','".$date_entered_product."','".$date_modified_product."','".$bean->assigned_user_id."','".$bean->assigned_user_id."','".$row9['descripcion_c']."',0,'1','1','".$row9['id_producto_c']."','".$bean->account_id."','".$bean->contact_id_c."','','".$id_cotizacion."',".$row9['valor_prospectado_c'].",".$row9['valor_prospectado_c'].",'-99','Taxable',1)";
				$result10 = $db->query($query10, true, 'Error creating the product record...');
				
				//9) crea las la relacion entre los productos y los grupos
				foreach($matriz_grupos as $item)
				{
					if($item[1] == $row9['categoria_c'])
					{
						if($actual == $pasada)
						{
							$bundle_product = $bundle_product + 1;
							$id_grp_prod = md5($this->create_guid());
							$query11 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
							$result11 = $db->query($query11, true, 'Error creating the group product record...');
							
						}
						else
						{
							if($j==0)
							{
								$id_grp_prod = md5($this->create_guid());
								$query11 = "insert into product_bundle_product(id,date_modified,deleted,bundle_id,product_id,product_index) values('".$id_grp_prod."','".$date_modified_product."',0,'".$item[0]."','".$id_producto."',".$bundle_product.")";
								$result11 = $db->query($query11, true, 'Error creating the group product record...');
							}
							else
							{
								$bundle_product = $bundle_product + 2;
								$id_grp_prod = md5($this->create_guid());
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
	}
	
	function create_guid()
	{
		$microTime = microtime();
		list($a_dec, $a_sec) = explode(" ", $microTime);

		$dec_hex = dechex($a_dec* 1000000);
		$sec_hex = dechex($a_sec);

		$this->ensure_length($dec_hex, 5);
		$this->ensure_length($sec_hex, 6);

		$guid = "";
		$guid .= $dec_hex;
		$guid .= $this->create_guid_section(3);
		$guid .= '-';
		$guid .= $this->create_guid_section(4);
		$guid .= '-';
		$guid .= $this->create_guid_section(4);
		$guid .= '-';
		$guid .= $this->create_guid_section(4);
		$guid .= '-';
		$guid .= $sec_hex;
		$guid .= $this->create_guid_section(6);

		return $guid;

	}

	function create_guid_section($characters)
	{
		$return = "";
		for($i=0; $i<$characters; $i++)
		{
			$return .= dechex(mt_rand(0,15));
		}
		return $return;
	}

	function ensure_length(&$string, $length)
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
}
?>