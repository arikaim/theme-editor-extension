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
        $this->addApiRoute('PUT','/api/editor/admin/translate','EditorControlPanel','translate','session');   
        $this->addApiRoute('POST','/api/editor/admin/translate/model','EditorControlPanel','translateModel','session');   
        $this->addApiRoute('POST','/api/editor/admin/translate/save/property','EditorControlPanel','saveTranslationProperty','session');   
        // Theme component editor
        $this->addApiRoute('POST','/api/editor/admin/translate/component','EditorControlPanel','createComponentTranslation','session');                 
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
