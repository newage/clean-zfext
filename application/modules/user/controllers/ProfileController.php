<?php

/**
 * Show and update user information
 *
 * @category   Application
 * @package    Application_Modules_User
 * @subpackage Controller
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_ProfileController extends Zend_Controller_Action
{

    /**
     * Show user profile
     *
     */
    public function indexAction()
    {
        $modelMapper = new User_Model_UsersMapper();
        $user = $modelMapper->getCurrentUser();

        $this->view->user = $user;
    }

    /**
     * Edit user action
     *
     */
    public function editAction()
    {
        $this->view->headTitle('Edit User Profile');
        $form = new User_Form_EditProfile();
        $mapper = new User_Model_ProfileMapper();

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                $model = new User_Model_Profile($form->getValues());

                if (true === (bool)$mapper->update($model)) {
                    $this->_helper->FlashMessenger('Update profile successful');
                    $this->getHelper('Redirector')->gotoUrl('/user/profile');
                } else {
                    $form->addError('Update profile failed!');
                }
            }
        } else {
            $model = $mapper->getCurrentProfile();
            $form->setDefaults($model->toArray());
        }

        $this->view->form = $form;
    }

    /**
     * Change passworf for current logined user
     *
     */
    public function changePasswordAction()
    {
        $this->view->headTitle('Change User Password');
        $form = new User_Form_ChangePassword();

        if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $model = new User_Model_Users($form->getValues());
            $mapper = new User_Model_UsersMapper();

            if (true === (bool)$mapper->changePassword($model)) {
                $this->_helper->FlashMessenger('Update password successful');
                $this->forward('logout', 'authentication');
            } else {
                $form->addError('Update password failed!');
            }
        }

        $this->view->form = $form;
    }
}
