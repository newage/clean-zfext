<?php
require_once 'Zend/Log.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Application/Resource/ResourceAbstract.php';
require_once 'Core/Application/Resource/Log.php';

class Core_Application_Resource_LogTest extends PHPUnit_Framework_TestCase
{
    protected $_log = null;

    public function SetUp()
    {
        $options = array(0 => array(
                'writerName' => 'Stream',
                'writerParams' => array(
                    'stream' => 'php://output'
                )
            )
        );
        
        $this->_log = new Core_Application_Resource_Log($options);
    }

    public function testSetLog()
    {
        $logger = new Zend_Log();
        $result = $this->_log->setLog($logger);

        $this->assertEquals('Zend_Log', get_class($result->init()));
    }

    public function testGetLog()
    {
        $this->assertEquals('Zend_Log', get_class($this->_log->init()));
    }
}