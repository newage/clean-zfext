<?php

/**
 * Create text field use twitter bootstrap framework
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterInput
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterInput extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <label class="control-label" for="%2$s">%1$s</label>
        <div class="controls">
          <input %6$s type="text" id="%2$s" name="%3$s" value="%4$s" %5$s>
        </div>
      </div>';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = $element->getLabel();
        $id      = htmlentities($element->getId());
        $value   = $element->getValue();
        $required = $element->isRequired() ? 'required' : '';
        $class    = $element->getAttrib('class');
        if (!empty($class)) {
            $class = 'class="'.$class.'"';
        } else {
            $class = '';
        }

        $markup  = sprintf($this->_format, $label, $id, $name, $value, $required, $class);
        return $markup;
    }
}
