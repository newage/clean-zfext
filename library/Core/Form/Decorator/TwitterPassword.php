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
    protected $_format = '<div class="control-group">
        <label class="control-label" for="%s">%s</label>
        <div class="controls">
          <input type="password" id="%s" name="%s" value="%s">
        </div>
      </div>';
    
    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = $element->getLabel();
        $id      = htmlentities($element->getId());
        $value   = $element->getValue();
 
        $markup  = sprintf($this->_format, $id, $label, $id, $name, $value);
        return $markup;
    }
}
