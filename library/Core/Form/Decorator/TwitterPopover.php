<?php

/**
 * Create popover in form element
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterPopover
 * @author V.Leontiev
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

