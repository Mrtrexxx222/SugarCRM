<?php 
require_once('nusoap/lib/nusoap.php');
require_once('cliente.php');
require_once('soporte_obrea.php');

// Crear un cliente apuntando al script del servidor (Creado con WSDL)
//$serverURL = 'http://200.105.236.246:8081/integracion_campanias_digitales/';
$serverURL = 'http://localhost:8081/test';//debe ser la url de marathon
$serverScript = 'server.php';
$soporteWS = new SoporteWS();

// Crear un cliente de NuSOAP para el WebService
$cliente = new nusoap_client("$serverURL/$serverScript?wsdl", 'wsdl');
// Se pudo conectar?
$error = $cliente->getError();
if ($error)
{
	echo '<pre style="color: red">' . $error  . '</pre>';
	echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
	die();
}

$listado = '';
$objCliente = '';
// Existe el parametro "view" en la URL con la cual se esta llamando a este script?
if (false) 
{
	// Si => debo mostrar los datos del cliente
	$metodoALlamar = 'getCliente';
	$result = $cliente->call(
    	$metodoALlamar,                     				// Funcion a llamar
    	array("1"),    								// Parametros pasados a la funcion
    	"uri:$serverURL/$serverScript",                   	// namespace
    	"uri:$serverURL/$serverScript/$metodoALlamar"       // SOAPAction
	);
	// Verificacion que los parametros estan ok, y si lo estan. mostrar respuesta.
	if ($cliente->fault)
	{
    	echo '<b>Error: ';
    	print_r($result);
    	echo '</b>';
	} 
	else 
	{
    	$error = $cliente->getError();
    	if ($error) 
		{
        	echo '<b style="color: red">Error: ' . $error . '</b>';
		} 
		else 
		{
    		$objCliente = $soporteWS->convertirDeVectorDesdeWS($result, 'Cliente', '1');
		}
    }
} 
else 
{ 
	// No fue llamado con el parametro "view" en la URL => debo mostrar el listado de clientes
	$metodoALlamar = 'listarClientes';
	$result = $cliente->call(
    	$metodoALlamar,                     				// Funcion a llamar
    	array(),    										// Parametros pasados a la funcion
    	"uri:$serverURL/$serverScript",                   	// namespace
    	"uri:$serverURL/$serverScript/$metodoALlamar"       // SOAPAction
	);
	// Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
	if ($cliente->fault) 
	{
    	echo '<b>Error: ';
    	print_r($result);
    	echo '</b>';
	} 
	else 
	{
    	$error = $cliente->getError();
    	if ($error) 
		{
        	echo '<b style="color: red">Error: ' . $error . '</b>';
		} 
		else 
		{
    		$listado = $soporteWS->convertirDeVectorDesdeWS($result, 'Cliente', 'n');
		}
    }
}
// De aca en mas es la pagina HTML que muestra el listado de clientes o los datos de un cliente en particular (dependiendo
// si se llamo con view como parametro o no)
?>
<html>
<body>
	<?php if ($listado) { ?>
	<!-- Listado de todos los clientes -->
	<h1>Listado</h1>
	<table>
		<tr><td>Nombre</td><td>Apellido</td><td>CUIT</td><td>Acciones</td></tr>
		<?php
			foreach ($listado as $objeto) {
				echo '<tr>';
				echo '<td>'.$objeto->nombre.'</td>';
				echo '<td>'.$objeto->apellido.'</td>';
				echo '<td>'.$objeto->cuit.'</td>';
				echo '<td><a href="nusoap_client_ej4_view.php?view=yes&id='.$objeto->id.'">Ver</a></td>';
				echo '</tr>';
			}
		?>
	</table>
	<?php } else { ?>
	<!-- Datos del cliente seleccionao -->
	<h1>Cliente</h1>
	<?php
		echo '<strong>ID:</strong> '.$objCliente->id.'<br/>';
		echo '<strong>Nombre:</strong> '.$objCliente->nombre.'<br/>';
		echo '<strong>Apellido:</strong> '.$objCliente->apellido.'<br/>';
		echo '<strong>CUIT:</strong> '.$objCliente->cuit.'<br/>';
	?>
	<?php } ?>
</body>
</html>