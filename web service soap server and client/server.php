<?php
require_once('nusoap/lib/nusoap.php');
require_once('cliente.php');
require_once('clienteDAO.php');
require_once('soporte_obrea.php');

$miURL = 'http://pruebas.orlandobrea.com.ar/nusoap';
$server = new soap_server();
$server->configureWSDL('ws_orlando', $miURL);
$server->wsdl->schemaTargetNamespace = $miURL;

$soporteWS = new SoporteWS(); // Creo una instancia del objeto propio (SoporteWS)

//--------Funciones usadas por el WS
function getCliente($id) 
{
	global $soporteWS;
	$dao = new ClienteDAO();
	$cliente = $dao->getCliente($id);
	$respuesta = $soporteWS->convertirAVectorParaWS($cliente);
	return new soapval('return', 'tns:Cliente', $respuesta);
}
function listarClientes() 
{
	$objSoporte = new SoporteWS();
	$dao = new ClienteDAO();
	$listado = $dao->getList();
	$respuesta = $objSoporte->convertirAVectorParaWS($listado);				  
	return new soapval('return', 'tns:listadoClientes', $respuesta);
}

//-------Definicion de las funciones y estructuras expuestas en el WS
$server->wsdl->addComplexType('Cliente',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'id' => array('name' => 'id', 'type' => 'xsd:int'),
		'nombre' => array('name' => 'nombre',	'type' => 'xsd:string'),
		'apellido' => array('name' => 'apellido', 'type' => 'xsd:string'),
		'cuit' => array('name' => 'CUIT',	'type' => 'xsd:string')
	)
);
$server->wsdl->addComplexType('listadoClientes',
	'complexType',
	'array',
	'',
	'',
	array (array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Cliente[]'))
);

$server->register('getCliente', 						// Nombre de la funcion
				   array('id' => 'xsd:int'), 			// Parametros de entrada
				   array('return' => 'tns:Cliente'), 	// Parametros de salida
				   $miURL
				 );
				 
$server->register('listarClientes', 							// Nombre de la funcion
				   array(), 									// Parametros de entrada
				   array('return' => 'tns:listadoClientes'), 	// Parametros de salida
				   $miURL
				 );
				 
// Las siguientes 2 lineas las aporto Ariel Navarrete. Gracias Ariel
if ( !isset( $HTTP_RAW_POST_DATA ))
    $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );

$server->service($HTTP_RAW_POST_DATA);
?>