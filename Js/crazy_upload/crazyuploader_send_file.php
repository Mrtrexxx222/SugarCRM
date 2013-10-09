<?php
    sleep(1);
    header("content-type: text/html; charset=iso-8859-1");
    header("expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header('last-modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');     
    header("cache-control: no-cache, no-store, must-revalidate");
    header("pragma: no-cache");    
    
	echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js" language="javascript"></script>';    
	echo '<script type="text/javascript" src="js/crazyuploader_functions.js" language="javascript"></script>';            
    
    if( $_POST )
    {
        
        include_once("crazyuploader_config.php");
        include_once("crazyuploader_utils.php");
        
        $profile = "default";
        $fileExt = pathinfo($_FILES["flFile"]["name"], PATHINFO_EXTENSION); 
        
        if( array_key_exists($_POST["profile"], $PROFILE_UPLOAD) )
        {
            $profile = $_POST["profile"];
        }
        
        if( !eregi("jpg|jpeg|jpe|gif|png" . ($PROFILE_UPLOAD[ $profile ]["IS_ALLOWED_FLASH"] ? "|swf" : ""), $fileExt) )
        {
        ?>

            <script type="text/javascript" language="javascript">
                top.window.alert("Arquivo com formato inválido!\n\nFormatos aceitos: [jpg, jpeg, jpe, gif, png<?=($PROFILE_UPLOAD[ $profile ]["IS_ALLOWED_FLASH"] ? ", swf" : "");?>]");
            </script>

        <?php 
            die;
        }        

        
        $prefix = ($PROFILE_UPLOAD[ $profile ]["PREFIX_IMAGES"] != "" ? $PROFILE_UPLOAD[ $profile ]["PREFIX_IMAGES"] . "_" : "");        
        
        if( $PROFILE_UPLOAD[ $profile ]["KEEP_REAL_NAMES"] )
        {
            $fileName = trim(preg_replace('/\\.' . $fileExt . '$/i', "", $_FILES["flFile"]["name"]));
            $fileName = noSpecialChars( preg_replace("/\s+/", " ", $fileName) );
            
            $tmpFileName = $prefix . $fileName . "." . $fileExt;
            $directory   = array_slice(scandir( $PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] ), 2);
            
            $i=1;
            while( true )
            {
                if( !in_array($tmpFileName, $directory) )
                {
                    $fileName = $tmpFileName;
                    break;
                }
                
                $tmpFileName = $prefix . $fileName . "(" . $i . ")" . "." . $fileExt;              
                $i++;
            }
        }
        else
        {
            $fileName = $prefix . md5(uniqid(rand(), true)) . "." . $fileExt;
        }
        
        $destination = $PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] . $fileName;
        $addressFile = ADDRESS_PLUGIN . $destination;
        
        if( move_uploaded_file($_FILES["flFile"]["tmp_name"], $destination) )
        {
        ?>

            <script type="text/javascript" language="javascript">
                top.showUploadedFile( '<?=$destination;?>', '<?=$addressFile;?>' );
            </script>

        <?php
        }
        else
        {
        ?>

            <script type="text/javascript" language="javascript">
                top.window.alert('Houve um problema ao fazer o upload!');
            </script>

        <?php 
        }
    }
    else
    {
    ?>
        
        <script type="text/javascript" language="javascript">
            top.window.alert('Houve um problema ao fazer o upload!');
        </script>
        
    <?php 
    }
?>