<?php

/**
 * Create popover in form element
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
class Core_Form_Decorator_TwitterPopover extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        $element = $this->getElement();
        $id      = htmlentities($element->getId());
        $description = $element->getDescription();
        $title = $element->getLabel();

        $script = '$("#'.$id.'").popover({
            trigger:"hover",
            content:"' . $description . '",
            title:"' . $title . '"
        });';

        $element->getView()->jqueryScript()->append($script);

        return $content;
    }
}

