<?php
    error_reporting(0);
    header("content-type: application/json; charset=iso-8859-1");
    header("expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header('last-modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');     
    header("cache-control: no-cache, no-store, must-revalidate");
    header("pragma: no-cache");             
    
    if( $_POST )
    {
        include_once("crazyuploader_config.php");        
        
        $profile = "default";
        
        if( array_key_exists($_POST["profile"], $PROFILE_UPLOAD) )
        {
            $profile = $_POST["profile"];
        }         
        
        # BEGIN CODE
        # >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        
        if( !file_exists($PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] . utf8_decode($_POST["fileName"])) )
        {
            exit('{ "deleted" : "no", "msgError" : "Ocorreu um problema ao excluir o arquivo!\\nSistema não encontrou o arquivo!" }');   
        }
        
        if( !unlink($PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] . utf8_decode($_POST["fileName"])) )
        {
            exit('{ "deleted" : "no", "msgError" : "Ocorreu um problema ao excluir o arquivo!" }');        
        }
        
        # END CODE
        # >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>        
        
        exit('{ "deleted" : "ok", "msgError" : "" }');        
    }
    else
    {
        exit('{ "deleted" : "no", "msgError" : "Ocorreu um problema ao excluir o arquivo!" }');
    }
?>