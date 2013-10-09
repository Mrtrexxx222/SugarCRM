<?php
/* Seguridad de la pagina, hay que añadir esta línea de PHP al principio. */
require('php_lib/include-pagina-restringida.php'); //el incude para vericar que estoy logeado. Si falla salta a la página de index.php
require_once('conexion.php'); 
  /**
   * ClickATell SMS API
   *
   * This library provides generic API for ClickATell SMS Service in an uniform way.
   *
   * @package     ClickATell SMS API
   * @version     1.0
   * @category    Library
   * @author      Utsav Handa < handautsav at hotmail dot com >
   * @license     http://opensource.org/licenses/gpl-license.php GNU Public License
   *
   *
   * @changelog 
   * -- 2009-01-01 Initial Implementation 
   *
   *
   */

  /** License
   *
   * Copyright (c) 2009 Utsav Handa <handautsav at hotmail dot com>
   *
   * Permission is hereby granted, free of charge, to any person obtaining a copy of this
   * software and associated documentation files (the "Software"), to deal in the Software 
   * without restriction, including without limitation the rights to use, copy, modify, 
   * merge, publish, distribute, sublicense, and/or sell copies of the Software, and to 
   * permit persons to whom the Software is furnished to do so, subject to the following
   * conditions:
   *
   * The above copyright notice and this permission notice shall be included in all copies
   * or substantial portions of the Software.
   *
   * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
   * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
   * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE 
   * FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR 
   * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
   * IN THE SOFTWARE.
   */

  /**
   * Usage Example ::
   *
   * require_once('class-clickatellsms-api.php');
   * $sms_obj = new ClickATellSMS('USERNAME', 'PASSWORD', 'API_ID', 'SENDER_ID');
   * $sms_obj -< sendSMS('NUMBER', 'MESSAGE');
   *
   **/

  /** Class to deal with Timezone Conversion */

  /** CLass 'ClickaTell' SMS Provider API */

class ClickATellSMS {

private $_sending_methods = array('curl_init', 'file_get_contents');
private $_sending_method  = null;
private $_sendURL = 'http://api.clickatell.com/http/sendmsg?api_id=%s&user=%s&password=%s&from=%s&text=%s&to=%s&callback=0&concat=1';
private $_estadoURL = 'http://api.clickatell.com/http/querymsg?user=%s&password=%s&api_id=%s&apimsgid=%s';
private $_max_message_length = '160';

private $_default_useragent  = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.5) Gecko/2008120121 Firefox/3.0.5';

private $_username = null;
private $_password = null;
private $_apiid    = null;
private $_senderid = null;

public $response_message = null;
public $error_id         = 0;
public $error_message    = null;

  /** Main Class Object constructor */
  function __construct($username = null, $password = null, $apiid = null, $senderid = null) {
    
    /** Set Param(s) */
    $this->_username = ( $username ? $username : '' );
    $this->_password = ( $password ? $password : '' );
    $this->_apiid    = ( $apiid    ? $apiid    : '' );
    $this->_senderid = ( $senderid ? $senderid : '' );


    /** Select Suuported Method */
    foreach ($this->_sending_methods as $sending_method) {
      if (function_exists($sending_method)) {
        $this->_sending_method = $sending_method;
        break;
      }
    }

  }
  
  /** Message Sending Method */
  public function sendSMS($to = null, $text = null) {

    /*************************/
    /**** Validate Inputs ****/
    /*************************/
    /** Default Message Length */
    if(strlen($text) > $this->_max_message_length) {
      $this->error_message = 'ERROR: Message length exceeds maximum permissible limit';
      return 0;
    } 
    /** 'To' Empty */
    if (empty($to)) {
      $this->error_message = 'ERROR: destination not specified';
      return 0;
    }
    
    /** Sanitize Inputs */
    $text = stripslashes($text);
    $text = str_replace("\r", "", $text);  

    /** Cleanup Message */
    $cleanup_chr = array ("+", " ", "(", ")", "\r", "\n", "\r\n");
    $to = str_replace($cleanup_chr, '', $to);     

    /** Build URL */
    $comm = sprintf (
                     $this->_sendURL,
                     $this->_apiid,
                     $this->_username,
                     $this->_password,
                     $this->_senderid,
                     rawurlencode($text),  
                     rawurlencode($to)
                     );  

    return ($this->_execgw($comm));
  }
    
  /** Message Sending GRUPAL Method */
  public function sendSMS_Grupal($to = null, $text = null,$id_user = null) 
  {	
	$numeros = explode(",",$to);
	$textos = explode(",",$text);
	$response = array();
	//1) se guarda el id de carga de usuario //obtengo el ultimo ID_CARGA_USUARIO de de la tabla de ID's
	$id_carga_usuario = "";
	$sql_id_carga = mysql_query("SELECT COUNT(*) AS numero FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_carga_usuario'");
	if($row_id_carga = mysql_fetch_array($sql_id_carga))
	{	
		if($row_id_carga['numero']==0)
		{
			$id_carga_usuario = $row_id_carga['numero']+1;
		}else if($row_id_carga['numero']>0)
		{
			$sql_val_id_carga 	= mysql_query("SELECT MAX(DISTINCT(valor)) AS valor FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_carga_usuario'");
			if($row_val_id_carga = mysql_fetch_array($sql_val_id_carga))
			{			
				$id_carga_usuario = $row_val_id_carga['valor']+1;
			}
		}
	}
	try
	{
		$sql_01 = mysql_query("insert into id_tabla(tabla,campos,valor) values('mensajes','id_carga_usuario',".$id_carga_usuario.")");
	}
	catch(Exception $e)
	{
		$error = $e->getMessage();
		echo '<br />';
		echo $error;
	}
	for($i=0;$i<count($numeros);$i++)
	{
		/** Sanitize Inputs */
		$texto = stripslashes($textos[$i]);
		$texto = str_replace("\r", "", $texto);  

		/** Cleanup Message */
		$cleanup_chr = array ("+", " ", "(", ")", "\r", "\n", "\r\n");
		$numero = str_replace($cleanup_chr, '', $numeros[$i]);     

		/** Build URL */
		$comm = sprintf (
						 $this->_sendURL,
						 $this->_apiid,
						 $this->_username,
						 $this->_password,
						 $this->_senderid,
						 rawurlencode($texto),  
						 rawurlencode($numero)
						 );  
		//GUARDAR TODA LA INFORMACION ANTES DE ENVIAR A CLICKATELL
		//2) se guardan los ids en la tabla de ids //obtengo el ultimo ID_MENSAJE de de la tabla de ID's
		$id_mensaje = "";
		$sql_id_sms = mysql_query("SELECT COUNT(*) AS numero FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_mensaje'");
		if($row_id_sms = mysql_fetch_array($sql_id_sms))
		{	
			if($row_id_sms['numero']==0)
			{
				$id_mensaje = $row_id_sms['numero']+1;
			}else if($row_id_sms['numero']>0)
			{
				$sql_id_sms = mysql_query("SELECT MAX(DISTINCT(valor)) AS valor FROM id_tabla WHERE tabla = 'mensajes' AND campos = 'id_mensaje'");
				if($row_val_id_sms = mysql_fetch_array($sql_id_sms))
				{
					$id_mensaje = $row_val_id_sms['valor']+1;
				}
			}
		}
		try
		{
			$sql_02 = mysql_query("insert into id_tabla(tabla,campos,valor) values('mensajes','id_mensaje',".$id_mensaje.")");
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			echo '<br />';
			echo $error;
		}		
		
		//3) se guarda la informacion del mensaje en la tabla de mensaje			
		//se debe tomar el id del usuario logeado si es que es un cliente, si que es un usuario interno se debe selccionar el cliente con algun campos
		try
		{	
			$sql_envio = mysql_query("insert into mensajes (destinatario,mensaje,fecha_programado,fecha_envio,id_mensaje,id_usuario,id_carga_usuario,id_estado_interno)
									values('".$numero."','".$texto."',NOW(),NOW(),".$id_mensaje.",".$id_user.",".$id_carga_usuario.",1)");
		}
		catch(Exception $e)
		{	
			$error = $e->getMessage();			
			echo $error;
		}
		$id_sms = '';
		$statusSMS	 = '';
		$estado_interno = "";	
		$debita_o_no 	= 0;
		$resp = $this->_execgw($comm);		
		$response = explode(" ",$resp);
		if($response[0] == 'ID:')
		{
			$id_sms	  = $response[1];
		}
		else if($response[0] == 'ERR:')
		{
			$id_sms	  = ''; 
			$statusSMS	  = $resp; 
			$estado_interno = 3;//fallo el envio
		}
		//VALIDA SI EXISTE UN ID DE RESPUESTA DE CLICKATELL PARA RECUPERAR EL ESTADO_C
		if($id_sms != '')
		{
			$status_click 	= $this->statusSMS($id_sms);
			$statusSMS 		= explode(" ",$status_click);
			if($statusSMS[0] == 'ID:')
			{
				$estado_interno = 2; //enviado
				$statusSMS 		= $statusSMS[3];
				$debita_o_no 	= 1;		
			}
			if($statusSMS[0] == 'ID:')
			{
				$estado_interno = 3; //fallo el envio
				$statusSMS 		= $status_click;				
			}
		}	
		//GUARDAR TODA LA INFORMACION CUANDO SE OBTIENE LA RESPUESTA DE CLICKATELL		
		try
		{
			$sql_return = mysql_query("insert into mensajes (id_clickatell_sms,destinatario,mensaje,fecha_programado_c,fecha_envio_c,estado_c,id_mensaje,id_usuario,id_carga_usuario,id_estado_interno)
									values('".$id_sms."','".$numero."','".$texto."',NOW(),NOW(),'".$statusSMS."',".$id_mensaje.",".$id_user.",".$id_carga_usuario.",".$estado_interno.")");
		}
		catch(Exception $e)
		{	
			$error = $e->getMessage();
			echo $error;
		}
	}
	if($debita_o_no == 1)
	{
		return count($numeros)."/".$id_carga_usuario;
		
	}	
  }
  
  /** Status Message ID*/	
  public function statusSMS($id_sms = null) 
  {
    /** Build URL */
    $comm = sprintf (
                     $this->_estadoURL,                     
                     $this->_username,
                     $this->_password,
					 $this->_apiid,
                     rawurlencode($id_sms)
                     );  

    return ($this->_execgw($comm));
  }
  
  /** Execute Command */
  private function _execgw($command = null) {

    $result = '';

    /** Validate 'sending method */
    if (!function_exists($this->_sending_method)) {
      $this->error_message = "ERROR: '".$this->_sending_method."' not supported in PHP";
      return 0;
    }

    /** Execute Method Call */
    if ($this->_sending_method == "file_get_contents") {
      $result = $this->_file_get_contents($command);
    } elseif ($this->_sending_method == "curl_init") {
      $result = $this->_curl_init($command);
    }

    /** Parse API Result */
    if ($result) {
      
      $status = $status_msg = null;
      if (@preg_match('/(.*?):(.*?)$/', $result, $matches)) {
        $status = $matches[1];
        $status_msg = $matches[2];
      }
      
      /** Process Result */
      if (stristr($status, 'err')) { /** ERROR */
        $this->response_message = $status;
        list($this->error_id, $this->error_message) = explode(',', $status_msg);
      } else {                        /** OK */
        $this->response_message = $status;
        $this->error_id = 0;
      }      

    }

    //return ( $this->error_id ? 0 : 1 );
	return ($result);
  }

  /** Curl Method */
  private function _curl_init($url = '') {

    /** Preparing CURL instance */
    $o_ch = curl_init();

    /** Starting Processing */
    curl_setopt ($o_ch, CURLOPT_URL, $url);
    curl_setopt ($o_ch, CURLOPT_USERAGENT, $this->_default_useragent);
    curl_setopt ($o_ch, CURLOPT_HEADER, 0);
    curl_setopt ($o_ch, CURLOPT_RETURNTRANSFER, 1);
    $s_html = curl_exec ($o_ch);
    curl_close ($o_ch);
    unset($o_ch);

    /** Cleaning HTML */
    for ($ascii = 0; $ascii <= 9; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);
    for ($ascii = 11; $ascii < 32; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);
    for ($ascii = 127; $ascii <= 255; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);

    return $s_html;
  } 

  /** fopen Method */
  private function _file_get_contents($url = null) {

    /** Fetch Contents */
    return file_get_contents($url);
  }
  
}

?>