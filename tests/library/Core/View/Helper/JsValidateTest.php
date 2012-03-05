<?php
require_once 'Zend/View/Helper/Abstract.php';
require_once 'Core/View/Helper/JsValidate.php';

class Core_View_Helper_JsValidateTest extends PHPUnit_Framework_TestCase
{
    protected $_jsValidator = null;

    public function SetUp()
    {
        $this->_jsValidator = new Core_View_Helper_JsValidate();
    }

    public function testSetForm()
    {
//        $form = 
    }
}