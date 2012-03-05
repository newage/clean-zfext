<?php
/**
 * Messenger controller helper test
 * 
 * @category   Core
 * @package    Core_Controller_Action_Helper
 * @subpackage UnitTests
 * @version    $Id$
 */

define('TEST_MESSAGE', 'test message');

class Core_Controller_Action_Helper_MessengerTest extends PHPUnit_Framework_TestCase
{
    protected $_messenger = null;

    public function setUp()
    {
        $this->_messenger = new Core_Controller_Action_Helper_Messenger(TEST_MESSAGE);
    }

    public function testCount()
    {
        $this->assertEquals($this->_messenger->count(), 1);
    }

    public function testSetMessage()
    {
        $this->_messenger->setMessage(TEST_MESSAGE);
        $this->assertEquals($this->_messenger->count(), 2);
    }

    public function testGetMessages()
    {
        $this->assertContains(TEST_MESSAGE, $this->_messenger->getMessages());
    }

}
