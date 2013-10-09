<?php
/*
 * test_string_mapping.php
 *
 * @(#) $Header: /cvsroot/PHPlibrary/test_string_mapping.php,v 1.1 1999/07/23 02:12:47 mlemos Exp $
 *
 */

 require("string_mapping.php");
 require("ISO-8859-1/strip_accents_mapping.php");
 require("ISO-8859-1/upper_case_mapping.php");
 require("ISO-8859-1/lower_case_mapping.php");

 $string=($argc<2 ? "ม่ฮ๕ü็ว" : $argv[1]);
 $string_mapping=new string_mapping_class;
 echo "String - \"$string\"\n";
 echo "Stripped accents and cedillas - \"".$string_mapping->Map($string,$strip_accents_mapping)."\"\n";
 echo "To lower case - \"".$string_mapping->Map($string,$lower_case_mapping,"strtolower")."\"\n";
 echo "To upper case - \"".$string_mapping->Map($string,$upper_case_mapping,"strtoupper")."\"\n";
?>