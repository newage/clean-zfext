<?php
/**
 * Registration view helper "Messenger" in controller helper
 *
 * @category   Library
 * @package    Core_View
 * @subpackage Helper
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */

class Core_View_Helper_Messenger extends Zend_View_Helper_Abstract
{

    public function Messenger()
    {
        return Zend_Controller_Action_HelperBroker::getStaticHelper("Messenger");
    }
}