<?php

/**
 * Create multi checkbox field use twitter bootstrap framework
 *
 * @category Core
 * @package Core_Form_Decorator
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterMultiCheckbox extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <label class="control-label">%1$s</label>
        <div class="controls">%2$s</div>
      </div>';

    public function render($content)
    {
        $element   = $this->getElement();
        $label     = $element->getLabel();
        $fieldName = htmlentities($element->getFullyQualifiedName());
        $extClass  = $element->getAttrib('class');
        $class     = empty($extClass) ? 'class="'.$extClass.'"' : '';
        $values    = $element->getValue();
        $checkbox  = array();
        $checked = '';

        foreach ($element->getMultiOptions() as $key => $name) {

            !is_array($values) ||
                $checked  = in_array($key, $values) ? 'checked' : '';

            $checkbox[] = sprintf(
                '<label class="checkbox">'.
                '<input type="checkbox" name="%1$s" id="%1$s-%2$s" value="%2$s" %4$s %5$s>'.
                ' %3$s'.
                '</label>',
                $fieldName,
                $key,
                $name,
                $checked,
                $class
            );
        }

        $markup  = sprintf($this->_format, $label, implode("\n", $checkbox));
        return $markup;
    }
}
