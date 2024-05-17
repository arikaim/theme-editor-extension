'use strict';

arikaim.component.onLoaded(function() {   
    arikaim.ui.button('.save-file',function(element) {
        var content = editorControlPanel.editor.getValue();
        var theme = $('#theme').val();
        var fileName = $('#file_name').val();
        var type = $('#type').val();
 
        editorControlPanel.saveThemeFile(theme,fileName,type,content,function(result) {          
            arikaim.page.toastMessage(result.message);    
            $('.save-file').addClass('disabled');          
        },function(error) {
            arikaim.page.toastMessage({
                class: 'error',
                message: error
            });       
        });       
    });
}); 