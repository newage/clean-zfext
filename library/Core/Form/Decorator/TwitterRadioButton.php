<?php

/**
 * Create radio field use twitter bootstrap framework
 *
 * @category Core
 * @package Core_Form_Decorator
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
class Core_Form_Decorator_TwitterRadioButton extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <label class="control-label">%1$s</label>
        <div class="controls">
            <div class="btn-group" data-toggle="buttons-radio">%2$s</div>
        </div>
      </div>';

    public function render($content)
    {
        $element   = $this->getElement();
        $label     = $element->getLabel();
        $fieldName = htmlentities($element->getFullyQualifiedName());
        $extClass  = $element->getAttrib('class');
        $class     = !empty($extClass) ? 'btn '.$extClass : 'btn';
        $value    = $element->getValue();
        $checkbox  = array();

        foreach ($element->getMultiOptions() as $key => $name) {

            $active = '';
            if (!empty($value) && $key == $value) {
                $active = ' active';
            }

            $checkbox[] = sprintf(
                '<button type="button" name="%1$s" id="%1$s-%2$s" value="%3$s" class="%4$s%5$s">'.
                ' %3$s'.
                '</button>',
                $fieldName,
                $key,
                $name,
                $class,
                $active
            );
        }

        $markup  = sprintf($this->_format, $label, implode("\n", $checkbox));
        return $markup;
    }
}
