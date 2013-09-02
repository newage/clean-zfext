<?php

/**
 * Abstract mapper with implemtn cache
 *
 * @category   Core
 * @package    Core_Model
 * @subpackage Mapper
 * @author V.Leontiev
 */
abstract class Core_Model_Mapper_Cache
{

    /**
     * Cache name from configs
     */
    const CACHE_NAME = 'models';

    /**
     * Prefix for cache id
     *
     * @var string
     */
    protected $_prefixCache = null;

    /**
     * Constructor
     * Check required variables
     *
     * @throws Core_Model_Mapper_Exception
     */
    public function __construct()
    {
        if($this->_prefixCache === null) {
            throw new Core_Model_Mapper_Exception(get_class($this) . ' must have a $_prefixCache');
        }
    }

    /**
     * Get generated cache id
     *
     * @param string $suffix
     * @return string
     */
    protected function _getCacheId($suffix)
    {
        return md5($this->_prefixCache . $suffix);
    }

    /**
     * Get cache manager
     *
     * @return Zend_Cache_Manager
     */
    protected function _getCacheManager()
    {
        $cacheName = 'Zend_Cache_Manager';
        if (Zend_Registry::isRegistered($cacheName) === false) {
            return false;
        } else {
            return Zend_Registry::get($cacheName);
        }
    }

    /**
     * Clean all cache in Zend_Cache_Manager
     *
     * @param string $mode Type from Zend_Cache
     * @param array $tags
     * @return bool
     */
    protected function _cleanCache($mode, Array $tags)
    {
        $cacheManager = $this->_getCacheManager();
        if ($cacheManager !== false) {
            foreach ($cacheManager->getCaches() as $cache) {
                $cache->clean($mode, $tags);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Clean all cache in Zend_Cache_Manager
     *
     * @param string $mode Type from Zend_Cache
     * @param array $tags
     */
    protected function _removeCache($cacheId)
    {
        if ($this->_isCache($cacheId) === true) {
            return $this->_getCache()->remove($cacheId);
        }
        return false;
    }

    /**
     * Get cache
     *
     * @return Zend_Cache_Core
     * @throws Core_Model_Mapper_Exception
     */
    protected function _getCache()
    {
        $cacheManager = $this->_getCacheManager();
        if ($cacheManager->hasCache(self::CACHE_NAME)) {
            return $cacheManager->getCache(self::CACHE_NAME);
        } else {
            throw new Core_Model_Mapper_Exception('Didn\'t set cache to manager with name: ' . self::CACHE_NAME);
        }
    }

    /**
     * Isset cache id
     *
     * @param string $cacheId
     * @return bool
     */
    protected function _isCache($cacheId)
    {
        return $this->_getCache()->test($cacheId) ? true : false;
    }

    /**
     * Get data from cache
     *
     * @param string $cacheId
     * @return mixed
     */
    protected function _loadCache($cacheId)
    {
        if ($this->_isCache($cacheId) === true) {
            return $this->_getCache()->load($cacheId);
        }
        return false;
    }

    /**
     * Set data to cache
     *
     * @param mixed $data Data to cache storage
     * @param string $cacheId Cache unique id
     * @param array $tags Cache tags [optional]
     * @param bool $force Force save cache [optional]
     * @return bool
     * @throw Core_Model_Mapper_Exception
     */
    protected function _saveCache($data, $cacheId, $tags = array())
    {
        return $this->_getCache()->save($data, $cacheId, $tags);
    }
}