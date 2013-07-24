<?php
/**
 * Reads configs from all modules
 *
 * @category Library
 * @package  Core_Module
 * @author   V.Leontiev <vadim.leontiev@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @since    php 5.3 or higher
 * @see      https://github.com/newage/clean-zfext
 */

class Core_Module_Config
{

    /**
     * @var array
     */
    private $_options = array();

    /**
     * @var Zend_Cache_Core
     */
    private static $_cache = null;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function  __construct(Array $options = array())
    {
        $this->setOptions($options);
    }

    /**
     * Set options
     *
     * @param array $options
     * @return Core_Module_Config
     */
    public function setOptions(Array $options)
    {
        if (!empty($options)) {
            $this->_options = $options;
        }
        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        if (empty($this->_options)) {
            throw new Zend_Exception('Dont set options in ' . __CLASS__);
        }
        return $this->_options;
    }

    /**
     * Set cache
     * @param Zend_Cache $cache
     */
    public static function setCache(Zend_Cache_Core $cache)
    {
        self::$_cache = $cache;
    }

    /**
     * Get cache
     * @return Zend_Cache
     */
    public static function getCache()
    {
        return self::$_cache;
    }

    /**
     * Has cache
     * @return bool
     */
    public static function hasCache()
    {
        return null !== self::$_cache ? true : false;
    }

    /**
     * Clears all set cache data
     *
     * @return void
     */
    public static function clearCache()
    {
        if (self::hasCache()) {
            self::$_cache->clean();
        }
    }

    /**
     * Get configs from all modules
     * @param string $name config name
     * @return Zend_Config_Core
     */
    public function readConfigs()
    {
        $options = $this->getOptions();
        $name = $options['config'];
        if (self::hasCache() && self::getCache()->test($name)) {
            $config = self::getCache()->load($name);
        } else {
            $config = $this->_getConfigFromModules();
            if (self::hasCache()) {
                self::getCache()->save($config, $name);
            }
        }
        return $config;
    }

    /**
     * Get all configs from modules
     *
     * @param string $name Config name
     * @return array
     */
    protected function _getConfigFromModules()
    {
        $options = $this->getOptions();
        $config = array();
        foreach (Zend_Controller_Front::getInstance()->getControllerDirectory() as $value) {
            $configFile = substr($value, 0, -11) . 'configs' . DIRECTORY_SEPARATOR . $options['config'] . '.xml';
            if (file_exists($configFile)) {
                try {
                    if (empty($config)) {
                        $config = new Zend_Config_Xml($configFile, $options['section'], true);
                    } else {
                        $configOther = new Zend_Config_Xml($configFile, $options['section']);
                        $config->merge($configOther);
                    }
                } catch (Zend_Config_Exception $e) {
                    throw new Zend_Exception($e->getMessage());
                }
            }
        }
        return $config;
    }

}
