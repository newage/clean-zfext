<?php

/**
 * Front Controller Application Resources
 *
 * You can use this is resource in your application.ini
 * Example
 * <code>
 * ; set classname
 * resources.frontController.plugins.acl.classname = "Core_Controller_Plugin_Acl"
 * ; set some options
 * resources.frontController.plugins.acl.options.denied.controller = error
 * resources.frontController.plugins.acl.options.denied.action = denied
 * resources.frontController.plugins.acl.options.role = guest
 * </code>
 *
 * @category   Library
 * @package    Core_Application
 * @subpackage Resource
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Application_Resource_Frontcontroller extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_Controller_Front
     */
    protected $_front;

    /**
     * Initialize Front Controller
     *
     * @return Zend_Controller_Front
     */
    public function init()
    {
        $front = $this->getFrontController();

        foreach ($this->getOptions() as $key => $value) {
            switch (strtolower($key)) {
                case 'controllerdirectory':
                    if (is_string($value)) {
                        $front->setControllerDirectory($value);
                    } elseif (is_array($value)) {
                        foreach ($value as $module => $directory) {
                            $front->addControllerDirectory($directory,
                                                           $module);
                        }
                    }
                    break;

                case 'modulecontrollerdirectoryname':
                    $front->setModuleControllerDirectoryName($value);
                    break;

                case 'moduledirectory':
                    $front->addModuleDirectory($value);
                    break;

                case 'defaultcontrollername':
                    $front->setDefaultControllerName($value);
                    break;

                case 'defaultaction':
                    $front->setDefaultAction($value);
                    break;

                case 'defaultmodule':
                    $front->setDefaultModule($value);
                    break;

                case 'baseurl':
                    $front->setBaseUrl($value);
                    break;

                case 'params':
                    $front->setParams($value);
                    break;

                case 'plugins':
                    ksort($value);
                    foreach ((array) $value as $index => $pluginClass) {
                        if (is_array($pluginClass)) {
                            if (!isset($pluginClass['options'])) {
                                $pluginClass['options'] = array();
                            }
                            $plugin = new $pluginClass['class']($pluginClass['options']);
                        } else {
                            $plugin = new $pluginClass();
                        }
                        $front->registerPlugin($plugin, $index);
                    }
                    break;

                case 'throwexceptions':
                    $front->throwExceptions((bool) $value);
                    break;

                case 'actionhelperpaths':
                    if (is_array($value)) {
                        foreach ($value as $helperPrefix => $helperPath) {
                            Zend_Controller_Action_HelperBroker::addPath($helperPath, $helperPrefix);
                        }
                    }
                    break;

                default:
                    $front->setParam($key, $value);
                    break;
            }
        }

        if (null !== ($bootstrap = $this->getBootstrap())) {
            $this->getBootstrap()->frontController = $front;
        }

        return $front;
    }

    /**
     * Retrieve front controller instance
     *
     * @return Zend_Controller_Front
     */
    public function getFrontController()
    {
        if (null === $this->_front) {
            $this->_front = Zend_Controller_Front::getInstance();
        }
        return $this->_front;
    }
}
