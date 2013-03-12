<?php
/**
 * User registration controller
 *
 * @category Application
 * @package Application_User
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */

class User_RegistrationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * Registration action
     * Cenerate user registration form
     *
     * @todo registration user
     */
    public function indexAction()
    {
        $this->view->headTitle('Registration User');
        $form = new User_Form_Registration();

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $model = new User_Model_Users($form->getValues());
            $mapper = new User_Model_UsersMapper();

            if (true === (bool)$mapper->save($model)) {
                $this->_helper->FlashMessenger('Registration successful');
                $this->getHelper('Redirector')->gotoUrl('/');
            } else {
                $form->addError('Registration failed!');
            }
        }
        $this->view->form = $form;
    }


}

