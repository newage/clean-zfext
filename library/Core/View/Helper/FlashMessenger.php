<?php
/**
 * Registration view helper "FlashMessenger" in controller helper
 * 
 * @category Core
 * @package Core_View
 * @subpackage Helper
 * @author V.Leontiev
 *
 * @version $Id$
 */
class Core_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract
{
    /**
     * Generates a javascript
     *
     * @access public
     *
     * @return Zend_Controller_Action_Helper_FlashMessenger
     */
    public function FlashMessenger()
    {
        return Zend_Controller_Action_HelperBroker::getStaticHelper("FlashMessenger");
    }
}
