/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function EditorControlPanel() {
    this.editor = null;

    this.loadThemeFile = function(theme, fileName, type, onSuccess, onError) {
        type = (isEmpty(type) == true) ? 'css' : type;
        
        return arikaim.get('/api/admin/editor/file/load/' + theme + '/' + fileName + '/' + type,onSuccess,onError);
    };

    this.saveThemeFile = function(theme, fileName, type, content, onSuccess, onError) {      
        var data = {
            theme: theme,
            file_name: fileName,
            type: (isEmpty(type) == true) ? 'css' : type,
            content: content
        };

        return arikaim.put('/api/admin/editor/file/save',data,onSuccess,onError);
    };

    this.loadFile = function(theme, componentName, type, onSuccess, onError) {
        var data = {
            theme: theme,
            component: componentName,         
            type: type
        };

        return arikaim.put('/api/admin/editor/load/component/file',data,onSuccess,onError);
    };   

    this.loadComponentFile = function(theme, componentName, type, onSuccess, onError) {
        var data = {
            theme: theme,
            component: componentName,         
            type: type
        };

        return arikaim.put('/api/admin/editor/load/component/file',data,onSuccess,onError);
    };   
    
    this.saveComponentFile = function(theme, componentName, type, content, onSuccess, onError) {    
        var data = {
            theme: theme,
            component: componentName,   
            content: content,     
            type: type
        };

        return arikaim.put('/api/admin/editor/save/component/file',data,onSuccess,onError);
    }; 

    this.savePageMetaTags = function(formId, onSuccess, onError) {    
        return arikaim.put('/api/admin/editor/save/pages/metatags',formId,onSuccess,onError);
    }; 

    this.setStatus = function(uuid, status, onSuccess, onError) { 
        var data = { 
            status: status,
            uuid: uuid 
        };
        
        return arikaim.put('/api/admin/editor/pages/status',data,onSuccess,onError);           
    };
    
    this.init = function() {
        arikaim.ui.tab();        
    };
}

var editorControlPanel = new EditorControlPanel();

arikaim.component.onLoaded(function() {
    editorControlPanel.init();
});