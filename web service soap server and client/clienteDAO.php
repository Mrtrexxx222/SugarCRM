<?php

class ClienteDAO
{
	/**
	 * getCliente($id) : Cliente
	 * Esta funcion deberia implementarse con una conexion a una base de datos
	 * y obtener la informacion de la base directamente
	 */
	function getCliente($id) 
	{
		$obj = new Cliente();
		if ($id==1) 
		{
			$obj->id = 1;
			$obj->nombre = 'Blas';
			$obj->apellido = 'Pascal';
			$obj->cuit = '11-11111111-1';
		}
		if ($id==2) 
		{
			$obj->id = 2;
			$obj->nombre = 'Isaac';
			$obj->apellido = 'Newton';
			$obj->cuit = '22-22222222-2';
		}		
		return $obj;
	}
	/**
	 * getList : Array
	 * Esta funcion retorna un listado de todos los clientes que estan en el sistema.
	 * @return 
	 */
	function getList() 
	{
		$rta = array();
		$rta[0] = $this->getCliente(1);
		$rta[1] = $this->getCliente(2);
		return $rta;
	}
}
?>