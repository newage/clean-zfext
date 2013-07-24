<?php

/**
 * Errors elemetn message use twitter bootstrap framework
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
            $append .= $this->addErrorToContent($error) . PHP_EOL;
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

    private function addErrorToContent($error)
    {
        return '<div class="alert alert-error">'.$error.'</div>';
    }
}
