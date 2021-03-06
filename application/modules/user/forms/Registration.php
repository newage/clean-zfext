<?php

/**
 * Registration user form
 *
 * @category Application
 * @package Application_User
 * @subpackage Forms
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Form_Registration extends Core_Form
{

    /**
     * Create user registration form
     * Set attribute required to form for view required fields
     */
    public function init()
    {
        $this->setMethod('post')
             ->setName('registration')
             ->setDescription('New User Registration')
             ->setAttrib('required', 'true');

        //Add email
        $element = new Zend_Form_Element_Text('email');
        $element->setRequired(true);
        $element->setLabel('E-mail');
        $element->setDescription('This email used be for the login');
        $element->addValidator('EmailAddress', true, array('domain' => false));
        $element->addValidator('Db_NoRecordExists', true, array('users','email'));
        $element->addDecorator(new Core_Form_Decorator_TwitterInput());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->addDecorator(new Core_Form_Decorator_TwitterPopover());
        $element->setAttrib('class', '22');
        $element->setOrder(1);
        $this->addElement($element);

        //Add password
        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Password');
        $element->addValidator('StringLength', false, array(6,30))
                 ->addValidator('Alnum', true, array(false));
        $element->addDecorator(new Core_Form_Decorator_TwitterPassword());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(2);
        $this->addElement($element);

        //Repeat password
        $element = new Zend_Form_Element_Password('re_password');
        $element->setRequired(true);
        $element->setLabel('Repeat password');
        $element->setDescription('Repeat the password');
        $element->addValidator('StringLength', false, array(6,30))
                    ->addValidator('Alnum', true, array(false))
                    ->addValidator(new Zend_Validate_Callback(array($this, 'comparePassword')));
        $element->addDecorator(new Core_Form_Decorator_TwitterPassword());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->addDecorator(new Core_Form_Decorator_TwitterPopover());
        $element->setOrder(3);
        $this->addElement($element);

        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Registration');
        $element->addDecorator(new Core_Form_Decorator_TwitterButtons);
        $element->setOrder(10);
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
