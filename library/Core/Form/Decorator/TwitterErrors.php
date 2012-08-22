<?php

/**
 * Errors elemetn message it Twitter Bootstrap
 *
 * @category Core
 * @package Core_Form_Decorator
 * @subpackage TwitterErrors
 * @author V.Leontiev
 */
class Core_Form_Decorator_TwitterErrors extends Zend_Form_Decorator_Abstract
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
        return '<div class="alert alert-error"><strong>' . $errorName . ':</strong> '.$error.'</div>';
    }
}
