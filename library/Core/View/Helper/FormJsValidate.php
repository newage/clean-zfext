<?php

/**
 * JsValidate form helper
 *
 * @author V.Leontiev
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