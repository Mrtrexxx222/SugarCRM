function validafono(valor, tipo)
{
	 var cadena = valor;
	 //alert(cadena);
     new Request(
     {	
        method: 'post',
        url: 'validafono.php',
        onSuccess: function(responseText,responseXML){
			//alert(responseText);
			if(responseText)
			{
				if(responseText == "ph_failure_1")
				{
					alert('Longitud de telefono no valida \n Se requiere 9 numeros');
					document.getElementById('telefono').value = '';
				}
				else
				{
					if(responseText == "ph_failure_2")
					{
						alert('No se debe repetir el mismo numero 9 veces');
						document.getElementById('telefono').value = '';
					}
					else
					{
						if(responseText == "ph_failure_3")
						{
							alert('Solo se adimiten numeros');
							document.getElementById('telefono').value = '';
						}
						else
						{

							if(responseText == "cph_failure_1")
							{
								alert('Solo se podra ingresar numeros iniciados en 09');
								document.getElementById('celular').value = '';
							}
							else
							{
								if(responseText == "cph_failure_2")
								{
									alert('Longitud de celular no valida (total 10 numeros incluidos 09)');
									document.getElementById('celular').value = '';
								}
								else
								{
									if(responseText == "cph_failure_3")
									{
										alert('No se debe repetir el mismo numero 8 veces (despues de 09)');
										document.getElementById('celular').value = '';
									}
									else
									{
										if(responseText == "cph_failure_4")
										{
											alert('Solo se adimiten numeros');
											document.getElementById('celular').value = '';
										}
										else
										{
											//Todo Ok;
										}
									}

								
								}
							
							
							}


						
						}
					}
				}
			}
        },
        onFailure: function(responseText,responseXML){
            //alert(responseText);
            alert('Error en la aplicación');
        }	        
    
     }
     ).send('cadena='+cadena+'&tipo='+tipo);

}