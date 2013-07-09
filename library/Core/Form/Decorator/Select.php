<?php

/**
 * Decorator for select input used select2 library
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage Select2
 * @author V.Leontiev
 */
class Core_Form_Decorator_Select extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <label class="control-label" for="%2$s">%1$s</label>
        <div class="controls">
            <select %6$s id="%2$s" name="%3$s" %5$s>%4$s</select>
        </div>
      </div>';

    public function render($content)
    {
        $element  = $this->getElement();
        $name     = htmlentities($element->getFullyQualifiedName());
        $label    = $element->getLabel();
        $id       = htmlentities($element->getId());
        $required = $element->isRequired() ? 'required' : '';
        $class    = $element->getAttrib('class');
        if (!empty($class)) {
            $class = 'class="'.$class.'"';
        } else {
            $class = 'class="select-default"';
        }

        $options = null;
        foreach ($element->options as $key => $val) {
            $options .= '<option value="'.$key.'">'.$val.'</option>';
        }

        $element->getView()->jqueryScript()->append('$("#'.$id.'").select2();', 'select2');

        $markup  = sprintf($this->_format, $label, $id, $name, $options, $required, $class);
        return $markup;
    }
}
