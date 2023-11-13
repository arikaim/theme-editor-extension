/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ThemeEditor() {
    var self = this;

    this.getCurrentTheme = function() {
        return $('#templates_dropdown').dropdown('get value');
    };

    this.init = function() {
        $('#templates_dropdown').dropdown({
            onChange: function(name) {
                self.laodPageSelector(name); 
                options.save('editor.current.theme',name);                    
            }
        });              
    };

    this.laodPageSelector = function(theme) {
        $('#page_label').show();

        arikaim.page.loadContent({
            id: 'page_selector',
            component: 'editor::admin.editor.pages.dropdown',
            params: { 
                theme_name: theme               
            }
        },function(result) {
            $('.page-dropdown').dropdown({
                onChange: function(page) {
                    self.loadEditor(self.getCurrentTheme(),page);
                }
            });
        });
    };

    this.loadEditor = function(theme, page) {
        arikaim.page.loadContent({
            id: 'page_editor',
            component: 'editor::admin.editor.pages.edit',
            params: { 
                theme: theme,
                page_name: page,
                full_screen_button: true             
            }
        },function(result) {
          
        });
    }
}

var themeEditor = new ThemeEditor();

arikaim.component.onLoaded(function() {
    themeEditor.init();
});