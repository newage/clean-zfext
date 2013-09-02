<?php

/**
 * Show and update user information
 *
 * @category   Application
 * @package    Application_Modules_User
 * @subpackage Controller
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_IndexController extends Zend_Controller_Action
{

    /**
     * Show user profile
     *
     */
    public function indexAction()
    {
        $modelMapper = new Application_Model_Mapper_User();
        $user = $modelMapper->getCurrentUser();

        $this->view->user = $user;
    }

    /**
     * Edit user action
     *
     */
    public function editAction()
    {
        $this->view->headTitle('Edit Profile');
        $form = new User_Form_EditProfile();
        $mapper = new Application_Model_Mapper_Profile();

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getPost())) {
                if (true === (bool)$mapper->save($form->getValues())) {
                    $this->getHelper('Messenger')->addMessage(
                        'Update profile successful',
                        Core_Controller_Action_Helper_Messenger::TYPE_SUCCESS,
                        true
                    );
                    $this->getHelper('Redirector')->gotoUrl('/user/index');
                } else {
                    $form->addError('Update profile failed!');
                }
            }
        } else {
            if ($model = $mapper->getCurrentProfile()) {
                $form->setDefaults($model->toArray());
            }
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
            $mapper = new Application_Model_Mapper_User();

            if (true === (bool)$mapper->changePassword($form->getValues())) {
                $this->getHelper('Messenger')->addMessage(
                    'Changed Password Successful',
                    Core_Controller_Action_Helper_Messenger::TYPE_SUCCESS,
                    true
                );
                $this->forward('logout', 'authentication');
            } else {
                $form->addError('Update password failed!');
            }
        }

        $this->view->form = $form;
    }
}
