/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ThemeEditor() {
    var self = this;

    this.loadThemeEdit = function(theme, language) {
        arikaim.page.loadContent({
            id: 'editor',
            component: "editor::admin.editor.edit",
            params: { 
                theme_name : theme,
                language: language
            },
            useHeader: true
        },function(result) {
            self.initRows()
        });     
    };

    this.init = function() {

        $('#templates_dropdown').dropdown({
            onChange: function(name) {
                var language = $('#choose_language').dropdown('get value');
                self.loadThemeEdit(name,language);                
            }
        });   

        $('#choose_language').dropdown({
            onChange: function(value) {
                var theme = $('#templates_dropdown').dropdown('get value');            
                self.loadThemeDetails(theme,value);                        
            }
        });

        arikaim.ui.button('.reload-theme-details',function(element) {
            var theme = $('#templates_dropdown').dropdown('get value');
            var language = $('#choose_language').dropdown('get value');

            self.loadThemeDetails(theme,language);
        });       
    };

    this.editTranslation = function(theme, language, componentName, type) {
        arikaim.page.loadContent({
            id: 'translation_content',
            component: 'translations::admin.translate.template.details.translation',
            params: { 
                theme_name: theme,
                language: language,
                component_name: componentName,
                type: type
            }
        });
    };

    this.loadChildComponents = function(theme, language, parent, id, type) {  
        
        var componentName = (type == 'pages') ? 'pages' : 'components';

        arikaim.page.loadContent({
            id: 'components_content_' + id,
            component: 'translations::admin.translate.template.details.' + componentName,
            params: { 
                theme_name: theme,
                language: language,
                parent_component: parent,               
                type: type
            }
        },function(result) {
            self.initRows();
        });
    };

    this.loadThemeComponents = function(theme, language, type) {

        if (type == 'pages') {
            var componentName = 'pages';
            var id = "theme_pages";
        } else {
            var componentName = 'components';
            var id = "theme_components";
        }
        $('.theme-components').html("");

        arikaim.page.loadContent({
            id: id,
            component: 'translations::admin.translate.template.details.' + componentName,
            params: { 
                theme_name: theme,
                language: language
            }
        },function(result) {
            self.initRows();
        });
    };

    this.initRows = function() {

        arikaim.ui.button('.load-child-components',function(element) {
            var parent = $(element).attr('parent');
            var type = $(element).attr('type');
            var theme = $(element).attr('theme');
            var language = $(element).attr('language');
            var id = $(element).attr('component-id');
            $('#components_content_' + id).show();
            
            return self.loadChildComponents(theme,language,parent,id,type);
        });

        arikaim.ui.button('.create-translation',function(element) {
            var theme = $(element).attr('theme');
            var type = $(element).attr('type');
            var language = $(element).attr('language');
            var componentName = $(element).attr('component-name');    
            $('#translation_content').html("");

            return translations.translateComponent(theme,componentName,language,type,function(result) {
                $(element).addClass('invisible');
                arikaim.ui.show('#edit_translaton_' + componentName);
           
                self.editTranslation(result.theme,result.language,result.component,result.type);   
            },function(error) {               
                arikaim.page.toastMessage({
                    message: error[0],
                    class: 'error'
                });
            });
        });

        arikaim.ui.button('.edit-translation',function(element) {
            var theme = $(element).attr('theme');
            var type = $(element).attr('type');
            var language = $(element).attr('language');
            var componentName = $(element).attr('component-name');
          
            self.editTranslation(theme,language,componentName,type);            
        });    
    };
}

var themeEditor = new ThemeEditor();

$(document).ready(function() {
    themeEditor.init();    
});