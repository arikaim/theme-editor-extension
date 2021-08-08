<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Editor;

use Arikaim\Core\Extension\Extension;

/**
 * Theme editor extension
*/
class Editor extends Extension
{
    /**
     * Install extension routes, events, jobs ..
     *
     * @return void
    */
    public function install()
    {
        // Control Panel
        $this->addApiRoute('PUT','/api/admin/editor/load/component/file','EditorControlPanel','loadComponentFile','session'); 
        $this->addApiRoute('PUT','/api/admin/editor/save/component/file','EditorControlPanel','saveComponentFile','session');   
        $this->addApiRoute('PUT','/api/admin/editor/save/pages/metatags','PagesControlPanel','saveMetatags','session'); 
        // files
        $this->addApiRoute('PUT','/api/admin/editor/file/load/{theme}/{name}','FilesControlPanel','loadFile','session');
        
        // options
        $this->createOption('editor.mode','simple');   
    }
    
    /**
     * UnInstall
     *
     * @return void
     */
    public function unInstall()
    {         
    }
}
