<?php

/**
 * Extend storage for objects used SplObjectStorage
 *
 *
 * @category Core
 * @author   V.Leontiev <vadim.leontiev@gmail.com>
 * @license  MIT
 */
class Core_Storage extends SplObjectStorage
{

    const CACHE_NAME = 'models';

    /**
     * Cache identifier
     * @var string
     */
    protected $_cacheId = null;

    /**
     * Check is cached
     *
     * @param Zend_Db_Select $select
     * @return bool
     */
    public function isCached(Zend_Db_Select $select)
    {
        $tables = array();
        $this->_cacheId = md5($select);
        foreach ($select->getPart('from') as $table) {
            $tables[] = $table['tableName'];
        }
        $this->_cacheTags = $tables;

        $cache = $this->_getCache();
        if (($data = $cache->load($this->_cacheId)) !== false) {
            $this->unserialize($data);
            return true;
        }
        return false;
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

