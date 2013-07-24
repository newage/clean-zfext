<?php

/**
 * Errors for form use twitter bootstrap framework
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
class Core_Form_Decorator_TwitterFormErrors extends Zend_Form_Decorator_Abstract
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
        return '<div class="alert alert-error"><strong>' . $strongMessage . ':</strong> ' . $error . '</div>';
    }
}

