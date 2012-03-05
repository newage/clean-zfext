<?php

/**
 * Enable short translate method __ and _e
 *
 * @category Core
 * @package Core_View
 * @author V.Leontiev
 *
 * @version $Id$
 */
class Core_View extends Zend_View
{
    
    /**
     * __
     *
     * @param  string $messageid Id of the message to be translated
     * @return string Translated message
     */
    public function __($messageid = null)
    {
        return $this->translate($messageid);
    }

    /**
     * _e
     *
     * @param  string $messageid Id of the message to be translated
     * @return string Translated message
     */
    public function _e($messageid = null)
    {
        if ($messageid === null) {
            return null;
        }
        
        echo $this->translate($messageid);
    }
}

