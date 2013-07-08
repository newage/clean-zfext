<?php

/**
 * Extends HeadScript helper
 * Add method jqueryScript()
 *
 * @category Core
 * @package Core_View
 * @subpackage Helper
 * @author V.Leontiev
 */
class Core_View_Helper_JqueryScript extends Zend_View_Helper_Placeholder_Container_Standalone
{
    protected $_items = array(
        '$("a").tooltip();'
    );
    
    protected $_libraries = array(
        'jquery',
        'bootstrap'
    );

    /**
     *
     * @return \Core_View_Helper_JqueryScript
     */
    public function jqueryScript()
    {
        return $this;
    }

    /**
     * Add jquery script
     *
     * @see Zend_View_Helper_HeadScript::__call()
     * @param string $script
     * @param string $library Require js library
     * @return Zend_View_Helper_HeadScript
     * @throws Zend_View_Exception if too few arguments or invalid method
     */
    public function append($script, $library = 'jquery')
    {
        if (!in_array($library, $this->_libraries)) {
            array_push($this->_libraries, $library);
        }
        
        array_push($this->_items, $script);
    }

    public function toString()
    {
        if (count($this->_items) > 0) {
            $scripts = '<script type="text/javascript">' . "\n"
                . 'require(["'.implode('","', $this->_libraries).'"], function($) {'.implode("\n", $this->_items).'});' . "\n"
                . '</script>';
        } else {
            $scripts = '';
        }
        return $scripts;
    }
}
