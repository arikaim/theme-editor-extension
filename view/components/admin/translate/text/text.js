'use strict';

arikaim.page.onReady(function() {  
    arikaim.ui.form.onSubmit('#translate_text_form',function() {
        var text = $('#text').val();
        var language = $('#choose_language').dropdown('get value');
        $('#translated_text').val('');
        
        return translations.translate(text,language,'auto',function(result) {
            $('#translated_text').val(result.text)
        });
    },function(result) {
        arikaim.ui.form.showMessage(result.message);              
    });
});