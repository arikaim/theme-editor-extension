'use strict';

arikaim.component.onLoaded(function() {
    imageUpload.onSuccess = function(result) {
        var theme = $('#image_content').attr('theme-name');
        
        arikaim.page.loadContent({
            id: 'image_content',
            component: 'editor::admin.code.simple.logo.image',
            params: { 
                theme_name: theme
            }
        });
    };
});