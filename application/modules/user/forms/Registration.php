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
             
        //Add email
        $element = new Zend_Form_Element_Text('email');
        $element->setRequired(true);
        $element->setLabel('E-mail');
        $element->addValidator('EmailAddress', true);
        $element->addValidator('Db_NoRecordExists', true, array('users','email'));
        $element->addDecorator(new Core_Form_Decorator_TwitterInput);
        $element->setOrder(1);

        $this->addElement($element);
        
        //Add password
        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Password');
        $element->addValidator('StringLength', false, array(6,30))
                 ->addValidator('Alnum', true, array(false));
        $element->addDecorator(new Core_Form_Decorator_TwitterPassword);
        $element->setOrder(2);

        $this->addElement($element);

        //Repeat password
        $element = new Zend_Form_Element_Password('re_password');
        $element->setRequired(true);
        $element->setLabel('Confirm Password');
        $element->addValidator('StringLength', false, array(6,30))
                    ->addValidator('Alnum', true, array(false))
                    ->addValidator(new Zend_Validate_Callback(array($this, 'comparePassword')));
        $element->addDecorator(new Core_Form_Decorator_TwitterPassword);
        $element->setOrder(3);

        $this->addElement($element);

        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Registration');
        $element->addDecorator(new Core_Form_Decorator_TwitterButton);
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
        $password = $this->getElement('password')->getValue();
        if ($password == $value) {
            return true;
        } else {
            return false;
        }
    }
}
