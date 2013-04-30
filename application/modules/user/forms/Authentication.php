<?php
/**
 * Authentication user form
 *
 * @category Application
 * @package Application_User
 * @subpackage Forms
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Form_Authentication extends Core_Form
{
    /**
     * Create user login form
     *
     */
    public function init()
    {
        $this->setMethod('post')
             ->setName('loginForm')
             ->setDescription('User Authentication');

        //create login field
        $element = new Zend_Form_Element_Text('email');
        $element->setRequired(true);
        $element->setLabel('Email');
        $element->addValidator('StringLength', false, array(8,30))
                ->addValidator('EmailAddress', true, array('domain' => false));
        $element->addDecorator(new Core_Form_Decorator_TwitterInput());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(1);

        $this->addElement($element);

        //create password field
        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Password');
        $element->addValidator('StringLength', false, array(6,20))
                ->addValidator('Alnum', true, array(false));
        $element->addDecorator(new Core_Form_Decorator_TwitterPassword());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(2);

        $this->addElement($element);

        //create password field
        $element = new Zend_Form_Element_Checkbox('remember');
        $element->setLabel('Remember me');
        $element->addFilter('Boolean');
        $element->addDecorator(new Core_Form_Decorator_TwitterCheckbox());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(3);

        $this->addElement($element);

        //create submit button
        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Sign In');
        $element->addDecorator(new Core_Form_Decorator_TwitterButton());
        $element->setOrder(4);

        $this->addElement($element);
    }
}
