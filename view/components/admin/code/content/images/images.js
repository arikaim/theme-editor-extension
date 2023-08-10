'use strict';

arikaim.component.onLoaded(function() {  
    arikaim.ui.button('.help-image-file',function(element) {
        var theme = $(element).attr('theme');
        var fileName = $(element).attr('file-name');     

        arikaim.page.loadContent({
            id: 'edit_file',
            component: 'editor::admin.code.content.images.help',
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
                component: 'editor::admin.code.content.images',
                params: { 
                    theme_name: themeCodeEditor.getCurrentTheme()               
                }
            });  
        },'themeCodeEditorImageUpload');

        arikaim.page.loadContent({
            id: 'edit_file',
            component: 'editor::admin.code.content.images.upload',
            params: { 
                theme_name: theme               
            }
        });    
    });
}); 