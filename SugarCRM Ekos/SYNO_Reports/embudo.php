<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

	$_SESSION['arrego_pipe'] = array();
	//REEMPLAZA CARACTERES ESPECIALES EN EL QUERY  

	$sql_reemplaza = str_replace("&#039;","'",$_POST['query']); 
	$query1 = str_replace("&lt;br&gt;", " ",$sql_reemplaza); 
	$query = str_replace("&lt;", "<",$query1); 
	$query = str_replace("a.mes_c 0", "a.mes_c+0",$query);

	
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
	
	$contador1 = 0;
	$valor=0;
	$probabilidad=0;
	$sql_result = array();
	
	$db =  DBManagerFactory::getInstance();
	
	$resultSQL = $db->query($query, true, 'Error selecting the opportunity record');
		
	while($val = $db->fetchByAssoc($resultSQL, -1, false)) 
	{
		$sql_result[] = $val;
	}
		
	$detalle = $sql_result;
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

	$prospecto100 = number_format($suma100,2);
	$prospecto75 = number_format($suma75,2);
	$prospecto50 = number_format($suma50,2);
	$prospecto25 = number_format($suma25,2);
	$prospecto0 = number_format($suma0,2);
	
	$estimado100 = ($suma100*100)/100;
	$estimado75 = ($suma75*75)/100;
	$estimado50 = ($suma50*50)/100;
	$estimado25 = ($suma25*25)/100;
	$estimado0 = ($suma0*0)/100;     

	if($count0 > 0)
	{
		//$s1[$x]  =array('Oferta Rechazada(0%)',$count0,0,$prospecto0,money_format('%.2n',$estimado0));
		$s1[$x]  =array('Oferta Rechazada(0%)',$count0,0,$prospecto0,number_format($estimado0,2));
		$x++;
	}
	if($count25 > 0)			
	{
		//$s1[$x]  = array('Oferta presentada (25%)',$count25,25,$prospecto25,money_format('%.2n',$estimado25));
		$s1[$x]  =array('Oferta presentada(25%)',$count25,25,$prospecto25,number_format($estimado25,2));
		$x++;
	}
	if($count50 > 0)
	{
		//$s1[$x]  = array('Oferta en Proceso de Negociacion (50%)',$count50,50,$prospecto50,money_format('%.2n',$estimado50));
		$s1[$x]  =array('Oferta en Proceso de Negociacion (50%)',$count50,50,$prospecto50,number_format($estimado50,2));
		$x++;
	}
	if($count75 > 0)
	{
		//$s1[$x]  = array('Propuesta Enviada y Aceptada (75%)',$count75,75,$prospecto75,money_format('%.2n',$estimado75));
		$s1[$x]  = array('Propuesta Enviada y Aceptada (75%)',$count75,75,$prospecto75,number_format($estimado75,2));
		$x++;
	}
	if($count100 > 0) 
	{
		//$s1[$x] = array('Contrato Firmado o Factura enviada(100%)',$count100,100,$prospecto100,money_format('%.2n',$estimado100));
		$s1[$x] = array('Contrato Firmado o Factura enviada(100%)',$count100,100,$prospecto100,number_format($estimado100,2));				
		$x++;
	}
	echo json_encode($s1);

?>