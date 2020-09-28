'use strict';

arikaim.page.onReady(function() {    
    arikaim.ui.form.addRules("#translate_text_form",{
        inline: false,
        fields: {
            text: {
                identifier: "text",      
                rules: [{
                    type: "minLength[2]"       
                }]
            }
        }
    });   
});