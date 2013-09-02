<?php

/**
 * Initialize new rules from the routes
 * Read configs for routes from all modules
 *
 * @category   Library
 * @package    Core_Controller
 * @subpackage Plugin
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Controller_Plugin_Routes extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var array
     */
    protected $_options = array();

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(Array $options)
    {
        $this->_options = $options;
    }

    /**
     * Route startup handler
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->setRoutes();
    }

    /**
     * Set new route config
     *
     * @return Zend_Config
     */
    public function setRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addConfig($this->_getRoutesConfig(), 'routes');
    }

    /**
     * Get route config
     */
    protected function _getRoutesConfig()
    {
        $cacheName = 'Zend_Cache_Manager';
        if (Zend_Registry::isRegistered($cacheName) && Zend_Registry::get($cacheName)->hasCache('routes')) {
            $cache = Zend_Registry::get($cacheName)->getCache('routes');
            Core_Module_Config_Xml::setCache($cache);
        }
        $moduleConfig = new Core_Module_Config_Xml($this->_options);
        $config = $moduleConfig->readConfigs();
        return $config;
    }
}