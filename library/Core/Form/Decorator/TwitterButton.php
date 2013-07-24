<?php

/**
 * Create button use twitter bootstrap framework
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
