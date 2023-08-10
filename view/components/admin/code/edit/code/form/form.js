'use strict';

arikaim.component.onLoaded(function() {  
    var theme = $('#theme').val();
    var componentName = $('#component_name').val();
    var type = $('#type').val();

    editorControlPanel.loadComponentFile(theme,componentName,type,function(result) {          
        themeCodeEditor.loadCodeEditor(result.content,function() {          
            $('#code_loader').remove();
        });                     
    },function(error) {
        arikaim.page.loadContent({
            id: 'file_content',
            component: "editor::admin.code.edit.code.form.message"                       
        });  
    });        
}); 