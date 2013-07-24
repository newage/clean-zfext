<?php

/**
 * Create radio field use twitter bootstrap framework
 *
 * @category   Library
 * @package    Core_Form
 * @subpackage Decorator
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 * @link       http://twitter.github.io/bootstrap/ "twitter-bootstrap" js framework
 */
class Core_Form_Decorator_TwitterRadio extends Zend_Form_Decorator_Abstract
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
        $class     = !empty($extClass) ? 'class="'.$extClass.'"' : '';
        $value    = $element->getValue();
        $checkbox  = array();
        $checked = '';

        foreach ($element->getMultiOptions() as $key => $name) {

            $checked  = strtolower($key) == strtolower($value) ? 'checked' : '';

            $checkbox[] = sprintf(
                '<label class="radio">'.
                '<input type="radio" name="%1$s" id="%1$s-%2$s" value="%2$s" %4$s %5$s>'.
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
