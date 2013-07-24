<?php

/**
 * Enable/disable debug information
 *
 * @category Library
 * @package  Core
 * @author   V.Leontiev <vadim.leontiev@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @since    php 5.3 or higher
 * @see      https://github.com/newage/clean-zfext
 */
class Core_Debug extends Zend_Debug
{
    /**
     * Get debug option from config
     *
     * @param string $message
     * @param string $label
     * @return string
     */
    public static function dump($message, $label = null)
    {
        $show = false;
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getApplication();
        switch ($bootstrap->getOption('debugger')) {
            case '1':
            case 'on':
            case 'true':
                $show = true;
                break;
        }

        return parent::dump($message, $label, $show);
    }
}

