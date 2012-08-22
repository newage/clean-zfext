<?php
/**
 * Recall login and password form
 *
 * @category Application
 * @package Application_Default
 * @subpackage Form
 *
 * @version  $Id: Forgot.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */
class User_Form_Forgot extends Core_Form
{
    /**
     * Create recall form
     *
     */
    public function init()
    {
        $this->setMethod('post')
             ->setName('forgot')
             ->setDescription('Forgot login and password?');

        //create login field
        $element = new Zend_Form_Element_Text('email');
        $element->setRequired(true);
        $element->setLabel('E-mail');
        $element->addValidator('EmailAddress', true, array('domain' => false));
        $element->addValidator('Db_RecordExists', true, array('users','email'));
        $element->addDecorator(new Core_Form_Decorator_TwitterInput());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(1);
        $this->addElement($element);

        //create submit button
        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Send email');
        $element->setOrder(2);
        $element->addDecorator(new Core_Form_Decorator_TwitterButton());
        $this->addElement($element);
    }
}
