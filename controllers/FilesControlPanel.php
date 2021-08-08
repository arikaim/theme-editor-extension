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
 * Files control panel controller
*/
class FilesControlPanel extends ControlPanelApiController
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
     *  Load template file (css,js)
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function loadFileController($request, $response, $data) 
    {  
        $this->onDataValid(function($data) {           
            $theme = $data->get('theme');
            $fileName = $data->get('name');          
           
            $packageManager = $this->get('packages')->create('template');
            $package = $packageManager->createPackage($theme);
            if (\is_object($package) == false) {
                $this->error('errors.theme_name');
                return false;
            }
            $properties = $package->getProperties(true);
            $filePath = $properties['path'] . 'css' .  DIRECTORY_SEPARATOR . $fileName;
            
            $fileContent = File::read($filePath);

            $this->setResponse(($fileContent != null),function() use($fileName,$theme,$fileContent) {                                
                $this
                    ->message('file.load')
                    ->field('theme',$theme)           
                    ->field('file_name',$fileName)
                    ->field('content',$fileContent);                         
            },'errors.metatags.save');
        });
        $data
            ->addRule('text:min=2','theme')  
            ->addRule('text:min=2','language')  
            ->addRule('text:min=1','component_name')
            ->validate();
    }
}
