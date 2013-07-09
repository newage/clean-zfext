<?php

/**
 * Create avatar field use twitter bootstrap framework
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterFile
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterAvatar extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<div class="control-group">
        <label class="control-label">%1$s%4$s</label>
        <div class="controls">
            <img %3$s id="imageAvatar" src="%7$s" width="%5$d" height="%6$d" alt="%2$s" />
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
        $class       = $element->getAttrib('class') !== null ? 'class="' . $element->getAttrib('class') . '"' : '';
        $width       = $element->getAttrib('width') !== null ? $element->getAttrib('width') : 100;
        $height      = $element->getAttrib('height') !== null ? $element->getAttrib('height') : 100;
        $value       = $element->getAttrib('default') !== null
                     ? $element->getAttrib('default')
                     : 'default_user.png';

        preg_match('~<dd>.*</dd>~sm', $content, $matches);
        $dd = isset($matches[0]) ? $matches[0] : $content;

        $element->getView()->jqueryScript()->append('$("#imageAvatar").click(function() {
                $("#'.$id.'").trigger("click");
            });
            $("dd").hide();
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = new Image;
                        img.onload = function() {
                            $("#imageAvatar").attr("src", e.target.result);
                        };
                        img.onerror = function() {
                            errorModal({body: "This file is not a image"});
                        }
                        img.src = reader.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#'.$id.'").change(function(){
                readURL(this);
            });');

        $markup = sprintf(
            $this->_format,
            $label,
            $description,
            $class,
            $required,
            $width,
            $height,
            $value
        );
        $markup .= $dd;
        return $markup;
    }
}
