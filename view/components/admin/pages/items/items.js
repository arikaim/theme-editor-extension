'use strict';

arikaim.component.onLoaded(function() {   
    safeCall('pagesControlPanel',function(obj) {
        obj.initRows();
    },true);
}); 