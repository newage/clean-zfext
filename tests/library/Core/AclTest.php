<?php
require_once 'Zend/Acl.php';
require_once 'Core/Acl.php';

/**
 * AclTest
 *
 * @category   Core
 * @package    Core_Acl
 * @subpackage UnitTests
 * @version    $Id$
 */

class Core_AclTest extends PHPUnit_Framework_TestCase
{
    /**
     * ACL object for each test method
     *
     * @var Core_Acl
     */
    protected $_acl;

    /**
     * Instantiates a new ACL object and creates internal reference to it for each test method
     *
     * @dataProvider Acl_Config
     * @return void
     */
    public function setUp()
    {
        $config = array(
            'roles' => array(
                'guest' => null,
                'user' => array('parent' => 'guest'),
                'tester' => null,
                'administrator' => null
            ),
            'resources' => array(
                'file' => null,
                'mp3' => 'file',
            ),
            'rules' => array(
                array(
                    'rule' => 'allow',
                    'role' => 'guest',
                    'resource' => 'file',
                    'action' => null
                ),
                array(
                    'rule' => 'allow',
                    'role' => 'tester',
                    'resource' => 'mp3',
                    'action' => null
                ),
                array(
                    'rule' => 'deny',
                    'role' => 'user',
                    'resource' => 'mp3',
                    'action' => 'edit'
                ),
            )
        );
        $this->_acl = new Core_Acl($config);
    }

    /**
     * Testing nested roles
     *
     * @return void
     */
    public function testNestedRole()
    {
        $this->assertTrue($this->_acl->isAllowed('user', 'file', 'view'));
    }

    /**
     * Testing nested resource
     *
     * @return void
     */
    public function testNestedResource()
    {
        $this->assertTrue($this->_acl->isAllowed('tester', 'mp3', 'view'));
    }

    /**
     * Test deny resource
     *
     * @return void
     */
    public function testDenyResource()
    {
        $this->assertFalse($this->_acl->isAllowed('user', 'mp3', 'edit'));
    }
}