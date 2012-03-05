<?php
/**
 * Search form
 *
 * @category Application
 * @package Application_User
 * @subpackage Form
 *
 * @version  $Id$
 */
class Default_Form_Search extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post')
             ->setName('search');

        $search = new ZendX_JQuery_Form_Element_AutoComplete('search');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Search');

        $this->addElement($search);
        $this->addElement($submit);
    }
}