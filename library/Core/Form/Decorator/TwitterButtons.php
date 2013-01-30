<?php

/**
 * Create button use twitter bootstrap framework
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterButton
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterButtons extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<hr/><div class="control-group">
    <div class="control">
      <button type="submit" class="btn btn-primary">%1$s</button>
      <button type="reset" class="btn">%2$s</button>
    </div>
    </div>';

    public function render($content)
    {
        $element = $this->getElement();
        $label   = $element->getLabel();
        $cancel  = $element->getTranslator()->translate('Cancel');

        $markup  = sprintf($this->_format, $label, $cancel);
        return $markup;
    }
}
