<?php
require_once 'Zend/Cache/Manager.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Application/Resource/ResourceAbstract.php';
require_once 'Core/Application/Resource/Cachemanager.php';

class Core_Application_Resource_CachemanagerTest extends PHPUnit_Framework_TestCase
{
    protected $_cacheManager = null;

    public function SetUp()
    {
        $options = array(
            'disable',
            'test' => array(
                'frontend' => array(
                    'name' => 'Core',
                    'options' => array(
                        'lifitime' => 7200
                    )
                )
            )
        );
        
        $this->_cacheManager = new Core_Application_Resource_Cachemanager($options);
    }

    public function testGetCacheManager()
    {
        $this->assertEquals('Zend_Cache_Manager', get_class($this->_cacheManager->init()));
        $this->assertEquals('Zend_Cache_Manager', get_class($this->_cacheManager->getCacheManager()));
    }
}
