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
    protected $_items = array();

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
     * @param  string $script
     * @return Zend_View_Helper_HeadScript
     * @throws Zend_View_Exception if too few arguments or invalid method
     */
    public function append($script)
    {
        $this->_items[] = "\n" . $script . "\n";
    }

    public function toString()
    {
        if (count($this->_items) > 0) {
            $scripts = '<script type="text/javascript">' . "\n"
                . 'require(["jquery", "bootstrap"], function($) {'.implode("\n", $this->_items).'});' . "\n"
                . '</script>';
        } else {
            $scripts = '';
        }
        return $scripts;
    }
}
