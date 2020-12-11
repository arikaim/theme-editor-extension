/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function EditorControlPanel() {
    this.editor = null;

    this.loadComponentFile = function(theme, componentName, type, onSuccess, onError) {
        var data = {
            theme: theme,
            component: componentName,         
            type: type
        };

        return arikaim.put('/api/editor/admin/load/component/file',data,onSuccess,onError);
    };   
    
    this.saveComponentFile = function(theme, componentName, type, content, onSuccess, onError) {    
        var data = {
            theme: theme,
            component: componentName,   
            content: content,     
            type: type
        };

        return arikaim.put('/api/editor/admin/save/component/file',data,onSuccess,onError);
    }; 

    this.savePageMetaTags = function(formId, onSuccess, onError) {    
        return arikaim.put('/api/editor/admin/save/pages/metatags',formId,onSuccess,onError);
    }; 

    this.setStatus = function(uuid, status, onSuccess, onError) { 
        var data = { 
            status: status,
            uuid: uuid 
        };
        
        return arikaim.put('/api/editor/admin/pages/status',data,onSuccess,onError);           
    };
    
    this.init = function() {
        arikaim.ui.tab();        
    };
}

var editorControlPanel = new EditorControlPanel();

arikaim.page.onReady(function() {
    editorControlPanel.init();
});