<?php 

class clase
{
    function funcion($bean, $event, $arguments)
	{	
		$db =  DBManagerFactory::getInstance();
		//1) buscar la campania con el ID de la cmapania que biene en el bean
		if($bean->fuente_c == 'ACTIVIDAD DIGITAL')
		{
			$id_inter_camp="";
			$query = "select id,name from M10_CD where id = '".$bean->id_campania_c."'";
			$result = $db->query($query, true, 'Error selecting the campaign record');
			if ($row=$db->fetchByAssoc($result))
			{
				//2) se debe crear un registro de una nueva interaccion en el modulo de interaccciones de camapanias digitales
				$fecha = date("Y-M-d H:i:s");
				$id_inter_camp = md5($this->create_guid());
				$query2 = "insert into M11_IC values('".$id_inter_camp."','".$row['name']."','".$fecha."','".$fecha."','1','1','','0','1','1','1')";
				$result2 = $db->query($query2, true, 'Error inserting the inter_camp record...');
				
				$query3 = "insert into M11_IC_CSTM values('".$id_inter_camp."','".$bean->tipo_registro_c."','".$bean->cupon_c."','".$bean->email1."')";
				$result3 = $db->query($query3, true, 'Error inserting the inter_camp_cstm record...');
				
				//3) se debe hacer la relacion entre el contacto y la interaccion en la tabla que corresponde
				$fecha = date("Y-M-d H:i:s");
				$rel_cont_inter_dig = md5($this->create_guid());
				$query4 = "insert into CONTACTS_M11_IC_1_C values('".$rel_cont_inter_dig."','".$fecha."','0','".$bean->id."','".$id_inter_camp."')";
				$result4 = $db->query($query4, true, 'Error inserting the reL_inter_cont_record...');
				 
				//4) se debe hacer la relacion entre la campania y la interaccion en la tabla que corresponde
				$rel_camp_inter_dig = md5($this->create_guid());
				$query5 = "insert into M10_CD_M11_IC_1_C values('".$rel_camp_inter_dig."','".$fecha."','0','".$bean->id_campania_c."','".$id_inter_camp."')";
				$result5 = $db->query($query5, true, 'Error inserting the reL_inter_camp record...');
				
				//busca el correo del contacto, si no lo encuentra lo crea y la relacion con el contacto tambien es creada
				$query6 = "SELECT EMAIL_ADDRESS FROM email_addresses WHERE EMAIL_ADDRESS = '".$bean->email1."'";
				$result6 = $db->query($query6, true, 'Error selecting the campaign record');
				if ($row6=$db->fetchByAssoc($result6))
				{
					//es el mismo correo, no se hace nada
				}
				else
				{
					//el correo que viene es nuevo, hay que agregarlo
					$id1 = md5($this->create_guid());
					$query7 = "INSERT INTO email_addresses (id,EMAIL_ADDRESS,EMAIL_ADDRESS_CAPS,INVALID_EMAIL,OPT_OUT,DATE_CREATED,DATE_MODIFIED,DELETED) VALUES('".$id1."','".$bean->email1."','".$bean->email1."','0','0','".$fecha."','".$fecha."','0')";
					$result7 = $db->query($query7, true, 'Error inserting the reL_inter_camp record...');
					
					//se crea la relación entre la tabla de correos y el contacto
					$id2 = md5($this->create_guid());
					$query8 = "INSERT INTO email_addr_bean_rel (id,EMAIL_ADDRESS_ID,BEAN_ID,BEAN_MODULE,PRIMARY_ADDRESS,REPLY_TO_ADDRESS,DATE_CREATED,DATE_MODIFIED,DELETED) VALUES('".$id2."','".$id1."','".$bean->id."','Contacts','1','0','','','0')";
					$result8 = $db->query($query8, true, 'Error inserting the reL_inter_camp record...');
				}
				
				if($bean->tiene_tarjeta_c == 'SI')
				{
					$tarjeta = $bean->tarjeta_credito_c;
					$emisora = $bean->emisora_tarjeta_c;
					$id_contacto = $bean->id;
					$tarjetas_y_emisoras = array();
					$i=0;
					$bandera_tarjeta = 0;
					$id_tarjeta="";

					$query = "select contacts_m4fc3arjetas_idb from contacts_m6_tarjetas_1_c where contacts_m936dontacts_ida = '".$id_contacto."'";
					$result = $db->query($query, true, 'Error selecting the campaign record');
					while($row=$db->fetchByAssoc($result))
					{
						//busca las relaciones del contacto con las tarjetas que tenga y arma un arreglo con los resultados encontrados
						$query2 = "select a.tarjeta_c, a.emisor_tarjeta_c, a.id_c from m6_tarjetas_cstm a, m6_tarjetas b where a.id_c = '".$row['contacts_m4fc3arjetas_idb']."' and a.id_c = b.id and b.deleted = '0'";
						$result2 = $db->query($query2, true, 'Error selecting the campaign record');
						if($row2=$db->fetchByAssoc($result2))
						{
							$tarjetas_y_emisoras[$i][0] = $row2['tarjeta_c'];
							$tarjetas_y_emisoras[$i][1] = $row2['emisor_tarjeta_c'];
							$tarjetas_y_emisoras[$i][2] = $row2['id_c'];
							$i++;
						}
					}
					
					//busca en el arreglo de tarjetas armado la tarjeta y emisor que viene en el registro
					foreach($tarjetas_y_emisoras as $res)
					{
						if($res[0] == $tarjeta && $res[1] == $emisora)
						{
							//ya tiene esta tarjeta con la emisora
							$bandera_tarjeta = 1;
							$id_tarjeta = $res[2];
						}
					}
					
					if($bandera_tarjeta == 1)
					{
						//actualiza la fecha de modificacion
						$fecha = date("Y-M-d H:i:s");
						$name_tarjeta = str_replace("_"," ",$tarjeta);
						$name_emisora = str_replace("_"," ",$emisora);
						$name = $name_tarjeta." - ".$name_emisora;
						$query3 = "UPDATE M6_TARJETAS SET DATE_MODIFIED = '".$fecha."', DESCRIPTION = '".$name."' where id = '".$id_tarjeta."'";
						$result3 = $db->query($query3, true, 'Error updating the tarjeta record...');
					}
					else
					{
						//ingresa un nuevo registro de tarjeta
						$id_tarjeta = md5($this->create_guid());
						$name_tarjeta = str_replace("_"," ",$tarjeta);
						$name_emisora = str_replace("_"," ",$emisora);
						$name = $name_tarjeta." - ".$name_emisora;
						$fecha = date("Y-M-d H:i:s");
						$query3 = "INSERT INTO M6_TARJETAS(ID,NAME,DATE_ENTERED,DATE_MODIFIED,MODIFIED_USER_ID,CREATED_BY,DESCRIPTION,DELETED,TEAM_ID,TEAM_SET_ID,ASSIGNED_USER_ID) VALUES('".$id_tarjeta."','".$name."','".$fecha."','".$fecha."','1','1','".$name."','0','1','1','1')";
						$result3 = $db->query($query3, true, 'Error inserting the tarjeta record...');
						
						$query4 = "INSERT INTO M6_TARJETAS_CSTM(ID_C,TARJETA_C,EMISOR_TARJETA_C) VALUES('".$id_tarjeta."','".$tarjeta."','".$emisora."')";
						$result4 = $db->query($query4, true, 'Error inserting the tarjeta_cstm record...');
						
						$id_tarjeta_relacion = md5($this->create_guid());
						//crea la relacion con el contacto
						$query5 = "INSERT INTO CONTACTS_M6_TARJETAS_1_C(ID,DATE_MODIFIED,DELETED,CONTACTS_M936DONTACTS_IDA,CONTACTS_M4FC3ARJETAS_IDB) VALUES('".$id_tarjeta_relacion."','".$fecha."','0','".$id_contacto."','".$id_tarjeta."')";
						$result5 = $db->query($query5, true, 'Error inserting the tarjeta_rel_record record...');
					}
				}
			}
		}
	}
	
	function create_guid()
	{
		$microTime = microtime();
		list($a_dec, $a_sec) = explode(" ", $microTime);

		$dec_hex = dechex($a_dec* 1000000);
		$sec_hex = dechex($a_sec);

		$this->ensure_length($dec_hex, 5);
		$this->ensure_length($sec_hex, 6);

		$guid = "";
		$guid .= $dec_hex;
		$guid .= $this->create_guid_section(3);
		$guid .= '-';
		$guid .= $this->create_guid_section(4);
		$guid .= '-';
		$guid .= $this->create_guid_section(4);
		$guid .= '-';
		$guid .= $this->create_guid_section(4);
		$guid .= '-';
		$guid .= $sec_hex;
		$guid .= $this->create_guid_section(6);

		return $guid;
	}

	function create_guid_section($characters)
	{
		$return = "";
		for($i=0; $i<$characters; $i++)
		{
			$return .= dechex(mt_rand(0,15));
		}
		return $return;
	}

	function ensure_length(&$string, $length)
	{
		$strlen = strlen($string);
		if($strlen < $length)
		{
			$string = str_pad($string,$length,"0");
		}
		else if($strlen > $length)
		{
			$string = substr($string, 0, $length);
		}
	}
} 
?>