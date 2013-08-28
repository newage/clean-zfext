<?php
/**
 * Bootstrap
 *
 * @category Application
 * @package Bootstrap
 * @author V.Leontiev
 *
 * @version $Id$
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Initialize the autoloader
     *
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {
        $this->bootstrap('frontController');
        $this->_front = $this->getResource('frontController');
        $autoLoader = Zend_Loader_Autoloader::getInstance();

        Zend_Controller_Action_HelperBroker::addPrefix('Core_Controller_Action_Helper');

        return $autoLoader;
    }

    /**
     * Autoload application resources (services, plugins, models)
     *
     * @return void
     */
    protected function _initAutoloadApplicationResources()
    {
        new Zend_Loader_Autoloader_Resource(array(
            'basePath' => APPLICATION_PATH,
            'namespace' => 'Application',
            'resourceTypes' => array(
                'model'   => array(
                    'namespace' => 'Model',
                    'path'      => 'models',
                ),
                'helper'   => array(
                    'namespace' => 'Helper',
                    'path'      => 'helpers',
                ),
                'plugin'  => array(
                    'namespace' => 'Plugin',
                    'path'      => 'plugins',
                ),
                'mapper' => array(
                    'namespace' => 'Model_Mapper',
                    'path' => 'models/mappers'
                )
            )
        ));
        return;
    }


    /**
     * Initialize the all modules
     *
     * @return void
     */
    protected function _initModules()
    {
        foreach($this->_front->getControllerDirectory() as $module=>$path) {
            new Zend_Application_Module_Autoloader(array(
                'basePath'  => substr($path, 0, -12),
                'namespace' => ucfirst($module)
            ));
        }
        return;
    }
}