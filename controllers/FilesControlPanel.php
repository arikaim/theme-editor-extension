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
        $data
            ->addRule('text:min=2','theme')             
            ->addRule('text:min=1','file_name')
            ->validate(true);

        $theme = $data->get('theme');
        $type = $data->get('type','css');
        $fileName = $data->get('name');          
        
        $packageManager = $this->get('packages')->create('template');
        $package = $packageManager->createPackage($theme);
        if (\is_object($package) == false) {
            $this->error('errors.theme_name');
            return false;
        }
        $properties = $package->getProperties(true);
        $filePath = $properties['path'] . $type .  DIRECTORY_SEPARATOR . $fileName;
        
        $fileContent = File::read($filePath);

        $this->setResponse(($fileContent != null),function() use($fileName,$theme,$fileContent,$type) {                                
            $this
                ->message('file.load')
                ->field('theme',$theme)     
                ->field('type',$type)           
                ->field('file_name',$fileName)
                ->field('content',$fileContent);                         
        },'errors.load');
    }

    /**
     *  Save template file (css,js)
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function saveFileController($request, $response, $data) 
    {  
        $data
            ->addRule('text:min=2','theme')           
            ->addRule('text:min=1','file_name')
            ->validate(true);

        $theme = $data->get('theme');
        $type = $data->get('type','css');
        $fileName = $data->get('file_name');          
        $content = $data->get('content','');

        $packageManager = $this->get('packages')->create('template');
        $package = $packageManager->createPackage($theme);
        if (\is_object($package) == false) {
            $this->error('errors.theme_name');
            return false;
        }
        $properties = $package->getProperties(true);
        $filePath = $properties['path'] . $type .  DIRECTORY_SEPARATOR . $fileName;
        
        if (File::isWritable($filePath) == false) {
            File::setWritable($filePath);
        }

        $result = File::write($filePath,$content);

        $this->setResponse($result,function() use($fileName,$theme,$content,$type) {                                
            $this
                ->message('file.save')
                ->field('theme',$theme)     
                ->field('type',$type)           
                ->field('file_name',$fileName)
                ->field('content',$content);                         
        },'errors.file.save');
    }
}
