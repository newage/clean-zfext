<?php

/**
 * Load default configs
 *
 * @category   Library
 * @package    Core_Text
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Test_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * Setup bootstrap file
     */
    public function setUp()
    {
        $configPath = APPLICATION_PATH . '/configs';

        $config = new Zend_Config_Ini(CONFIG_PATH, 'testing', true);
        if (file_exists($configPath . '/application.development.ini')) {
            $configOther = new Zend_Config_Ini($configPath . '/application.development.ini', 'testing');
            $config->merge($configOther);
        }

        $this->bootstrap = new Zend_Application(APPLICATION_ENV, $config);
        parent::setUp();
    }

    /**
     * Tear down after test case
     */
    public function tearDown()
    {
        Authenticate::doLogout();
    }
}

