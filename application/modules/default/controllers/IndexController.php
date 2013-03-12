<?php
/**
 * Default index controller
 *
 * @category Application
 * @package Application_Default
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */

class IndexController extends Zend_Controller_Action
{

    /**
     * Initialize default method
     * /url/format/json
     *
     *
     *
     */
    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('index', 'json')
            ->initContext();
    }

    public function indexAction()
    {
    }

    public function aboutAction()
    {
        $this->getHelper('Messenger')->addMessage(
            'This message from backend',
            Core_Controller_Action_Helper_Messenger::TYPE_ERROR
        );
    }

    public function dologinAction()
    {
        $this->getHelper('Messenger')->addMessage(
            'This message from default/index/dologin action',
            Core_Controller_Action_Helper_Messenger::TYPE_SUCCESS,
            true
        );
        $this->getHelper('Redirector')->gotoUrl('/en/user/authentication/login');
    }
}

