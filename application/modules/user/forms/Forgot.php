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
        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(true);
        $email->setLabel('E-mail');
        $email->addValidator('EmailAddress', true);
        $email->setOrder(1);

        //create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Recall');
        $submit->setOrder(2);

        $this->addElement($email);
        $this->addElement($submit);
    }
}
