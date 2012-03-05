<?php
/**
 * User registration controller
 *
 * @category   Application
 * @package    Application_User
 * @subpackage Controller
 *
 * @version  $Id$
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
            $model = User_Model_UsersTable::getInstance();

            if (true === (bool)$model->registrate($form->getValues())) {
                $this->_helper->FlashMessenger('Registration successful');
                $this->getHelper('Redirector')->gotoUrl('/');
            } else {
                $form->addError('Registration failed!');
            }
        }
        $this->view->form = $form;
    }


}

