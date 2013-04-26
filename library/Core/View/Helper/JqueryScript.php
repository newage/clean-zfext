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
    /**
     *
     * @return \Core_View_Helper_JqueryScript
     */
    public function jqueryScript()
    {
        return $this;
    }

    /**
     *
     * @see Zend_View_Helper_HeadScript::__call()
     * @param  string $method
     * @param  array $args
     * @return Zend_View_Helper_HeadScript
     * @throws Zend_View_Exception if too few arguments or invalid method
     */
    public function __call($method, $args)
    {
        $headScript = new Zend_View_Helper_HeadScript();
        $content = "$(function() {\n" . $args[0] . "\n})";
        return $headScript->$method($content);
    }
}
