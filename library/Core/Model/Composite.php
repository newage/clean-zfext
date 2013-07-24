<?php

/**
 * Extend object for SplObjectStorage
 * Caching models in storage
 *
 * @category Library
 * @package  Core_Model
 * @author   V.Leontiev <vadim.leontiev@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @since    php 5.3 or higher
 * @see      https://github.com/newage/clean-zfext
 */
class Core_Model_Composite extends SplObjectStorage
{
    const CACHE_NAME = 'composite';

    /**
     * Cache identifier
     * @var string
     */
    protected $_cacheId = null;

    /**
     * Cache tags
     *
     * @var array
     */
    protected $_cacheTags = array();

    /**
     * Check is cached
     *
     * @param Zend_Db_Select $select
     * @return bool
     */
    public function isCached(Zend_Db_Select $select)
    {
        $this->_cacheId = md5($select);
        $this->_cacheTags = array_keys($select->getPart('from'));

        $cache = $this->_getCache();
        if (($data = $cache->load($this->_cacheId)) !== false) {
            $this->unserialize($data);
        }

        return $this->count() > 0 ? true : false;
    }

    /**
     * Save models to cache
     *
     * @throws Core_Exception
     * @return void
     */
    public function toCache()
    {
        if (empty($this->_cacheId)) {
            throw new Core_Exception('Need set cache id called method "isCached()"');
        }

        $cache = $this->_getCache();
        $cache->save($this->serialize(), $this->_cacheId, $this->_cacheTags);
    }

    /**
     * Get registered cache
     *
     * @return Zend_Cache_Core
     * @throws Core_Exception
     */
    protected function _getCache()
    {
        $cacheName = 'Zend_Cache_Manager';
        if (Zend_Registry::isRegistered($cacheName) && Zend_Registry::get($cacheName)->hasCache(self::CACHE_NAME)) {
            return Zend_Registry::get($cacheName)->getCache(self::CACHE_NAME);
        }
        throw new Core_Exception('Don\'t set cache with name "'.self::CACHE_NAME.'" in cache manager!');
    }
}

