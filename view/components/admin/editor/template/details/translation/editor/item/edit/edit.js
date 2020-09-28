'use strict';

$(document).ready(function() {
    arikaim.ui.form.onSubmit('.save-property-form',function() {       
        var key = $("#property_key").val();

        return translations.saveComponentProperty('#property_form_' + key);
    },function(result) {
        arikaim.page.toastMessage(result.message);
        translationEditor.loadProperty(result.theme,result.language,result.key,result.component,result.type);
    });

    arikaim.ui.button('.cancel-button',function(element) {
        var theme = $(element).attr('theme');
        var language = $(element).attr('language');
        var componentName = $(element).attr('component-name');
        var propertyKey = $(element).attr('property-key');
        var type = $(element).attr('type');

        translationEditor.loadProperty(theme,language,propertyKey,componentName,type);
    });    
});
