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

use Arikaim\Core\Db\Model;
use Arikaim\Core\Controllers\Controller;
use Arikaim\Core\Http\Url;

/**
 * Editor page controler
*/
class EditorPage extends Controller
{
    /**
     * Show theme editor editor
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function showEditor($request, $response, $data) 
    {       
        $theme = $data->get('theme',null);
        $page = $data->get('page',null);
        $language = $this->getPageLanguage($data,false);          

        if ($this->hasControlPanelAccess() == false) {         
            return $this->withRedirect($response,Url::BASE_URL . '/admin');              
        }
        
        $this->get('page')->setRenderMode(1); // Edit mode
        $component = $this->get('page')->render($theme . ':' . $page,$data->toArray(),$language);
        $data['page_content'] = $component->getHtmlCode();
     
        return $this->pageLoad($request,$response,$data->toArray(),'system:page-editor','en');  
    }   
}
