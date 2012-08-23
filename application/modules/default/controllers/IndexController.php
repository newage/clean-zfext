<?php
/**
 * Default index controller
 *
 * @category   Application
 * @package    Application_Default
 * @subpackage Controller
 *
 * @version  $Id: IndexController.php 101 2010-09-22 08:10:53Z vadim.leontiev $
 */

class IndexController extends Zend_Controller_Action
{
    
    /**
     * Initialize default method
     * /url/format/json
     *
     */
    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('index', 'json')
            ->initContext();
    }
    
    /**
     * Intex action
     * Generate login form
     *
     */
    public function indexAction()
    {
    }
}
