'use strict';

arikaim.component.onLoaded(function() {  
    arikaim.ui.button('.edit-css-file',function(element) {
        var theme = $(element).attr('theme');
        var fileName = $(element).attr('file-name');           
      
        themeCodeEditor.editThemeFile(theme,fileName,'css','css');            
    });    
}); 