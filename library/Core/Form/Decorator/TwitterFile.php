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
        <div class="controls">
          <button id="upload_button" class="btn btn-success"><i class="icon-plus"></i> %1$s</button>
          <span id="upload_filename"></span>
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

        $element->getView()->headScript()->appendScript('$("#upload_button").click(function() {
                $("#'.$id.'").trigger("click");
            });
            $("dd").hide();
            $("#'.$id.'").change(function() {
                filename = $("#'.$id.'").val().split("\\\\")[2];
                if (filename == undefined) {
                    filename = $("#'.$id.'").val();
                }

                $("#upload_filename").text(filename);
            });');

        $markup = sprintf($this->_format, $label, $id, $name, $required);
        $markup .= $dd;
        return $markup;
    }
}
