'use strict';

arikaim.component.onLoaded(function() {  
    safeCall('themeEditor',function(obj) {
        obj.initRows();
    },true);   
}); 