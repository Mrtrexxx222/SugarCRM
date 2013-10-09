{if $fields.syno_reports_type.value == 'matrix'}
	<h4 class="dataLabel">{sugar_translate label='LBL_RESULTAT_MATRICE' module='{{$module}}'}</h4><br>

	{if $MATRICE_OK == 1}
		{php}
			$nombre_reporte = $GLOBALS['FOCUS']->name;
			$bandera='0';
			$cuenta = '';
			$i=0;
			$producto = array();
			$cabecera = array();
			$$detalle = array();
			$resultado_matriz = "";
			$otro_resultado_matriz = "";
			$cadena = explode("FROM", $this->_tpl_vars['DESC']);
			$tabla = trim($cadena[1]);
			$cadena2 = explode(" ",$tabla);
			$nombre_tabla = trim($cadena2[0]);
			if($nombre_tabla == 'detalle_asig_producto_cstm')
			{
				$cabecera = $this->_tpl_vars['SQL_HEADER_MATRICE'];
				$detalle = $this->_tpl_vars['SQL_RESULT_MATRICE'];
				$MAPA = $this->_tpl_vars['MAPA'];
				$resultado_matriz.="<script type='text/javascript' src='custom/modules/SYNO_Reports/jquery.tablescroll.js'></script>
									<style type='text/css'>
										.tablescroll {
											font: 12px normal Tahoma, Geneva, 'Helvetica Neue', Helvetica, Arial, sans-serif;
										}
										 
										.tablescroll td, 
										.tablescroll_wrapper,
										.tablescroll_head,
										.tablescroll_foot { 
											border:1px solid #ccc;
										}
										 
										.tablescroll td {
											padding:3px 5px;
											border-bottom:0;
											border-right:0; 
										}
										 
										.tablescroll_wrapper {
											background-color:#fff;
											border-left:0;
										}
										 
										.tablescroll_head,
										.tablescroll_foot { 
											background-color:#eee;
											border-left:0;
											border-top:0;
											font-size:11px;
											font-weight:bold;
										}
										 
										.tablescroll_head { 
											margin-bottom:3px;
										}
										 
										.tablescroll_foot { 
											margin-top:3px;
										}
										 
										.tablescroll tbody tr.first td { 
											border-top:0; 
										}
									</style>";
				
				echo $resultado_matriz;
				echo $MAPA;
			}
			else
			{
				if($nombre_reporte == 'Presupuesto mensual por producto')
				{
					$total_enero = 0;
					$total_febrero = 0;
					$total_marzo = 0;
					$total_abril = 0;
					$total_mayo = 0;
					$total_junio = 0;
					$total_julio = 0;
					$total_agosto = 0;
					$total_septiembre = 0;
					$total_octubre = 0;
					$total_noviembre = 0;
					$total_diciembre = 0;
					$totales = 0;
					$cabecera = $this->_tpl_vars['SQL_HEADER_MATRICE'];
					$detalle = $this->_tpl_vars['SQL_RESULT_MATRICE'];
					$resultado_matriz.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='scrollTable'>
											<tr>";
					foreach($cabecera as $row)
					{
						if($row == '1')
						{
							$row = 'Enero';
						}
						if($row == '2')
						{
							$row = 'Febrero';
						}
						if($row == '3')
						{
							$row = 'Marzo';
						}
						if($row == '4')
						{
							$row = 'Abril';
						}
						if($row == '5')
						{
							$row = 'Mayo';
						}
						if($row == '6')
						{
							$row = 'Junio';
						}
						if($row == '7')
						{
							$row = 'Julio';
						}
						if($row == '8')
						{
							$row = 'Agosto';
						}
						if($row == '9')
						{
							$row = 'Septiembre';
						}
						if($row == '10')
						{
							$row = 'Octubre';
						}
						if($row == '11')
						{
							$row = 'Noviembre';
						}
						if($row == '12')
						{
							$row = 'Diciembre';
						}
						$resultado_matriz.="<th id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row."</th>";
						$i++;
					}
					$resultado_matriz.="<th id='13' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Total</th>";
					$resultado_matriz.="</tr>";
					foreach($detalle as $colum)
					{
						$i=0;
						$total_producto = 0;
						$bandera='0';
						$resultado_matriz.="<tr>";
						foreach($colum as $value)
						{
							if($bandera=='0')
							{
								$resultado_matriz.="<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'>".$value."</td>";
							}
							else
							{
								$value = floatval($value);
								if($i==1)
								{
									$total_enero = $total_enero + $value;
								}
								if($i==2)
								{
									$total_febrero = $total_febrero + $value;
								}
								if($i==3)
								{
									$total_marzo = $total_marzo + $value;
								}
								if($i==4)
								{
									$total_abril = $total_abril + $value;
								}
								if($i==5)
								{
									$total_mayo = $total_mayo + $value;
								}
								if($i==6)
								{
									$total_junio = $total_junio + $value;
								}
								if($i==7)
								{
									$total_julio = $total_julio + $value;
								}
								if($i==8)
								{
									$total_agosto = $total_agosto + $value;
								}
								if($i==9)
								{
									$total_septiembre = $total_septiembre + $value;
								}
								if($i==10)
								{
									$total_octubre = $total_octubre + $value;
								}
								if($i==11)
								{
									$total_noviembre = $total_noviembre + $value;
								}
								if($i==12)
								{
									$total_diciembre = $total_diciembre + $value;
								}
								$total_producto = $total_producto + $value;
								setlocale(LC_MONETARY, 'en_US');
								$valor = money_format('%.2n', $value);
								if($valor != '$0.00')
								{
									$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='right'>".$valor."</td>";
								}
								else
								{
									$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='center'>-</td>";
								}
							}
							$bandera++;
							$i++;
						}
						$totales = $totales + $total_producto;
						setlocale(LC_MONETARY, 'en_US');
						$total_producto = money_format('%.2n', $total_producto);
						$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto."</b></td>";
						$resultado_matriz.="</tr>";
					}
					setlocale(LC_MONETARY, 'en_US');
					$total_enero = money_format('%.2n', $total_enero);
					$total_febrero = money_format('%.2n', $total_febrero);
					$total_marzo = money_format('%.2n', $total_marzo);
					$total_abril = money_format('%.2n', $total_abril);
					$total_mayo = money_format('%.2n', $total_mayo);
					$total_junio = money_format('%.2n', $total_junio);
					$total_julio = money_format('%.2n', $total_julio);
					$total_agosto = money_format('%.2n', $total_agosto);
					$total_septiembre = money_format('%.2n', $total_septiembre);
					$total_octubre = money_format('%.2n', $total_octubre);
					$total_noviembre = money_format('%.2n', $total_noviembre);
					$total_diciembre = money_format('%.2n', $total_diciembre);
					$totales = money_format('%.2n', $totales);
					$resultado_matriz.="<tr>
											<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Total</td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_enero."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_febrero."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_marzo."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_abril."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_mayo."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_junio."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_julio."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_agosto."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_septiembre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_octubre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_noviembre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_diciembre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$totales."</b></td>
										</tr>";
					$resultado_matriz.=" </table>";
					echo $resultado_matriz;
				}
				if($nombre_reporte == 'Presupuesto mensual por relacionador')
				{
					$total_enero = 0;
					$total_febrero = 0;
					$total_marzo = 0;
					$total_abril = 0;
					$total_mayo = 0;
					$total_junio = 0;
					$total_julio = 0;
					$total_agosto = 0;
					$total_septiembre = 0;
					$total_octubre = 0;
					$total_noviembre = 0;
					$total_diciembre = 0;
					$totales = 0;
					$cabecera = $this->_tpl_vars['SQL_HEADER_MATRICE'];
					$detalle = $this->_tpl_vars['SQL_RESULT_MATRICE'];
					$resultado_matriz.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='scrollTable'>
											<tr>";
					foreach($cabecera as $row)
					{
						if($row == '1')
						{
							$row = 'Enero';
						}
						if($row == '2')
						{
							$row = 'Febrero';
						}
						if($row == '3')
						{
							$row = 'Marzo';
						}
						if($row == '4')
						{
							$row = 'Abril';
						}
						if($row == '5')
						{
							$row = 'Mayo';
						}
						if($row == '6')
						{
							$row = 'Junio';
						}
						if($row == '7')
						{
							$row = 'Julio';
						}
						if($row == '8')
						{
							$row = 'Agosto';
						}
						if($row == '9')
						{
							$row = 'Septiembre';
						}
						if($row == '10')
						{
							$row = 'Octubre';
						}
						if($row == '11')
						{
							$row = 'Noviembre';
						}
						if($row == '12')
						{
							$row = 'Diciembre';
						}
						$resultado_matriz.="<th id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row."</th>";
						$i++;
					}
					$resultado_matriz.="<th id='13' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Total</th>";
					$resultado_matriz.="</tr>";
					foreach($detalle as $colum)
					{
						$i=0;
						$total_producto = 0;
						$bandera='0';
						$resultado_matriz.="<tr>";
						foreach($colum as $value)
						{
							if($bandera=='0')
							{
								$resultado_matriz.="<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'>".$value."</td>";
							}
							else
							{
								$value = floatval($value);
								if($i==1)
								{
									$total_enero = $total_enero + $value;
								}
								if($i==2)
								{
									$total_febrero = $total_febrero + $value;
								}
								if($i==3)
								{
									$total_marzo = $total_marzo + $value;
								}
								if($i==4)
								{
									$total_abril = $total_abril + $value;
								}
								if($i==5)
								{
									$total_mayo = $total_mayo + $value;
								}
								if($i==6)
								{
									$total_junio = $total_junio + $value;
								}
								if($i==7)
								{
									$total_julio = $total_julio + $value;
								}
								if($i==8)
								{
									$total_agosto = $total_agosto + $value;
								}
								if($i==9)
								{
									$total_septiembre = $total_septiembre + $value;
								}
								if($i==10)
								{
									$total_octubre = $total_octubre + $value;
								}
								if($i==11)
								{
									$total_noviembre = $total_noviembre + $value;
								}
								if($i==12)
								{
									$total_diciembre = $total_diciembre + $value;
								}
								$total_producto = $total_producto + $value;
								setlocale(LC_MONETARY, 'en_US');
								$valor = money_format('%.2n', $value);
								if($valor != '$0.00')
								{
									$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='right'>".$valor."</td>";
								}
								else
								{
									$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='center'>-</td>";
								}
							}
							$bandera++;
							$i++;
						}
						$totales = $totales + $total_producto;
						setlocale(LC_MONETARY, 'en_US');
						$total_producto = money_format('%.2n', $total_producto);
						$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto."</b></td>";
						$resultado_matriz.="</tr>";
					}
					setlocale(LC_MONETARY, 'en_US');
					$total_enero = money_format('%.2n', $total_enero);
					$total_febrero = money_format('%.2n', $total_febrero);
					$total_marzo = money_format('%.2n', $total_marzo);
					$total_abril = money_format('%.2n', $total_abril);
					$total_mayo = money_format('%.2n', $total_mayo);
					$total_junio = money_format('%.2n', $total_junio);
					$total_julio = money_format('%.2n', $total_julio);
					$total_agosto = money_format('%.2n', $total_agosto);
					$total_septiembre = money_format('%.2n', $total_septiembre);
					$total_octubre = money_format('%.2n', $total_octubre);
					$total_noviembre = money_format('%.2n', $total_noviembre);
					$total_diciembre = money_format('%.2n', $total_diciembre);
					$totales = money_format('%.2n', $totales);
					$resultado_matriz.="<tr>
											<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Total</td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_enero."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_febrero."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_marzo."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_abril."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_mayo."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_junio."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_julio."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_agosto."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_septiembre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_octubre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_noviembre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_diciembre."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$totales."</b></td>
										</tr>";
					$resultado_matriz.=" </table>";
					echo $resultado_matriz;
				}
				if($nombre_reporte == 'Presupuesto por relacionador por producto')
				{
					$total_producto1 = 0;
					$total_producto2 = 0;
					$total_producto3 = 0;
					$total_producto4 = 0;
					$total_producto5 = 0;
					$total_producto6 = 0;
					$total_producto7 = 0;
					$total_producto8 = 0;
					$total_producto9 = 0;
					$total_producto10 = 0;
					$total_producto11 = 0;
					$total_producto12 = 0;
					$total_producto13 = 0;
					$total_producto14 = 0;
					$totales = 0;
					$cabecera = $this->_tpl_vars['SQL_HEADER_MATRICE'];
					$detalle = $this->_tpl_vars['SQL_RESULT_MATRICE'];
					$resultado_matriz.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='scrollTable'>
											<tr>";
					foreach($cabecera as $row)
					{
						$resultado_matriz.="<th id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row."</th>";
						$i++;
					}
					$resultado_matriz.="<th id='13' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Total</th>";
					$resultado_matriz.="</tr>";
					foreach($detalle as $colum)
					{
						$i=0;
						$total_producto = 0;
						$bandera='0';
						$resultado_matriz.="<tr>";
						foreach($colum as $value)
						{
							if($bandera=='0')
							{
								$resultado_matriz.="<td style='border:1px solid; border-color:#D8D8D8; color:#888888; background-color:#F0F0F0;'>".$value."</td>";
							}
							else
							{
								$value = floatval($value);
								if($i==1)
								{
									$total_producto1 = $total_producto1 + $value;
								}
								if($i==2)
								{
									$total_producto2 = $total_producto2 + $value;
								}
								if($i==3)
								{
									$total_producto3 = $total_producto3 + $value;
								}
								if($i==4)
								{
									$total_producto4 = $total_producto4 + $value;
								}
								if($i==5)
								{
									$total_producto5 = $total_producto5 + $value;
								}
								if($i==6)
								{
									$total_producto6 = $total_producto6 + $value;
								}
								if($i==7)
								{
									$total_producto7 = $total_producto7 + $value;
								}
								if($i==8)
								{
									$total_producto8 = $total_producto8 + $value;
								}
								if($i==9)
								{
									$total_producto9 = $total_producto9 + $value;
								}
								if($i==10)
								{
									$total_producto10 = $total_producto10 + $value;
								}
								if($i==11)
								{
									$total_producto11 = $total_producto11 + $value;
								}
								if($i==12)
								{
									$total_producto12 = $total_producto12 + $value;
								}
								if($i==13)
								{
									$total_producto13 = $total_producto13 + $value;
								}
								if($i==14)
								{
									$total_producto14 = $total_producto14 + $value;
								}
								$total_producto = $total_producto + $value;
								setlocale(LC_MONETARY, 'en_US');
								$valor = money_format('%.2n', $value);
								if($valor != '$0.00')
								{
									$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='right'>".$valor."</td>";
								}
								else
								{
									$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='center'>-</td>";
								}
							}
							$bandera++;
							$i++;
						}
						$totales = $totales + $total_producto;
						setlocale(LC_MONETARY, 'en_US');
						$total_producto = money_format('%.2n', $total_producto);
						$resultado_matriz.="<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto."</b></td>";
						$resultado_matriz.="</tr>";
					}
					setlocale(LC_MONETARY, 'en_US');
					$total_producto1 = money_format('%.2n', $total_producto1);
					$total_producto2 = money_format('%.2n', $total_producto2);
					$total_producto3 = money_format('%.2n', $total_producto3);
					$total_producto4 = money_format('%.2n', $total_producto4);
					$total_producto5 = money_format('%.2n', $total_producto5);
					$total_producto6 = money_format('%.2n', $total_producto6);
					$total_producto7 = money_format('%.2n', $total_producto7);
					$total_producto8 = money_format('%.2n', $total_producto8);
					$total_producto9 = money_format('%.2n', $total_producto9);
					$total_producto10 = money_format('%.2n', $total_producto10);
					$total_producto11 = money_format('%.2n', $total_producto11);
					$total_producto12 = money_format('%.2n', $total_producto12);
					$total_producto13 = money_format('%.2n', $total_producto13);
					$total_producto14 = money_format('%.2n', $total_producto14);
					$totales = money_format('%.2n', $totales);
					$resultado_matriz.="<tr>
											<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Total</td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto1."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto2."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto3."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto4."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto5."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto6."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto7."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto8."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto9."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto10."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto11."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto12."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto13."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_producto14."</b></td>
											<td style='border:1px solid; border-color: #eee;' align='right'><b>".$totales."</b></td>
										</tr>";
					$resultado_matriz.=" </table>";
					echo $resultado_matriz;
				}
				if($nombre_reporte == 'Presupuesto por producto por relacionador por mes')
				{}
			}
		{/php}
	{else}
		{sugar_translate label='LBL_MATRICE_ERROR' module='{{$module}}'}
	{/if}
{/if}
{php}
	$nombre_reporte = $GLOBALS['FOCUS']->name;
	$tipo = $GLOBALS['FOCUS']->tipo_visualizacion_c;
	$cumplimiento = $GLOBALS['FOCUS']->tipo_cumplimiento_c;
	$semanal_mensual = $GLOBALS['FOCUS']->semanal_mensual_c;
	$anio = $GLOBALS['FOCUS']->periodo_c;
	$cadena = explode("FROM", $this->_tpl_vars['DESC']);
	$tabla = trim($cadena[1]);
	$cadena2 = explode(" ",$tabla);
	$nombre_tabla = trim($cadena2[0]);
	$productos_graf = array();
	$productos_graf_pre = array();
	$productos_graf_ven = array();
	$relacionadores_graf = array();
	$relacionadores_graf_pre = array();
	$relacionadores_graf_ven = array();
	$mes_graf = array();
	$mes_graf_pre = array();
	$mes_graf_ven = array();
	$mes_drill = array();
	$relacioandor_drill = array();
	$producto_drill = array();
	$result="";
	if($nombre_tabla == 'm1_oportunidad_productos_cstm')
	{
		if($nombre_reporte != 'Pipeline de ventas')
		{
			{/php}
				<h4 class='dataLabel'>{sugar_translate label='LBL_RESULTAT' module='{{$module}}'}</h4><br>
			{php}
			$contador=0;
			$i=0;
			$j=0;
			$presu=0;
			$venta=0;
			$porce=0;
			$multi=0;
			$ventas = 0;
			$presupuesto = 0;
			$mes='';
			require_once("custom/modules/SYNO_Reports/libchart/libchart/classes/libchart.php");
			$cabecera_grafico = $this->_tpl_vars['SQL_HEADER'];
			$detalle_grafico = $this->_tpl_vars['SQL_RESULT'];
			$serie1 = new XYDataSet();
			$serie2 = new XYDataSet();
			$rels = array();
			$mess = array();
			$registrosB = array();
			$registrosM = array();
			foreach($detalle_grafico as $row_grafico)
			{
				if($nombre_reporte == 'Cumplimiento por producto')
				{
					if($detalle_grafico[$i]['Producto'] == $detalle_grafico[$i+1]['Producto'])
					{
						$continua=1;
						$rel = $detalle_grafico[$i]['Relacionador'];
						$pro = $detalle_grafico[$i]['Producto'];
						$mes = $detalle_grafico[$i]['Mes'];
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$continua = 2;
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$registrosM[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							foreach($rels as $row)
							{
								foreach($mess as $colum)
								{
									if($registrosB[$row][$colum] == $registrosM[$rel][$mes])
									{
										$continua = 0;
									}
								}
							}
						}
						if($continua == 1)
						{
							$ventas = $ventas + $row_grafico['Ventas'];
							$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
						}
					}
					else
					{
						$continua=1;
						$rel = $detalle_grafico[$i]['Relacionador'];
						$pro = $detalle_grafico[$i]['Producto'];
						$mes = $detalle_grafico[$i]['Mes'];
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$continua = 2;
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Producto']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$registrosM[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							foreach($rels as $row)
							{
								foreach($mess as $colum)
								{
									if($registrosB[$row][$colum] == $registrosM[$rel][$mes])
									{
										$continua = 0;
									}
								}
							}
						}
						if($continua == 1)
						{
							$dibuja = 1;
							$ventas = $ventas + $row_grafico['Ventas'];
							$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
							
							foreach($productos_graf as $key => $value)
							{
								if($productos_graf[$key] == $row_grafico['Producto'])
								{
									$dibuja = 0;
									$productos_graf_pre[$key] = $productos_graf_pre[$key] + $presupuesto;
									$productos_graf_ven[$key] = $productos_graf_ven[$key] + $ventas;
								}
							}
							if($dibuja == 1)
							{
								$productos_graf[$row_grafico['Producto']] = $row_grafico['Producto'];
								$productos_graf_pre[$row_grafico['Producto']] = $productos_graf_pre[$row_grafico['Producto']] + $presupuesto;
								$productos_graf_ven[$row_grafico['Producto']] = $productos_graf_ven[$row_grafico['Producto']] + $ventas;
							}
						}
						if($continua == 0)
						{
							$dibuja = 1;
							$ventas = $ventas + $row_grafico['Ventas'];
							//$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
							
							foreach($productos_graf as $key => $value)
							{
								if($productos_graf[$key] == $row_grafico['Producto'])
								{
									$dibuja = 0;
									$productos_graf_pre[$key] = $productos_graf_pre[$key] + $presupuesto;
									$productos_graf_ven[$key] = $productos_graf_ven[$key] + $ventas;
								}
							}
							if($dibuja == 1)
							{
								$productos_graf[$row_grafico['Producto']] = $row_grafico['Producto'];
								$productos_graf_pre[$row_grafico['Producto']] = $productos_graf_pre[$row_grafico['Producto']] + $presupuesto;
								$productos_graf_ven[$row_grafico['Producto']] = $productos_graf_ven[$row_grafico['Producto']] + $ventas;
							}
						}
						$ventas = 0;
						$presupuesto = 0;
					}
					$i++;
				}
				else if($nombre_reporte == 'Cumplimiento por relacionador')
				{
					if($detalle_grafico[$i]['Relacionador'] == $detalle_grafico[$i+1]['Relacionador'])
					{
						$continua=1;
						$rel = $detalle_grafico[$i]['Relacionador'];
						$pro = $detalle_grafico[$i]['Producto'];
						$mes = $detalle_grafico[$i]['Mes'];
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$continua = 2;
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$registrosM[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							foreach($rels as $row)
							{
								foreach($mess as $colum)
								{
									if($registrosB[$row][$colum] == $registrosM[$rel][$mes])
									{
										$continua = 0;
									}
								}
							}
						}
						if($continua == 1)
						{
							$ventas = $ventas + $row_grafico['Ventas'];
							$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
						}
					}
					else
					{
						$continua=1;
						$rel = $detalle_grafico[$i]['Relacionador'];
						$pro = $detalle_grafico[$i]['Producto'];
						$mes = $detalle_grafico[$i]['Mes'];
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$continua = 2;
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$rels[$i] = $rel;
							$mess[$i] = $mes;
							$registrosB[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							$mes_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Mes'];
							$relacionador_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Relacionador'];
							$producto_drill[$detalle_grafico[$i]['Relacionador']][$i] = $detalle_grafico[$i]['Producto'];
						}
						if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
						{
							$registrosM[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							foreach($rels as $row)
							{
								foreach($mess as $colum)
								{
									if($registrosB[$row][$colum] == $registrosM[$rel][$mes])
									{
										$continua = 0;
									}
								}
							}
						}
						if($continua == 1)
						{
							$dibuja = 1;
							$ventas = $ventas + $row_grafico['Ventas'];
							$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
							
							foreach($relacionadores_graf as $key => $value)
							{
								if($relacionadores_graf[$key] == $row_grafico['Relacionador'])
								{
									$dibuja = 0;
									$relacionadores_graf_pre[$key] = $relacionadores_graf_pre[$key] + $presupuesto;
									$relacionadores_graf_ven[$key] = $relacionadores_graf_ven[$key] + $ventas;
								}
							}
							if($dibuja == 1)
							{
								$relacionadores_graf[$row_grafico['Relacionador']] = $row_grafico['Relacionador'];
								$relacionadores_graf_pre[$row_grafico['Relacionador']] = $relacionadores_graf_pre[$row_grafico['Relacionador']] + $presupuesto;
								$relacionadores_graf_ven[$row_grafico['Relacionador']] = $relacionadores_graf_ven[$row_grafico['Relacionador']] + $ventas;
							}
						}
						if($continua == 0)
						{
							$dibuja = 1;
							$ventas = $ventas + $row_grafico['Ventas'];
							//$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
							
							foreach($relacionadores_graf as $key => $value)
							{
								if($relacionadores_graf[$key] == $row_grafico['Relacionador'])
								{
									$dibuja = 0;
									$relacionadores_graf_pre[$key] = $relacionadores_graf_pre[$key] + $presupuesto;
									$relacionadores_graf_ven[$key] = $relacionadores_graf_ven[$key] + $ventas;
								}
							}
							if($dibuja == 1)
							{
								$relacionadores_graf[$row_grafico['Relacionador']] = $row_grafico['Relacionador'];
								$relacionadores_graf_pre[$row_grafico['Relacionador']] = $relacionadores_graf_pre[$row_grafico['Relacionador']] + $presupuesto;
								$relacionadores_graf_ven[$row_grafico['Relacionador']] = $relacionadores_graf_ven[$row_grafico['Relacionador']] + $ventas;
							}
						}
						$ventas = 0;
						$presupuesto = 0;
					}
					$i++;
				}
				else if($nombre_reporte == 'Cumplimiento por mes')
				{
					if($tipo == 'Individual')
					{
						if($detalle_grafico[$i]['Mes'] == $detalle_grafico[$i+1]['Mes'])
						{
							$continua=1;
							$rel = $detalle_grafico[$i]['Relacionador'];
							$pro = $detalle_grafico[$i]['Producto'];
							$mesr = $detalle_grafico[$i]['Mes'];
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$continua = 2;
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$registrosM[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								foreach($rels as $row)
								{
									foreach($mess as $colum)
									{
										if($registrosB[$row][$colum] == $registrosM[$rel][$mesr])
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$ventas = $ventas + $row_grafico['Ventas'];
								$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
							}
						}
						else
						{
							$continua=1;
							$rel = $detalle_grafico[$i]['Relacionador'];
							$pro = $detalle_grafico[$i]['Producto'];
							$mesr = $detalle_grafico[$i]['Mes'];
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$continua = 2;
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$registrosM[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								foreach($rels as $row)
								{
									foreach($mess as $colum)
									{
										if($registrosB[$row][$colum] == $registrosM[$rel][$mesr])
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$dibuja = 1;
								$ventas = $ventas + $row_grafico['Ventas'];
								$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
								foreach($mes_graf as $key => $value)
								{
									if($mes_graf[$key] == $row_grafico['Mes'])
									{
										$dibuja = 0;
										$mes_graf_pre[$key] = $mes_graf_pre[$key] + $presupuesto;
										$mes_graf_ven[$key] = $mes_graf_ven[$key] + $ventas;
									}
								}
								if($dibuja == 1)
								{
									$mes_graf[$row_grafico['Mes']] = $row_grafico['Mes'];
									$mes_graf_pre[$row_grafico['Mes']] = $mes_graf_pre[$row_grafico['Mes']] + $presupuesto;
									$mes_graf_ven[$row_grafico['Mes']] = $mes_graf_ven[$row_grafico['Mes']] + $ventas;
								}
							}
							if($continua == 0)
							{
								$dibuja = 1;
								$ventas = $ventas + $row_grafico['Ventas'];
								//$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
								foreach($mes_graf as $key => $value)
								{
									if($mes_graf[$key] == $row_grafico['Mes'])
									{
										$dibuja = 0;
										$mes_graf_pre[$key] = $mes_graf_pre[$key] + $presupuesto;
										$mes_graf_ven[$key] = $mes_graf_ven[$key] + $ventas;
									}
								}
								if($dibuja == 1)
								{
									$mes_graf[$row_grafico['Mes']] = $row_grafico['Mes'];
									$mes_graf_pre[$row_grafico['Mes']] = $mes_graf_pre[$row_grafico['Mes']] + $presupuesto;
									$mes_graf_ven[$row_grafico['Mes']] = $mes_graf_ven[$row_grafico['Mes']] + $ventas;
								}
							}
							$ventas = 0;
							$presupuesto = 0;
						}
						$i++;
					}
					else
					{
						if($detalle_grafico[$i]['Mes'] == $detalle_grafico[$i+1]['Mes'])
						{
							$continua=1;
							$rel = $detalle_grafico[$i]['Relacionador'];
							$pro = $detalle_grafico[$i]['Producto'];
							$mesr = $detalle_grafico[$i]['Mes'];
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$continua = 2;
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$registrosM[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								foreach($rels as $row)
								{
									foreach($mess as $colum)
									{
										if($registrosB[$row][$colum] == $registrosM[$rel][$mesr])
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$ventas = $ventas + $row_grafico['Ventas'];
								$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
							}
						}
						else
						{
							$continua=1;
							$rel = $detalle_grafico[$i]['Relacionador'];
							$pro = $detalle_grafico[$i]['Producto'];
							$mesr = $detalle_grafico[$i]['Mes'];
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$continua = 2;
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] == '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] != '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$rels[$i] = $rel;
								$mess[$i] = $mesr;
								$registrosB[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								$mes_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Mes'];
								$relacionador_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Relacionador'];
								$producto_drill[$detalle_grafico[$i]['Mes']][$i] = $detalle_grafico[$i]['Producto'];
							}
							if($detalle_grafico[$i]['Ventas'] == '0.000000' && $detalle_grafico[$i]['Presupuesto'] != '0.000000')
							{
								$registrosM[$rel][$mesr] = $rel.'_'.$mesr.'_'.$pro;
								foreach($rels as $row)
								{
									foreach($mess as $colum)
									{
										if($registrosB[$row][$colum] == $registrosM[$rel][$mesr])
										{
											$continua = 0;
										}
									}
								}
							}
							
							if($continua == 1)
							{
								$dibuja = 1;
								$ventas = $ventas + $row_grafico['Ventas'];
								$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
								foreach($mes_graf as $key => $value)
								{
									if($mes_graf[$key] == $row_grafico['Mes'])
									{
										$dibuja = 0;
										$mes_graf_pre[$key] = $mes_graf_pre[$key] + $presupuesto;
										$mes_graf_ven[$key] = $mes_graf_ven[$key] + $ventas;
									}
								}
								if($dibuja == 1)
								{
									$mes_graf[$row_grafico['Mes']] = $row_grafico['Mes'];
									$mes_graf_pre[$row_grafico['Mes']] = $mes_graf_pre[$row_grafico['Mes']] + $presupuesto;
									$mes_graf_ven[$row_grafico['Mes']] = $mes_graf_ven[$row_grafico['Mes']] + $ventas;
								}
							}
							if($continua == 0)
							{
								$dibuja = 1;
								$ventas = $ventas + $row_grafico['Ventas'];
								//$presupuesto = $presupuesto + $row_grafico['Presupuesto'];
								foreach($mes_graf as $key => $value)
								{
									if($mes_graf[$key] == $row_grafico['Mes'])
									{
										$dibuja = 0;
										$mes_graf_pre[$key] = $mes_graf_pre[$key] + $presupuesto;
										$mes_graf_ven[$key] = $mes_graf_ven[$key] + $ventas;
									}
								}
								if($dibuja == 1)
								{
									$mes_graf[$row_grafico['Mes']] = $row_grafico['Mes'];
									$mes_graf_pre[$row_grafico['Mes']] = $mes_graf_pre[$row_grafico['Mes']] + $presupuesto;
									$mes_graf_ven[$row_grafico['Mes']] = $mes_graf_ven[$row_grafico['Mes']] + $ventas;
								}
							}
						}	
						$i++;
					}
				}
				else
				{}
			}

			if($nombre_reporte == 'Cumplimiento por producto')
			{
				asort($productos_graf_ven);
				foreach($productos_graf_ven as $key => $value)
				{
					if($productos_graf[$key] != '' && $productos_graf[$key] != null)
					{
						$serie1->addPoint(new Point($productos_graf[$key], $productos_graf_pre[$key]));
						$serie2->addPoint(new Point($productos_graf[$key], $productos_graf_ven[$key]));
					}
				}
			}
			if($nombre_reporte == 'Cumplimiento por relacionador')
			{
				asort($relacionadores_graf_ven);
				foreach($relacionadores_graf_ven as $key => $value)
				{
					if($relacionadores_graf[$key] != '' && $relacionadores_graf[$key] != null)
					{
						$serie1->addPoint(new Point($relacionadores_graf[$key], $relacionadores_graf_pre[$key]));
						$serie2->addPoint(new Point($relacionadores_graf[$key], $relacionadores_graf_ven[$key]));
					}
				}
			}
			if($nombre_reporte == 'Cumplimiento por mes')
			{
				krsort($mes_graf);
				$mes="";
				foreach($mes_graf as $key => $value)
				{
					if($key == '1')
					{
						$mes = 'Enero';
					}
					if($key == '2')
					{
						$mes = 'Febrero';
					}
					if($key == '3')
					{
						$mes = 'Marzo';
					}
					if($key == '4')
					{
						$mes = 'Abril';
					}
					if($key == '5')
					{
						$mes = 'Mayo';
					}
					if($key == '6')
					{
						$mes = 'Junio';
					}
					if($key == '7')
					{
						$mes = 'Julio';
					}
					if($key == '8')
					{
						$mes = 'Agosto';
					}
					if($key == '9')
					{
						$mes = 'Septiembre';
					}
					if($key == '10')
					{
						$mes = 'Octubre';
					}
					if($key == '11')
					{
						$mes = 'Noviembre';
					}
					if($key == '12')
					{
						$mes = 'Diciembre';
					}
					$serie1->addPoint(new Point($mes, $mes_graf_pre[$key]));
					$serie2->addPoint(new Point($mes, $mes_graf_ven[$key]));
				}
			}
			$chart="";
			
			if(count($productos_graf) == 1 || count($relacionadores_graf) == 1 || count($mes_graf) == 1)
			{
				$chart = new HorizontalBarChart(1500,200);
			}
			if(count($productos_graf) == 2 || count($relacionadores_graf) == 2 || count($mes_graf) == 2)
			{
				$chart = new HorizontalBarChart(1500,300);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6em;
							}
						</style>";
			}
			if(count($productos_graf) == 3 || count($relacionadores_graf) == 3 || count($mes_graf) == 3)
			{
				$chart = new HorizontalBarChart(1500,400);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6.5em;
							}
						</style>";
			}
			if(count($productos_graf) == 4 || count($relacionadores_graf) == 4 || count($mes_graf) == 4)
			{
				$chart = new HorizontalBarChart(1500,500);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6em;
							}
						</style>";
			}
			if(count($productos_graf) == 5 || count($relacionadores_graf) == 5 || count($mes_graf) == 5)
			{
				$chart = new HorizontalBarChart(1500,600);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6em;
							}
						</style>";
			}
			if(count($productos_graf) == 6 || count($relacionadores_graf) == 6 || count($mes_graf) == 6)
			{
				$chart = new HorizontalBarChart(1500,700);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6em;
							}
						</style>";
			}
			if(count($productos_graf) == 7 || count($relacionadores_graf) == 7 || count($mes_graf) == 7)
			{
				$chart = new HorizontalBarChart(1500,800);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6em;
							}
						</style>";
			}
			if(count($productos_graf) == 8 || count($relacionadores_graf) == 8 || count($mes_graf) == 8)
			{
				$chart = new HorizontalBarChart(1500,900);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6em;
							}
						</style>";
			}
			if(count($productos_graf) == 9 || count($relacionadores_graf) == 9 || count($mes_graf) == 9)
			{
				$chart = new HorizontalBarChart(1500,1000);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 6em;
							}
						</style>";
			}
			if(count($productos_graf) == 10 || count($relacionadores_graf) == 10 || count($mes_graf) == 10)
			{
				$chart = new HorizontalBarChart(1500,1000);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5em;
							}
						</style>";
			}
			if(count($productos_graf) == 11 || count($relacionadores_graf) == 11 || count($mes_graf) == 11)
			{
				$chart = new HorizontalBarChart(1500,1100);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5em;
							}
						</style>";
			}
			if(count($productos_graf) == 12 || count($relacionadores_graf) == 12 || count($mes_graf) == 12)
			{
				$chart = new HorizontalBarChart(1500,1200);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.1em;
							}
						</style>";
			}
			if(count($productos_graf) == 13 || count($relacionadores_graf) == 13 || count($mes_graf) == 13)
			{
				$chart = new HorizontalBarChart(1500,1300);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.2em;
							}
						</style>";
			}
			if(count($productos_graf) == 14 || count($relacionadores_graf) == 14 || count($mes_graf) == 14)
			{
				$chart = new HorizontalBarChart(1500,1400);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.3em;
							}
						</style>";
			}
			if(count($productos_graf) == 15 || count($relacionadores_graf) == 15 || count($mes_graf) == 15)
			{
				$chart = new HorizontalBarChart(1500,1500);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.3em;
							}
						</style>";
			}
			if(count($productos_graf) == 16 || count($relacionadores_graf) == 16 || count($mes_graf) == 16)
			{
				$chart = new HorizontalBarChart(1500,1600);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.35em;
							}
						</style>";
			}
			if(count($productos_graf) == 17 || count($relacionadores_graf) == 17 || count($mes_graf) == 17)
			{
				$chart = new HorizontalBarChart(1500,1700);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.35em;
							}
						</style>";
			}
			if(count($productos_graf) == 18 || count($relacionadores_graf) == 18 || count($mes_graf) == 18)
			{
				$chart = new HorizontalBarChart(1500,1800);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.4em;
							}
						</style>";
			}
			if(count($productos_graf) == 19 || count($relacionadores_graf) == 19 || count($mes_graf) == 19)
			{
				$chart = new HorizontalBarChart(1500,1900);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.4em;
							}
						</style>";
			}
			if(count($productos_graf) == 20 || count($relacionadores_graf) == 20 || count($mes_graf) == 20)
			{
				$chart = new HorizontalBarChart(1500,2000);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.4em;
							}
						</style>";
			}
			if(count($productos_graf) == 21 || count($relacionadores_graf) == 21 || count($mes_graf) == 21)
			{
				$chart = new HorizontalBarChart(1500,2000);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.05em;
							}
						</style>";
			}
			if(count($productos_graf) == 22 || count($relacionadores_graf) == 22 || count($mes_graf) == 22)
			{
				$chart = new HorizontalBarChart(1500,2100);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 5.05em;
							}
						</style>";
			}
			if(count($productos_graf) == 23 || count($relacionadores_graf) == 23 || count($mes_graf) == 23)
			{
				$chart = new HorizontalBarChart(1500,2100);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 4.8em;
							}
						</style>";
			}
			if(count($productos_graf) == 24 || count($relacionadores_graf) == 24 || count($mes_graf) == 24)
			{
				$chart = new HorizontalBarChart(1500,2200);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 4.8em;
							}
						</style>";
			}
			if(count($productos_graf) == 25 || count($relacionadores_graf) == 25 || count($mes_graf) == 25)
			{
				$chart = new HorizontalBarChart(1500,2300);
				$result.="<style>
							tr.spaceUnder > td
							{
							  padding-bottom: 4.8em;
							}
						</style>";
			}
			
			$result.="<div id='contenedor'>
				<div id='tabla_links' style='float:left; position:absolute; margin-top:2em;'><table>";
			if($nombre_reporte == 'Cumplimiento por producto')
			{
				arsort($productos_graf_ven);
				foreach($productos_graf_ven as $key => $value)
				{
					$parametros="";
					$parametros.= $anio."/producto/".$key."/";
					if(count($mes_drill[$key]) > 0 && count($relacionador_drill[$key]) > 0)
					{
						foreach($mes_drill[$key] as $key2 => $value2)
						{
							if($value2 != '' && $value2 != null)
							{
								$parametros.= $value2."-";
							}
						}
						$parametros = substr($parametros, 0, -1);
						$parametros.= "/";
						foreach($relacionador_drill[$key] as $key2 => $value2)
						{
							if($value2 != '' && $value2 != null)
							{
								$parametros.= $value2."-";
							}
						}
						$parametros = substr($parametros, 0, -1);
					}
					$result.="<tr class='spaceUnder'><td onclick='envia(\"$parametros\");' ><img src='custom/modules/SYNO_Reports/lupa.jpg' style='border: 1px solid gray; cursor: pointer;' width='25' height='25'></td></tr>";
				}
			}
			if($nombre_reporte == 'Cumplimiento por relacionador')
			{
				arsort($relacionadores_graf_ven);
				foreach($relacionadores_graf_ven as $key => $value)
				{
					$parametros="";
					$parametros.= $anio."/relacionador/".$key."/";
					if(count($producto_drill[$key]) > 0 && count($mes_drill[$key]) > 0)
					{
						foreach($producto_drill[$key] as $key2 => $value2)
						{
							if($value2 != '' && $value2 != null)
							{
								$parametros.= $value2."-";
							}
						}
						$parametros = substr($parametros, 0, -1);
						$parametros.= "/";
						foreach($mes_drill[$key] as $key2 => $value2)
						{
							if($value2 != '' && $value2 != null)
							{
								$parametros.= $value2."-";
							}
						}
						$parametros = substr($parametros, 0, -1);
					}
					$result.="<tr class='spaceUnder'><td onclick='envia(\"$parametros\");'><img src='custom/modules/SYNO_Reports/lupa.jpg' style='border: 1px solid gray; cursor: pointer;'  width='25' height='25'></td></tr>";
				}
			}
			if($nombre_reporte == 'Cumplimiento por mes')
			{
				ksort($mes_graf);
				if($tipo == 'Individual')
				{
					foreach($mes_graf as $key => $value)
					{
						$parametros="";
						$parametros.= $anio."/mes/".$key."/";
						if(count($relacionador_drill[$key]) > 0 && count($producto_drill[$key]) > 0)
						{
							foreach($relacionador_drill[$key] as $key2 => $value2)
							{
								if($value2 != '' && $value2 != null)
								{
									$parametros.= $value2."-";
								}
							}
							$parametros = substr($parametros, 0, -1);
							$parametros.= "/";
							foreach($producto_drill[$key] as $key2 => $value2)
							{
								if($value2 != '' && $value2 != null)
								{
									$parametros.= $value2."-";
								}
							}
							$parametros = substr($parametros, 0, -1);
						}
						$result.="<tr class='spaceUnder'><td onclick='envia(\"$parametros\");'><img src='custom/modules/SYNO_Reports/lupa.jpg' style='border: 1px solid gray; cursor: pointer;' width='25' height='25'></td></tr>";
					}
				}
				else
				{
					$parametros="";
					$relas = "";
					$prods = "";
					$months ="";
					foreach($mes_graf as $key => $value)
					{
						$parametros = "";
						$months.= $key."-";
						$parametros.= $anio."/mes/".$months;
						$parametros = substr($parametros, 0, -1);
						$parametros.= "/";
						foreach($relacionador_drill[$key] as $key2 => $value2)
						{
							if($value2 != '' && $value2 != null)
							{
								$relas.= $value2."-";
							}
						}
						//$relas = substr($relas, 0, -1);
						$parametros.= $relas;
						$parametros.= "/";
						foreach($producto_drill[$key] as $key2 => $value2)
						{
							if($value2 != '' && $value2 != null)
							{
								$prods.= $value2."-";
							}
						}
						//$prods = substr($prods, 0, -1);
						$parametros.= $prods;
						
						$result.="<tr class='spaceUnder'><td onclick='envia(\"$parametros\");'><img src='custom/modules/SYNO_Reports/lupa.jpg' style='border: 1px solid gray; cursor: pointer;' width='25' height='25'></td></tr>";
					}
				}
			}
			$result.="</table></div>";
						
			$dataSet = new XYSeriesDataSet();
			$dataSet->addSerie("Presupuesto", $serie1);
			$dataSet->addSerie("Venta", $serie2);
			$chart->setDataSet($dataSet);
			$chart->getPlot()->setGraphCaptionRatio(0.65);
			$chart->setTitle("PRESUPUESTO VS CUMPLIMIENTO");
			$chart->render("custom/modules/SYNO_Reports/libchart/demo/generated/demo7.png");
			$result.= "<div id='barras' style='margin-left:3em;'><img alt='Line chart' src='custom/modules/SYNO_Reports/libchart/demo/generated/demo7.png' style='border: 1px solid gray;'></div></div><div style='clear:both'></div>";
			echo $result;
			$cabecera = array();
			$detalle = array();
			$cabecera = $this->_tpl_vars['SQL_HEADER'];
			$detalle = $this->_tpl_vars['SQL_RESULT'];
			$resultado.="<div id='detalle' style='position: relative;'><table width='100%' border='0' cellspacing='0' cellpadding='0' class='edit view'>
					<tr>";
			foreach($cabecera as $row)
			{
				if($row != 'id_oportunidad')
				{
					$resultado.="<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>".$row."</td>";
				}
			}
			if($nombre_reporte == 'Cumplimiento por producto' || $nombre_reporte == 'Cumplimiento por relacionador')
			{
				$resultado.="<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Porcentaje</td>";
			}
			$resultado.="</tr>";
			if($nombre_reporte == 'Cumplimiento por producto' || $nombre_reporte == 'Cumplimiento por relacionador')
			{
				$relsd = array();
				$messd = array();
				$registrosBD = array();
				$registrosMD = array();
				$total_presupuestos = 0;
				$total_ventas = 0;
				$i=0;
				foreach($detalle as $colum)
				{
					$continua=1;
					$rel = $detalle[$i]['Relacionador'];
					$pro = $detalle[$i]['Producto'];
					$mes = $detalle[$i]['Mes'];
					if($detalle[$i]['Ventas'] != '0.000000' && $detalle[$i]['Presupuesto'] != '0.000000')
					{
						$relsd[$i] = $rel;
						$messd[$i] = $mes;
						$registrosBD[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
					}
					if($detalle[$i]['Ventas'] == '0.000000' && $detalle[$i]['Presupuesto'] != '0.000000')
					{
						$registrosMD[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
						foreach($relsd as $rows)
						{
							foreach($messd as $colums)
							{
								if($registrosBD[$rows][$colums] == $registrosMD[$rel][$mes])
								{
									$continua = 0;
								}		
							}
						}
					}
					if($detalle[$i]['Ventas'] == '0.000000' && $detalle[$i]['Presupuesto'] == '0.000000')
					{
						$continua = 0;
					}
					
					if($continua == 1)
					{
						$resultado.="<tr>";
						foreach($colum as $value)
						{
							if($contador == 4)
							{
								$venta = $value;
								setlocale(LC_MONETARY, 'en_US');
								$value = money_format('%.2n', $value);
								$total_ventas = $total_ventas + $venta;
							}
							if($contador == 5)
							{
								$presu = $value;
								setlocale(LC_MONETARY, 'en_US');
								$value = money_format('%.2n', $value);
								$total_presupuestos = $total_presupuestos + $presu;
							}
							if($contador == 2)
							{
								if($value == 1)
								{
									$value = "Enero";
								}
								else if($value == 2)
								{
									$value = "Febrero";
								}
								else if($value == 3)
								{
									$value = "Marzo";
								}
								else if($value == 4)
								{
									$value = "Abril";
								}
								else if($value == 5)
								{
									$value = "Mayo";
								}
								else if($value == 6)
								{
									$value = "Junio";
								}
								else if($value == 7)
								{
									$value = "Julio";
								}
								else if($value == 8)
								{
									$value = "Agosto";
								}
								else if($value == 9)
								{
									$value = "Septiembre";
								}
								else if($value == 10)
								{
									$value = "Octubre";
								}
								else if($value == 11)
								{
									$value = "Noviembre";
								}
								else if($value == 12)
								{
									$value = "Diciembre";
								}
							}
							if($contador != 6)
							{
								if($contador == 4 || $contador == 5)
								{
									$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'right'>".$value."</td>";
								}
								else
								{
									$resultado.="<td style='border:1px solid; border-color: #eee;'>".$value."</td>";
								}
							}
							$contador++;
						}
						$contador=0;
						if($presu != 0.000000)
						{
							$multi = $venta*100;
							$porce = $multi/$presu;
							$partes = explode(".",$porce);
							$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'center'>".$partes[0]."%"."</td>";
						}
						else
						{
							$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'center'>0%</td>";
						}
						$resultado.="</tr>";
					}
					$i++;
				}
				if($total_presupuestos != 0.000000)
				{
					$multi_tot = $total_ventas*100;
					$porce_tot = $multi_tot/$total_presupuestos;
					$total_porcentaje = explode(".",$porce_tot);
					setlocale(LC_MONETARY, 'en_US');
					$total_presupuestos = money_format('%.2n', $total_presupuestos);
					$total_ventas = money_format('%.2n', $total_ventas);
					$resultado.="<tr>
								 <td style='border:1px solid; border-color: #eee;'><b>TOTAL</b></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_ventas."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_presupuestos."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'center'><b>".$total_porcentaje[0]."%"."</b></td>
								 </tr>";
				}
				else
				{
					setlocale(LC_MONETARY, 'en_US');
					$total_presupuestos = money_format('%.2n', $total_presupuestos);
					$total_ventas = money_format('%.2n', $total_ventas);
					$resultado.="<tr>
								 <td style='border:1px solid; border-color: #eee;'><b>TOTAL</b></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_ventas."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_presupuestos."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'center'><b>0%</b></td>
								 </tr>";
				}
			}
			else if($nombre_reporte == 'Cumplimiento por mes')
			{
				$relsd = array();
				$messd = array();
				$registrosBD = array();
				$registrosMD = array();
				$total_presupuestos = 0;
				$total_ventas = 0;
				if($tipo == 'Individual')
				{
					$ventas2 = 0;
					$presupuesto2 = 0;
					for($j=0;$j<count($detalle);$j++)
					{
						$continua=1;
						$rel = $detalle[$j]['Relacionador'];
						$mes = $detalle[$j]['Mes'];
						$pro = $detalle[$j]['Producto'];
						if($detalle[$j]['Ventas'] != '0.000000' && $detalle[$j]['Presupuesto'] != '0.000000')
						{
							$relsd[$j] = $rel;
							$messd[$j] = $mes;
							$registrosBD[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
						}
						if($detalle[$j]['Ventas'] == '0.000000' && $detalle[$j]['Presupuesto'] != '0.000000')
						{
							$registrosMD[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							foreach($relsd as $rows)
							{
								foreach($messd as $colums)
								{
									if($registrosBD[$rows][$colums] == $registrosMD[$rel][$mes])
									{
										$continua = 0;
									}		
								}
							}
						}
						if($detalle[$j]['Ventas'] == '0.000000' && $detalle[$j]['Presupuesto'] == '0.000000')
						{
							$continua = 0;
						}
						if($continua == 1)
						{
							$ventas2 = $detalle[$j]['Ventas'];
							$presupuesto2 = $detalle[$j]['Presupuesto'];
							$multi = $ventas2*100;
							$total_ventas = $total_ventas + $ventas2;
							$total_presupuestos = $total_presupuestos + $presupuesto2;
							
							$resultado.="<tr>";
							
							setlocale(LC_MONETARY, 'en_US');
							$ventas3 = money_format('%.2n', $ventas2);
							setlocale(LC_MONETARY, 'en_US');
							$presupuesto3 = money_format('%.2n', $presupuesto2);
							if($detalle[$j]['Mes'] == 1)
							{
								$detalle[$j]['Mes'] = "Enero";
							}
							else if($detalle[$j]['Mes'] == 2)
							{
								$detalle[$j]['Mes'] = "Febrero";
							}
							else if($detalle[$j]['Mes'] == 3)
							{
								$detalle[$j]['Mes'] = "Marzo";
							}
							else if($detalle[$j]['Mes'] == 4)
							{
								$detalle[$j]['Mes'] = "Abril";
							}
							else if($detalle[$j]['Mes'] == 5)
							{
								$detalle[$j]['Mes'] = "Mayo";
							}
							else if($detalle[$j]['Mes'] == 6)
							{
								$detalle[$j]['Mes'] = "Junio";
							}
							else if($detalle[$j]['Mes'] == 7)
							{
								$detalle[$j]['Mes'] = "Julio";
							}
							else if($detalle[$j]['Mes'] == 8)
							{
								$detalle[$j]['Mes'] = "Agosto";
							}
							else if($detalle[$j]['Mes'] == 9)
							{
								$detalle[$j]['Mes'] = "Septiembre";
							}
							else if($detalle[$j]['Mes'] == 10)
							{
								$detalle[$j]['Mes'] = "Octubre";
							}
							else if($detalle[$j]['Mes'] == 11)
							{
								$detalle[$j]['Mes'] = "Noviembre";
							}
							else
							{
								$detalle[$j]['Mes'] = "Diciembre";
							}
								
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Anio']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Mes']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Relacionador']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Producto']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'right'>".$ventas3."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'right'>".$presupuesto3."</td>";
							$partes = explode(".",$detalle[$j]['Porcentaje']);
							$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'center'>".$partes[0]."%"."</td>";
							$resultado.="</tr>";
						}
					}
				}
				else
				{
					$ventas2 = 0;
					$presupuesto2 = 0;
					for($j=0;$j<count($detalle);$j++)
					{
						$continua=1;
						$rel = $detalle[$j]['Relacionador'];
						$mes = $detalle[$j]['Mes'];
						$pro = $detalle[$j]['Producto'];
						if($detalle[$j]['Ventas'] != '0.000000' && $detalle[$j]['Presupuesto'] != '0.000000')
						{
							$relsd[$j] = $rel;
							$messd[$j] = $mes;
							$registrosBD[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
						}
						if($detalle[$j]['Ventas'] == '0.000000' && $detalle[$j]['Presupuesto'] != '0.000000')
						{
							$registrosMD[$rel][$mes] = $rel.'_'.$mes.'_'.$pro;
							foreach($relsd as $rows)
							{
								foreach($messd as $colums)
								{
									if($registrosBD[$rows][$colums] == $registrosMD[$rel][$mes])
									{
										$continua = 0;
									}		
								}
							}
						}
						if($detalle[$j]['Ventas'] == '0.000000' && $detalle[$j]['Presupuesto'] == '0.000000')
						{
							$continua = 0;
						}
						
						if($continua == 1)
						{
							$ventas2 = $ventas2 + $detalle[$j]['Ventas'];
							$presupuesto2 = $presupuesto2 + $detalle[$j]['Presupuesto'];
													
							$multi = $ventas2*100;
							if($presupuesto2 != 0.000000)
							{
								$porce = $multi/$presupuesto2;
								$partes = explode(".",$porce);
							}
							else
							{
								$porce = 0;
							}
							$partes = explode(".",$porce);
							
							$resultado.="<tr>";
							
							setlocale(LC_MONETARY, 'en_US');
							$ventas3 = money_format('%.2n', $ventas2);
							setlocale(LC_MONETARY, 'en_US');
							$presupuesto3 = money_format('%.2n', $presupuesto2);
							if($detalle[$j]['Mes'] == 1)
							{
								$detalle[$j]['Mes'] = "Enero";
							}
							else if($detalle[$j]['Mes'] == 2)
							{
								$detalle[$j]['Mes'] = "Febrero";
							}
							else if($detalle[$j]['Mes'] == 3)
							{
								$detalle[$j]['Mes'] = "Marzo";
							}
							else if($detalle[$j]['Mes'] == 4)
							{
								$detalle[$j]['Mes'] = "Abril";
							}
							else if($detalle[$j]['Mes'] == 5)
							{
								$detalle[$j]['Mes'] = "Mayo";
							}
							else if($detalle[$j]['Mes'] == 6)
							{
								$detalle[$j]['Mes'] = "Junio";
							}
							else if($detalle[$j]['Mes'] == 7)
							{
								$detalle[$j]['Mes'] = "Julio";
							}
							else if($detalle[$j]['Mes'] == 8)
							{
								$detalle[$j]['Mes'] = "Agosto";
							}
							else if($detalle[$j]['Mes'] == 9)
							{
								$detalle[$j]['Mes'] = "Septiembre";
							}
							else if($detalle[$j]['Mes'] == 10)
							{
								$detalle[$j]['Mes'] = "Octubre";
							}
							else if($detalle[$j]['Mes'] == 11)
							{
								$detalle[$j]['Mes'] = "Noviembre";
							}
							else
							{
								$detalle[$j]['Mes'] = "Diciembre";
							}
								
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Anio']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Mes']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Relacionador']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;'>".$detalle[$j]['Producto']."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'right'>".$ventas3."</td>";
							$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'right'>".$presupuesto3."</td>";
							if($presupuesto2 != 0.000000)
							{
								$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'center'>".$partes[0]."%"."</td>";
							}
							else
							{
								$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'center'>0%</td>";
							}
							$resultado.="</tr>";
						
						}
					}
					$total_presupuestos = $presupuesto2;
					$total_ventas = $ventas2;
				}
				
				if($total_presupuestos != 0.000000)
				{
					$multi_tot = $total_ventas*100;
					$porce_tot = $multi_tot/$total_presupuestos;
					$total_porcentaje = explode(".",$porce_tot);
					setlocale(LC_MONETARY, 'en_US');
					$total_presupuestos = money_format('%.2n', $total_presupuestos);
					$total_ventas = money_format('%.2n', $total_ventas);
					$resultado.="<tr>
								 <td style='border:1px solid; border-color: #eee;'><b>TOTAL</b></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_ventas."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_presupuestos."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'center'><b>".$total_porcentaje[0]."%"."</b></td>
								 </tr>";
				}
				else
				{
					setlocale(LC_MONETARY, 'en_US');
					$total_presupuestos = money_format('%.2n', $total_presupuestos);
					$total_ventas = money_format('%.2n', $total_ventas);
					$resultado.="<tr>
								 <td style='border:1px solid; border-color: #eee;'><b>TOTAL</b></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;'></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_ventas."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'right'><b>".$total_presupuestos."</b></td>
								 <td style='border:1px solid; border-color: #eee;' align = 'center'><b>0%</b></td>
								 </tr>";
				}
			}
			else
			{}
			$resultado.="</table></div>"; 
			echo $resultado;
		}
		else
		{
			{/php}
				<h4 class='dataLabel'>{sugar_translate label='LBL_RESULTAT' module='{{$module}}'}</h4><br>
			{php}
			$PIPE = $this->_tpl_vars['PIPE'];
			echo $PIPE;
			$contador = 0;
			$contador1 = 0;
			$valor=0;
			$probabilidad=0;
			$total_presupuestado = 0;
			$total_facturado = 0;
			$count100 = 0;
			$count75 = 0;
			$count50 = 0;
			$count25 = 0;
			$count0 = 0;
      $suma100 = 0;
			$suma75 = 0;
			$suma50 = 0;
			$suma25 = 0;
			$suma0 = 0;
			$cabecera = $this->_tpl_vars['SQL_HEADER'];
			$detalle = $this->_tpl_vars['SQL_RESULT'];                               
           
      foreach($detalle as $acumular)
			{									
				foreach($acumular as $valor)
				{
				    
					if($contador1 == 8)
					{
						if($valor == 100)
						{
							$count100++;
                            $suma100 += $acumular['Prospeccion'];
						}else if($valor == 75)
						{
							$count75++;
                            $suma75 += $acumular['Prospeccion'];
						}
						if($valor == 50)
						{
							$count50++;
                            $suma50 += $acumular['Prospeccion'];
						}
						if($valor == 25)
						{
							$count25++;
                            $suma25 += $acumular['Prospeccion'];
						}	
						if($valor == 0)
						{
							$count0++;
                            $suma0 += $acumular['Prospeccion'];
						}                        
					}
                    
					$contador1++;					
				}
				$contador1=0;				
			}				
			$s1 = array();
			$x=0;	
      setlocale(LC_MONETARY, 'en_US');
      $prospecto100 = money_format('%.2n', $suma100);  
			$prospecto75 = money_format('%.2n', $suma75);
			$prospecto50 = money_format('%.2n', $suma50);
			$prospecto25 = money_format('%.2n', $suma25);
			$prospecto0 = money_format('%.2n', $suma0);
            
      $estimado100 = ($suma100*100)/100;
			$estimado75 = ($suma75*75)/100;
			$estimado50 = ($suma50*50)/100;
			$estimado25 = ($suma25*25)/100;
			$estimado0 = ($suma0*0)/100;     
                        
                     							
			if($count0 > 0)
			{
				$s1[$x]  =array('Oferta Rechazada(0%)',$count0,0,$prospecto0,money_format('%.2n',$estimado0));
				$x++;
			}
            if($count25 > 0)			
			{
				$s1[$x]  = array('Oferta presentada (25%)',$count25,25,$prospecto25,money_format('%.2n',$estimado25));
				$x++;
			}
            if($count50 > 0)
			{
				$s1[$x]  = array('Oferta en Proceso de Negociacion (50%)',$count50,50,$prospecto50,money_format('%.2n',$estimado50));
				$x++;
			}
            if($count75 > 0)
			{
				$s1[$x]  = array('Propuesta Enviada y Aceptada (75%)',$count75,75,$prospecto75,money_format('%.2n',$estimado75));
				$x++;
			}
            if($count100 > 0) 
			{
				$s1[$x] = array('Contrato Firmado o Factura enviada(100%)',$count100,100,$prospecto100,money_format('%.2n',$estimado100));
				$x++;
			}
			$resultado="<style type='text/css'>
                #info_pipe
                {
                	position: absolute;
                	display:none;
                	font-family:Arial;
                	font-size:0.8em;
                	width:220px;
                	border:1px solid #808080;
                	background-color:#f1f1f1;	
					padding:5px;
                }
                </style>
				<table id= 'tabla_pipe' width='100%' border='0' cellspacing='0' cellpaddig='0' class='detail view'>
				<tr>
					<th colspan='3' style='color:#888888;background-color:#F0F0F0;padding:10px;' align='center'>Pipeline de Ventas<div style='display:block;float:right;background-color:#F0F0F0;' align='right'><img id='reload_grey' src='custom/modules/SYNO_Reports/reload_gray.png' style='cursor: pointer;' width='25' height='25'></div></th>
				</tr>
				<tr>
					<td style='border-left:1px solid;border-bottom:1px solid; border-color: #eee;'></td>
					<td width='660px' height='550px' align = 'center' style='border-bottom:1px solid; border-color: #eee;'>
						<div id='loading' style='min-width:660px;margin-top:210px;' align='center'><img src='custom/modules/SYNO_Reports/cargando.gif' width='41' height='39' /></div>					
						<div id='chart2' style='min-height:550px;min-width:660px;float:left;' ></div>
					</td>
					<td style='border-right:1px solid;border-bottom:1px solid; border-color: #eee;'></td>
				</tr>
				</table>
				<div style='z-index:1000;' id='info_pipe' ><span id='texto' style='padding:5px;'></span></div>";  			                       
			$resultado.="<table width='100%' border='0' cellspacing='0' cellpaddig='0' class='edit view'>
					<tr>";
			unset($cabecera[count($cabecera)-1]);                    
			foreach($cabecera as $row)
			{
				$resultado.="<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>".$row."</td>";
			}
			$resultado.="<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Facturacion Estimada</td>";
			$resultado.="</tr>";             
			foreach($detalle as $colum)
			{					
				$resultado.="<tr>";                
				foreach($colum as $value)
				{
					if($contador == 1)
					{
						if($value == 1)
						{
							$value = "Enero";
						}
						else if($value == 2)
						{
							$value = "Febrero";
						}
						else if($value == 3)
						{
							$value = "Marzo";
						}
						else if($value == 4)
						{
							$value = "Abril";
						}
						else if($value == 5)
						{
							$value = "Mayo";
						}
						else if($value == 6)
						{
							$value = "Junio";
						}
						else if($value == 7)
						{
							$value = "Julio";
						}
						else if($value == 8)
						{
							$value = "Agosto";
						}
						else if($value == 9)
						{
							$value = "Septiembre";
						}
						else if($value == 10)
						{
							$value = "Octubre";
						}
						else if($value == 11)
						{
							$value = "Noviembre";
						}
						else if($value == 12)
						{
							$value = "Diciembre";
						}
						$resultado.="<td style='border:1px solid; border-color: #eee;'>".$value."</td>";
					}
					if($contador == 6)
					{
						$id_opt = $colum['id_Op'];
						$resultado.="<td onclick='envia_idopt(\"$id_opt\");' align='left' valign='top' style='border:1px solid; border-color: #eee;'><a href='#'>".$value."</a></td>";
					}
					if($contador == 7)
					{
						$valor = $value;
						setlocale(LC_MONETARY, 'en_US');
						$value = money_format('%.2n', $value);
						$total_presupuestado = $total_presupuestado + $valor;
						$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'right'>".$value."</td>";
					}
					if($contador == 8)
					{
						$probabilidad = $value;
						$value = $value."%";
						$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'center'>".$value."</td>";
					}
					if($contador != 9 && $contador != 6 && $contador != 7 && $contador != 8 && $contador != 1)
					{
						$resultado.="<td style='border:1px solid; border-color: #eee;'>".$value."</td>";
					}
					$contador++;
				}
				$contador=0;
				$multi = $valor*$probabilidad;
				$facturacion = $multi/100;
				$total_facturado = $total_facturado + $facturacion;
				setlocale(LC_MONETARY, 'en_US');
				$facturacion = money_format('%.2n', $facturacion);
				$resultado.="<td style='border:1px solid; border-color: #eee;' align = 'right'>".$facturacion."</td>";
				$resultado.="</tr>";
			}
			setlocale(LC_MONETARY, 'en_US');
			$total_presupuestado = money_format('%.2n', $total_presupuestado);
			setlocale(LC_MONETARY, 'en_US');
			$total_facturado = money_format('%.2n', $total_facturado);
			$getJSON = json_encode($s1);
			$resultado.="<tr>
						<td><b>TOTAL</b></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align = 'right'><b>".$total_presupuestado."</b></td>
						<td></td>
						<td align = 'right'><b>".$total_facturado."</b></td>
						</tr>";
			$resultado.="</table>
			<script type='text/javascript'>
			var datos = eval(".$getJSON.");
				$(document).ready(function(e){
					incluir_lib(datos);
				});
				
				function include(file_path,datos){
					var j = document.createElement('script');
					j.type = 'text/javascript';
					j.src = file_path;
					document.body.appendChild(j);
					setTimeout(function(){grafica_pipe(datos);},5000);
				}

				function include_once(file_path,datos){
					var sc = document.getElementsByTagName('script');
					for (var x in sc)
						if (sc[x].src != null && sc[x].src.indexOf(file_path) != -1) return;
					include(file_path,datos);
				}

				function incluir_lib(datos)
				{
					include_once('custom/modules/SYNO_Reports/phpChart_Basic/js/plugins/jqplot.funnelrenderer.min.js',datos);
					$('#loading').show();
					$('#chart2').hide();
				}
				function grafica_pipe(datos)
				{
					$('#loading').hide();
					$('#chart2').show();
					$('#chart2').empty();
					$('#chart2').unbind('jqplotDataClick');
					$('#chart2').unbind('jqplotDataHighlight');
					$('#chart2').unbind('jqplotDataUnhighlight');
					
					var opciones = {
									'grid':{
										'gridLineColor':'#ffffff','background':'rgba(0,0,0,0)','borderWidth':0,'drawBorder':false,'shadow':false
									},
									'legend':{
										'show':true,'location':'s','placement':'insideGrid','rendererOptions':{
											'numberColumns':datos.length
										}
									},'animate':true,'animateReplot':true,'axesDefaults':[],
									'seriesDefaults':{
										'renderer':$.jqplot.FunnelRenderer,'rendererOptions':{
											'showDataLabels':true,'widthRatio':0.1,'sectionMargin':1,'dataLabels':'percent'
										}
									},'seriesColors':[
										'#588A78','#CD5200','#2B5D8C','#366D21','#8C2B2B'
									]
								}
										
					var data = [];
					data.push(datos);
					
					plot = $.jqplot('chart2', data, opciones);				
					
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
			</script>";
            $sql = $this->_tpl_vars['DESC'];			
			sleep(2);
			echo $resultado;                       			
		}
	}
	else
	{
		if($nombre_reporte == 'Presupuesto por producto por relacionador por mes')
		{
			$i=0;
			$mes=1;
			$presupuesto_producto = 0;
			$total_enero = 0;
			$total_febrero = 0;
			$total_marzo = 0;
			$total_abril = 0;
			$total_mayo = 0;
			$total_junio = 0;
			$total_julio = 0;
			$total_agosto = 0;
			$total_septiembre = 0;
			$total_octubre = 0;
			$total_noviembre = 0;
			$total_diciembre = 0;
			$total_relacionador = 0;
			$totales = 0;
			$cabecera = $this->_tpl_vars['SQL_HEADER'];
			$detalle = $this->_tpl_vars['SQL_RESULT'];
			$db =  DBManagerFactory::getInstance();
			foreach($detalle as $row)
			{
				$query3 = "SELECT SUM(valor_c) as valor FROM presupuestos_cstm WHERE nombre_producto_c = '".$row['nombre_producto_c']."' AND nombre_periodo_c = '2013'  AND tipo_c = 'totales'";
				$result3 = $db->query($query3, true, 'Error selecting the user record');
				if($row4=$db->fetchByAssoc($result3))
				{
					$presupuesto_producto = $row4['valor'];
				}
				$resultado.="<table width='100%' border='0' cellspacing='0' cellpaddig='0' class='edit view'>
								<tr>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>".$row['nombre_producto_c']."</td>
								</tr>
								<tr>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Relacionador</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Enero</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Febrero</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Marzo</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Abril</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Mayo</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Junio</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Julio</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Agosto</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Septiembre</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Octubre</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Noviembre</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Diciembre</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Total</td>
									<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Porcentaje</td>
								</tr>";
								$query = "SELECT DISTINCT(CONCAT(d.first_name,' ',d.last_name)) AS Relacionador FROM presupuestos_cstm a, presupuestos b, product_templates c, users d WHERE a.nombre_producto_c = c.name AND b.assigned_user_id = d.id AND a.estatus_c IN('Aprobado','Solicitar') AND a.tipo_c = 'distribucion' AND a.nombre_producto_c = '".$row['nombre_producto_c']."' AND a.id_c = b.id and c.deleted = '0'";
								$result = $db->query($query, true, 'Error selecting the user record');
								while($row2=$db->fetchByAssoc($result))
								{
									$resultado.="<tr>";
									$resultado.="<td style='border:1px solid; border-color: #eee;' align='center'>".$row2['Relacionador']."</td>";
									while($mes <= 12)
									{
										$query2 = "SELECT SUM(a.valor_c) AS valor FROM presupuestos_cstm a, presupuestos b, users c WHERE b.assigned_user_id = c.id AND a.estatus_c IN('Aprobado','Solicitar') AND a.tipo_c = 'distribucion' AND a.nombre_producto_c = '".$row['nombre_producto_c']."' AND a.id_mes_c = '".$mes."' AND CONCAT(c.first_name,' ',c.last_name) = '".$row2['Relacionador']."' AND a.id_c = b.id";
										$result2 = $db->query($query2, true, 'Error selecting the user record');
										if($row3=$db->fetchByAssoc($result2))
										{
											$value = floatval($row3['valor']);
											if($mes==1)
											{
												$total_enero = $total_enero + $value;
											}
											if($mes==2)
											{
												$total_febrero = $total_febrero + $value;
											}
											if($mes==3)
											{
												$total_marzo = $total_marzo + $value;
											}
											if($mes==4)
											{
												$total_abril = $total_abril + $value;
											}
											if($mes==5)
											{
												$total_mayo = $total_mayo + $value;
											}
											if($mes==6)
											{
												$total_junio = $total_junio + $value;
											}
											if($mes==7)
											{
												$total_julio = $total_julio + $value;
											}
											if($mes==8)
											{
												$total_agosto = $total_agosto + $value;
											}
											if($mes==9)
											{
												$total_septiembre = $total_septiembre + $value;
											}
											if($mes==10)
											{
												$total_octubre = $total_octubre + $value;
											}
											if($mes==11)
											{
												$total_noviembre = $total_noviembre + $value;
											}
											if($mes==12)
											{
												$total_diciembre = $total_diciembre + $value;
											}
											$total_relacionador = $total_relacionador + $row3['valor'];
											setlocale(LC_MONETARY, 'en_US');
											$valor = money_format('%.2n', $row3['valor']);
											if($valor != '$0.00')
											{
												$resultado.="<td style='border:1px solid; border-color: #eee;' align='right'>".$valor."</td>";
											}
											else
											{
												$resultado.="<td style='border:1px solid; border-color: #eee;' align='center'>-</td>";
											}
										}
										$mes++;
									}
									$totales = $totales + $total_relacionador;
									$multi = $total_relacionador*100;
									$divi = $multi/$presupuesto_producto;
									$partes = explode('.',$divi);
									setlocale(LC_MONETARY, 'en_US');
									$total_relacionador = money_format('%.2n', $total_relacionador);
									$resultado.="<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_relacionador."</b></td>
												 <td style='border:1px solid; border-color: #eee;' align='center'><b>".$partes[0]."%</b></td>
									</tr>";
									$mes=1;
								}
					setlocale(LC_MONETARY, 'en_US');
					$total_enero = money_format('%.2n', floatval($total_enero));
					$total_febrero = money_format('%.2n', floatval($total_febrero));
					$total_marzo = money_format('%.2n', floatval($total_marzo));
					$total_abril = money_format('%.2n', floatval($total_abril));
					$total_mayo = money_format('%.2n', floatval($total_mayo));
					$total_junio = money_format('%.2n', floatval($total_junio));
					$total_julio = money_format('%.2n', floatval($total_julio));
					$total_agosto = money_format('%.2n', floatval($total_agosto));
					$total_septiembre = money_format('%.2n', floatval($total_septiembre));
					$total_octubre = money_format('%.2n', floatval($total_octubre));
					$total_noviembre = money_format('%.2n', floatval($total_noviembre));
					$total_diciembre = money_format('%.2n', floatval($total_diciembre));
					$multi = $totales*100;
					$divi = $multi/$presupuesto_producto;
					$partes = explode('.',$divi);
					$totales = money_format('%.2n', floatval($totales));
					$resultado.="<tr>
									<td style='border:1px solid; border-color: #eee;' align='center'>Total</td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_enero."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_febrero."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_marzo."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_abril."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_mayo."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_junio."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_julio."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_agosto."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_septiembre."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_octubre."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_noviembre."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_diciembre."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='right'><b>".$totales."</b></td>
									<td style='border:1px solid; border-color: #eee;' align='center'><b>".$partes[0]."%</b></td>
								</tr>";
					$resultado.="</table>";
			}
			echo $resultado;
		}
		if($nombre_reporte == 'Consolidado de Presupuestos y Cumplimiento por relacionador')
		{
			$db =  DBManagerFactory::getInstance();
			$resultado1 = str_replace("&#039;", "'", $GLOBALS['FOCUS']->query1_c);
			$result = $db->query($resultado1, true, 'Error selecting the user record');
			$resultado2 = str_replace("&#039;", "'", $GLOBALS['FOCUS']->query2_c);
			$result2 = $db->query($resultado2, true, 'Error selecting the user record');
			
			$query3 = "SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, b.Prospectado, b.Estimado, ((b.Estimado*100)/b.Prospectado) as Prob, c.Presupuesto, ((b.Estimado*100)/c.Presupuesto) as Probabilidad
FROM users a, temp1 b, temp2 c
WHERE b.Relacionador = c.Relacionador
AND a.id = b.Relacionador
ORDER BY Relacionador ASC;";
			$result3 = $db->query($query3, true, 'Error selecting the user record');
			$resultado_consolidado.="<table width='100%' border='0' cellspacing='0' cellpaddig='0' class='edit view'>
					<tr>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Relacionador</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Prospectado</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Facturacion Estimada</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Prob. Estadio Promedio</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Presupuesto</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Porcentaje de Cumplimiento</td>
					</tr>";
			setlocale(LC_MONETARY, 'en_US');
			$total_prospectado =0;
			$total_estimado =0;
			$total_presupuesto =0;
			$usuario_actual = '';
			$usuario_antiguo = '';
			while($row=$db->fetchByAssoc($result3))
			{
				$usuario_actual = $row['Relacionador'];
				if($usuario_antiguo != $usuario_actual)
				{
					$total_presupuesto = $total_presupuesto + $row['Presupuesto'];
				}
				$total_prospectado = $total_prospectado + $row['Prospectado'];
				$total_estimado = $total_estimado + $row['Estimado'];
				$prospectado = money_format('%.2n', $row['Prospectado']);
				$estimado = money_format('%.2n', $row['Estimado']);
				$presupuesto = money_format('%.2n', $row['Presupuesto']);
				$prob_partes = explode('.',$row['Prob']);
				$prob_partes2 = explode('.',$row['Probabilidad']);
				$resultado_consolidado.="<tr><td style='border:1px solid; border-color: #eee;'>".$row['Relacionador']."</td>
										<td style='border:1px solid; border-color: #eee;' align='right'>".$prospectado."</td>
										<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado."</td>
										<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td>
										<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto."</td>
										<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes2[0]."%</td></tr>";
				$usuario_antiguo = $row['Relacionador'];
			}
			$total_prob_estimada = (($total_estimado*100)/$total_prospectado);
			$total_prob_estimada_partes = explode('.',$total_prob_estimada);
			$total_prob_cumplida = (($total_estimado*100)/$total_presupuesto);
			$total_prob_cumplida_partes = explode('.',$total_prob_cumplida);
			$total_prospectado = money_format('%.2n', $total_prospectado);
			$total_estimado = money_format('%.2n', $total_estimado);
			$total_presupuesto = money_format('%.2n', $total_presupuesto);
			$resultado_consolidado.="<tr><td style='border:1px solid; border-color: #eee;'><b>TOTAL</b></td>
										<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_prospectado."</b></td>
										<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_estimado."</b></td>
										<td style='border:1px solid; border-color: #eee;' align='center'><b>".$total_prob_estimada_partes[0]."%</b></td>
										<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_presupuesto."</b></td>
										<td style='border:1px solid; border-color: #eee;' align='center'><b>".$total_prob_cumplida_partes[0]."%</b></td></tr></table>";
			$query4 = "DROP TABLE temp1;";
			$result4 = $db->query($query4, true, 'Error selecting the user record');
			
			$query5 = "DROP TABLE temp2;";
			$result5 = $db->query($query5, true, 'Error selecting the user record');
			
			echo $resultado_consolidado;
		}
		if($nombre_reporte == 'Historico de ventas por relacionador semanal')
		{
			require_once("custom/modules/SYNO_Reports/phpChart_Basic/conf.php");
			$db =  DBManagerFactory::getInstance();
			$resultado1 = str_replace("&#039;", "'", $GLOBALS['FOCUS']->query1_c);
			$result = $db->query($resultado1, true, 'Error selecting the user record');
			$resultado2 = str_replace("&#039;", "'", $GLOBALS['FOCUS']->query2_c);
			$result2 = $db->query($resultado2, true, 'Error selecting the user record');
			
			if($semanal_mensual == 'Semanal')
			{
				$query3 = "SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, SUM(b.Estimado) AS Estimado, b.Mes, b.Semanas FROM users a, temp1 b
WHERE a.id = b.Relacionador
GROUP BY b.Relacionador, b.Semanas
ORDER BY Semanas ASC";
				$result3 = $db->query($query3, true, 'Error selecting the user record');
				
				$query4 = "SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, SUM(b.Presupuesto) AS Presupuesto, b.Mes, b.Semanas FROM users a, temp2 b
WHERE a.id = b.Relacionador
GROUP BY b.Relacionador, b.Semanas
ORDER BY Semanas ASC";
				$result4 = $db->query($query4, true, 'Error selecting the user record');
			}
			else
			{
				$query3 = "CREATE TEMPORARY TABLE temp3
SELECT a.id AS Relacionador, b.Estimado AS Estimado, c.Presupuesto AS Presupuesto, b.Semanas AS Semanas, b.Mes AS Mes
FROM users a, temp1 b, temp2 c
WHERE a.id = b.Relacionador
AND a.id = c.Relacionador
AND b.Relacionador = c.Relacionador
AND b.Mes = c.Mes
GROUP BY Relacionador, Mes";
				$result3 = $db->query($query3, true, 'Error selecting the user record');
				
				$query4 = "SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, SUM(b.Estimado) AS Estimado, SUM(b.Presupuesto) AS Presupuesto, b.Semanas AS Semanas, b.Mes AS Mes
FROM users a, temp3 b
WHERE a.id = b.Relacionador
GROUP BY Relacionador, Mes
UNION ALL
SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, NULL AS Estimado, SUM(d.Presupuesto) AS Presupuesto, d.Semanas AS Semanas, d.Mes AS Mes
FROM users a, temp2 d
WHERE a.id = d.Relacionador
GROUP BY Relacionador, Mes
ORDER BY Mes+0 ASC, Estimado DESC";
				$result4 = $db->query($query4, true, 'Error selecting the user record');
			}
			$result4 = $db->query($query4, true, 'Error selecting the user record');
			setlocale(LC_MONETARY, 'en_US');
			$cont=0;
			$line1 = array();
			$line2 = array();
			$semanas = array();
			$meses = array();
			$total_semanal_estimado = 0;
			$total_semanal_presupuesto = 0;
			$total_mensual_estimado = 0;
			$total_mensual_presupuesto = 0;
			$semana_anterior = 0;
			$semana_actual = 0;
			$mes_anterior = 0;
			$mes_actual = 0;
			$registros = array();
			$rel = "";
			$mes = "";
			$registrosB = array();
			$registrosM = array();
			$ventas = array();
			$presupuestos = array();
			$rels = array();
			$mess = array();
			$i=0;
			if($semanal_mensual == 'Semanal')
			{
				while($row=$db->fetchByAssoc($result3))
				{
					$ventas[$i] = $row;
					$i++;
				}
				$i=0;
				while($row=$db->fetchByAssoc($result4))
				{
					if($row['Mes'] == 1)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 1);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 2);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 3);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 4);
						$i = $i + 4;
					}
					if($row['Mes'] == 2)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 5);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 6);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 7);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 8);
						$i = $i + 4;
					}
					if($row['Mes'] == 3)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 9);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 10);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 11);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 12);
						$i = $i + 4;
					}
					if($row['Mes'] == 4)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 13);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 14);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 15);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 16);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 17);
						$i = $i + 5;
					}
					if($row['Mes'] == 5)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 18);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 19);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 20);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 21);
						$i = $i + 4;
					}
					if($row['Mes'] == 6)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 22);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 23);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 24);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 25);
						$i = $i + 4;
					}
					if($row['Mes'] == 7)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 26);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 27);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 28);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 29);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 30);
						$i = $i + 5;
					}
					if($row['Mes'] == 8)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 31);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 32);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 33);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 34);
						$i = $i + 4;
					}
					if($row['Mes'] == 9)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 35);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 36);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 37);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 38);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 39);
						$i = $i + 5;
					}
					if($row['Mes'] == 10)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 40);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 41);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 42);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 43);
						$i = $i + 4;
					}
					if($row['Mes'] == 11)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 44);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 45);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 46);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 47);
						$i = $i + 4;
					}
					if($row['Mes'] == 12)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 48);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 49);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 50);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 51);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 52);
						$i = $i + 5;
					}
				}
				usort($presupuestos, "cmp");
				$i=0;
				foreach($presupuestos as $presupuesto)
				{
					$igual=0;
					foreach($ventas as $venta)
					{
						if($venta['Semanas'] == $presupuesto['Semanas'] && $venta['Relacionador'] == $presupuesto['Relacionador'])
						{
							$igual=1;
							if($presupuesto['Presupuesto'] != '0.0000000000')
								$probabilidad  = (($venta['Estimado']*100)/$presupuesto['Presupuesto']);
							else
								$probabilidad = 0;
							$registros[$i] = array('Relacionador' => $venta['Relacionador'], 'Estimado' => $venta['Estimado'], 'Presupuesto' => $presupuesto['Presupuesto'], 'Mes' => $venta['Mes'], 'Semanas' => $venta['Semanas'], 'Probabilidad' => $probabilidad);
						}
					}
					if($igual == 1)
					{}
					else
					{
						$registros[$i] = array('Relacionador' => $presupuesto['Relacionador'], 'Estimado' => '0', 'Presupuesto' => $presupuesto['Presupuesto'], 'Mes' => $presupuesto['Mes'], 'Semanas' => $presupuesto['Semanas'], 'Probabilidad' => '0');
					}
					$i++;
				}
			}
			else
			{
				while($row=$db->fetchByAssoc($result4))
				{
					$registros[$i] = $row;
					$i++;
				}
			}
			$i=0;
			
			if($semanal_mensual == 'Semanal')
			{
				foreach($registros as $row)
				{
					if($tipo == 'Individual')
					{
						if(isset($registros[$i+1]['Semanas']))
						{
							if($registros[$i]['Semanas'] == $registros[$i+1]['Semanas'])
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
									$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
								}
							}
							else
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
									$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
									$estimado_formato = money_format('%.2n', $total_semanal_estimado);
									$presupuesto_formato = money_format('%.2n', $total_semanal_presupuesto);				
									$line1[] = array($registros[$i]['Semanas'],floatval($total_semanal_estimado), $estimado_formato);
									$line2[] = array($registros[$i]['Semanas'],floatval($total_semanal_presupuesto), $presupuesto_formato);
									$semanas[] = $registros[$i]['Semanas'];
									$total_semanal_estimado = 0;
									$total_semanal_presupuesto = 0;
								}
							}
						}
						else
						{
							$continua=1;
							$rel = $registros[$i]['Relacionador'];
							$mes = $registros[$i]['Semanas'];
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
							{
								$continua = 0;
							}
							if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$rels[$rel] = $rel;
								$mess[$mes] = $mes;
								$registrosB[$rel][$mes] = $rel.'_'.$mes;
							}
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$registrosM[$rel][$mes] = $rel.'_'.$mes;
								foreach($registrosB as $rows)
								{
									foreach($rows as $value)
									{
										if($value == $rel.'_'.$mes)
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
								$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
								$estimado_formato = money_format('%.2n', $total_semanal_estimado);
								$presupuesto_formato = money_format('%.2n', $total_semanal_presupuesto);				
								$line1[] = array($registros[$i]['Semanas'],floatval($total_semanal_estimado), $estimado_formato);
								$line2[] = array($registros[$i]['Semanas'],floatval($total_semanal_presupuesto), $presupuesto_formato);
								$semanas[] = $registros[$i]['Semanas'];
								$total_semanal_estimado = 0;
								$total_semanal_presupuesto = 0;
							}
						}
					}
					else
					{
						if(isset($registros[$i+1]['Semanas']))
						{
							if($registros[$i]['Semanas'] == $registros[$i+1]['Semanas'])
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
									$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
								}
							}
							else
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
									$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
									$estimado_formato = money_format('%.2n', $total_semanal_estimado);
									$presupuesto_formato = money_format('%.2n', $total_semanal_presupuesto);				
									$line1[] = array($registros[$i]['Semanas'],floatval($total_semanal_estimado), $estimado_formato);
									$line2[] = array($registros[$i]['Semanas'],floatval($total_semanal_presupuesto), $presupuesto_formato);
									$semanas[] = $registros[$i]['Semanas'];
								}
							}
						}
						else
						{
							$continua=1;
							$rel = $registros[$i]['Relacionador'];
							$mes = $registros[$i]['Semanas'];
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
							{
								$continua = 0;
							}
							if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$rels[$rel] = $rel;
								$mess[$mes] = $mes;
								$registrosB[$rel][$mes] = $rel.'_'.$mes;
							}
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$registrosM[$rel][$mes] = $rel.'_'.$mes;
								foreach($registrosB as $rows)
								{
									foreach($rows as $value)
									{
										if($value == $rel.'_'.$mes)
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
								$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
								$estimado_formato = money_format('%.2n', $total_semanal_estimado);
								$presupuesto_formato = money_format('%.2n', $total_semanal_presupuesto);				
								$line1[] = array($registros[$i]['Semanas'],floatval($total_semanal_estimado), $estimado_formato);
								$line2[] = array($registros[$i]['Semanas'],floatval($total_semanal_presupuesto), $presupuesto_formato);
								$semanas[] = $registros[$i]['Semanas'];
							}
						}
					}
					$i++;
				}
			}
			else
			{
				foreach($registros as $row)
				{
					if($tipo == 'Individual')
					{
						if(isset($registros[$i+1]['Mes']))
						{
							if($registros[$i]['Mes'] == $registros[$i+1]['Mes'])
							{
								if($registros[$i]['Relacionador'] == $registros[$i+1]['Relacionador'])
								{
									$continua=1;
									$rel = $registros[$i]['Relacionador'];
									$mes = $registros[$i]['Mes'];
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
									{
										$continua = 0;
									}
									if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$rels[$rel] = $rel;
										$mess[$mes] = $mes;
										$registrosB[$rel][$mes] = $rel.'_'.$mes;
									}
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$registrosM[$rel][$mes] = $rel.'_'.$mes;
										foreach($registrosB as $rows)
										{
											foreach($rows as $value)
											{
												if($value == $rel.'_'.$mes)
												{
													$continua = 0;
												}
											}
										}
									}
									if($continua == 1)
									{
										$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
										$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									}
								}
								else
								{
									$continua=1;
									$rel = $registros[$i]['Relacionador'];
									$mes = $registros[$i]['Mes'];
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
									{
										$continua = 0;
									}
									if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$rels[$rel] = $rel;
										$mess[$mes] = $mes;
										$registrosB[$rel][$mes] = $rel.'_'.$mes;
									}
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$registrosM[$rel][$mes] = $rel.'_'.$mes;
										foreach($registrosB as $rows)
										{
											foreach($rows as $value)
											{
												if($value == $rel.'_'.$mes)
												{
													$continua = 0;
												}
											}
										}
									}
									if($continua == 1)
									{
										$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
										$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									}
								}
							}
							else
							{
								$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
								$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
								$estimado_formato = money_format('%.2n', $total_mensual_estimado);
								$presupuesto_formato = money_format('%.2n', $total_mensual_presupuesto);				
								$line1[] = array($registros[$i]['Mes'],floatval($total_mensual_estimado), $estimado_formato);
								$line2[] = array($registros[$i]['Mes'],floatval($total_mensual_presupuesto), $presupuesto_formato);
								$meses[] = $registros[$i]['Mes'];
								$total_mensual_estimado = 0;
								$total_mensual_presupuesto = 0;
							}
						}
						else
						{
							$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
							$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
							$estimado_formato = money_format('%.2n', $total_mensual_estimado);
							$presupuesto_formato = money_format('%.2n', $total_mensual_presupuesto);				
							$line1[] = array($registros[$i]['Mes'],floatval($total_mensual_estimado), $estimado_formato);
							$line2[] = array($registros[$i]['Mes'],floatval($total_mensual_presupuesto), $presupuesto_formato);
							$meses[] = $registros[$i]['Mes'];
							$total_mensual_estimado = 0;
							$total_mensual_presupuesto = 0;
						}
					}
					else
					{
						if(isset($registros[$i+1]['Mes']))
						{
							if($registros[$i]['Mes'] == $registros[$i+1]['Mes'])
							{
								if($registros[$i]['Relacionador'] == $registros[$i+1]['Relacionador'])
								{
									$continua=1;
									$rel = $registros[$i]['Relacionador'];
									$mes = $registros[$i]['Mes'];
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
									{
										$continua = 0;
									}
									if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$rels[$rel] = $rel;
										$mess[$mes] = $mes;
										$registrosB[$rel][$mes] = $rel.'_'.$mes;
									}
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$registrosM[$rel][$mes] = $rel.'_'.$mes;
										foreach($registrosB as $rows)
										{
											foreach($rows as $value)
											{
												if($value == $rel.'_'.$mes)
												{
													$continua = 0;
												}
											}
										}
									}
									if($continua == 1)
									{
										$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
										$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									}
								}
								else
								{
									$continua=1;
									$rel = $registros[$i]['Relacionador'];
									$mes = $registros[$i]['Mes'];
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
									{
										$continua = 0;
									}
									if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$rels[$rel] = $rel;
										$mess[$mes] = $mes;
										$registrosB[$rel][$mes] = $rel.'_'.$mes;
									}
									if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
									{
										$registrosM[$rel][$mes] = $rel.'_'.$mes;
										foreach($registrosB as $rows)
										{
											foreach($rows as $value)
											{
												if($value == $rel.'_'.$mes)
												{
													$continua = 0;
												}
											}
										}
									}
									if($continua == 1)
									{
										$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
										$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									}
								}
							}
							else
							{
								$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
								$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
								$estimado_formato = money_format('%.2n', $total_mensual_estimado);
								$presupuesto_formato = money_format('%.2n', $total_mensual_presupuesto);				
								$line1[] = array($registros[$i]['Mes'],floatval($total_mensual_estimado), $estimado_formato);
								$line2[] = array($registros[$i]['Mes'],floatval($total_mensual_presupuesto), $presupuesto_formato);
								$meses[] = $registros[$i]['Mes'];
							}
						}
						else
						{
							$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
							$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
							$estimado_formato = money_format('%.2n', $total_mensual_estimado);
							$presupuesto_formato = money_format('%.2n', $total_mensual_presupuesto);				
							$line1[] = array($registros[$i]['Mes'],floatval($total_mensual_estimado), $estimado_formato);
							$line2[] = array($registros[$i]['Mes'],floatval($total_mensual_presupuesto), $presupuesto_formato);
							$meses[] = $registros[$i]['Mes'];
						}
					}
					$i++;
				}
			}
			
			$pc = new C_PhpChartX(array($line2,$line1),'chart1');
			$pc->add_plugins(array('cursor','pointLabels','barRenderer','categoryAxisRenderer'),true);
			$pc->set_animate(true);
			$pc->set_title(array('text'=>'Historico de ventas vs Presupuestado'));
			$pc->set_axes_default(array('useSeriesColor' => true));
			$pc->set_series_default(array('showMarker' =>false, 'pointLabels'=>array('location'=>'s', 'ypadding' =>2)));
			$pc->add_series(array('label'=>'Presupuesto'));
			$pc->add_series(array('label'=>'Ventas'));
			$pc->set_cursor(array('tooltipLocation'=>'sw', 'zoom'=>true, 'looseZoom'=>true));
			if($semanal_mensual == 'Semanal')
			{
				$min = min($semanas);
				$max = max($semanas);
				$pc->set_axes(array(
					'xaxis'=>array('label'=>'Semanas','min'=>floatval($min),'tickInterval'=>'1','max'=>floatval($max),'autoscale'=>true,'pad'=>1.0),
					'yaxis'=>array('label'=>'Monto','min'=>0,'autoscale'=>true,'pad'=>1.0)
				));
			}
			else
			{
				$min = min($meses);
				$max = max($meses);
				$pc->set_axes(array(
					'xaxis'=>array('label'=>'Meses','min'=>floatval($min),'tickInterval'=>'1','max'=>floatval($max),'autoscale'=>true,'pad'=>1.0),
					'yaxis'=>array('label'=>'Monto','min'=>0,'autoscale'=>true,'pad'=>1.0)
				));
			}
			$pc->set_legend(array('show'=>true,'location'=>'e','placement'=>'outside'));
			$pc->draw(1100,600);
			$resultado_lineas="";
			$total_semanal_estimado = 0;
			$total_semanal_presupuesto = 0;
			$total_mensual_estimado = 0;
			$total_mensual_presupuesto = 0;
			$semana_anterior = 0;
			$semana_actual = 0;
			$mes_anterior = 0;
			$mes_actual = 0;
			$usuario_actual = "";
			$usuario_anterior = "";
			$total_estimado=0;
			$total_presupuesto=0;
			$rel = "";
			$mes = "";
			$registrosB = array();
			$registrosM = array();
			$rels2 = array();
			$mess2 = array();
			$ventas = array();
			$registros = array();
			$presupuestos = array();
			$i=0;
			$continua="";
			if($semanal_mensual == 'Semanal')
			{}
			else
			{
				$query9 = "DROP TABLE temp3;";
				$result9 = $db->query($query9, true, 'Error selecting the user record');
			}
			if($semanal_mensual == 'Semanal')
			{
				$query3 = "SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, SUM(b.Estimado) AS Estimado, b.Mes, b.Semanas FROM users a, temp1 b
WHERE a.id = b.Relacionador
GROUP BY b.Relacionador, b.Semanas
ORDER BY Semanas+0 ASC";
				$result3 = $db->query($query3, true, 'Error selecting the user record');
				
				$query4 = "SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, SUM(b.Presupuesto) AS Presupuesto, b.Mes, b.Semanas FROM users a, temp2 b
WHERE a.id = b.Relacionador
GROUP BY b.Relacionador, b.Semanas
ORDER BY Semanas+0 ASC";
				$result4 = $db->query($query4, true, 'Error selecting the user record');
			}
			else
			{
				$query3 = "CREATE TEMPORARY TABLE temp3
SELECT a.id AS Relacionador, b.Estimado AS Estimado, c.Presupuesto AS Presupuesto, b.Semanas AS Semanas, b.Mes AS Mes
FROM users a, temp1 b, temp2 c
WHERE a.id = b.Relacionador
AND a.id = c.Relacionador
AND b.Relacionador = c.Relacionador
AND b.Mes = c.Mes
GROUP BY Relacionador, Mes";
				$result3 = $db->query($query3, true, 'Error selecting the user record');
				
				$query4 = "SELECT Relacionador, Estimado, Presupuesto, Semanas, Mes, Probabilidad
FROM (
    (SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, SUM(b.Estimado) AS Estimado, SUM(b.Presupuesto) AS Presupuesto, b.Semanas AS Semanas, b.Mes AS Mes, ((b.Estimado*100)/b.Presupuesto) AS Probabilidad
	FROM users a, temp3 b
	WHERE a.id = b.Relacionador
	GROUP BY Relacionador, Mes)
	UNION ALL
	(SELECT CONCAT(a.first_name,' ',a.last_name) AS Relacionador, 0 AS Estimado, SUM(d.Presupuesto) AS Presupuesto, d.Semanas AS Semanas, d.Mes AS Mes, ((0*100)/d.Presupuesto) AS Probabilidad
	FROM users a, temp2 d
	WHERE a.id = d.Relacionador
	GROUP BY Relacionador, Mes)
	ORDER BY Mes+0 ASC, Estimado DESC
) t
GROUP BY Relacionador, Mes
ORDER BY Mes+0 ASC, Estimado DESC";
				$result4 = $db->query($query4, true, 'Error selecting the user record');
			}
			$resultado_lineas.="<table width='100%' border='0' cellspacing='0' cellpaddig='0' class='edit view'>
					<tr>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Relacionador</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Mes</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Semana</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Estimado</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Presupuesto</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;' align='center'>Porcentaje de Cumplimiento</td>
					</tr>";
			setlocale(LC_MONETARY, 'en_US');
			$mes="";
			if($semanal_mensual == 'Semanal')
			{
				while($row=$db->fetchByAssoc($result3))
				{
					$ventas[$i] = $row;
					$i++;
				}
				$i=0;
				while($row=$db->fetchByAssoc($result4))
				{
					if($row['Mes'] == 1)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 1);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 2);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 3);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 4);
						$i = $i + 4;
					}
					if($row['Mes'] == 2)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 5);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 6);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 7);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 8);
						$i = $i + 4;
					}
					if($row['Mes'] == 3)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 9);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 10);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 11);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 12);
						$i = $i + 4;
					}
					if($row['Mes'] == 4)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 13);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 14);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 15);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 16);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 17);
						$i = $i + 5;
					}
					if($row['Mes'] == 5)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 18);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 19);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 20);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 21);
						$i = $i + 4;
					}
					if($row['Mes'] == 6)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 22);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 23);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 24);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 25);
						$i = $i + 4;
					}
					if($row['Mes'] == 7)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 26);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 27);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 28);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 29);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 30);
						$i = $i + 5;
					}
					if($row['Mes'] == 8)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 31);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 32);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 33);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 34);
						$i = $i + 4;
					}
					if($row['Mes'] == 9)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 35);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 36);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 37);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 38);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 39);
						$i = $i + 5;
					}
					if($row['Mes'] == 10)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 40);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 41);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 42);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 43);
						$i = $i + 4;
					}
					if($row['Mes'] == 11)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 44);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 45);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 46);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 47);
						$i = $i + 4;
					}
					if($row['Mes'] == 12)
					{
						$presupuestos[$i] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 48);
						$presupuestos[$i+1] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 49);
						$presupuestos[$i+2] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 50);
						$presupuestos[$i+3] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 51);
						$presupuestos[$i+4] = array('Relacionador' => $row['Relacionador'], 'Presupuesto' => $row['Presupuesto'], 'Mes' => $row['Mes'], 'Semanas' => 52);
						$i = $i + 5;
					}
				}
				usort($presupuestos, "cmp");
				$i=0;
				foreach($presupuestos as $presupuesto)
				{
					$igual=0;
					foreach($ventas as $venta)
					{
						if($venta['Semanas'] == $presupuesto['Semanas'] && $venta['Relacionador'] == $presupuesto['Relacionador'])
						{
							$igual=1;
							if($presupuesto['Presupuesto'] != '0.0000000000')
								$probabilidad  = (($venta['Estimado']*100)/$presupuesto['Presupuesto']);
							else
								$probabilidad = 0;
							$registros[$i] = array('Relacionador' => $venta['Relacionador'], 'Estimado' => $venta['Estimado'], 'Presupuesto' => $presupuesto['Presupuesto'], 'Mes' => $venta['Mes'], 'Semanas' => $venta['Semanas'], 'Probabilidad' => $probabilidad);
						}
					}
					if($igual == 1)
					{}
					else
					{
						$registros[$i] = array('Relacionador' => $presupuesto['Relacionador'], 'Estimado' => '0', 'Presupuesto' => $presupuesto['Presupuesto'], 'Mes' => $presupuesto['Mes'], 'Semanas' => $presupuesto['Semanas'], 'Probabilidad' => '0');
					}
					$i++;
				}
			}
			else
			{
				$i=0;
				while($row=$db->fetchByAssoc($result4))
				{
					$registros[$i] = $row;
					$i++;
				}
			}
			$i=0;
			foreach($registros as $row)
			{
				if($semanal_mensual == 'Semanal')
				{
					if($tipo == 'Individual')
					{
						if(isset($registros[$i+1]['Semanas']) && isset($registros[$i+1]['Relacionador']))
						{
							if($registros[$i]['Semanas'] == $registros[$i+1]['Semanas'] && $registros[$i]['Relacionador'] == $registros[$i+1]['Relacionador'])
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
									$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
								}
							}
							else
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
									$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
									$estimado = money_format('%.2n', $total_semanal_estimado);
									$presupuesto = money_format('%.2n', $total_semanal_presupuesto);
									$prob_partes = explode('.',$registros[$i]['Probabilidad']);
							
									if($registros[$i]['Mes'] == '1')
									{
										$mes = 'Enero';
									}
									if($registros[$i]['Mes'] == '2')
									{
										$mes = 'Febrero';
									}
									if($registros[$i]['Mes'] == '3')
									{
										$mes = 'Marzo';
									}
									if($registros[$i]['Mes'] == '4')
									{
										$mes = 'Abril';
									}
									if($registros[$i]['Mes'] == '5')
									{
										$mes = 'Mayo';
									}
									if($registros[$i]['Mes'] == '6')
									{
										$mes = 'Junio';
									}
									if($registros[$i]['Mes'] == '7')
									{
										$mes = 'Julio';
									}
									if($registros[$i]['Mes'] == '8')
									{
										$mes = 'Agosto';
									}
									if($registros[$i]['Mes'] == '9')
									{
										$mes = 'Septiembre';
									}
									if($registros[$i]['Mes'] == '10')
									{
										$mes = 'Octubre';
									}
									if($registros[$i]['Mes'] == '11')
									{
										$mes = 'Noviembre';
									}
									if($registros[$i]['Mes'] == '12')
									{
										$mes = 'Diciembre';
									}

									$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$registros[$i]['Relacionador']."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
									$total_presupuesto = $total_presupuesto + $total_semanal_presupuesto;
									$total_estimado = $total_estimado + $total_semanal_estimado;
									$total_semanal_presupuesto = 0;
									$total_semanal_estimado = 0;
								}
							}
						}
						else
						{
							$continua=1;
							$rel = $registros[$i]['Relacionador'];
							$mes = $registros[$i]['Semanas'];
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
							{
								$continua = 0;
							}
							if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$rels[$rel] = $rel;
								$mess[$mes] = $mes;
								$registrosB[$rel][$mes] = $rel.'_'.$mes;
							}
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$registrosM[$rel][$mes] = $rel.'_'.$mes;
								foreach($registrosB as $rows)
								{
									foreach($rows as $value)
									{
										if($value == $rel.'_'.$mes)
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
								$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
								$estimado = money_format('%.2n', $total_semanal_estimado);
								$presupuesto = money_format('%.2n', $total_semanal_presupuesto);
								$prob_partes = explode('.',$registros[$i]['Probabilidad']);
						
								if($registros[$i]['Mes'] == '1')
								{
									$mes = 'Enero';
								}
								if($registros[$i]['Mes'] == '2')
								{
									$mes = 'Febrero';
								}
								if($registros[$i]['Mes'] == '3')
								{
									$mes = 'Marzo';
								}
								if($registros[$i]['Mes'] == '4')
								{
									$mes = 'Abril';
								}
								if($registros[$i]['Mes'] == '5')
								{
									$mes = 'Mayo';
								}
								if($registros[$i]['Mes'] == '6')
								{
									$mes = 'Junio';
								}
								if($registros[$i]['Mes'] == '7')
								{
									$mes = 'Julio';
								}
								if($registros[$i]['Mes'] == '8')
								{
									$mes = 'Agosto';
								}
								if($registros[$i]['Mes'] == '9')
								{
									$mes = 'Septiembre';
								}
								if($registros[$i]['Mes'] == '10')
								{
									$mes = 'Octubre';
								}
								if($registros[$i]['Mes'] == '11')
								{
									$mes = 'Noviembre';
								}
								if($registros[$i]['Mes'] == '12')
								{
									$mes = 'Diciembre';
								}

								$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$registros[$i]['Relacionador']."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
													<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado."</td>
													<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
								$total_presupuesto = $total_presupuesto + $total_semanal_presupuesto;
								$total_estimado = $total_estimado + $total_semanal_estimado;
								$total_semanal_presupuesto = 0;
								$total_semanal_estimado = 0;
							}
						}
					}
					else
					{
						if(isset($registros[$i+1]['Semanas']) && isset($registros[$i+1]['Relacionador']))
						{
							if($registros[$i]['Semanas'] == $registros[$i+1]['Semanas'] && $registros[$i]['Relacionador'] == $registros[$i+1]['Relacionador'])
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_presupuesto = $total_semanal_presupuesto + $registros[$i]['Presupuesto'];
									$total_semanal_estimado = $total_semanal_estimado + $registros[$i]['Estimado'];
								}
							}
							else
							{	
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Semanas'];
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_semanal_estimado = $total_semanal_estimado + $row['Estimado'];
									$total_semanal_presupuesto = $total_semanal_presupuesto + $row['Presupuesto'];
									$estimado_formato = money_format('%.2n', $total_semanal_estimado);
									$presupuesto_formato = money_format('%.2n', $total_semanal_presupuesto);		
									$total_estimado	= $total_semanal_estimado;
									$total_presupuesto = $total_semanal_presupuesto;							
									$prob_partes = (($total_semanal_estimado*100)/$total_semanal_presupuesto);
									$prob_partes = explode(".",$prob_partes);
									
									if($registros[$i]['Mes'] == '1')
									{
										$mes = 'Enero';
									}
									if($registros[$i]['Mes'] == '2')
									{
										$mes = 'Febrero';
									}
									if($registros[$i]['Mes'] == '3')
									{
										$mes = 'Marzo';
									}
									if($registros[$i]['Mes'] == '4')
									{
										$mes = 'Abril';
									}
									if($registros[$i]['Mes'] == '5')
									{
										$mes = 'Mayo';
									}
									if($registros[$i]['Mes'] == '6')
									{
										$mes = 'Junio';
									}
									if($registros[$i]['Mes'] == '7')
									{
										$mes = 'Julio';
									}
									if($registros[$i]['Mes'] == '8')
									{
										$mes = 'Agosto';
									}
									if($registros[$i]['Mes'] == '9')
									{
										$mes = 'Septiembre';
									}
									if($registros[$i]['Mes'] == '10')
									{
										$mes = 'Octubre';
									}
									if($registros[$i]['Mes'] == '11')
									{
										$mes = 'Noviembre';
									}
									if($registros[$i]['Mes'] == '12')
									{
										$mes = 'Diciembre';
									}

									$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$row['Relacionador']."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado_formato."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto_formato."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
								}
							}
						}
						else
						{	
							$continua=1;
							$rel = $registros[$i]['Relacionador'];
							$mes = $registros[$i]['Semanas'];
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] == '0.0000000000')
							{
								$continua = 0;
							}
							if($registros[$i]['Estimado'] != '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$rels[$rel] = $rel;
								$mess[$mes] = $mes;
								$registrosB[$rel][$mes] = $rel.'_'.$mes;
							}
							if($registros[$i]['Estimado'] == '0' && $registros[$i]['Presupuesto'] != '0.0000000000')
							{
								$registrosM[$rel][$mes] = $rel.'_'.$mes;
								foreach($registrosB as $rows)
								{
									foreach($rows as $value)
									{
										if($value == $rel.'_'.$mes)
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$total_semanal_estimado = $total_semanal_estimado + $row['Estimado'];
								$total_semanal_presupuesto = $total_semanal_presupuesto + $row['Presupuesto'];
								$estimado_formato = money_format('%.2n', $total_semanal_estimado);
								$presupuesto_formato = money_format('%.2n', $total_semanal_presupuesto);		
								$total_estimado	= $total_semanal_estimado;
								$total_presupuesto	= $total_semanal_presupuesto;							
								$prob_partes = (($total_semanal_estimado*100)/$total_semanal_presupuesto);
								$prob_partes = explode(".",$prob_partes);
								
								if($registros[$i]['Mes'] == '1')
								{
									$mes = 'Enero';
								}
								if($registros[$i]['Mes'] == '2')
								{
									$mes = 'Febrero';
								}
								if($registros[$i]['Mes'] == '3')
								{
									$mes = 'Marzo';
								}
								if($registros[$i]['Mes'] == '4')
								{
									$mes = 'Abril';
								}
								if($registros[$i]['Mes'] == '5')
								{
									$mes = 'Mayo';
								}
								if($registros[$i]['Mes'] == '6')
								{
									$mes = 'Junio';
								}
								if($registros[$i]['Mes'] == '7')
								{
									$mes = 'Julio';
								}
								if($registros[$i]['Mes'] == '8')
								{
									$mes = 'Agosto';
								}
								if($registros[$i]['Mes'] == '9')
								{
									$mes = 'Septiembre';
								}
								if($registros[$i]['Mes'] == '10')
								{
									$mes = 'Octubre';
								}
								if($registros[$i]['Mes'] == '11')
								{
									$mes = 'Noviembre';
								}
								if($registros[$i]['Mes'] == '12')
								{
									$mes = 'Diciembre';
								}

								$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$row['Relacionador']."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
													<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado_formato."</td>
													<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto_formato."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
							}
						}
					}
					$i++;
				}
				else
				{
					if($tipo == 'Individual')
					{
						if(isset($registros[$i+1]['Mes']) && isset($registros[$i+1]['Relacionador']))
						{
							if($registros[$i]['Mes'] == $registros[$i+1]['Mes'] && $registros[$i]['Relacionador'] == $registros[$i+1]['Relacionador'])
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Mes'];
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$rels2[$rel] = $rel;
									$mess2[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
								}
							}
							else
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Mes'];
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$rels2[$rel] = $rel;
									$mess2[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
									$estimado = money_format('%.2n', $total_mensual_estimado);
									$presupuesto = money_format('%.2n', $total_mensual_presupuesto);
									$prob_partes = explode('.',$registros[$i]['Probabilidad']);
								
									if($registros[$i]['Mes'] == '1')
									{
										$mes = 'Enero';
									}
									if($registros[$i]['Mes'] == '2')
									{
										$mes = 'Febrero';
									}
									if($registros[$i]['Mes'] == '3')
									{
										$mes = 'Marzo';
									}
									if($registros[$i]['Mes'] == '4')
									{
										$mes = 'Abril';
									}
									if($registros[$i]['Mes'] == '5')
									{
										$mes = 'Mayo';
									}
									if($registros[$i]['Mes'] == '6')
									{
										$mes = 'Junio';
									}
									if($registros[$i]['Mes'] == '7')
									{
										$mes = 'Julio';
									}
									if($registros[$i]['Mes'] == '8')
									{
										$mes = 'Agosto';
									}
									if($registros[$i]['Mes'] == '9')
									{
										$mes = 'Septiembre';
									}
									if($registros[$i]['Mes'] == '10')
									{
										$mes = 'Octubre';
									}
									if($registros[$i]['Mes'] == '11')
									{
										$mes = 'Noviembre';
									}
									if($registros[$i]['Mes'] == '12')
									{
										$mes = 'Diciembre';
									}

									$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$registros[$i]['Relacionador']."</td>
															<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
															<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
															<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado."</td>
															<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto."</td>
															<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
									$total_presupuesto = $total_presupuesto + $total_mensual_presupuesto;
									$total_estimado = $total_estimado + $total_mensual_estimado;
									$total_mensual_estimado = 0;
									$total_mensual_presupuesto = 0;
								}
							}
						}
						else
						{
							$continua=1;
							$rel = $registros[$i]['Relacionador'];
							$mes = $registros[$i]['Mes'];
							if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
							{
								$continua = 0;
							}
							if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
							{
								$rels2[$rel] = $rel;
								$mess2[$mes] = $mes;
								$registrosB[$rel][$mes] = $rel.'_'.$mes;
							}
							if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
							{
								$registrosM[$rel][$mes] = $rel.'_'.$mes;
								foreach($registrosB as $rows)
								{
									foreach($rows as $value)
									{
										if($value == $rel.'_'.$mes)
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
								$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
								$estimado = money_format('%.2n', $total_mensual_estimado);
								$presupuesto = money_format('%.2n', $total_mensual_presupuesto);
								$prob_partes = explode('.',$registros[$i]['Probabilidad']);
							
								if($registros[$i]['Mes'] == '1')
								{
									$mes = 'Enero';
								}
								if($registros[$i]['Mes'] == '2')
								{
									$mes = 'Febrero';
								}
								if($registros[$i]['Mes'] == '3')
								{
									$mes = 'Marzo';
								}
								if($registros[$i]['Mes'] == '4')
								{
									$mes = 'Abril';
								}
								if($registros[$i]['Mes'] == '5')
								{
									$mes = 'Mayo';
								}
								if($registros[$i]['Mes'] == '6')
								{
									$mes = 'Junio';
								}
								if($registros[$i]['Mes'] == '7')
								{
									$mes = 'Julio';
								}
								if($registros[$i]['Mes'] == '8')
								{
									$mes = 'Agosto';
								}
								if($registros[$i]['Mes'] == '9')
								{
									$mes = 'Septiembre';
								}
								if($registros[$i]['Mes'] == '10')
								{
									$mes = 'Octubre';
								}
								if($registros[$i]['Mes'] == '11')
								{
									$mes = 'Noviembre';
								}
								if($registros[$i]['Mes'] == '12')
								{
									$mes = 'Diciembre';
								}

								$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$registros[$i]['Relacionador']."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
								$total_presupuesto = $total_presupuesto + $total_mensual_presupuesto;
								$total_estimado = $total_estimado + $total_mensual_estimado;
								$total_mensual_estimado = 0;
								$total_mensual_presupuesto = 0;
							}
						}
					}
					else
					{
						if(isset($registros[$i+1]['Mes']) && isset($registros[$i+1]['Relacionador']))
						{
							if($registros[$i]['Mes'] == $registros[$i+1]['Mes'] && $registros[$i]['Relacionador'] == $registros[$i+1]['Relacionador'])
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Mes'];
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
								}
							}
							else
							{
								$continua=1;
								$rel = $registros[$i]['Relacionador'];
								$mes = $registros[$i]['Mes'];
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
								{
									$continua = 0;
								}
								if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$rels[$rel] = $rel;
									$mess[$mes] = $mes;
									$registrosB[$rel][$mes] = $rel.'_'.$mes;
								}
								if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
								{
									$registrosM[$rel][$mes] = $rel.'_'.$mes;
									foreach($registrosB as $rows)
									{
										foreach($rows as $value)
										{
											if($value == $rel.'_'.$mes)
											{
												$continua = 0;
											}
										}
									}
								}
								if($continua == 1)
								{
									$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
									$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
									$estimado_formato = money_format('%.2n', $total_mensual_estimado);
									$presupuesto_formato = money_format('%.2n', $total_mensual_presupuesto);
									$total_estimado	= $total_mensual_estimado;
									$total_presupuesto = $total_mensual_presupuesto;
									$prob_partes = (($total_mensual_estimado*100)/$total_mensual_presupuesto);
									$prob_partes = explode(".",$prob_partes);
									
									if($registros[$i]['Mes'] == '1')
									{
										$mes = 'Enero';
									}
									if($registros[$i]['Mes'] == '2')
									{
										$mes = 'Febrero';
									}
									if($registros[$i]['Mes'] == '3')
									{
										$mes = 'Marzo';
									}
									if($registros[$i]['Mes'] == '4')
									{
										$mes = 'Abril';
									}
									if($registros[$i]['Mes'] == '5')
									{
										$mes = 'Mayo';
									}
									if($registros[$i]['Mes'] == '6')
									{
										$mes = 'Junio';
									}
									if($registros[$i]['Mes'] == '7')
									{
										$mes = 'Julio';
									}
									if($registros[$i]['Mes'] == '8')
									{
										$mes = 'Agosto';
									}
									if($registros[$i]['Mes'] == '9')
									{
										$mes = 'Septiembre';
									}
									if($registros[$i]['Mes'] == '10')
									{
										$mes = 'Octubre';
									}
									if($registros[$i]['Mes'] == '11')
									{
										$mes = 'Noviembre';
									}
									if($registros[$i]['Mes'] == '12')
									{
										$mes = 'Diciembre';
									}

									$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$row['Relacionador']."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado_formato."</td>
														<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto_formato."</td>
														<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
								}
							}
						}
						else
						{
							$continua=1;
							$rel = $registros[$i]['Relacionador'];
							$mes = $registros[$i]['Mes'];
							if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] == '0.000000')
							{
								$continua = 0;
							}
							if($registros[$i]['Estimado'] != '' && $registros[$i]['Presupuesto'] != '0.000000')
							{
								$rels[$rel] = $rel;
								$mess[$mes] = $mes;
								$registrosB[$rel][$mes] = $rel.'_'.$mes;
							}
							if($registros[$i]['Estimado'] == '' && $registros[$i]['Presupuesto'] != '0.000000')
							{
								$registrosM[$rel][$mes] = $rel.'_'.$mes;
								foreach($registrosB as $rows)
								{
									foreach($rows as $value)
									{
										if($value == $rel.'_'.$mes)
										{
											$continua = 0;
										}
									}
								}
							}
							if($continua == 1)
							{
								$total_mensual_estimado = $total_mensual_estimado + $registros[$i]['Estimado'];
								$total_mensual_presupuesto = $total_mensual_presupuesto + $registros[$i]['Presupuesto'];
								$estimado_formato = money_format('%.2n', $total_mensual_estimado);
								$presupuesto_formato = money_format('%.2n', $total_mensual_presupuesto);
								$total_estimado	= $total_mensual_estimado;
								$total_presupuesto	= $total_mensual_presupuesto;
								$prob_partes = (($total_mensual_estimado*100)/$total_mensual_presupuesto);
								$prob_partes = explode(".",$prob_partes);
								
								if($registros[$i]['Mes'] == '1')
								{
									$mes = 'Enero';
								}
								if($registros[$i]['Mes'] == '2')
								{
									$mes = 'Febrero';
								}
								if($registros[$i]['Mes'] == '3')
								{
									$mes = 'Marzo';
								}
								if($registros[$i]['Mes'] == '4')
								{
									$mes = 'Abril';
								}
								if($registros[$i]['Mes'] == '5')
								{
									$mes = 'Mayo';
								}
								if($registros[$i]['Mes'] == '6')
								{
									$mes = 'Junio';
								}
								if($registros[$i]['Mes'] == '7')
								{
									$mes = 'Julio';
								}
								if($registros[$i]['Mes'] == '8')
								{
									$mes = 'Agosto';
								}
								if($registros[$i]['Mes'] == '9')
								{
									$mes = 'Septiembre';
								}
								if($registros[$i]['Mes'] == '10')
								{
									$mes = 'Octubre';
								}
								if($registros[$i]['Mes'] == '11')
								{
									$mes = 'Noviembre';
								}
								if($registros[$i]['Mes'] == '12')
								{
									$mes = 'Diciembre';
								}

								$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'>".$row['Relacionador']."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$mes."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$registros[$i]['Semanas']."</td>
													<td style='border:1px solid; border-color: #eee;' align='right'>".$estimado_formato."</td>
													<td style='border:1px solid; border-color: #eee;' align='right'>".$presupuesto_formato."</td>
													<td style='border:1px solid; border-color: #eee;' align='center'>".$prob_partes[0]."%</td></tr>";
							}
						}
					}
					$i++;
				}
			}
			$total_prob_cumplida = (($total_estimado*100)/$total_presupuesto);
			$total_prob_cumplida_partes = explode('.',$total_prob_cumplida);
			$total_estimado = money_format('%.2n', $total_estimado);
			$total_presupuesto = money_format('%.2n', $total_presupuesto);
			$resultado_lineas.="<tr><td style='border:1px solid; border-color: #eee;'><b>TOTAL</b></td>
										<td style='border:1px solid; border-color: #eee;' align='center'></td>
										<td style='border:1px solid; border-color: #eee;' align='center'></td>
										<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_estimado."</b></td>
										<td style='border:1px solid; border-color: #eee;' align='right'><b>".$total_presupuesto."</b></td>
										<td style='border:1px solid; border-color: #eee;' align='center'><b>".$total_prob_cumplida_partes[0]."%</b></td></tr></table>";
										
			if($semanal_mensual == 'Semanal')
			{
				$query7 = "DROP TABLE temp1;";
				$result7 = $db->query($query7, true, 'Error selecting the user record');
				$query8 = "DROP TABLE temp2;";
				$result8 = $db->query($query8, true, 'Error selecting the user record');
			}
			else
			{
				$query7 = "DROP TABLE temp1;";
				$result7 = $db->query($query7, true, 'Error selecting the user record');
				$query8 = "DROP TABLE temp2;";
				$result8 = $db->query($query8, true, 'Error selecting the user record');
				$query9 = "DROP TABLE temp3;";
				$result9 = $db->query($query9, true, 'Error selecting the user record');
			}
			
			echo $resultado_lineas;
		}
		if($nombre_reporte == 'Ranking de Clientes')
		{
			$detalle = $this->_tpl_vars['SQL_RESULT'];
			$total_ventas=0;
			$resultado_ranking.="<table width='100%' border='0' cellspacing='0' cellpaddig='0' class='edit view'>
					<tr>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Empresa</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Ventas</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Relacionador</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Direccion</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Telefono</td>
					<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Ciudad</td>
					</tr>";
			setlocale(LC_MONETARY, 'en_US');
			foreach($detalle as $colum)
			{
				$total_ventas = $total_ventas +  $colum['Ventas'];
				$valor = money_format('%.2n', $colum['Ventas']);
				$resultado_ranking.="<tr>
										<td style='border:1px solid; border-color: #eee;'>".$colum['Empresa']."</td>
										<td style='border:1px solid; border-color: #eee;'>".$valor."</td>
										<td style='border:1px solid; border-color: #eee;'>".$colum['Relacionador']."</td>
										<td style='border:1px solid; border-color: #eee;'>".$colum['Direccion']."</td>
										<td style='border:1px solid; border-color: #eee;'>".$colum['Telefono']."</td>
										<td style='border:1px solid; border-color: #eee;'>".$colum['Ciudad']."</td>
									</tr>";
			}
			$total_ventas = money_format('%.2n',$total_ventas);
			$resultado_ranking.="<tr>
									<td style='border:1px solid; border-color: #eee;'><b>Total</b></td>
									<td style='border:1px solid; border-color: #eee;'><b>".$total_ventas."</b></td>
									<td style='border:1px solid; border-color: #eee;'></td>
									<td style='border:1px solid; border-color: #eee;'></td>
									<td style='border:1px solid; border-color: #eee;'></td>
									<td style='border:1px solid; border-color: #eee;'></td>
								</tr>";
			$resultado_ranking.="</table>";
			echo $resultado_ranking;
		}
		if($nombre_reporte == 'Cuentas asignadas sin actividades')
		{
			$detalle = $this->_tpl_vars['SQL_RESULT'];
			$resultado_cuentas.="<table width='100%' border='0' cellspacing='0' cellpaddig='0' class='edit view'>
					<tr>
						<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Empresa</td>
						<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Fecha de Creacion</td>
						<td style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Fecha de Modificacion</td>
					</tr>";
			foreach($detalle as $colum)
			{
				$fecha_creacion = explode(' ',$colum['date_entered']);
				$fecha_modificacion = explode(' ',$colum['date_modified']);
				$resultado_cuentas.="<tr>
										<td style='border:1px solid; border-color: #eee;'>".$colum['Empresa']."</td>
										<td style='border:1px solid; border-color: #eee;'>".$fecha_creacion[0]."</td>
										<td style='border:1px solid; border-color: #eee;'>".$fecha_modificacion[0]."</td>
									</tr>";
			}
			$resultado_cuentas.="</table>";
			echo $resultado_cuentas;
		}
	}
	if($nombre_reporte == 'Cumplimiento por producto' || $nombre_reporte == 'Cumplimiento por relacionador' || $nombre_reporte == 'Cumplimiento por mes')
	{
		$resultx.="<script type='text/javascript'>
			var produ = '".count($productos_graf)."';
			var relac = '".count($relacionadores_graf)."';
			var meses = '".count($mes_graf)."';
			if(produ == 1 || relac == 1 || meses == 1)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 2 || relac == 2 || meses == 2)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 3 || relac == 3 || meses == 3)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 4 || relac == 4 || meses == 4)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 5 || relac == 5 || meses == 5)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 6 || relac == 6 || meses == 6)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 7 || relac == 7 || meses == 7)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 8 || relac == 8 || meses == 8)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 9 || relac == 9 || meses == 9)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 10 || relac == 10 || meses == 10)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 11 || relac == 11 || meses == 11)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 12 || relac == 12 || meses == 12)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 13 || relac == 13 || meses == 13)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 14 || relac == 14 || meses == 14)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 15 || relac == 15 || meses == 15)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 16 || relac == 16 || meses == 16)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 17 || relac == 17 || meses == 17)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 18 || relac == 18 || meses == 18)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 19 || relac == 19 || meses == 19)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 20 || relac == 20 || meses == 20)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 21 || relac == 21 || meses == 21)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 22 || relac == 22 || meses == 22)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 23 || relac == 23 || meses == 23)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 24 || relac == 24 || meses == 24)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			if(produ == 25 || relac == 25 || meses == 25)
			{
				document.getElementById('tabla_links').style.marginTop ='85px';
			}
			document.getElementById('dataLabel').appendChild(document.getElementById('contenedor'));
								
			function envia(parametro)
			{
				var url = 'index.php?module=Opportunities&action=lista&parametro='+parametro;
				window.open(url, '_blank');
			}
			</script>";
		echo $resultx;
	}
	if($nombre_reporte == 'Pipeline de ventas')
	{
		$resultx2="";
		$resultx2.="<script type='text/javascript'>
			function envia_idopt(id)
			{
				var url = 'index.php?module=Opportunities&action=DetailView&record='+id;
				window.open(url, '_blank');
			}
			</script>";
		echo $resultx2;
	}
	
	function cmp($a, $b)
	{
		return $a["Semanas"] - $b["Semanas"];
	}
{/php}