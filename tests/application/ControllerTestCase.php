<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

abstract class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * @var Zend_Application
     */
    protected $application;

    public function setUp()
    {
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }

    public function appBootstrap()
    {
        $configPath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs';
        $config = new Zend_Config_Ini($configPath . '/application.ini', 'production', true);
        if ('production' != APPLICATION_ENV && file_exists($configPath . '/application.development.ini')) {
            $configOther = new Zend_Config_Ini($configPath . '/application.development.ini', APPLICATION_ENV);
            $config->merge($configOther);
        }

         $this->application = new Zend_Application(APPLICATION_ENV, $config);
         
         $this->application->bootstrap();
    }

}

