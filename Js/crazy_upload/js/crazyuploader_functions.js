/**
 * Copyright 2012, Sandro Alves Peres
 * sandrinhodobanjo@yahoo.com.br
 */

function showTab( tab, button )
{
    $('#tabFileServer').hide();
    $('#tabUpload').hide();    
    $('#tabButtonFileServer').removeClass("crazyuploader_tab_button_selected");
    $('#tabButtonUpload').removeClass("crazyuploader_tab_button_selected");   
    
    $('#' + button).addClass("crazyuploader_tab_button_selected");     
    $("#" + tab).toggle( 400 );
}


function isAcceptedFormat()
{
    var allowSWF = ($("#hdAllowSWF").val() == 1);
    
    var formats = 'jpg,jpeg,jpe,gif,png' + (allowSWF ? ',swf' : '');
        formats = formats.toLowerCase();
        
    var pieces = $('#flFile', window.parent.ifrUpload.document).val().split(".");

    if( pieces.length >= 2 )
    {
        var arrFormats = formats.replace(/\s+/gi, "").split(",");

        for( var i in arrFormats )
        {
            if( pieces[ pieces.length-1 ].toLowerCase() == arrFormats[ i ] )
            {
                return true;
            }
        }
        
        return false;
    }
    else 
    {
        return false; 
    }
}


function makeFileUpload()
{
    var allowSWF = ($("#hdAllowSWF").val() == 1);
    
    if( $('#flFile', window.parent.ifrUpload.document).val().replace(/^\s+|\s+$/i, "") == "" )
    {
        alert("Selecione o arquivo!");
        return;
    }
    
    if( !isAcceptedFormat() )
    {
        alert("Arquivo com formato inválido!\n\nFormatos aceitos: [jpg, jpeg, jpe, gif, png" + (allowSWF ? ', swf' : '') + "]");
        return;
    }

    $("#btSubmit").hide();
    $("#ifrUpload").hide();
    $("#divUploading").show();
    
    var profile = '<input type="hidden" name="profile" value="' + $("#hdProfileUpload").val() + '" />';
    
    $('#ifrUpload').contents().find('#frmUploadFile').append( profile );
    $('#frmUploadFile', window.parent.ifrUpload.document).submit();
}


function getSwfHtml( pathSwf )
{
    var htmlObject  = '<object width="250" height="180" ';
        htmlObject += 'data="' + pathSwf + '" '; 
        htmlObject += 'type="application/x-shockwave-flash">';
        htmlObject += '<param name="src" value="' + pathSwf + '" />';
        htmlObject += '<param name="quality" value="high" />';
        htmlObject += '<param name="wmode" value="transparent" />';
        htmlObject += '</object>' 
    
    return htmlObject;
}


function showUploadedFile( pathFile, addressFile )
{
    var ext = pathFile.split(".");
        ext = ext[ ext.length-1 ].toLowerCase();
       
    var inputExt      = '<input type="hidden" id="hdExtension" value="' + ext + '" />';   
    var inputPathFile = '<input type="hidden" id="hdAddressFile" value="' + addressFile + '" />';   
       
    if( ext == "swf" )
    {
        var objSWF = getSwfHtml( pathFile );
        
        $("#divUploadedFile").html( inputExt + inputPathFile + objSWF ); 
    }
    else // Imagem
    {
        var urlImg   = 'crazyuploader_show_image.php?img=' + pathFile + '&amp;w=250&amp;h=180';        
        var inputImg = '<img id="imUploadedImage" src="' + urlImg + '" border="0" alt="" align="absmiddle" style="vertical-align: middle;" />';
        
        $("#divUploadedFile").html( inputExt + inputPathFile + inputImg );
    } 
    
    $("#ifrUpload").hide();
    $("#divUploading").hide();
    
    $("#btAddFile").show();
    $("#btNewUpload").show();    
    $("#divUploadedFile").show(); 
    
    $("#ifrUpload").attr("src", "crazyuploader_upload.htm");
    searchFile( 1, true );
}


function showFile( pathFile )
{
    var ext = pathFile.split(".");
    
    ext = ext[ ext.length-1 ];
    
    if( ext == "swf" )
    {
        var view = getSwfHtml( pathFile );
        
        $("#cellViewFile").html( view );
    }
    else // Imagem
    {   
        var urlImg = 'crazyuploader_show_image.php?img=' + pathFile + '&amp;w=250&amp;h=180';        
        var view   = '<img id="imViewImage" src="' + urlImg + '" border="0" alt="" align="absmiddle" style="vertical-align: middle;" />';
        
        $("#cellViewFile").html( view );
    }     
}


function addFileToEditor( addressFile, w, h )
{
    var codeHTML = "";  
    var ed       = tinyMCEPopup.editor;        
    var ext      = addressFile.split(".");
    
    ext = ext[ ext.length-1 ];
    
    if( ext == "swf" )
    {
        codeHTML = getSwfHtml( addressFile );  
    }
    else // Image
    {           
        codeHTML = '<img src="' + addressFile + '" border="0" alt="" align="absmiddle" width="' + w + '" height="' + h + '" />';
    }     

    ed.execCommand('mceInsertContent', false, codeHTML);    
    tinyMCEPopup.close();    
    
}


function addFileAfterUploaded()
{
    var codeHTML = "";
    var ed       = tinyMCEPopup.editor;    
    var address  = $("#hdAddressFile").val();
    var ext      = $("#hdExtension").val();
    
    if( ext == "swf" )
    {
        codeHTML = getSwfHtml( address );
    }
    else // Image
    {    
        var w = $("#imUploadedImage").width();
        var h = $("#imUploadedImage").height();
        
        codeHTML = '<img src="' + address + '" border="0" alt="" align="absmiddle" width="' + w + '" height="' + h + '" />';
    }     

    ed.execCommand('mceInsertContent', false, codeHTML);    
    tinyMCEPopup.close();
}


function newUploadFile()
{
    $("#divUploading").hide();    
    $("#btAddFile").hide();
    $("#btNewUpload").hide();    
    $("#divUploadedFile").hide(); 

    $("#ifrUpload").show();
    $("#btSubmit").show();
}


function enterSearchFile( ev )
{
    var key = (window.event ? ev.keyCode : ev.which);

    if( key == 13 ){
        searchFile( 1, true ); 
    }
}


function searchFile( page, newSearch )
{
    if( newSearch )
    {   
        page = 1;
        var search = $("#txSearchFile").val();
    }
    else
    {
        var search = $("#hdPagSearchFile").val();  
    }
    
    var profile = $("#hdProfileUpload").val();   
    
    var img = '<img src="img/crazyuploader_loading_bar.gif" border="0" align="absmiddle" style="vertical-align:middle;" alt="" />';    

    $("#cellViewFile").html("");
    $("#divSearchResult").html( "&nbsp;Pesquisando...<br />" + img);

    $.ajax({
        
        type: "POST",
        url: "crazyuploader_search_file.php",
        data: { 
            page: page, 
            search: search, 
            profile: profile
        },
        dataType: "html",
        timeout: 30000,
        cache: false,
        
        success: function( data ){                       
            if( data )
            {
                $("#divSearchResult").html( data );
            }
            else
            {
                alert("Ocorreu um erro ao pesquisar os arquivos!");
            }
        },
        
        error: function(request, status, err){
            if( status == "timeout" )
            {
                alert("Servidor sobrecarregado (Timeout)!\nTente novamente mais tarde!");                
            }
            else
            {
                alert("Ocorreu um erro ao pesquisar os arquivos!");  
            }
        }
        
    }); 
}


function deleteFileFromServer( scriptDelete, fileName, obj )
{ 
    if( !confirm("Deseja realmente excluir o arquivo?") )
    {
        return;
    }
    
    $("#cellViewFile").html("");

    var profile = $("#hdProfileUpload").val();  

    $.ajax({
        
        type: "POST",
        url: scriptDelete,
        data: { 
            fileName: fileName,
            profile: profile 
        },
        dataType: "json",
        timeout: 30000,
        cache: false,
        
        success: function( data )
        {                
            if( typeof(data) == "object" )
            {
                if( data.deleted != "ok" )
                {
                    alert( data.msgError );
                    searchFile( 1, true );
                }
            } 
            else
            {
                alert("Ocorreu um problema ao excluir o arquivo!");
                searchFile( 1, true );
            }
        },
        
        error: function( request, status, err )
        {
            if( status == "timeout" )
            {
                alert("Servidor sobrecarregado (Timeout)!\nTente novamente mais tarde!");                
            }
            else
            {
                alert("Ocorreu um problema ao excluir o arquivo!");
                searchFile( 1, true );                
            }
        }
        
    }); 
    
    $( obj ).parent().parent().remove(); 
    
    if( $('#tbSearchFile tr').size() <= 3 )
    {
        searchFile( 1, true );
    }
}


function hoverRowTableSearchOn( obj )
{
    hoverRowTableSearchOff( obj );
    $(obj).addClass("crazyuploader_table_search_row_hover");
}


function hoverRowTableSearchOff( obj )
{
    $(obj).removeClass("crazyuploader_table_search_row_hover"); 
}


function loadProfileSettings()
{
    var profile = $("#hdProfileUpload").val();  

    $("#btSubmit").attr("disabled", "disabled");

    $.ajax({
        
        type: "POST",
        url: "crazyuploader_profile_settings.php",
        data: { 
            p: profile
        },
        dataType: "json",
        timeout: 30000,
        cache: false,
        
        success: function( data )
        {                       
            if( typeof(data) == "object" )
            {
                var input  = '<input type="hidden" ';
                    input += 'name="hdAllowSWF" id="hdAllowSWF" ';
                    input += 'value="' + data.IS_ALLOWED_FLASH + '" />';
                    
                $("#frmFormUpload").append( input );
                $("#ifrUpload").attr("src", "crazyuploader_upload.htm");
            } 
            else
            {
                alert("Ocorreu um erro ao carregar o perfil do plugin!");
            }
            
            $("#btSubmit").removeAttr("disabled");
        },
        
        error: function( request, status, err )
        {
            alert("Ocorreu um erro ao carregar o perfil do plugin!");
            $("#btSubmit").removeAttr("disabled");            
        }
        
    }); 
}