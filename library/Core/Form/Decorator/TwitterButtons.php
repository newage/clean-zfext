<?php

/**
 * Create buttons (add cancel) use twitter bootstrap framework
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
class Core_Form_Decorator_TwitterButtons extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<hr/><div class="control-group">
    <div class="controls">
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
