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
class User_Form_Users extends Core_Form
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
        $element->addValidator('StringLength', false, array(3,20))
                ->addValidator('Alnum', true, array(false))
                ->addValidator(new Core_Validate_Doctrine_NoRecordExists('User_Model_Users','login'));
        $element->setOrder(1);

        $this->addElement($element);

        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Password');
        $element->addValidator('StringLength', false, array(6,30))
                ->addValidator('Alnum', true, array(false));
        $element->setOrder(2);

        $this->addElement($element);

        $element = new Zend_Form_Element_Password('repassword');
        $element->setRequired(true);
        $element->setLabel('Confirm Password');
        $element->addValidator('StringLength', false, array(6,30))
                ->addValidator('Alnum', true, array(false))
                ->addValidator(new Zend_Validate_Callback(array($this, 'comparePassword')));
        $element->setOrder(3);

        $this->addElement($element);

        $element = new Zend_Form_Element_Text('email');
        $element->setRequired(true);
        $element->setLabel('E-mail');
        $element->addValidator('EmailAddress', true)
                ->addValidator(new Core_Validate_Doctrine_NoRecordExists('User_Model_Users','email'));
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

    public function update(Doctrine_Record $record)
    {
        foreach($this->getElements() as $key => $element ) {
            if ($record->hasColumn($key) === true) {
                $element->setValue($record->get($key));
            }
        }
        $this->getElement('submit')->setLabel('Update');
    }


}
