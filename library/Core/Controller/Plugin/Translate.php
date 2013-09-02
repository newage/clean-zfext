<?php

/**
 * Front controller plugin
 * Set route for translate
 *
 * @category   Library
 * @package    Core_Controller
 * @subpackage Plugin
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Controller_Plugin_Translate extends Zend_Controller_Plugin_Abstract
{

    /**
     * Default registry name
     */
    const DEFAULT_REGISTRY_KEY = 'Zend_Translate';

    /**
     * Default name on cache manager
     * Setted in configuration param:
     * <code>
     *   resources.frontcontroller.plugins.translate.options.cache = translate
     * <code>
     *
     * Need add cache to cache manager
     * <code>
     *   resources.cachemanager.translate.frontend.name = Core
     *   resources.cachemanager.translate.frontend.options.lifetime = 7200
     *   resources.cachemanager.translate.frontend.options.automatic_serialization = true
     *   resources.cachemanager.translate.backend.name = Apc
     * <code>
     */
    const DEFAULT_CACHE_NAME = 'translate';

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
    protected $_default = 'en';

    /**
     * Current language
     *
     * @var string
     */
    protected $_language = 'en';

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
        $nameCacheManager = 'Zend_Cache_Manager';
        if (isset($this->_options['cache'])) {
            $cacheName = $this->_options['cache'];
            unset($this->_options['cache']);
        } else {
            $cacheName = self::DEFAULT_CACHE_NAME;
        }

        if (Zend_Registry::isRegistered($nameCacheManager) &&
            Zend_Registry::get($nameCacheManager)->hasCache($cacheName)
        ) {
            Zend_Translate::setCache(
                Zend_Registry::get($nameCacheManager)->getCache($cacheName)
            );
        }

        $localeString = $this->_locales[$this->_language];
        $locale = Zend_Registry::isRegistered('Zend_Locale')
            ? Zend_Registry::get('Zend_Locale') : new Zend_Locale();
        $locale->setLocale($localeString);
        $this->_options['locale'] = $locale;

        if ($this->_options['logUntranslated']) {
            $writer = new Zend_Log_Writer_Stream($this->_options['logPath']);

            $this->_options['log'] = new Zend_Log($writer);
            $this->_options['log']->setTimestampFormat('Y-m-d H:i:s');
        }

        $translator = new Zend_Translate($this->_options);

        //Set default translator for validator
        $validateTranslator = new Zend_Translate(
            array(
                'adapter' => 'array',
                'content' => $this->_options['validateTranslatorPath'],
                'locale' => $translator->getAdapter()->getLocale(),
                'scan' => Zend_Translate::LOCALE_FILENAME,
                'ignore'  => '==='
            )
        );

        $translator->addTranslation($validateTranslator);

        Zend_Registry::isRegistered('Zend_Locale')
            || Zend_Registry::set('Zend_Locale', $locale);
        Zend_Registry::isRegistered(self::DEFAULT_REGISTRY_KEY)
            || Zend_Registry::set(self::DEFAULT_REGISTRY_KEY, $translator);
    }
}
