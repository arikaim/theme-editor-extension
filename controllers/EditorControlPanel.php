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
use Arikaim\Core\Utils\File;

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
     *  Read file
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return mixed
    */
    public function loadComponentFileController($request, $response, $data) 
    { 
        $type = $data->get('type','components');
        $theme = $data->get('theme',null);
        $component = $data->get('component');
     
        $packageManager = $this->get('packages')->create('template');
        $package = $packageManager->createPackage($theme);
        if (\is_object($package) == false) {
            $this->error('errors.theme_name');
            return false;
        }

        $path = $package->getComponentPath($component,$type);
        $fileName = $path . DIRECTORY_SEPARATOR . $this->getComponentFileName($component);
        if (empty($path) == true) {
            $this->error('errors.path');
            return false;
        }
        if (File::exists($fileName) == false) {
            $this->error('errors.code');
            return false;
        }
        
        $fileContent = File::read($fileName);
                  
        $this
            ->message('file.load')
            ->field('theme',$theme)
            ->field('content',$fileContent)
            ->field('type',$type)                 
            ->field('component',$component);                                               
    }

    /**
     *  Save file
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return mixed
    */
    public function saveComponentFileController($request, $response, $data) 
    {  
        $data
            ->addRule('text:min=2','theme')             
            ->validate(true);  
       
        $theme = $data->get('theme');           
        $type = $data->get('type');
        $component = $data->get('component');
        $content = $data->get('content');

        $packageManager = $this->get('packages')->create('template');
        $package = $packageManager->createPackage($theme);
        if (\is_object($package) == false) {
            $this->error('errors.theme_name');
            return false;
        }

        $path = $package->getComponentPath($component,$type);
        $fileName = $path . DIRECTORY_SEPARATOR . $this->getComponentFileName($component);
        if (File::exists($fileName) == false) {
            $this->error('errors.file');
            return false;
        }
        if (File::isWritable($fileName) == false) {
            File::setWritable($fileName);
        }

        $result = File::write($fileName,$content);

        $this->setResponse($result,function() use($theme,$component,$type) {                                
            $this
                ->message('file.save')
                ->field('theme',$theme)
                ->field('type',$type)                 
                ->field('component',$component);                                       
        },'errors.save');    
    }

    /**
     * Get component file name.
     *
     * @param string $componentName
     * @return string
     */
    protected function getComponentFileName($componentName)
    {
        $tokens = \explode('.',$componentName);

        return \last($tokens) . '.html';
    }
}
