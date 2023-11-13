'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.panel-close-button',function(button) {
        $('#component_editor').hide();      
    });
});