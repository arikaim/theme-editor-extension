'use strict';

$(document).ready(function() {      
    safeCall('themeEditor',function(obj) {
        obj.initRows();
    },true);   
}); 