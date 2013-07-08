<?php

/**
 * Create datepicker field use extension datepicker for twitter bootstrap
 * GitHub: https://github.com/eternicode/bootstrap-datepicker
 *
 * @category Core
 * @package Core_Form_Decorator
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
class Core_Form_Decorator_TwitterDatepicker extends Zend_Form_Decorator_Abstract
{

    protected $_format = '<div class="control-group">
        <label class="control-label">%1$s</label>
        <div class="controls">
            <div class="date" id="dp3" data-date-format="dd-mm-yyyy">
                <input class="%6$s" type="text" value="%4$s" readonly id="%2$s" name="%3$s">
            </div>
        </div>
      </div>';

    public function render($content)
    {
        $element  = $this->getElement();
        $name     = htmlentities($element->getFullyQualifiedName());
        $label    = $element->getLabel();
        $id       = htmlentities($element->getId());
        $value    = $element->getValue();
        $required = $element->isRequired() ? 'required' : '';
        $class    = $element->getAttrib('class');
        $class    = !empty($class) ? 'class="'.$class.'"' : '';

        $options  = function($options) {
            if (!empty($options)) {
                $option = array();
                foreach ($options as $name => $value) {
                    if (is_string($value)) {
                        $value = '"'.$value.'"';
                    }
                    if (is_bool($value)) {
                        $value = $value === true ? 'true' : 'false';
                    }

                    $option[] = $name . ':' . $value;
                }
                $options = '{'.implode(',', $option).'}';
            } else {
                $options = '';
            }
            return $options;
        };

        $view = $element->getView();
        $view->jqueryScript()->append(
            '$("#'.$id.'").datepicker('.$options($this->getOptions()).');',
            'bootstrap-datepicker'
        );

        $markup  = sprintf($this->_format, $label, $id, $name, $value, $required, $class);

        return $markup;
    }
}
