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

use Arikaim\Core\Controllers\ControlPanelApiController;
use Arikaim\Core\Db\Model;
use Arikaim\Core\Utils\File;
use Arikaim\Core\Utils\Utils;
use Arikaim\Core\Collection\Arrays;

/**
 * Theme editor control panel controller
*/
class EditorControlPanel extends ControlPanelApiController
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
     *  Save file
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function saveFileController($request, $response, $data) 
    {  
        $this->onDataValid(function($data) {              
            $packageManager = $this->get('packages')->create('template');

            $template = $packageManager->createPackage($theme);
            if (\is_object($template) == false) {
                $this->error('errors.theme_name');
                return false;
            }

            $this->setResponse($result,function() use($language,$theme,$propertyKey,$componentName,$type) {                                
                $this
                    ->message('property.save')
                    ->field('theme',$theme)
                    ->field('type',$type)
                    ->field('key',$propertyKey)
                    ->field('component',$componentName)
                    ->field('language',$language);                         
            },'errors.property.save');
        });
        $data
            ->addRule('text:min=2','theme')             
            ->validate();   
    }
}
