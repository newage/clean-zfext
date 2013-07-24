<?php

/**
 * Create texarea field use twitter bootstrap framework
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
class Core_Form_Decorator_TwitterTextarea extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <label class="control-label" for="%2$s">%1$s</label>
        <div class="controls">
          <textarea %6$s id="%2$s" name="%3$s" rows="%7$s" %5$s>%4$s</textarea>
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
        $rows     = $element->getAttrib('rows');
        if (!empty($class)) {
            $class = 'class="'.$class.'"';
        } else {
            $class = '';
        }

        $markup  = sprintf($this->_format, $label, $id, $name, $value, $required, $class, $rows);
        return $markup;
    }
}
