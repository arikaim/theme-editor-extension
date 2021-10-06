'use strict';

arikaim.component.onLoaded(function() {  
    var theme = $('#theme').val();
    var fileName = $('#file_name').val();
    var type = $('#type').val();
    var mode = $('#mode').val();

    editorControlPanel.loadThemeFile(theme,fileName,type,function(result) {    
        console.log(mode);      
        themeEditor.loadCodeEditor(result.content,function() {               
            $('#code_loader').remove();
        },mode);                     
    },function(error) {
        arikaim.page.loadContent({
            id: 'file_content',
            component: "editor::admin.editor.edit.code.form.message"                       
        });  
    });      
    
}); 