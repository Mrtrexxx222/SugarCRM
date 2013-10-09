<?php
/*
 * string_mapping.php
 *
 * @(#) $Header: /cvsroot/PHPlibrary/string_mapping.php,v 1.2 1999/07/23 02:10:04 mlemos Exp $
 *
 */

class string_mapping_class
{
 Function Map($string,&$mapping,$function="")
 {
  for($mapped="",$character=0;$character<strlen($string);$character++)
  {
   $code=Ord($string[$character]);
   $mapped.=(IsSet($mapping[$code]) ? $mapping[$code] : (strcmp($function,"") ? $function($string[$character]) : $string[$character]));
  }
  return($mapped);
 }
};

?>