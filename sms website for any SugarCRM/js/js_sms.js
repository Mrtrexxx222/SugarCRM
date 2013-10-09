$(document).ready(function() 
{
	//COMBO TIPO DE SMS
	$('#tipo_sms').change(function(){	
		if($(this).val()=='individual')
		{	
			window.location = "mensaje_individual.php";		
		}
		if($(this).val()=='grupal')
		{
			window.location = "mensaje_grupal.php";	
		}
	});
	//VALIDACION CSV
	$("#archivo").change(function() 
	{
		var val = $(this).val();
		switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
			case 'csv': case 'CSV':	
				$('#archivo').css("border-color","#999");
				break;
			default:
				$(this).css("border-color","red");	
				$(this).val('');
				// error message here 				
				alert("El archivo seleccionado no es valido, recuerde que el archivo debe tener la extencion (.csv)");				
				break;
		}
	});
	//COMBO TIPO REPORTE
	$('#tipo_reporte').change(function()
	{	
		if($(this).val()=='Rango_de_fechas')
		{	
			window.location = "reporte_fechas.php";		
		}
		if($(this).val()=='por_mes')
		{
			window.location = "reporte_meses.php";	
		}
	});	
	//EJECUCION DE REPORTE POR FECHAS AUTOMATICO
	if ($("#fecha_inicio,#fecha_fin").val() != '')
	{		
		$('#ejcutar').trigger('click');
	}
});

function ReturnText(fecha_inicio,fecha_fin)
{
	id_user = $('#id_user').val();
	fecha_inicio = fecha_inicio + ' 00:00:01';
	fecha_fin = fecha_fin + ' 23:59:59';
    if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
    }
    else
	{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
	{
        if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{ 
            /*here define what to be called asynch*/
            ajaxReturnText(xmlhttp.responseText); 
        }
    } 
    xmlhttp.open("GET","procesar_datos.php?tipo_reporte=rango_fechas&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&cont="+id_user,true);
    xmlhttp.send();
}

/*to be called asynch*/
function ajaxReturnText(input)
{
    var output = new Object();
    output.value = input; 
	document.getElementById('ver_reporte').innerHTML = input;
}

var fecha = '';
function ReturnText_r2(mes,anio)
{	
	id_user = $('#id_user').val();
	h_ini = '00:00:01';
	//h_fin = '23:59:59';
	
	fecha = anio+'-'+mes;
	
	fecha_inicio = anio+'-'+mes+'-01'+' '+h_ini;
	//fecha_fin = anio+'-'+mes+'-'+dia_fin+' '+h_fin;
    if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
    }
    else
	{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
	{
        if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{ 
            //here define what to be called asynch 
			var response = xmlhttp.responseText;
			var datos = response.split(":");	
			dia_fin = datos[0];
			resp = datos[1].substring(0,datos[1].length-1);				
			ajaxReturnText_r2(resp,dia_fin,datos[2]);
        }
    } 
    xmlhttp.open("GET","procesar_datos.php?tipo_reporte=por_mes&fecha_inicio="+fecha_inicio+"&fecha="+fecha+"&cont="+id_user,true);
    xmlhttp.send();
}

/*to be called asynch*/
function ajaxReturnText_r2(input,dia_fin,total_sms) //12_4,13_8,
{
	if(input.trim() == 'x')
	{		
		$('.imagen_reporte').hide();				
		$('#basic_chart').empty();			
		mensaje = '<div class="contenedor_tabla"><p><div align="center" style="color:#999;font:14px \'Capriola-Regular\';">No existe informaci&oacute;n que coincida con los parametros ingresados.</div></p></div>';
		document.getElementById('error_msj').innerHTML = mensaje;
	}
	else
	{		
		var datos = input.split(",");	
		var d_axis  = new Array();
		var d_chart = new Array();
		//Muestra el total de SMS enviados segun la consulta
		mensaje = '<br /><div align="left" style="color:#333;font:14px \'Capriola-Regular\';">Total SMS enviados: '+total_sms+' </div>';
		document.getElementById('total').innerHTML = mensaje;
		//RECORRO TODO EL ARRAR ENCERANDO LOS LOS VALORES DE LOS INDICES 
		for(i=0;i<dia_fin;i++)
		{
			if(i<10)
			{
				d_axis[i]=i+1;
				d_chart[i]=0;			
			}
			else
			{
				d_axis[i]=i+1;
				d_chart[i]=0;	
			}
		}	
		//INSERTO EL VALOR EN EL INDICE CORRESPONDIENTE
		for (var h in d_chart) 
		{	
			for (var i in datos) 
			{
				var sub_datos = datos[i].split("_");
				if(h == sub_datos[0].trim())
				{						
					d_chart[parseInt(sub_datos[0].trim())-1]= parseInt(sub_datos[1].trim());
				}			
			}	
		}
		grafico_barras(d_axis,d_chart);
	}	
}

/** GRAFICO BARRAS **/
function grafico_barras(axisDates,chartData)
{
	//var axisDates = ["Jan 19", "Jan 20", "Jan 21"]
	//var chartData = [2.61,5.00,6.00]
	$('#error_msj').empty();	
	$('.contenedor_tabla').show();
	$('#basic_chart').empty();	
	$.jqplot.config.enablePlugins = true;
		 var plot2 = $.jqplot('basic_chart', [chartData], {
			// Turns on animatino for all series in this plot.
			animate: true,
			// Will animate plot on calls to plot1.replot({resetAxes:true})
			animateReplot: true,
			title: 'Grafico de SMS enviados por dia.',
			 seriesDefaults:{
				 renderer: $.jqplot.BarRenderer,
				 rendererOptions: {
					barPadding: 1,
					barMargin: 15,
					barDirection: 'vertical',
					barWidth: 15,
					varyBarColor: true
				}, 
				pointLabels: { show: true }
			},
			axes: {
				xaxis: {                            
						renderer:  $.jqplot.CategoryAxisRenderer,
						ticks: axisDates
				},
				yaxis: {
					tickOptions: {
						formatString: '%.0f'
					}
				}
			},
			highlighter: {
				sizeAdjust: 7.5
			},
			cursor: {
				show: true
			}
		});
	$('#basic_chart').bind('jqplotDataHighlight',	function (ev, seriesIndex, pointIndex, data) {	
		$(this).css('cursor','pointer');
		/*
		margin=15;
		tempX = ev.pageX;
		tempY = ev.pageY;
		$('#info_pipe').css({'top': tempY+margin, 'left': tempX+margin});
		$('#info_pipe').css('display','block');
		return;	
		*/
	});
	$('#basic_chart').bind('jqplotDataUnhighlight',function (ev) {
		$(this).css('cursor','auto');  
		//$('#info_pipe').hide();
	});
	/** Drilldown **/
	$('#basic_chart').bind('jqplotDataClick',function (ev, seriesIndex, pointIndex, data) {					
		var fecha_e = '';
		var dia = parseInt(pointIndex+1);
		fecha_e = fecha+'-'+dia;
		//alert(fecha_e);
		window.location = 'reporte_fechas.php?cf='+fecha_e+'';	
	});
}
/** FIN GRAFICO BARRAS **/

function validar_correo()
{
	var elem_correo = $('#correo').val();
	var correo = elem_correo.trim();
	if(correo == '')
	{
		$('#correo').css("border-color","red");
		alert('El correo electronico es necesario para reiniciar su clave.');
	}
	else if(validar_email($("#correo").val()))
	{
		$('#correo').css("border-color","#999");
		document.forms['reseteo'].submit();
	}else
	{
		$('#correo').css("border-color","red");
		alert("Por favor ingrese una direccion de correo valida.");		
	}

}

function validar_email(valor)
{
	// creamos nuestra regla con expresiones regulares.
	var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	// utilizamos test para comprobar si el parametro valor cumple la regla
	if(filter.test(valor))
		return true;
	else
		return false;
}

function valida_pass()
{
	var nueva_clave = $('#nueva_clave').val();
	var confirma_clave = $('#confirma_clave').val();
	var b_nueva = 0;
	var b_confi = 0;
	var b_nueva2 = 0;
	var b_confi2 = 0;
	if(nueva_clave == '')
	{		
		$('#nueva_clave').css("border-color","red");
		var b_nueva = 1;
	}
	else
	{
		$('#nueva_clave').css("border-color","#999");
	}
	if(confirma_clave == '')
	{
		$('#confirma_clave').css("border-color","red");
		var b_confi = 1;
	}
	else
	{
		$('#confirma_clave').css("border-color","red");	
	}	
	if(nueva_clave.length >= 6)
	{
		$('#nueva_clave').css("border-color","#999");
	}
	else
	{
		$('#nueva_clave').css("border-color","red");
		var b_nueva2 = 1;
	}
	if(confirma_clave.length >= 6)
	{
		$('#confirma_clave').css("border-color","red");	
	}
	else
	{
		$('#confirma_clave').css("border-color","red");
		var b_confi2 = 1;
	}
	
	if(b_nueva == 1 && b_confi == 0)
	{
		alert('Debe especificar una nueva clave.');
	}
	else if(b_nueva == 0 && b_confi == 1)
	{
		alert('Debe confirmar su nueva clave.');
	}
	else if(b_nueva == 1 && b_confi == 1)
	{
		alert('Por favor ingrese la informacion requerida, recuerde que la clave debe tener como minimo 6 caracteres.1');
	}
	else 
	{
		if(b_nueva2 == 1 && b_confi2 == 0)
		{
			alert('Su clave debe tener mas de 6 digitos.');
		}
		else if(b_nueva2 == 0 && b_confi2 == 1)
		{
			alert('Su clave debe tener mas de 6 digitos.');
		}
		else if(b_nueva2 == 1 && b_confi2 == 1)
		{
			alert('Por favor ingrese la informacion requerida, recuerde que la clave debe tener como minimo 6 caracteres.2');
		}
		else 
		{
			if(nueva_clave == confirma_clave)
			{
				$('#nueva_clave').css("border-color","#999");
				$('#confirma_clave').css("border-color","#999");	
				document.forms['cambio'].submit();				
			}
			else
			{
				$('#nueva_clave').css("border-color","red");
				$('#confirma_clave').css("border-color","red");
				alert('Las claves no coinciden.');				
			}
		}
	}
	//
}

function reseteo_clave()
{	
	var form_login = document.forms['login'];
	var form_reset = document.forms['reseteo'];
	document.forms['reseteo'].reset();
	$('#alertas').hide();
	$(form_login).hide();
	$(form_reset).show();

}

function cancel_reset()
{
	var form_login = document.forms['login'];
	var form_reset = document.forms['reseteo'];
	document.forms['login'].reset();		
	$('#alertas').show();
	$(form_login).show();
	$(form_reset).hide();

}

function grupal_vacio()
{
	if($("#archivo").val() == '')
	{
		$('#archivo').css("border-color","red");	
		alert('No se encontro ningun archivo cargado.');		
	}
	else
	{
		$('#archivo').css("border-color","#999");	
		document.forms['env_gr'].submit();
	}
}

function contar_carateres(campo)
{
	var total_letras = 160;
	$(campo).attr("maxlength", 160);
	var longitud = $(campo).val().length;
	var resto = total_letras - longitud;
	$('#contador').val(resto);	
}

function fn_numeros(e) {
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8 || tecla==0) 
	{
		return true;
	}
    patron =/\d/; 
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
}

function vacios(){
	//destino,mensaje	
	var d = $('#destino').val();
	var m = $('#mensaje').val();
	var d2 = d.trim();
	var m2 = m.trim();	
	var vacio_d = 0;
	var vacio_m = 0;
	//validacion de los dos campos que no esten vacios
	if(d2 != "")
	{
		$('#destino').css("border-color","#999");
	}
	else
	{
		$('#destino').css("border-color","red");
		vacio_d = 1;		
	}
	if (m2 != "")
	{
		$('#mensaje').css("border-color","#999");
	}
	else
	{				
		$('#mensaje').css("border-color","red");	
		vacio_m = 1;
	}
	//validacion pra mostrar mensaje segun el caso
	if(d2.length == 12)
	{	
		$('#destino').css("border-color","#999");
		if(vacio_m == 1)
		{
			alert('Falta ingresar informacion para el envio.');
			$('#mensaje').css("border-color","red");	
		}
		else
		{
			if(vacio_m == 1)
			{
				alert('Falta ingresar informacion para el envio.');
				$('#mensaje').css("border-color","red");	
			}
			else
			{	
				//validar 593 y 0
				var digitos = d2.substring(4,-4);
				var cod_pais = digitos.substring(3,-3);
				var no_0 = digitos.substring(3);
				if(cod_pais == '593')
				{
					if(no_0 == '9')
					{
						$('#destino').css("border-color","#999");
						//envio el formulario por submit cuando todo ya esta correcto
						document.forms['env_in'].submit();
					}
					else
					{
						alert('El numero se encuentra incorrecto, recuerde que despues del 593 su numero debe tener el siguiente formato: 9xxxxxxxx.');
						$('#destino').css("border-color","red");
					}
				}
				else
				{
					alert('Los tres primeros digitos: '+cod_pais+' no coinciden con formato indicado(593).');
					$('#destino').css("border-color","red");
				}			
			}
		}
	}
	else
	{
		if(vacio_d == 1 && vacio_m == 0)
		{
			alert('Falta ingresar informacion para el envio.');
			$('#destino').css("border-color","red");	
		}
		else if(vacio_d == 0 && vacio_m == 1)
		{
			alert('El formato del numero esta incorrecto y falta ingresar informacion para el envio.');
			$('#destino').css("border-color","red");
			$('#mensaje').css("border-color","red");	
		}else if(vacio_d == 1 && vacio_m == 1)
		{
			alert('Falta ingresar informacion para el envio.');
			$('#destino').css("border-color","red");	
			$('#mensaje').css("border-color","red");	
		}else
		{
			alert('El formato del numero esta incorrecto.');
			$('#destino').css("border-color","red");				
		}
	}	
}