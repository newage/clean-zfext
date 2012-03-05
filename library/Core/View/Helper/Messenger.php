<?php
/**
 * Registration view helper "Messenger" in controller helper
 *
 * @category Core
 * @package Core_View
 * @subpackage Helper
 * @author V.Leontiev
 *
 * @version $Id$
 */

class Core_View_Helper_Messenger extends Zend_View_Helper_Abstract
{

    public function Messenger()
    {
        return Zend_Controller_Action_HelperBroker::getStaticHelper("Messenger");
    }
}