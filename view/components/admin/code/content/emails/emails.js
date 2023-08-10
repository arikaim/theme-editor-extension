'use strict';

arikaim.component.onLoaded(function() {  
    safeCall('themeCodeEditor',function(obj) {
        obj.initRows();
    },true);   
}); 