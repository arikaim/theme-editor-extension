'use strict';

$(document).ready(function() {      
    safeCall('pagesControlPanel',function(obj) {
        obj.initRows();
    },true);
}); 