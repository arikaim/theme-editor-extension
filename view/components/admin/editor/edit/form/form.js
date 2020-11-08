'use strict';

$(document).ready(function() {      
    var theme = $('#theme').val();
    var componentName = $('#component_name').val();
    var type = $('#type').val();

    editorControlPanel.loadComponentFile(theme, componentName, type,function(result) {

        arikaim.component.loadLibrary('codemirror:eclipse',function() {
            var textArea = document.getElementById('code_content');

            arikaim.component.loadLibrary('codemirror:template',function() {
                editorControlPanel.editor = CodeMirror.fromTextArea(textArea, {
                    lineNumbers: true,
                    styleActiveLine: true,
                    lineWrapping: true,
                    htmlMode: true,                  
                    mode: "xml"
                });
                editorControlPanel.editor.setValue(result.content);     
                editorControlPanel.editor.setSize('100%','100%');  

                editorControlPanel.editor.on('change',function(CodeMirror,changeObj) {
                    $('.save-file').removeClass('disabled');                   
                });           
            });
        });  
              
    });    
}); 