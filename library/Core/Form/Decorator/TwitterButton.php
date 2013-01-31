<?php

/**
 * Create button use twitter bootstrap framework
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterButton
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterButton extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary">%1$s</button>
    </div>
    </div>';

    public function render($content)
    {
        $element = $this->getElement();
        $label   = $element->getLabel();

        $markup  = sprintf($this->_format, $label);
        return $markup;
    }
}
