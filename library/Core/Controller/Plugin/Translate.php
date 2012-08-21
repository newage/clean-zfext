<?php

/**
 * Front controller plugin
 * Set route for translate
 *
 * @category Core
 * @package Core_Controller
 * @subpackage Plugin
 * @author V.Leontiev
 *
 * @version $Id$
 */
class Core_Controller_Plugin_Translate extends Zend_Controller_Plugin_Abstract
{

    /**
     * Options
     *
     * @var array
     */
    private $_options = array();

    /**
     * Default language
     *
     * @var string
     */
    protected $_default = 'ru';

    /**
     * Current language
     *
     * @var string
     */
    protected $_language = 'ru';

    /**
     * Map of supported locales.
     *
     * @var array
     */
    protected $_locales = array();

    /**
     * Contructor
     * Verify options
     *
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        if (!sizeof($options)) {
           throw new Zend_Translate_Exception('No translate plugin config found in bootstrap.ini');
        }

        if (isset($options['locales'])) {
            $this->_locales = array_merge($this->_locales, $options['locales']);
            unset($options['locales']);
        }

        if (isset($options['default']) && array_key_exists($options['default'], $this->_locales)) {
            $this->_default = $options['default'];
            unset($options['default']);
        }
        
        $this->_options = array_merge($this->_options, $options);
    }

    /**
     * Create multilingual route before route startup
     * 
     * @param Zend_Controller_Request_Abstract $request
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $params = explode('/', trim($request->getPathInfo(), '/'));

        if (in_array($params[0], array_keys($this->_locales))) {
            $this->_language = $params[0];
        } else {
            $this->_language = $this->_default;
        }
        
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $route  = new Zend_Controller_Router_Route(
            ':translate/:module/:controller/:action/*',
            array(
                'module' => Zend_Controller_Front::getInstance()->getDefaultModule(),
                'controller' => Zend_Controller_Front::getInstance()->getDefaultControllerName(),
                'action' => Zend_Controller_Front::getInstance()->getDefaultAction(),
                'translate' => $this->_default
            ),
            array(
                'translate' => '\w{2}'
            )
        );
        $router->addRoute('multilingual', $route);
    }
    
    /**
     * Set language global parametr to router
     * 
     * @param Zend_Controller_Request_Abstract $request 
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        Zend_Controller_Front::getInstance()->getRouter()->setGlobalParam('translate', $this->_language);
    }

    /**
     * Init default and zend_validate translator
     * Registry translator and locale to Zend_Registry
     * Caching translators
     *
     * @param end_Controller_Request_Abstract $request
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $cacheName = 'Zend_Cache_Manager';
        if (Zend_Registry::isRegistered($cacheName) && Zend_Registry::get($cacheName)->hasCache('translate')) {
            Zend_Translate::setCache(
                Zend_Registry::get($cacheName)->getCache('translate')
            );
        }

        $localeString = $this->_locales[$this->_language];
        $locale    = new Zend_Locale($localeString);
        $this->_options['locale'] = $locale;
        
        if ($this->_options['logUntranslated']) {
            $db = Zend_Db_Table::getDefaultAdapter();

            $writer = new Zend_Log_Writer_Db($db, $this->_options['logTable']);

            $this->_options['log'] = new Zend_Log($writer);
            $this->_options['log']->setTimestampFormat('Y-m-d H:i:s');
        }
        
        $translate = new Zend_Translate($this->_options);

        //Set default translator for validator
        $validateTranslator = new Zend_Translate(
            'array',
            $this->_options['validateTranslatorPath'],
            $translate->getAdapter()->getLocale(),
            array('scan' => Zend_Translate::LOCALE_DIRECTORY)
        );

        $translate->addTranslation($validateTranslator);

        Zend_Registry::set('Zend_Locale', $locale);
        Zend_Registry::set('Zend_Translate', $translate);
        Zend_Form::setDefaultTranslator($translate);
        Zend_Validate_Abstract::setDefaultTranslator($translate);
        
        $currency = new Zend_Currency($localeString);
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->assign('currency', $currency);
    }
}
