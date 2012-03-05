<?php
/**
 * If forgot login or password
 * Create new password
 *
 * @category   Application
 * @package    Application_User
 * @subpackage Controller
 *
 * @version  $Id: ForgotController.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */

class User_ForgotController extends Zend_Controller_Action
{

    public function init()
    {
    }

    /**
     * Recall login and password
     *
     * @todo send login and password to email
     */
    public function indexAction()
    {
        $this->view->headTitle($this->view->translate('Forgot password?'));
        $form = new User_Form_Forgot();

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $model = User_Model_UsersTable::getInstance();

            if (true === $model->forgotPassword($form->getValues())) {
                $this->_helper->FlashMessenger('You will be sent email with instructions');
                $this->getHelper('Redirector')->gotoUrl('/user/authentication/login');
            }
        }
        $this->view->form = $form;
    }

    /**
     * Show form for create new password
     *
     * @todo show form create new password
     */
    public function restoreAction()
    {
        $this->view->headTitle($this->view->translate('Update user password'));
        $form = new User_Form_Restore();

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $model = User_Model_UsersTable::getInstance();

            if (true === $model->updatePassword($form->getValues())) {
                $this->_helper->FlashMessenger('You password update successful');
                $this->getHelper('Redirector')->gotoUrl('/user/authentication/login');
            }
        }
        $this->view->form = $form;
    }

}

