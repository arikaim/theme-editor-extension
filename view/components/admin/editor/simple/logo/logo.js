'use strict';

arikaim.component.onLoaded(function() {
    imageUpload.onSuccess = function(result) {
        console.log(result);
    };
});