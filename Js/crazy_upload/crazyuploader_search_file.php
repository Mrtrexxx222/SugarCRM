<?php 
    header("content-type: text/html; charset=iso-8859-1");
    header("expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header('last-modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');    
    header("cache-control: no-cache, no-store, must-revalidate");
    header("pragma: no-cache");             
    
    if( $_POST )
    {
        include_once("crazyuploader_config.php");
        include_once("crazyuploader_utils.php");
        
        $profile = "default";
        
        if( array_key_exists($_POST["profile"], $PROFILE_UPLOAD) )
        {
            $profile = $_POST["profile"];
        }        
        
        $pgCurrent  = (int)$_POST["page"];  
        
        $directory  = array_slice(scandir( $PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] ), 2);
        $directory  = array_filter($directory, "filterDirectory");       
        $totalFiles = sizeof($directory);         
        
        $limitFirst = ($pgCurrent - 1) * $PROFILE_UPLOAD[ $profile ]["SEARCH_FILES_INTERVAL"]; 
        $directory  = array_slice($directory, $limitFirst, $PROFILE_UPLOAD[ $profile ]["SEARCH_FILES_INTERVAL"]);
        
        if( count($directory) == 0 )
        {
            echo '<div class="crazyuploader_info">' . htmlentities('Nenhum arquivo foi encontrado!') . '</div>';   
            die;
        }
        
        natcasesort( $directory );       
        ?>

        <input type="hidden" name="hdPagSearchFile" id="hdPagSearchFile" value="<?=utf8_decode($_POST["search"]);?>" />
        
        <table id="tbSearchFile" border="0" cellpadding="2" width="100%" class="crazyuploader_table_search">
            
            <tr class="crazyuploader_table_search_header">
                <td colspan="<?=($PROFILE_UPLOAD[ $profile ]["IS_ALLOWED_DELETE"] ? '4' : '3');?>" align="left">Arquivo</td>
            </tr>
            
        <?php
        foreach( $directory as $file ):   
            
            $w = 250;
            $h = 180;
            
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            
            if( $ext != "swf" )
            {
                list($oW, $oH) = getimagesize($PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] . $file);

                $h = ($oH * 250) / $oW;
                
                if( $h > 180 )
                {
                    $w = (250 * 180) / $h;
                    $h = 180;
                }
                
                $w = round($w);
                $h = round($h);
            }            
            ?>
        
            <tr onmouseover="hoverRowTableSearchOn(this);" onmouseout="hoverRowTableSearchOff(this);">
                <td align="left" width="<?=($PROFILE_UPLOAD[ $profile ]["IS_ALLOWED_DELETE"] ? "82%" : "88%");?>"><?=htmlentities($file);?></td> 
                
                <td align="center" valign="middle" width="6%">
                    <a href="javascript:void(0);" onclick="showFile('<?=$PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] . $file;?>');">
                        <img src="img/crazyuploader_view.png" border="0" alt="Visualizar Arquivo" title="Visualizar Arquivo" />
                    </a>                    
                </td>                 
                
                <td align="center" valign="middle" width="6%">
                    <a href="javascript:void(0);" onclick="addFileToEditor('<?=ADDRESS_PLUGIN . $PROFILE_UPLOAD[ $profile ]["PATH_IMAGES"] . $file;?>', <?=$w . ", " . $h;?>);">
                        <img src="img/crazyuploader_add.png" border="0" alt="Anexar Arquivo" title="Anexar Arquivo" />
                    </a>
                </td>
                
                <?php
                if( $PROFILE_UPLOAD[ $profile ]["IS_ALLOWED_DELETE"] ):
                ?>
                
                <td align="center" valign="middle" width="6%">
                    <a href="javascript:void(0);" onclick="deleteFileFromServer('<?=$PROFILE_UPLOAD[ $profile ]["SCRIPT_DELETE"];?>', '<?=$file;?>', this);">
                        <img src="img/crazyuploader_delete.gif" border="0" alt="Excluir Arquivo" title="Excluir Arquivo" />
                    </a>                    
                </td>
                
                <?php
                endif;
                ?>
                
            </tr>
            
            <?php
        endforeach;
        ?>
         
            <tr class="crazyuploader_table_search_footer">
                <td colspan="<?=($PROFILE_UPLOAD[ $profile ]["IS_ALLOWED_DELETE"] ? '4' : '3');?>" align="right">
                    
                    
                    <table cellpadding="2" cellspacing="3">
                        <tr>

                        <?php                     
     
                            $pages = ceil($totalFiles / $PROFILE_UPLOAD[ $profile ]["SEARCH_FILES_INTERVAL"]);


                            echo '<td width="28" align="center" class="crazyuploader_page_arrow" title="Primeira p&aacute;gina" onclick="searchFile( 1, false );">';
                            echo '&larr;';
                            echo '</td>';                


                            for($i = ($pgCurrent-3); $i < $pgCurrent; $i++)
                            {
                                if( $i > 0 )
                                {
                                    echo '<td width="20" align="center" class="crazyuploader_page_active" onclick="searchFile( ' . $i . ', false );">';
                                    echo $i;
                                    echo '</td>';
                                }
                            }


                            print '<td width="20" align="center" class="crazyuploader_page_current" onclick="searchFile( ' . $pgCurrent . ', false );">';
                            print $pgCurrent;
                            print '</td>';


                            for($i = ($pgCurrent+1); ($i <= ($pgCurrent + 3) && $i <= $pages); $i++)
                            {
                                echo '<td width="20" align="center" class="crazyuploader_page_active" onclick="searchFile( ' . $i . ', false );">';
                                echo $i;
                                echo '</td>';
                            }


                            echo '<td width="28" align="center" class="crazyuploader_page_arrow" title="&Uacute;ltima p&aacute;gina" onclick="searchFile( ' . $pages . ', false );">';
                            echo '&rarr;';
                            echo '</td>';


                            echo '<td width="40" align="center">de &nbsp;<b>' . $pages . '</b></td>';

                        ?>

                        </tr>
                    </table> 
                    

                </td>
            </tr>            
            
        </table>

        <?php
    }
    else
    {
        echo '<div class="crazyuploader_error">' . htmlentities("Ocorreu um erro ao pesquisar os arquivos!") . '</div>';
    }
?>