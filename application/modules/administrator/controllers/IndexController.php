<?php
/**
 * Administrator index controller
 *
 * @category   Application
 * @package    Application_Administrator
 * @subpackage Controller
 *
 * @version  $Id: IndexController.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */

class Administrator_IndexController extends Zend_Controller_Action
{
    /**
     * Default model object
     *
     * @var object
     */
    private $_model = null;
    
    /**
     * Initialize default method
     *
     */
    public function init()
    {
        $this->_helper->layout->setLayout('administrator/layout');
    }
    
    /**
     * Intex action
     *
     */
    public function indexAction()
    {

    }
}