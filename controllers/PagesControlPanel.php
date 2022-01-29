<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Editor\Controllers;

use Arikaim\Core\Utils\File;
use Arikaim\Core\Utils\Utils;
use Arikaim\Core\Controllers\ControlPanelApiController;

/**
 * Pages control panel controller
*/
class PagesControlPanel extends ControlPanelApiController
{
    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('editor::admin.messages');
    }

    /**
     *  Save page metatags
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function saveMetatagsController($request, $response, $data) 
    {  
        $this->onDataValid(function($data) {           
            $theme = $data->get('theme');
            $language = $data->get('language');          
            $componentName = $data->get('component_name');
            $component = \str_replace('_','.',$componentName);
        
            $packageManager = $this->get('packages')->create('template');
            $template = $packageManager->createPackage($theme);
            if (\is_object($template) == false) {
                $this->error('errors.theme_name');
                return false;
            }
            
            $translation = $template->readTranslation($component,$language,'pages');
            if ($translation === false) {
                $this->error('errors.translation.file');
                return false;
            }
            
            $translation['head']['title'] = $data->get('title','');
            $translation['head']['description'] = $data->get('description','');
            $translation['head']['keywords'] = $data->get('keywords','');

            $path = $template->getComponentPath($componentName,'pages');
            $fileName = $template->resolveTranslationFileName($path,$language);  

            $result = File::write($fileName,Utils::jsonEncode($translation));

            $this->setResponse($result,function() use($language,$theme,$componentName) {                                
                $this
                    ->message('metatags.save')
                    ->field('theme',$theme)           
                    ->field('component',$componentName)
                    ->field('language',$language);                         
            },'errors.metatags.save');
        });
        $data
            ->addRule('text:min=2','theme')  
            ->addRule('text:min=2','language')  
            ->addRule('text:min=1','component_name')
            ->validate();
    }
}
