<?php
require_once 'Zend/Acl.php';
require_once 'Zend/Controller/Plugin/Abstract.php';
require_once 'Core/Acl.php';
require_once 'Core/Controller/Plugin/Acl.php';

/**
 * AclXmlTest
 *
 * @category   Core
 * @package    Core_Controller_Plugin
 * @subpackage UnitTests
 * @version    $Id$
 */
class Core_Controller_Plugin_AclTest extends PHPUnit_Framework_TestCase
{
    protected $_acl = null;

    public function setUp()
    {
        $options = array(
            'options' => array(
                'config' => 'acl',
                'section' => 'production',
                'unlogined' => '/login',
                'role' => 'guest',
                'denied' => array(
                    'module' => 'default',
                    'controller' => 'error',
                    'action' => 'denied'
                )
            )
        );
        
        $this->_acl = new Core_Controller_Plugin_Acl($options);
    }
}