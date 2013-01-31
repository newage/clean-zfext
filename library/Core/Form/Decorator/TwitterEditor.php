<?php

/**
 * Create texarea field and use bootstrap-wysiwyg
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterEditor
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterEditor extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <label class="control-label" for="%2$s">%1$s</label>
        <div class="controls">
          <textarea class="textarea" id="%2$s" name="%3$s" %5$s>%4$s</textarea>
        </div>
      </div>';

    public function render($content)
    {
        $element  = $this->getElement();

        $element->getView()->headScript()->appendFile('/vendor/components/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.min.js');
        $element->getView()->headScript()->appendFile('/vendor/components/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js');
        $element->getView()->headLink()->appendStylesheet('/vendor/components/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css');
        $element->getView()->headLink()->appendStylesheet('/vendor/components/bootstrap-wysihtml5/lib/css/wysiwyg-color.css');

        $name     = htmlentities($element->getFullyQualifiedName());
        $label    = $element->getLabel();
        $id       = htmlentities($element->getId());
        $value    = $element->getValue();
        $required = $element->isRequired() ? 'required' : '';

        $element->getView()->headScript()->appendScript('$("#'.$id.'").wysihtml5()');

        $markup  = sprintf($this->_format, $label, $id, $name, $value, $required);
        return $markup;
    }
}
