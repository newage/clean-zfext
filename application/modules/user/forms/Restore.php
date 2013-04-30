<?php
/**
 * Recall login and password form
 *
 * @category Application
 * @package Application_User
 * @subpackage Forms
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Form_Restore extends Core_Form
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

        $element = new Zend_Form_Element_Hidden('hash');

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
