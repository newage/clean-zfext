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
        <label class="control-label">%1$s%4$s</label>
        <div class="controls">
            <div class="input-append">
                <input %3$s id="appendedInputButton" type="text" value="" placeholder="%2$s">
                <button class="btn" id="upload_button" type="button"><i class="icon-folder-open"></i></button>
            </div>
        </div>
      </div>';

    public function render($content)
    {
        $matches     = null;
        $element     = $this->getElement();
        $label       = $element->getLabel();
        $description = $element->getDescription();
        $id          = htmlentities($element->getId());
        $required    = $element->isRequired() ? ' *' : '';
        $class       = $element->getAttrib('class');
        if (!empty($class)) {
            $class = 'class="'.$class.'"';
        } else {
            $class = '';
        }

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

        $markup = sprintf($this->_format, $label, $description, $class, $required);
        $markup .= $dd;
        return $markup;
    }
}
