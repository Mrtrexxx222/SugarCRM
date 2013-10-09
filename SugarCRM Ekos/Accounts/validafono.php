<?php
$cadena = trim($_POST['cadena']);
$tipo = trim($_POST['tipo']);

if($tipo == "convencional")
{
			if(strlen($cadena) < 9 ||  strlen($cadena) > 9)
			{
				echo "ph_failure_1";
			}
			else
			{
				if(count(explode(1, $cadena)) - 1 == 9 || count(explode(2, $cadena)) - 1 == 9 || count(explode(3, $cadena)) - 1 == 9 || count(explode(4, $cadena)) - 1 == 9 || count(explode(5, $cadena)) - 1 == 9 || count(explode(6, $cadena)) - 1 == 9 || count(explode(7, $cadena)) - 1 == 9 || count(explode(8, $cadena)) - 1 == 9 || count(explode(9, $cadena)) - 1 == 9)
				  echo "ph_failure_2";
				else
					if(!is_numeric($cadena))
						echo "ph_failure_3";
					else
						echo "success";
			}
}

if($tipo == "celular")
{
			$checker = substr ($cadena , 0, 2);
			$number = substr($cadena,2,strlen($cadena));

			if($checker != "09")
			{
				echo "cph_failure_1";
			}
			else
			{
				if(strlen($number) < 8 ||  strlen($number) > 8)
				{
					echo "cph_failure_2";
				}
				else
				{
					if(count(explode(1, $number)) - 1 == 8 || count(explode(2, $number)) - 1 == 8 || count(explode(3, $number)) - 1 == 8 || count(explode(4, $number)) - 1 == 8 || count(explode(5, $number)) - 1 == 8 || count(explode(6, $number)) - 1 == 8 || count(explode(7, $number)) - 1 == 8 || count(explode(8, $number)) - 1 == 8 || count(explode(9, $number)) - 1 == 8)
					  echo "cph_failure_3";
					else
						    if(!is_numeric($number))
								echo "cph_failure_4";
							else
								echo "success";

				}
			}
}

?>