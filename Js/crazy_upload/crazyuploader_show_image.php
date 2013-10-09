<?php
/*
  This script does not allow the image
  to pass neither width nor height
*/

error_reporting(0);

$img  = urldecode($_GET["img"]);
$type = pathinfo($img, PATHINFO_EXTENSION); 
$im   = imagecreatefromstring(file_get_contents($img));

$widthEx  = imagesx($im); # it gets the width of the sample
$heightEx = imagesy($im); # it gets the height of the sample

$newWidth  = imagesx($im); # it gets the width of the sample
$newHeight = imagesy($im); # it gets the height of the sample

if( $_GET["w"] > 250 )
{
    # Resize by Width
    $newWidth  = $_GET["w"];
    $newHeight = abs(($heightEx * $newWidth) / $widthEx);
}


$newImg = imagecreatetruecolor($newWidth, $newHeight); # it creates an empty image
imagecopyresampled($newImg, $im, 0, 0, 0, 0, $newWidth, $newHeight, $widthEx, $heightEx);


# Resize by height
if( isset($_GET["h"]) )
{
    if( $newHeight > $_GET["h"] )
    {
        $widthEx  = $newWidth;  # it gets the width of the sample
        $heightEx = $newHeight; # it gets the height of the sample	  

        $newHeight = $_GET["h"];
        $newWidth  = abs(($widthEx * $newHeight) / $heightEx);

        $im = $newImg;

        $newImg = imagecreatetruecolor($newWidth, $newHeight); # it creates an empty image
        imagecopyresampled($newImg, $im, 0, 0, 0, 0, $newWidth, $newHeight, $widthEx, $heightEx);	
    }
}

if(eregi("jpg|jpeg", $type))
{
    header("content-type: image/jpeg");	
    imagejpeg($newImg); 
}
elseif(eregi("gif", $type))
{
    header("content-type: image/gif");	
    imagegif($newImg); 
}
elseif(eregi("png", $type))
{
    header("content-type: image/png");	
    imagepng($newImg);
}

imagedestroy($newImg);
imagedestroy($im);
?>