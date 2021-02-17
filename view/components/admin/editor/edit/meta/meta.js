'use strict';

arikaim.component.onLoaded(function() {     
    $('#choose_language').dropdown({
        onChange: function(value) {
            var theme = $('#templates_dropdown').dropdown('get value');
            var componentName = $('#component_name').html();

            arikaim.page.loadContent({
                id: 'meta_tags_content',
                component: 'editor::admin.editor.edit.meta.form',
                params: { 
                    theme_name: theme,
                    theme_component: componentName,
                    language: value
                }
            });
        }
    });
}); 