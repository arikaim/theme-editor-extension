<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
 */
namespace Arikaim\Extensions\Translations\Console;

use Arikaim\Core\Utils\File;
use Arikaim\Core\Utils\Utils;

/**
 * Translate console
 */
class TranslateConsole 
{  
    /**
     * on before translate callback
     *
     * @var Closure|null
     */
    protected $onBeforeTranslate = null;

    /**
     * on translated done callback
     *
     * @var Closure|null
     */
    protected $onTranslated = null;

    /**
     * on sstart child component translation callback
     *
     * @var Closure|null
     */
    protected $onHasChild = null;

    /**
     * on translation error
     *
     * @var Closure|null
     */
    protected $onError = null;

    /**
     * Constructor
     *
     * @param Closure|null $onBeforeTranslate
     * @param Closure|null $onTranslated
     * @param Closure|null $onError
     */
    public function __construct($onBeforeTranslate = null, $onTranslated = null, $onError = null, $onHasChild = null)
    {
        $this->onBeforeTranslate = $onBeforeTranslate;
        $this->onTranslated = $onTranslated;
        $this->onError = $onError; 
        $this->onHasChild = $onHasChild;      
    }

    /**
     * Translate page
     *
     * @param object $package
     * @param object $driver
     * @param string $language
     * @param string $pageName    
     * @param integer $indent
     * @return boolean
     */
    public function translatePage($package, $driver, $language, $pageName, $indent = 2)
    {
        return $this->translateComponent($package,$driver,$language,$pageName,'pages',$indent);
    }

    /**
     * Trranslate component and all child components
     *
     * @param object $package
     * @param object $driver
     * @param string $language
     * @param string $componentName
     * @param string $type
     * @param integer $indent
     * @return boolean
     */
    public function translateComponent($package, $driver, $language, $componentName, $type = 'components', $indent = 2)
    {
        if (\is_callable($this->onBeforeTranslate) == true) {
            ($this->onBeforeTranslate)($componentName,$indent);
        }
       
        // translate child
        $childComponents = ($type == 'pages') ? $package->getPages($componentName) : $package->getComponents($componentName);
        if (\count($childComponents) > 0) {   
            if (\is_callable($this->onHasChild) == true) {
                ($this->onHasChild)($componentName);
            }           
            $this->translateComponents($package,$driver,$language,$type,$componentName,($indent + 2));
        }

        // read english translation file
        $translation = $package->readTranslation($componentName,'en',$type);
        if ($translation === false) {
            $this->showError($componentName,' Missing english language file');      
            return false;
        }

        $path = ($type == 'components') ? $package->getComponentPath($componentName) : $package->getPagePath($componentName);
        $newFile = $package->resolveTranslationFileName($path,$language);      

        if (File::setWritable($path) == false) {
            $this->showError($componentName,' Path not writable!');                 
            return false;
        }    

        if (File::exists($newFile) == true) {
            $this->showError($componentName,' Translation file exists!');                
            return false;
        }

        $translation = $this->translate($translation,$language,$driver);
        if ($translation === false) {
            $this->showError($componentName,' Translation api error!');    
            return false;
        }

        $result = File::write($newFile,Utils::jsonEncode($translation));   
        if ($result !== false) {
            if (\is_callable($this->onTranslated) == true) {
                ($this->onTranslated)($componentName);
            }    
            return true;              
        }
        
        $this->showError($componentName,' Error translating component'); 
        return false;              
    }

    /**
     * Translate theme components
     *
     * @param object $package
     * @param object $driver
     * @param string $language
     * @param string $type
     * @return void
     */
    public function translateComponents($package, $driver, $language, $type = 'components', $parent = '', $indent = 2)
    {
        $components = ($type == 'pages') ? $package->getPages($parent) : $package->getComponents($parent);

        foreach($components as $item) {
            $componentName = $item['full_name'];               
            $this->translateComponent($package,$driver,$language,$componentName,$type,$indent);               
        }
    }

    /**
     * Translate component
     *
     * @param array $translation
     * @param string $language
     * @param object $driver
     * @return array|false
     */
    public function translate(array $translation, $language, $driver)
    {
        foreach ($translation as $key => $value) {
            if (\is_array($value) == true) {
                $translation[$key] = $this->translate($value,$language,$driver);
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
     * Call onError closure if set
     *
     * @param string $componentName
     * @param string $message
     * @return void
     */
    public function showError($componentName, $message)
    {
        if (\is_callable($this->onError) == true) {
            ($this->onError)($componentName,$message);
        }           
    }
}
