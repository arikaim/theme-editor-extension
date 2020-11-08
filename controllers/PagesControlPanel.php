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
use Arikaim\Core\Controllers\Traits\Status;

/**
 * Pages control panel controller
*/
class PagesControlPanel extends ControlPanelApiController
{
    use Status;

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
     * Constructor
     * 
     * @param Container|null $container 
     */
    public function __construct($container = null)
    {
        parent::__construct($container);
        
        $this->setExtensionName(null);
        $this->setModelClass('Routes');
    }
}
