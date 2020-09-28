'use strict';

$(document).ready(function() {
    $('#drivers_dropdown').on('change',function() {
        var driverName = $('#drivers_dropdown').dropdown('get value');
        arikaim.page.loadContent({
            id: 'driver_config',
            component: 'system:admin.modules.drivers.config.form',
            params: { driver_name: driverName }
        });    
    });
});