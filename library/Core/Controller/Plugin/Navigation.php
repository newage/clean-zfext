<?php
/**
 * Controller plugin that sets the correct paths to the Zend_Layout instances
 * 
 * @category Core
 * @package Core_Controller
 * @subpackage Plugin
 * @author V.Leontiev
 * 
 * @version  $Id$
 */
class Core_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
    /**
     * Plugin configuration settings array
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Constructor
     *
     * Options may include:
     * - config
     *
     * @param  Array $options
     * @return void
     */
    public function __construct(Array $options = array())
    {
        $this->_options = $options;
    }
    
    /**
     * preDispatch
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->_initNavigation();
    }

    
    /**
     * Initialize navigation
     * Add acl, role and translator to navigation
     * 
     * @param   string $section
     * @return  void  
     */
    protected function _initNavigation() 
    {
        $config = $this->_getConfig();

        if (!empty($config)) {
            $container = new Zend_Navigation($config);
            
            Zend_Layout::getMvcInstance()->getView()->navigation($container);

            if (Zend_Registry::isRegistered('Zend_Translate') && Zend_Registry::isRegistered('Zend_Acl')) {
                $acl = Zend_Registry::get('Zend_Acl');
                $translator = Zend_Registry::get('Zend_Translate');

                $identity = Zend_Auth::getInstance()->getIdentity();
                $role = $identity ? $identity->role : 'guest';

                Zend_Layout::getMvcInstance()->getView()->navigation()
                                             ->setAcl($acl)
                                             ->setRole($role)
                                             ->setTranslator($translator);
            }
        }
    }
    
    /**
     * Get config from cache or read config
     *
     * @return array
     */
    protected function _getConfig()
    {
        if (Zend_Registry::isRegistered('Zend_Cache_Manager') && Zend_Registry::get('Zend_Cache_Manager')->hasCache('navigation')) {
            $cache = Zend_Registry::get('Zend_Cache_Manager')->getCache('navigation');
            Core_Module_Config_Xml::setCache($cache);
        }
        $moduleConfig = new Core_Module_Config_Xml($this->_options);
        $config = $moduleConfig->readConfigs(true);
        return $config;
    }
}