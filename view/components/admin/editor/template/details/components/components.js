'use strict';

$(document).ready(function() {     
    safeCall('templateTranslations',function(obj) {
        obj.initRows();
    },true);   
}); 