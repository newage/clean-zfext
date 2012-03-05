<?php
/**
 * Form element CkEditor
 *
 * @category   Core
 * @package    Core_Form
 * @subpackage Element
 *
 * @version  $Id: CkEditor.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */


class Core_Form_Element_CkEditor extends Zend_Form_Element_Textarea
{
    /**
    * Use formTextarea view helper by default
    * @var string
    */
    public $helper = 'formCkEditor';
}