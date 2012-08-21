<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JUErrors
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage JQueryErrorForm
 * @author V.Leontiev
 */
class Core_Form_Decorator_JQueryErrorForm extends Zend_Form_Decorator_Abstract
{
    /**
     * Render errors
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $formErrors = $element->getErrorMessages();
        
        if (empty($formErrors) && empty($errors)) {
            return $content;
        }

        $append = '';
        foreach ($formErrors as $error) {
            $append .= $this->addErrorToContent($error) . PHP_EOL;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        
        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $append;
            case self::PREPEND:
                return $append . $separator . $content;
        }
    }

    private function addErrorToContent($error)
    {
        $translate = $this->getElement()->getDefaultTranslator();
        $strongMessage = $translate->translate('Error');
        $error = $translate->translate($error);
        return '<div class="ui-widget">
            <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>' . $strongMessage . ':</strong> ' . $error . '</p>
            </div>
        </div><br/>';
    }
}

