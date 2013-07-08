<?php
/**
 * User authentication controller
 * Login and logout actions
 *
 * @category Application
 * @package Application_User
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */

class User_AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * Goto login action
     */
    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $this->view->identity = $auth->hasIdentity();
    }

    /**
     * Login action
     * View and validate login form
     */
    public function loginAction()
    {
        $this->view->jqueryScript()->append('$("a").tooltip();', 'bootstrap');

        $this->view->headTitle('Login');
        $form = new User_Form_Authentication();

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $mapper = new User_Model_UsersMapper();

            if ($mapper->authenticate($form->getValue('email'), $form->getValue('password'), $form->getValue('remember'))) {
                $this->getHelper('Messenger')->addMessage(
                    'You Logined',
                    Core_Controller_Action_Helper_Messenger::TYPE_INFO,
                    true
                );
                $this->getHelper('Redirect')->gotoUrl('/');
            } else {
                $form->addError('Not correct login or password! Or not active account');
            }
        }
        $this->view->form = $form;
    }

    /**
     * Logout action
     * Logout user and redirect to default module
     *
     */
    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('Zend_Auth'));
        $auth->getStorage()->clear();

        $this->getHelper('Messenger')->addMessage(
            'You Logout',
            Core_Controller_Action_Helper_Messenger::TYPE_INFO,
            true
        );

        $this->getHelper('Redirect')->gotoUrl('/');
    }
}
