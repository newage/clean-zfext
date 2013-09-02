<?php

/**
 * Decorator for select input used js library "select2"
 *
 * @category   Library
 * @package    Core_Form
 * @subpackage Decorator
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 * @link       http://ivaynberg.github.io/select2/ "select2" js library
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
