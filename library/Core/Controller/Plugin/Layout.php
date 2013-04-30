<?php

/**
 * Enable layout for current module
 *
 * @category Core
 * @package Core_Controller
 * @subpackage Plugin
 * @author V.Leontiev
 */
class Core_Controller_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{

    /**
     * options from application.ini
     * @var array
     */
    protected $_options = array();

    /**
     * Set options
     * @param array $options
     */
    public function  __construct(Array $options = array())
    {
        $this->_options = $options;
    }

    /**
     * Set layout for current module
     *
     * @param \Zend_Controller_Request_Abstract $request
     */
    public function dispatchLoopShutdown()
    {
        $layout = Zend_Layout::getMvcInstance();
        $moduleName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();

        if (!strstr($layout->getLayout(), $moduleName)
            && is_dir($layout->getLayoutPath() . DIRECTORY_SEPARATOR . $moduleName)
        ) {
            $layoutName = strstr($layout->getLayout(), '/');
            $layout->setLayout($moduleName . $layoutName);
        }
    }
}
