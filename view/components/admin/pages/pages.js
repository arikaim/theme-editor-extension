/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function PagesControlPanel() {
    var self = this;
    
    this.setStatus = function(uuid, status, onSuccess, onError) { 
        var data = { 
            status: status,
            uuid: uuid 
        };
        
        return arikaim.put('/api/editor/admin/pages/status',data,onSuccess,onError);           
    };

    this.init = function() {
        paginator.init('view_pages',{
            name: 'editor::admin.pages.items',
            params: {}
        },'pages',{
            selector: 'paginator',
            component: 'components:paginator',
            params: {}
        });    
    };

    this.loadItem = function(uuid) {
        arikaim.page.loadContent({
            id: 'route_' + uuid,
            component: 'editor::admin.pages.item',
            params: { uuid: uuid }
        },function(result) {
            self.initRows();
        }); 
    };

    this.initRows = function() {
        arikaim.ui.button('.status-route',function(element) {
            var uuid = $(element).attr('uuid');
            var status = $(element).attr('status')

            return self.setStatus(uuid,status,function(result) {
                self.loadItem(uuid);
            });
        });
    };
}

var pagesControlPanel = new PagesControlPanel();

arikaim.page.onReady(function() {
    pagesControlPanel.init();
});