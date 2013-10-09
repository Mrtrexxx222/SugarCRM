/**
 * editor_plugin_src.js
 *
 * Copyright 2012, Sandro Alves Peres
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function()
{
	tinymce.create('tinymce.plugins.CrazyUploaderPlugin', 
    {
		init : function(ed, url) {
			var t = this;

			t.editor = ed;

			// Comando que abre a janela do editor
			ed.addCommand('mceCrazyUploader', function(ui)
            {                
				ed.windowManager.open({
					file : url + '/crazyuploader.php',
					width : ed.getParam('crazyuploader_popup_width', 700),
					height : ed.getParam('crazyuploader_popup_height', 420),
					inline : 1
				}, 
                {
					plugin_url : url
				});
			});

			ed.addCommand('mceInsertCrazyUploader', t._insertCrazyUploader, t);

			// Adiciona o botão do CrazyUploader
			ed.addButton('crazyuploader', {
                title : "Crazy Uploader", 
                image: url + '/img/crazyuploader_icon.png', 
                cmd : 'mceCrazyUploader'
            });
		},

		getInfo : function()
        {
			return {
				longname : 'CrazyUploader plugin',
				author : 'Sandro Alves Peres',
				authorurl : 'http://www.facebook.com/SandroAlvesPeres',
				infourl : '',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('crazyuploader', tinymce.plugins.CrazyUploaderPlugin);
})();