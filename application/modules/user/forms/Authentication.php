<?php
/**
 * Authentication user form
 *
 * @category Application
 * @package Application_User
 * @subpackage Form
 *
 * @version  $Id: Authentication.php 94 2010-09-20 10:29:13Z vadim.leontiev $
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
        $element->setLabel('Login');
        $element->addValidator('StringLength', false, array(8,30))
                ->addValidator('EmailAddress', true, array('domain' => false));
        $element->setOrder(1);

        $this->addElement($element);

        //create password field
        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Password');
        $element->addValidator('StringLength', false, array(6,20))
                ->addValidator('Alnum', true, array(false));
        $element->setOrder(2);

        $this->addElement($element);

        //create submit button
        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Log In');
        $element->setAttrib('class', 'ui-button ui-widget ui-state-default ui-corner-all');
        $element->setOrder(3);

        $this->addElement($element);
    }
}
