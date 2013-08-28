<?php

/**
 * Change user password form
 *
 * @category Application
 * @package Application_Modules_User
 * @subpackage Form
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Form_ChangePassword extends Core_Form
{

    /**
     * Change password for user account
     * Set attribute required to form for view required fields
     */
    public function init()
    {
        $this->setMethod('post')
             ->setName('changepassword')
             ->setDescription('Change password')
             ->setAttrib('required', 'true');

        //Add password
        $element = new Zend_Form_Element_Password('password');
        $element->setRequired(true);
        $element->setLabel('Password');
        $element->addValidator('StringLength', false, array(6,30))
                 ->addValidator('Alnum', true, array(false));
        $element->addDecorator(new Core_Form_Decorator_TwitterPassword());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(5);
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
        $element->setOrder(6);
        $this->addElement($element);

        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Change');
        $element->addDecorator(new Core_Form_Decorator_TwitterButtons);
        $element->setOrder(7);
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
