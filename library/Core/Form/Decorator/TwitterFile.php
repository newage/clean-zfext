<?php

/**
 * Create file field use twitter bootstrap framework
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterFile
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterFile extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <div class="controls input-append">
            <input class="span2" id="appendedInputButton" type="text" value="" placeholder="%1$s">
            <button class="btn" id="upload_button" type="button"><i class="icon-list"></i></button>
        </div>
      </div>';

    public function render($content)
    {
        $matches = null;
        $element  = $this->getElement();
        $name     = htmlentities($element->getFullyQualifiedName());
        $label    = $element->getLabel();
        $id       = htmlentities($element->getId());
        $required = $element->isRequired() ? 'required' : '';

        preg_match('~<dd>.*</dd>~sm', $content, $matches);
        $dd = isset($matches[0]) ? $matches[0] : $content;

        $element->getView()->jqueryScript()->append('$("#upload_button, #appendedInputButton").click(function() {
                $("#'.$id.'").trigger("click");
            });
            $("dd").hide();
            $("#'.$id.'").change(function() {
                filename = $("#'.$id.'").val().split("\\\\").pop();
                if (filename == undefined) {
                    filename = $("#'.$id.'").val();
                }

                $("#appendedInputButton").val(filename);
            });');

        $markup = sprintf($this->_format, $label, $id, $name, $required);
        $markup .= $dd;
        return $markup;
    }
}
