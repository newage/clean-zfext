<?php

/**
 * Description of TwitterPassword
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage SimpleInput
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterPassword extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<input class="span2" id="%s" name="%s" type="password" placeholder="%s" value="%s"/>';
    
    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
 
        $markup  = sprintf($this->_format, $id, $name, $label, $value);
        return $markup;
    }
}
