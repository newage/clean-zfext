<?php

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JUErrors
 *
 * @author vadim
 */
class Core_Form_Decorator_JQueryErrors extends Zend_Form_Decorator_Abstract
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

        $errors = $element->getMessages();

        if (empty($errors)) {
            return $content;
        }

        $append = '';
        foreach ($errors as $error) {
            $append .= $this->addErrorToContent($error, $element->getLabel()) . PHP_EOL;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        
        switch ($placement) {
            case self::APPEND:
                $content = $content . $separator . $append;
                break;
            case self::PREPEND:
                $content = $append . $separator . $content;
                break;
        }
        
        return $content;
    }

    private function addErrorToContent($error, $errorName)
    {
        if (empty($errorName)) {
            $translator = $this->getElement()->getTranslator();
            $errorName = $translator->translate('Error');
        }
        return '<div class="ui-widget">
            <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>' . $errorName . ':</strong> '.$error.'</p>
            </div>
        </div><br/>';
    }
}
