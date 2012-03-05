<?php
require_once 'Zend/View/Helper/Abstract.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';
require_once 'Core/View/Helper/Messenger.php';

class Core_View_Helper_MessengerTest extends PHPUnit_Framework_TestCase
{
    protected $_messenger = null;

    public function setUp()
    {
        $this->_messenger = new Core_View_Helper_Messenger();
    }

    public function testMessenger()
    {
        Zend_Controller_Action_HelperBroker::addPath('Core/Controller/Action/Helper', 'Core_Controller_Action_Helper');
        $this->assertEquals('Core_Controller_Action_Helper_Messenger', get_class($this->_messenger->Messenger()));
    }
}
