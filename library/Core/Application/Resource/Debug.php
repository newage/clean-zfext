<?php

/**
 * Resource ZFDebug
 *
 * @category   Library
 * @package    Core_Application
 * @subpackage Resource
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Application_Resource_Debug extends Zend_Application_Resource_ResourceAbstract
{

    /**
     * Initialize debugger;
     *
     * @return bool
     */
    public function init()
    {
        if (isset($_SERVER['argc']) && $_SERVER['argc'] > 0) {
            return false;
        }

        return $this->setDebugger();
    }

    /**
     * Registrate plugin zfdebug
     *
     * @return bool
     */
    public function setDebugger()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug');

        $view = new Zend_View();
        $view->headLink()->appendStylesheet('/vendor/newage/zf-console/css/zf-debug.css', 'screen');
        $view->headScript()->appendFile('/vendor/newage/zf-console/js/zf-debug.js');

        $options = $this->getOptions();

        # Setup the cache plugin
        if (Zend_Registry::isRegistered('Zend_Cache_Manager')) {
            $resources = $this->_bootstrap->getOption('resources');
            $cacheManager = Zend_Registry::get('Zend_Cache_Manager');

            foreach (array_keys($resources['cachemanager']) as $value) {
                if ($cacheManager->hasCache($value)) {
                    $cacheOption[$value] = $cacheManager->getCache($value)->getBackend();
                }
            }

            if (!empty($cacheOption)) {
                $options['plugins']['Cache']['backend'] = $cacheOption;
            }
        }

        $options['plugins'][] = 'Exception';

        $debug = new ZFDebug_Controller_Plugin_Debug($options);

        Zend_Controller_Front::getInstance()->registerPlugin($debug);

        return true;
    }

}
