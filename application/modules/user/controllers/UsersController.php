<?php

/**
 * This is a class generated with Zend_CodeGenerator.
 * 
 * @category ###CATEGORY###
 * @package ###PACKAGE###
 * @subpackage ###SUBPACKAGE###
 * @version $Id$
 * @license New BSD
 */
class User_UsersController extends Zend_Controller_Action
{

    /**
     * Create user account
     * (registration new user)
     */
    public function createAction()
    {
        $this->view->headTitle('Registration User');
        $form = new User_Form_Users();

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $model = User_Model_UsersTable::getInstance();

            if ($model->registrate($form->getValues())) {
                $this->_helper->FlashMessenger('Registration successful');
                $this->getHelper('Redirector')->gotoUrl('/user/users/read');
            } else {
                $form->addError('Registration failed!');
            }
        }
        $this->view->form = $form;
    }

    /**
     * Disable user account
     */
    public function disableAction()
    {
        $validator = new Zend_Validator_Int();
        $param = $this->_request->getParam('id');
        
        if ($param && $validator->isValid($param)) {
            $model = Doctrine_Core::getTable('User_Model_Users');
        
            if ($model->disable($param)) {
                $this->_helper->FlashMessenger('Disable user account');
            } else {
                $this->_helper->FlashMessenger('Error disabled account');
            }
        } else {
            $this->_helper->FlashMessenger('Error validate');
        }

        $this->getHelper('Redirector')->gotoUrl('/user/users/read');
    }

    /**
     * Enable user account
     */
    public function enableAction()
    {
        $validator = new Zend_Validator_Int();
        $param = $this->_request->getParam('id');

        if ($param && $validator->isValid($param)) {
            $model = Doctrine_Core::getTable('User_Model_Users');

            if ($model->enable($param)) {
                $this->_helper->FlashMessenger('Disable user account');
            } else {
                $this->_helper->FlashMessenger('Error disabled account');
            }
        } else {
            $this->_helper->FlashMessenger('Error validate');
        }

        $this->getHelper('Redirector')->gotoUrl('/user/users/read');
    }

    /**
     * Update user account
     */
    public function updateAction()
    {
        $this->view->headTitle('Update user account');
        $validator = new Zend_Validate_Int();
        $id = $this->_request->getParam('id');
        $form = new User_Form_Users();
        
        if ($id && $validator->isValid($id)) {
            $mapper = new User_Model_UsersTable();
        
            if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
                $model = Doctrine_Core::getTable('User_Model_Users');
        
                if ($model->update($form->getValues())) {
                    $this->_helper->FlashMessenger('Update user account success');
                    $this->getHelper('Redirector')->gotoUrl('/');
                } else {
                    $form->addError('Error');
                }
            } else {
                $form->update($model->findOneById($id));
            }
        } else {
            $this->_helper->FlashMessenger('Error validate');
        }
        $this->view->form = $form;
    }

    public function readAction()
    {
        $model = Doctrine_Core::getTable('User_Model_Users');
        $paginator = new Zend_Paginator(
            new Zend_Paginator_Adapter_Array($model->findAll()->toArray())
        );
        $paginator->setCurrentPageNumber($this->_request->getParam('page'));
        
        $this->view->paginator = $paginator;
    }


}
