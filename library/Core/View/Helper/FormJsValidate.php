<?php

/**
 * JsValidate form helper
 *
 * @category   Library
 * @package    Core_View
 * @subpackage Helper
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_View_Helper_FormJsValidate extends Zend_View_Helper_Abstract
{

    public function FormJsValidate(Zend_Form $form, $masked = false)
    {
        $this->view->JsValidate()->addForm($form);
        $this->view->JsValidate()->addMasked($masked);

//        $this->view->JsValidate()->addvalidators($config);

        $this->view->JsValidate()->render();
    }
}