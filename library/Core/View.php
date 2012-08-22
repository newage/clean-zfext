<?php

/**
 * Enable short translate method __ and _e
 *
 * @category Core
 * @package Core_View
 * @author V.Leontiev
 */
class Core_View extends Zend_View
{
 
    /**
     * Title project
     * 
     * @var string
     */
    protected $_projectTitle = null;
    
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
    
    /**
     * Get project title
     * 
     * @return string
     */
    public function projectTitle()
    {
        if (func_num_args() == 1) {
            $param = func_get_arg(0);
            $this->_projectTitle = $param;
        }
        return $this->_projectTitle;
    }
}

