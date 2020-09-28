'use strict';

$(document).ready(function() {  
    $('.accordion').accordion({
        onOpen: function() {
            var language = $(this).attr('language');
            var theme = $(this).attr('theme');
            var type = $(this).attr('type');
           
            templateTranslations.loadThemeComponents(theme,language,type)
        },
        onClose: function() {
            $(this).html("");
        }
    }); 
});