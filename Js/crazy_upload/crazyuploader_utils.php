<?php
function noSpecialChars( $s )
{
    $s = ereg_replace("[АЮБЦ╙]", "a", $s);
    $s = ereg_replace("[аюбц]", "A", $s);
    $s = ereg_replace("[ИХЙ]", "e", $s);
    $s = ereg_replace("[ихй]", "E", $s);
    $s = ereg_replace("[МЛН]", "i", $s);
    $s = ereg_replace("[млн]", "I", $s);
    $s = ereg_replace("[СРТУ╨]", "o", $s);
    $s = ereg_replace("[срту]", "O", $s);
    $s = ereg_replace("[ЗЫШ]", "u", $s);
    $s = ereg_replace("[зыш]", "U", $s);
    $s = str_replace("Я", "n", $s);
    $s = str_replace("я", "N", $s);
    $s = str_replace("Г", "c", $s);
    $s = str_replace("г", "г", $s);
    $s = str_replace("[©?!]", "", $s);    

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