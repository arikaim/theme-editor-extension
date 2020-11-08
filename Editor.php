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
        $this->addApiRoute('PUT','/api/editor/admin/load/component/file','EditorControlPanel','loadComponentFile','session'); 
        $this->addApiRoute('PUT','/api/editor/admin/save/component/file','EditorControlPanel','saveComponentFile','session');   
        $this->addApiRoute('PUT','/api/editor/admin/pages/status','PagesControlPanel','setStatus','session');   
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
