/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function TranslationsControlPanel() {
  
    this.translateComponent = function(theme, componentName, language, type, onSuccess, onError) {
        var data = {
            theme: theme,
            component_name: componentName,
            language: language,
            type: type
        };

        return arikaim.post('/api/translations/admin/translate/component',data,onSuccess,onError);
    };

    this.saveComponentProperty = function(formId, onSuccess, onError) {
        return arikaim.post('/api/translations/admin/translate/save/property',formId,onSuccess,onError); 
    };

    this.translate = function(text, targetLanguage, sourceLanguage, onSuccess, onError) {
        sourceLanguage = getDefaultValue(sourceLanguage,'auto');
        var data = {
            target_language: targetLanguage,
            source_language: sourceLanguage,
            text: text
        };
        
        return arikaim.put('/api/translations/admin/translate',data,onSuccess,onError);          
    };

    this.translateModel = function(options, onSuccess, onError) {        
        return arikaim.post('/api/translations/admin/translate/model',options,onSuccess,onError);          
    };

    this.init = function() {    
        arikaim.ui.tab();
    };
}

var translations = new TranslationsControlPanel();

arikaim.page.onReady(function() {
    translations.init();
});