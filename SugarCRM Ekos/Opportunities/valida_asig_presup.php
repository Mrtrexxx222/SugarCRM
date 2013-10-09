<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

$resultado = "";
$nombre_oportunidad = @$_POST['oportunidad'];
$id_oportunidad_old = '';
$id_usuario_actual 	= @$_POST['id_usuario'];
$nombre_cuenta 	= @$_POST['cuenta'];
$guarda_o_no 	= @$_POST['guarda_o_no'];
$ids_validar 	= @$_POST['ids_validar'];
$probabilidad	='0';
$id_oportunidad	='';
$distintos 		= 0;
$op_duplicado 	= @$_POST['id_op_old'];
if($op_duplicado == 'NO')
{
	$id_oportunidad_old = ''; 
}
else
{
	$id_oportunidad_old = $op_duplicado;
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
//echo $cadena;

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
if(strpos($nombre_cuenta,"/") !== false)
{
    $nombre_cuenta = str_replace("/", "&", $nombre_cuenta);
}
$total=0;
$cont=0;
$anio = date("Y");
$duenio = $_POST['duenio'];
$usuario = new User();
$usuario->retrieve_by_string_fields(array('id'=>$id_usuario_actual));
$nombres_usuario = $usuario->first_name." ".$usuario->last_name;
$db =  DBManagerFactory::getInstance();
if($duenio == $nombres_usuario)
{
}
else
{
	$query0 = "SELECT id FROM users where CONCAT(first_name,' ',last_name) = '".$duenio."'";
	$result0 = $db->query($query0, true, 'Error selecting the oportunity record');
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

$query6 = "select * FROM opportunities where id = '".$id_oportunidad."'";

$result6 = $db->query($query6, true, 'Error selecting the product record');
if($row6=$db->fetchByAssoc($result6))
{
	$probabilidad = $row6['probability'];
}
else
{
	$probabilidad = '0';
}

$query3 = "select count(id_producto_c) as total from m1_oportunidad_productos_cstm 
		   where id_c in (".$cadena.") and estado_c = '1'";

$result3 = $db->query($query3, true, 'Error selecting the product record');
if($row3=$db->fetchByAssoc($result3))
{
	$total = $row3['total'];
}

$query2 = "select id_producto_c from m1_oportunidad_productos_cstm 
		   where id_c in (".$cadena.") and estado_c = '1'";

$result2 = $db->query($query2, true, 'Error selecting the product record');
while($row2=$db->fetchByAssoc($result2))
{
	$id_producto = $row2['id_producto_c'];
	$det_asig_prod = new Detalle_asig_producto();
	$det_asig_prod->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'assigned_user_id'=>$id_usuario_actual,'estatus_c'=>'Aprobado'));
	if($det_asig_prod->id)
	{
		//El producto ya esta aprobado para este usuario
		//verifica que el usuario tenga presupuesto para ese producto
		/*$presupuesto = new Presupuestos();
		$presupuesto->retrieve_by_string_fields(array('assigned_user_id'=>$id_usuario_actual,'nombre_periodo_c'=>$anio,'tipo_c'=>'distribucion','producttemplate_id_c'=>$id_producto,'estatus_c'=>'Aprobado'));					
		if($presupuesto->id)
		{*/
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
						
						$resultado.=" 1 ";
					}
					else
					{						
							if($distintos == 1)
							{	
								$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario_actual."' , usuario_c = '".$nombres_usuario."' 
									WHERE id_c = '".$row4['id_c']."'";
								$result = $db->query($query, true, 'Error selecting the user record'); 
								$resultado.=" 3 ";
							}			
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
						$resultado.=" 4 ";
					}		
					else 
					{
						if($id_oportunidad_old != '')
						{
							$SQL_X  = "SELECT id_usuario_c,usuario_c 
										FROM m1_oportunidad_productos_cstm 
										WHERE id_producto_c = '".$id_producto."' AND id_oportunidad_c = '".$id_oportunidad_old."'";
							$result_SQL_X = $db->query($SQL_X, true, 'Error selecting the OLD opportunity record');
							if($row_SQL_X = $db->fetchByAssoc($result_SQL_X))
							{
								$query = "UPDATE m1_oportunidad_productos_cstm
											SET id_usuario_c = '".$row_SQL_X['id_usuario_c']."' , usuario_c = '".$row_SQL_X['usuario_c']."' 
											WHERE id_c = '".$row4['id_c']."'"; 
								$result = $db->query($query, true, 'Error selecting the user record'); 
							}
						}
					}	
				}
			}
		//}		
	}
	else
	{
		//CUANDO EL USUARIO VENDE UN PRODUCTO ASIGNADO A OTRO USUARIO
	$resultado.=" - A ";		
		$det_asig_prod2 = new Detalle_asig_producto();
		//valida si algun usuario ya tiene asignado ese producto
		$det_asig_prod2->retrieve_by_string_fields(array('producttemplate_id_c'=>$id_producto,'account_id_c'=>$id_cuenta,'estatus_c'=>'Aprobado'));
		if($det_asig_prod2->id)
		{	
			//El producto ya esta asignado a otro usuario
			//Obtiene el nombre y el id del usuario asignado a ese producto
			$usuario2 = new User();
			$usuario2->retrieve_by_string_fields(array('id'=>$det_asig_prod2->assigned_user_id));
			$nombres_usuario2 = $usuario2->first_name." ".$usuario2->last_name;
			$id_usuario2 = $det_asig_prod2->assigned_user_id;

			//valida que el otro usuario tenga presupuesto para ese producto
			/*$presupuesto2 = new Presupuestos();
			$presupuesto2->retrieve_by_string_fields(array('assigned_user_id'=>$id_usuario2,'nombre_periodo_c'=>$anio,'tipo_c'=>'distribucion','producttemplate_id_c'=>$id_producto,'estatus_c'=>'Aprobado'));
			if($presupuesto2->id) 
			{//el producto esta para otro usuario pero igual cumple
			*/
				
				$cont++; 
				$query5 = "SELECT id_c FROM m1_oportunidad_productos_cstm where oportunidad_c = '".$nombre_oportunidad."' and id_producto_c = '".$id_producto."' and id_cuenta_c = '".$id_cuenta."'";
				$result5 = $db->query($query5, true, 'Error selecting the opportunity record'); 
				if($row5=$db->fetchByAssoc($result5))
				{
					if($probabilidad != '100')
					{ 
						/*if($guarda_o_no == 1)
						{
							$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario2."' , usuario_c = '".$nombres_usuario2."' 
									WHERE id_c = '".$row5['id_c']."'";
							$result = $db->query($query, true, 'Error selecting the user record'); 							
							
							$resultado.=" A1 "."N2:".$nombres_usuario2." N1:".$nombres_usuario.";";
						}
						else
						{														
								if($distintos == 1)
								{*/
									if($id_oportunidad_old != '')
									{
										$SQL_X  = "SELECT id_usuario_c,usuario_c 
													FROM m1_oportunidad_productos_cstm 
													WHERE id_producto_c = '".$id_producto."' AND id_oportunidad_c = '".$id_oportunidad_old."'";
										//echo $SQL_X;			
										$result_SQL_X = $db->query($SQL_X, true, 'Error selecting the OLD opportunity record');
										if($row_SQL_X = $db->fetchByAssoc($result_SQL_X))
										{
											$query = "UPDATE m1_oportunidad_productos_cstm
														SET id_usuario_c = '".$row_SQL_X['id_usuario_c']."' , usuario_c = '".$row_SQL_X['usuario_c']."' 
														WHERE id_c = '".$row5['id_c']."'"; 
											$result = $db->query($query, true, 'Error selecting the user record'); 
											//$resultado.=" A4 "."N2:".$nombres_usuario2." N1:".$nombres_usuario.";";
										}
									}
									else
									{
										$query = "UPDATE m1_oportunidad_productos_cstm
										SET id_usuario_c = '".$id_usuario2."', usuario_c = '".$nombres_usuario2."' 
										WHERE id_c = '".$row5['id_c']."'";
										$result = $db->query($query, true, 'Error selecting the user record'); 
										
										//$resultado.=" A3 "."N2:".$nombres_usuario2." N1:".$nombres_usuario.";";
									}
								/*}																					
						}*/
					}
					else
					{	
						/*if($guarda_o_no == 1)
						{		
							$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario2."', usuario_c = '".$nombres_usuario2."' 
									WHERE id_c = '".$row5['id_c']."'";
							$result = $db->query($query, true, 'Error selecting the user record'); 

							//$resultado.=" A4x "."N2:".$nombres_usuario2." N1:".$nombres_usuario.";";
						}
						else 
						{	*/
							//VALIDA SI ES DUPLICADO
							if($id_oportunidad_old != '')
							{
								$SQL_X  = "SELECT id_usuario_c,usuario_c 
											FROM m1_oportunidad_productos_cstm 
											WHERE id_producto_c = '".$id_producto."' AND id_oportunidad_c = '".$id_oportunidad_old."'";
								echo $SQL_X;			
								$result_SQL_X = $db->query($SQL_X, true, 'Error selecting the OLD opportunity record');
								if($row_SQL_X = $db->fetchByAssoc($result_SQL_X))
								{
									$query = "UPDATE m1_oportunidad_productos_cstm
												SET id_usuario_c = '".$row_SQL_X['id_usuario_c']."' , usuario_c = '".$row_SQL_X['usuario_c']."' 
												WHERE id_c = '".$row5['id_c']."'"; 
									$result = $db->query($query, true, 'Error selecting the user record'); 
									//$resultado.=" A4 "."N2:".$nombres_usuario2." N1:".$nombres_usuario.";";
								}
							}
							else
							{
								//VALIDA SI EL USUARIO QUE MODIFICA ES DISTINTO AL ASIGNADO
								/*if($distintos == 1)
								{*/
									$query = "UPDATE m1_oportunidad_productos_cstm
									SET id_usuario_c = '".$id_usuario2."', usuario_c = '".$nombres_usuario2."' 
									WHERE id_c = '".$row5['id_c']."'";
									$result = $db->query($query, true, 'Error selecting the user record'); 
									
									//$resultado.=" A5 "."N2:".$nombres_usuario2." N1:".$nombres_usuario.";";
								/*}*/
							}	
						/*}*/
					}
				}
			//}		
		}
	}
}



if($total == $cont)
{
	echo '1';
}
else
{
	echo '0';
}

echo " ok: ".$resultado;
echo " ok2: ".$result;
?>