<?php
/**
 * Administrator index controller
 *
 * @category Application
 * @package Application_Administrator
 * @subpackage Controllers
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */

class Administrator_IndexController extends Zend_Controller_Action
{

    /**
     * Initialize default method
     *
     */
    public function init()
    {
        $this->_helper->layout->setLayout('administrator/layout');
    }

    /**
     * Intex action
     *
     */
    public function indexAction()
    {

    }
}