<?php
    error_reporting(0);
    header("content-type: application/json; charset=iso-8859-1");
    header("expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header('last-modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');     
    header("cache-control: no-cache, no-store, must-revalidate");
    header("pragma: no-cache");    
        
    include_once("crazyuploader_config.php");

    $profile = "default";

    if( array_key_exists($_POST["p"], $PROFILE_UPLOAD) )
    {
        $profile = $_POST["p"];
    }

    $json = '{';
    
    $i = 0;
    foreach( $PROFILE_UPLOAD[ $profile ] as $key => $value )
    {
        $json .= '"' . $key . '" : "' . (is_bool($value) ? (int)$value : addslashes($value)) . '"';
        $json .= ($i++ < sizeof($PROFILE_UPLOAD[ $profile ])-1 ? ',' : '');
    }
    
    $json .= '}';
    
    exit( $json );
 ?>