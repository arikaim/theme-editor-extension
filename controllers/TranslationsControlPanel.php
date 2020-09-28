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
     * Translate component
     *
     * @param array $translation
     * @param string $language
     * @param object $driver
     * @return array|false
     */
    public function translateComponent(array $translation, $language, $driver)
    {
        foreach ($translation as $key => $value) {
            if (\is_array($value) == true) {
                $translation[$key] = $this->translateComponent($value,$language,$driver);
            } else {
                $translatedText = $driver->getInstance()->translate($value,$language);
                if ($translatedText === false) {
                    return false;
                }
                $translation[$key] = $translatedText;
            }           
        }

        return $translation;
    }

    /**
     *  Create component translation
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function createComponentTranslationController($request, $response, $data)
    {
        $this->onDataValid(function($data) {      
            $type = $data->get('type','components'); 
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

            $translationFileName = $template->getTranslationFileName($component,$language,$type);
            if (File::exists($translationFileName) == true) {
                $this->error('errors.translation.exists');
                return false;
            }
            // Read english translation file
            $translation = $template->readTranslation($component,'en',$type);
            if ($translation === false) {
                $this->error('errors.translation.file');
                return false;
            }
            $path = ($type == 'components') ? $template->getComponentPath($componentName) : $template->getPagePath($componentName);
            $newFile = $template->resolveTranslationFileName($path,$language);      

            if (File::setWritable($path) == false) {
                $this->error('errors.translation.writable');
                return false;
            }            
            $driver = $this->createTranslationDriver();
            $translation = $this->translateComponent($translation,$language,$driver);
            if ($translation === false) {
                $this->error('errors.translation.api');
                return false;
            }

            $result = File::write($newFile,Utils::jsonEncode($translation));

            $this->setResponse($result,function() use($language,$theme,$componentName,$type) {                                
                $this
                    ->message('translation.create')
                    ->field('theme',$theme)      
                    ->field('type',$type)             
                    ->field('component',$componentName)
                    ->field('language',$language);                         
            },'errors.translation.create');
           
        });
        $data
            ->addRule('text:min=2','theme')  
            ->addRule('text:min=2','language')  
            ->addRule('text:min=1','component_name')
            ->validate();   
    }

    /**
     *  Save translation property
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function saveTranslationPropertyController($request, $response, $data) 
    {  
        $this->onDataValid(function($data) {  
            $type = $data->get('type','components');       
            $theme = $data->get('theme');
            $language = $data->get('language');
            $propertyKey = $data->get('property_key');
            $componentName = $data->get('component_name');
            $component = \str_replace('_','.',$componentName);
            $value = $data->get('property_value');
            $packageManager = $this->get('packages')->create('template');

            $template = $packageManager->createPackage($theme);
            if (\is_object($template) == false) {
                $this->error('errors.theme_name');
                return false;
            }

            $translation = $template->readTranslation($component,$language,$type);
            $translation = $template->setTranslationProperty($translation,$propertyKey,$value,'_');

            $result = $template->saveTranslation($translation,$component,$language,$type);
           
            if ($result == false) {
                $fileName = $template->getTranslationFileName($component,$language,$type);
                if (File::isWritable($fileName) == false) {
                    $this->error('errors.property.writable');
                    return false;
                }
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
            ->addRule('text:min=2','language')  
            ->addRule('text:min=1','component_name')  
            ->addRule('text:min=1','property_key')  
            ->validate();   
    }

    /**
     *  Translate text
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function translateController($request, $response, $data) 
    {       
        $this->onDataValid(function($data) {            
            $language = $data->get('target_language',$this->getPageLanguage($data));
            $text = $data->get('text','');         
            
            $driver = $this->createTranslationDriver();
            $translatedText = (\is_object($driver) == true) ? $driver->getInstance()->translate($text,$language) : false;
           
            if ($translatedText === false) {
                $this->error($driver->getErrorMessage());
                return;
            }
            $this->setResponse($translatedText,function() use($language,$translatedText) {                                
                $this
                    ->message('translate')
                    ->field('text',$translatedText)
                    ->field('language',$language);                         
            },'errors.translate');
        });
        $data           
            ->addRule('text:min=2','text')           
            ->validate();       
    }

    /**
     *  Translate database model fields. 
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function translateModelController($request, $response, $data) 
    {       
        $this->onDataValid(function($data) { 
            $extension = $data->get('extension',null);  
            $language = $data->get('language',$this->getPageLanguage($data));
            $uuid = $data->get('uuid',null);  
            $fields = $data->get('fields','');

            $translatedFields = $this->translateDbModel($data['model'],$extension,$uuid,$fields,$language);

            $this->setResponse(true,function() use($language,$uuid,$translatedFields) {                                
                $this
                    ->message('create')
                    ->field('uuid',$uuid)
                    ->field('fields',$translatedFields)
                    ->field('language',$language);                                  
            },'errors.create');
        });
        $data
            ->addRule('text:required','fields')         
            ->validate();       
    }

    /**
     * Translate db model
     *
     * @param string $modelName
     * @param string $extension
     * @param string $uuid
     * @param string $fields
     * @param string $language
     * @return array|false
     */
    public function translateDbModel($modelName, $extension, $uuid, $fields, $language)
    {
        $fields = Arrays::toArray($fields,',');  
        $model = Model::create($modelName,$extension)->findById($uuid);
        if (\is_object($model) == false) {
            $this->error('Not valid translation uuid.');
            return false;
        }
        
        return $this->translateFields($fields,$model->toArray(),$language);      
    }

    /**
     * Translate fields
     *
     * @param string|array $fields
     * @param array $values
     * @param string $language
     * @return array|false
     */
    public function translateFields($fields, array $values, $language)
    {
        $driver = $this->createTranslationDriver();
        if (\is_object($driver) == false) {
            return false;
        }

        $fields = (\is_string($fields) == true) ? Arrays::toArray($fields,',') : $fields;  
      
        foreach ($fields as $index => $key) {           
            $text = (isset($values[$key]) == true) ? $values[$key] : null;   
            $text = (\is_array($text) == true) ? null : \trim($text);   
            if (empty($text) == false) {
                $translatedText = $driver->getInstance()->translate($text,$language);
                $translatedFields[$key] = ($translatedText === false) ? $text : $translatedText;   
            } 
                                
        }

        return $translatedFields;
    } 

    /**
     * Create translation driver
     *
     * @return Driver|false
     */
    protected function createTranslationDriver()
    {
        $driverName = $this->get('options')->get('translations.service.driver');
        $driver = $this->get('driver')->create($driverName);
        if (\is_object($driver) == false) {
            $this->error('Not valid translation api driver');
            return false;
        }

        return $driver;
    } 
}
