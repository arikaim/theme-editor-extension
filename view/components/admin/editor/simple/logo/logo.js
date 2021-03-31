'use strict';

arikaim.component.onLoaded(function() {
    imageUpload.onSuccess = function(result) {
        var theme = $('#image_content').attr('theme-name');
        
        arikaim.page.loadContent({
            id: 'image_content',
            component: 'editor::admin.editor.simple.logo.image',
            params: { 
                theme_name: theme
            }
        });
    };
});