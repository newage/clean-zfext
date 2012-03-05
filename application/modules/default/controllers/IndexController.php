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
        $container = new Zend_Navigation(array(
            array(
                'label'  => 'Page 1',
                'action'     => 'read',
                'controller' => 'index',
                'module'     => 'default',
                'pages' => array(
                    array(
                        'label'  => 'Page 2',
                        'action'     => 'delete',
                        'controller' => 'index',
                        'module'     => 'default',
                        'pages'      => array(
                            array(
                                'label'  => 'Page 3',
                                'action'     => 'index',
                                'controller' => 'index',
                                'module'     => 'default',
                            )
                        )
                    )
                )
            )
        ));
        $this->view->container = $container;
    }
}
