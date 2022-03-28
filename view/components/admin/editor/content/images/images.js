'use strict';

arikaim.component.onLoaded(function() {  
    arikaim.ui.button('.help-image-file',function(element) {
        var theme = $(element).attr('theme');
        var fileName = $(element).attr('file-name');     

        arikaim.page.loadContent({
            id: 'edit_file',
            component: 'editor::admin.editor.content.images.help',
            params: { 
                theme_name: theme,
                file_name: fileName
            }
        });          
    });  
    
    arikaim.ui.button('.upload-image',function(element) {
        var theme = $(element).attr('theme');

        arikaim.events.on('image.upload',function(theme) {
            $('#edit_file').html('');
            
            arikaim.page.loadContent({
                id: 'edit_items',
                component: 'editor::admin.editor.content.images',
                params: { 
                    theme_name: themeEditor.getCurrentTheme()               
                }
            });  
        },'themeEditorImageUpload');

        arikaim.page.loadContent({
            id: 'edit_file',
            component: 'editor::admin.editor.content.images.upload',
            params: { 
                theme_name: theme               
            }
        });    
    });
}); 