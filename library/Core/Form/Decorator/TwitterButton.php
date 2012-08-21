<?php

/**
 * Description of TwitterButton
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage SimpleInput
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterButton extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<button type="submit" class="btn">%s</button>';
    
    public function render($content)
    {
        $element = $this->getElement();
        $label   = htmlentities($element->getLabel());
 
        $markup  = sprintf($this->_format, $label);
        return $markup;
    }
}
