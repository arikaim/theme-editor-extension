'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.edit-component',function(button) {
        var componentName = $(button).attr('component');
        console.log(componentName);

        $('#component_editor').show();
        
        arikaim.page.loadContent({
            id: 'component_editor',
            component: 'editor::admin.editor.components.editor',
            params: { 
                component_name: componentName               
            }
        });
    });
});