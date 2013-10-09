<?php

    # Example: http://yourdomain.com/tinymce/jscripts/tiny_mce/plugins/crazyuploader/
    define("ADDRESS_PLUGIN", "http://localhost/meuSite/tinymce-3.5.6/jscripts/tiny_mce/plugins/crazyuploader/");

    
    # Defines the settings from the value set in the 
    # instance of tinyMCE in "profileUpload"
    # >>>>>
    # Paths from the location of this file. For storing the images
    
    $PROFILE_UPLOAD = array();
    
    /*
     * IF YOU WANT MORE PROFILES, JUST COPY ONE OF THE PROFILES 
     * AND CHANGE THE KEY TO THE NAME OF THE YOU WANT 
     */
    
    $PROFILE_UPLOAD["default"] = array(
        "PATH_IMAGES"           => "storeImages/",
        "PREFIX_IMAGES"         => "", 
        "KEEP_REAL_NAMES"       => true,
        "SEARCH_FILES_INTERVAL" => 7,
        "IS_ALLOWED_DELETE"     => true,
        "IS_ALLOWED_FLASH"      => true,
        "SCRIPT_DELETE"         => "crazyuploader_delete_file.php"
    );
    
    
    $PROFILE_UPLOAD["blog"] = array(
        "PATH_IMAGES"           => "imagensBlog/",
        "PREFIX_IMAGES"         => "", 
        "KEEP_REAL_NAMES"       => false,
        "SEARCH_FILES_INTERVAL" => 7,
        "IS_ALLOWED_DELETE"     => false,
        "IS_ALLOWED_FLASH"      => true,        
        "SCRIPT_DELETE"         => ""
    );  
    
    
    $PROFILE_UPLOAD["home"] = array(
        "PATH_IMAGES"           => "imagensHome/",
        "PREFIX_IMAGES"         => "", 
        "KEEP_REAL_NAMES"       => true,
        "SEARCH_FILES_INTERVAL" => 7,
        "IS_ALLOWED_DELETE"     => true,
        "IS_ALLOWED_FLASH"      => true,        
        "SCRIPT_DELETE"         => "crazyuploader_delete_file.php"
    );    
    
    
    /**************************************************************************
     * DOCUMENTATION                                                          *
     **************************************************************************/
    
    # PREFIX_IMAGES
    # >> Prefix to the names of the uploaded imagens
    # : String

    
    # KEEP_REAL_NAMES
    # >> Keep the real name of the imagens, otherwise it generates a name for the file
    # : Boolean    
    
    
    # SEARCH_FILES_INTERVAL
    # >> Number of files in the list
    # : Integer    
    
    
    # IS_ALLOWED_DELETE    
    # >> Say if it's allowed to delete
    # : Boolean    
    
    
    # IS_ALLOWED_FLASH    
    # >> Say if it's allowed to upload flash (swf)
    # : Boolean  
    
    
    # SCRIPT_DELETE
    # >>
    # : String (Path)
    #
    # Script that deletes files from the server
    # The plugin will always pass the name of the file via POST as fileName variable / $_POST["fileName"] in UTF-8
    # So you will able to do all validations you need
    #
    # Pay attention:
    #
    # This file need to return a JSON data in the following format: 
    # { "deleted" : "ok", "msgError" : "Any message you want the system to display" }
    # 
    # if "deleted" != "ok" the system will send your message for the user
    #
    # You must put the path from this root
    
?>