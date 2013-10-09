<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$resultado="";
$simple = $_POST['simple'];
$id_tag = $_POST['id_tag'];
$estatus = $_POST['estatus'];
$id_cuenta = $_POST['id_cuenta'];
$producto = $_POST['producto'];

if($simple == "si")
{
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
					$detalle_asig_producto = $focus->retrieve($id_det_asig_pro_record);
					$detalle_asig_producto->estatus_c = $estatus;
					$detalle_asig_producto->nombre_producto_c = $producto;
					$detalle_asig_producto->nombre_cuenta_c = $nombre_cuenta;
					//$detalle_asig_producto->nombre_usuario_c = $nombres_usuario;
					$detalle_asig_producto->nombre_linea_c = $linea_producto;
					$detalle_asig_producto->save();
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
				$focus->save();
				$resultado.="/1";
			}
		}
	}
}
else
{
	$usuario = $_POST['usuario'];
	$id_usuario = $_POST['id_usuario'];

	$product = new ProductTemplate();
	$product->retrieve_by_string_fields(array('name'=>$producto));
	$id_producto = $product->id;
	$id_linea = $product->category_id;

	$det_asig_prod = new Detalle_asig_producto();
	$det_asig_prod->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario,'estatus_c'=>'Solicitar'));

	if($det_asig_prod->id)
	{
		if($estatus == 'No aprobado' || $estatus == 'Aprobado')
		{
			$focus = BeanFactory::getBean('Detalle_asig_producto');
			$detalle_asig_producto = $focus->retrieve($det_asig_prod->id);
			$detalle_asig_producto->estatus_c = $estatus;
			$detalle_asig_producto->save();
			$resultado.="1/".$id_usuario."/".$usuario."/".$product->name."/".$det_asig_prod->nombre_cuenta_c."/".$estatus;
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
				$focus = BeanFactory::getBean('Detalle_asig_producto');
				$detalle_asig_producto = $focus->retrieve($det_asig_prod2->id);
				$detalle_asig_producto->estatus_c = $estatus;
				$detalle_asig_producto->save();
				$resultado.="1/".$id_usuario."/".$usuario."/".$product->name."/".$det_asig_prod2->nombre_cuenta_c."/".$estatus;
			}
		}
		else
		{
			$det_asig_prod3 = new Detalle_asig_producto();
			$det_asig_prod3->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario,'estatus_c'=>'No aprobado'));
			if($det_asig_prod3->id)
			{
				if($estatus == 'Aprobado')
				{
					$focus = BeanFactory::getBean('Detalle_asig_producto');
					$detalle_asig_producto = $focus->retrieve($det_asig_prod3->id);
					$detalle_asig_producto->estatus_c = $estatus;
					$detalle_asig_producto->save();
					$resultado.="1/".$id_usuario."/".$usuario."/".$product->name."/".$det_asig_prod3->nombre_cuenta_c."/".$estatus;
				}
			}
			else
			{
				$det_asig_prod4 = new Detalle_asig_producto();
				$det_asig_prod4->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'estatus_c'=>'Aprobado'));
				if($det_asig_prod4->id)
				{
					if($estatus == 'Aprobado')
					{
						//no guarda, por que ya esta aprobado a otro cliente
						$resultado.="El producto ".$producto." ya esta aprobado a otro relacionador";
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
					}
					$resultado.="/1";
				}
			}
		}
	}
}

echo $resultado;
?>