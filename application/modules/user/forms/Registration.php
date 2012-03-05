<?php

/**
 * Registration user form
 *
 * @category Application
 * @package Application_Default
 * @subpackage Form
 *
 * @version  $Id$
 */
class User_Form_Registration extends Core_Form
{
    
    /**
     * Create user registration form
     */
    public function init()
    {
        $this->setMethod('post')
             ->setName('registration')
             ->setDescription('User Registration');
             
        $element = new Zend_Form_Element_Text('login');
        $element->setRequired(true);
        $element->setLabel('Login');
        $element->addValidator('StringLength', false, array(3,40))
                ->addValidator('Alnum', true, array(false))
                ->addValidator(new Zend_Validate_Db_NoRecordExists('users','login'));
        $element->setOrder(1);

        $this->addElement($element);
        
        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Password');
        $element->addValidator('StringLength', false, array(3,30))
                 ->addValidator('Alnum', true, array(false));
        $element->setOrder(2);

        $this->addElement($element);

        $element = new Zend_Form_Element_Password('re_password');
        $element->setRequired(true);
        $element->setLabel('Confirm Password');
        $element->addValidator('StringLength', false, array(3,30))
                    ->addValidator('Alnum', true, array(false))
                    ->addValidator(new Zend_Validate_Callback(array($this, 'comparePassword')));
        $element->setOrder(3);

        $this->addElement($element);

        $element = new Zend_Form_Element_Text('email');
        $element->setRequired(true);
        $element->setLabel('E-mail');
        $element->addValidator('EmailAddress', true);
        $element->addValidator('Db_NoRecordExists', true, array('users','email'));
        $element->setOrder(4);

        $this->addElement($element);

        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Registration');
        $element->setOrder(5);

        $this->addElement($element);
    }

    /**
     * Compare two passwords
     *
     * @return bool
     */
    public function comparePassword($value)
    {
        $password = Zend_Controller_Front::getInstance()->getRequest()->getParam('password');
        if ($password == $value) {
            return true;
        } else {
            return false;
        }
    }
}
