'use strict';

$(document).ready(function() {      
    var theme = $('#theme').val();
    var componentName = $('#component_name').val();
    var type = $('#type').val();

    editorControlPanel.loadComponentFile(theme,componentName,type,function(result) {          
        themeEditor.loadCodeEditor(result.content,function() {
            console.log('remove');
            $('#code_loader').remove();
        });                     
    },function(error) {
        arikaim.page.loadContent({
            id: 'file_content',
            component: "editor::admin.editor.edit.code.form.message"                       
        });  
    });        
}); 