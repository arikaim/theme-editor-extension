/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function TranslationEditor() {
    var self = this;

    this.loadProperty = function(theme, language, propertyKey, componentName, type) {
        arikaim.page.loadContent({
            id: 'property_' + propertyKey,
            component: 'translations::admin.translate.template.details.translation.editor.item',
            params: { 
                theme_name: theme,
                language: language,
                component_name: componentName,
                property_key: propertyKey,
                type: type
            }
        },function(result) {
            self.init();
        });
    };

    this.init = function() {

        arikaim.ui.button('.edit-property',function(element) {
            var theme = $(element).attr('theme');
            var type = $(element).attr('type');
            var language = $(element).attr('language');
            var componentName = $(element).attr('component-name');
            var propertyKey = $(element).attr('property-key');
         
            $('.cancel-button').click();

            arikaim.page.loadContent({
                id: 'property_' + propertyKey,
                component: 'translations::admin.translate.template.details.translation.editor.item.edit',
                params: { 
                    theme_name: theme,
                    language: language,
                    component_name: componentName,
                    type: type,
                    property_key: propertyKey
                }
            });
        });    
    };
}

var translationEditor = new TranslationEditor();

$(document).ready(function() {
    translationEditor.init();
});