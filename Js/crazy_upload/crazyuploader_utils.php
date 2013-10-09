<?php
function noSpecialChars( $s )
{
    $s = ereg_replace("[����]", "a", $s);
    $s = ereg_replace("[����]", "A", $s);
    $s = ereg_replace("[���]", "e", $s);
    $s = ereg_replace("[���]", "E", $s);
    $s = ereg_replace("[���]", "i", $s);
    $s = ereg_replace("[���]", "I", $s);
    $s = ereg_replace("[�����]", "o", $s);
    $s = ereg_replace("[����]", "O", $s);
    $s = ereg_replace("[���]", "u", $s);
    $s = ereg_replace("[���]", "U", $s);
    $s = str_replace("�", "n", $s);
    $s = str_replace("�", "N", $s);
    $s = str_replace("�", "c", $s);
    $s = str_replace("�", "�", $s);
    $s = str_replace("[�?!]", "", $s);    

    return $s;
} 


function filterDirectory( $var )
{
    $search = noSpecialChars( utf8_decode($_POST["search"]) );

    if( $search == "" )
    {
        return true;
    }

    if( stripos($var, $search) !== false )
    {
        return true;
    }

    return false;
}
?>