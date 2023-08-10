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
use Arikaim\Core\Collection\Arrays;
use Arikaim\Core\Paginator\Paginator;

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
    public function showEditorPage($request, $response, $data) 
    {       
        $slug = $data->get('slug',null);
        $pageUrl = $this->getParam('page_url','/blog/');

       
        $perPage = $this->get('options')->get('blog.posts.perpage',7);

        $pages = Model::Pages('blog');
        $posts = Model::Posts('blog')->getNotDeletedQuery()->where('status','=',1);

        $page = null;
        if (empty($slug) == false) {
            $page = $pages->findBySlug($slug);    
            if ($page == null) {
                // page not found
                return $this->pageNotFound($response,$data->toArray());
            } 
            if ($page->status != $page->ACTIVE()) {
                // page not published
                return $this->pageNotFound($response,$data->toArray());
            }
            if ($page->isDeleted() == true) {
                // page is deleted
                return $this->pageNotFound($response,$data->toArray());
            }
        }
       
        if ($page != null) {
            $posts = $posts->where('page_id','=',$page->id);          
            $data['page_title'] = $page->name;
            $data['page_url'] = $pageUrl . $slug;
        }    
    }   
}
