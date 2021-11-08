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
        // Files
        $this->addApiRoute('GET','/api/admin/editor/file/load/{theme}/{name}/{type}','FilesControlPanel','loadFile','session');
        $this->addApiRoute('PUT','/api/admin/editor/file/save','FilesControlPanel','saveFile','session');   
        // Options
        $this->createOption('editor.mode','simple');  
        $this->createOption('editor.current.theme',null);   
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
