'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.editor-menu-item',function(element) {
        var componentName = $(element).attr('component');
        var editorItem = $(element).attr('editor-item');
        var theme = $(element).attr('theme-name');

        return arikaim.page.loadContent({
            id: 'simple_editor_content',
            component: 'editor::admin.editor.simple.edit',
            params: { 
                theme_name: theme,
                component: componentName,
                editor_item: editorItem                       
            }
        });
    });
});