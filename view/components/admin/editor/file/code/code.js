'use strict';

arikaim.component.onLoaded(function() {   
    arikaim.ui.button('.save-file',function(element) {
        var content = editorControlPanel.editor.getValue();
        var theme = $('#theme').val();
        var componentName = $('#file_name').val();
        var type = $('#type').val();
 
        editorControlPanel.saveComponentFile(theme,componentName,type, content,function(result) {          
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