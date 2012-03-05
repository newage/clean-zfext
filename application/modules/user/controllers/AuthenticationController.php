<?php
/**
 * User authentication controller
 * Login and logout actions
 *
 * @category   Application
 * @package    Application_User
 * @subpackage Controller
 *
 * @version  $Id: AuthenticationController.php 87 2010-08-29 10:15:50Z vadim.leontiev $
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
    }

    /**
     * Login action
     * View and validate login form
     */
    public function loginAction()
    {
        $this->view->headTitle('Login');
        $form = new User_Form_Authentication();

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $model = User_Model_UsersTable::getInstance();

            if ($model->authenticate($form->getValues())) {
                $this->_helper->FlashMessenger('Successful Login');
                $this->getHelper('Redirector')->gotoUrl('/');
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

        $this->_helper->redirector(
                Zend_Controller_Front::getInstance()->getDefaultAction(),
                Zend_Controller_Front::getInstance()->getDefaultControllerName(),
                Zend_Controller_Front::getInstance()->getDefaultModule()
        );
    }
}