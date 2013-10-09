<html xmlns="http://www.w3.org/1999/xhtml">
<head>  
	<title>Crazy Uploader</title>
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="rating" content="general" />
    <meta name="author" content="Sandro Alves Peres" /> 
    <link rel="shortcut icon" href="img/crazyuploader_icon.png" type="image/png" />    
	<script type="text/javascript" src="../../tiny_mce_popup.js" language="javascript"></script>
	<script type="text/javascript" src="js/crazyuploader.js" language="javascript"></script>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js" language="javascript"></script>        
	<script type="text/javascript" src="js/crazyuploader_functions.js" language="javascript"></script>    
	<link href="css/crazyuploader.css" rel="stylesheet" type="text/css" />
    <style media="all" type="text/css">
        body {
            background-color: #F0F0EE;
        }
    </style>
    <script language="javascript" type="text/javascript">
        $(document).ready(function()
        {
            var config = tinyMCEPopup.editor.settings; 
            
            if( config.profileUpload != undefined )
            {
                $("#hdProfileUpload").val( config.profileUpload );
            }
            else
            {
                $("#hdProfileUpload").val( "default" );    
            }              
            
            loadProfileSettings();
            $('#txSearchFile').val('');
            showTab('tabUpload', 'tabButtonUpload');
            searchFile( true, 1 );             
        });
    </script>    
</head>

<body> 
    
	<form name="frmFormUpload" id="frmFormUpload" onsubmit="return false;">
		
        <div align="left" style="clear: both;">
            <div align="center" class="crazyuploader_tab_button" id="tabButtonFileServer">
                <a href="javascript:void(0);" onclick="showTab('tabFileServer', 'tabButtonFileServer');">&nbsp; &nbsp;Lista de Arquivos&nbsp; &nbsp;</a>
            </div>
            <div align="center" class="crazyuploader_tab_button" id="tabButtonUpload" style="margin-left: -1px;">
                <a href="javascript:void(0);" onclick="showTab('tabUpload', 'tabButtonUpload');">&nbsp; &nbsp;Upload&nbsp; &nbsp;</a>
            </div>        
        </div>
        
        
        <div align="left" style="clear: both; margin-top: 10px;">
            <div id="tabFileServer" class="crazyuploader_tab_content">
               
                <table border="0" width="100%">
                    <tr>
                        <td width="60%" valign="top">
                        
                         
                            <table border="0" cellpadding="2" width="100%">
                                <tr>
                                    <td align="left" class="crazyuploader_text">Pesquisar arquivo:</td>                                      
                                </tr>
                                <tr>
                                    <td align="left"> 
                                        <input type="text" name="txSearchFile" id="txSearchFile" size="25" onkeypress="enterSearchFile(event);" class="crazyuploader_search_input" />
                                        <img onclick="searchFile( true, 1 );" src="img/crazyuploader_search.png" border="0" alt="" title="Pesquisar" align="absmiddle" style="vertical-align: middle; cursor: pointer;" />
                                    </td>                                    
                                </tr>                                
                            </table> 
                            
                            <div id="divSearchResult"></div>
                            
                            
                        </td>
                        <td id="cellViewFile" align="right" valign="top">
                            <!-- view file -->
                        </td>                                        
                    </tr>
                </table>
                
            </div>
            <div id="tabUpload" class="crazyuploader_tab_content">
             
                <table width="100%" cellpadding="5" border="0">
                    <tr>
                        <td class="crazyuploader_text">Selecione o arquivo</td>
                    </tr>
                    <tr>
                        <td>
                            
                            <div id="divUploading" class="crazyuploader_loading_upload">
                                <table border="0">
                                    <tr>
                                        <td align="center" width="50">
                                            <img src="img/crazyuploader_loading.gif" border="0" alt="" align="absmiddle" style="vertical-align: middle;" />
                                        </td>
                                        <td align="left" class="crazyuploader_text">
                                            Enviando arquivo...
                                        </td>                                        
                                    </tr>
                                </table>
                            </div>
                            
                            <div id="divUploadedFile" class="crazyuploader_uploaded_file"></div>                            
                            
                            <iframe src="" name="ifrUpload" id="ifrUpload" frameborder="0" width="100%" height="48" scrolling="no"></iframe>

                    </tr>
                    <tr>
                        <td>
                            <input onclick="makeFileUpload();" type="button" id="btSubmit" name="btSumit" value="Enviar arquivo" class="crazyuploader_action_button" />
                            <input onclick="addFileAfterUploaded();" type="button" id="btAddFile" name="btAddFile" value="Anexar arquivo" class="crazyuploader_action_button" style="display: none;" />
                            &nbsp; &nbsp; <input onclick="newUploadFile();" type="button" id="btNewUpload" name="btNewUpload" value="Novo Upload" class="crazyuploader_action_button" style="display: none;" />                            
                        </td>
                    </tr>                    
                </table>
                
            </div>        
        </div>         
        
        
		<div class="mceActionPanel">
			<input onclick="tinyMCEPopup.close();" type="button" id="cancel" name="cancel" value="Cancelar" />
		</div>
        
        <input type="hidden" name="hdProfileUpload" id="hdProfileUpload" value="" />
        
	</form>
    
</body> 
</html>