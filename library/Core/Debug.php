<?php

/**
 * Description of Debug
 *
 * @category Core
 * @package Core_Debug
 * @author V.Leontiev
 */
class Core_Debug extends Zend_Debug
{
    /**
     * Get debug option from config
     * 
     * @author V.Leontiev
     * @param type $message
     * @param type $label 
     * @return string
     */
    public static function dump($message, $label = null, $show = true)
    {
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getApplication();
        $show = $bootstrap->getOption('debugger') == 1 ? true : false;
        
        return parent::dump($message, $label, $show);
    }
}

