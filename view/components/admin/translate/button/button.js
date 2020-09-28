'use strict';

arikaim.page.onReady(function() { 
    var translationCallback = null;

    arikaim.ui.button('.translate-button',function(element) {        
        var options = {
            uuid: $(element).attr('model-uuid'),
            fields: $(element).attr('fields'),
            language: $(element).attr('language'),
            extension: $(element).attr('extension'),
            model: $(element).attr('model')           
        };
        translationCallback = $(element).attr('callback');

        return translations.translateModel(options);
    },function(result) {
        callFunction(translationCallback,result);
    });
});