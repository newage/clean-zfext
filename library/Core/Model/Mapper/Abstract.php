<?php
require_once 'Interface.php';

/**
 * Abstract Model mapper
 *
 * @category   Core
 * @package    Core_Model
 * @subpackage Mapper
 */

abstract class Core_Model_Mapper_Abstract implements Core_Model_Maper_Interface
{

    const DEFAULT_CACHE_NAME = 'composite';

    /**
     * Default start page number
     */
    const DEFAULT_PAGE_NUMBER = 1;

    /**
     * @var Zend_Db
     */
    protected $_dbTable = null;

    /**
     * Last select object
     *
     * @var Zend_Db_Select
     */
    protected $_lastSelect = null;

    /**
     * Delete row
     *
     * @param int $id
     */
    public function delete($id)
    {

    }

    public function fetchAll()
    {

    }

    public function find($id)
    {

    }

    /**
     * Set select for paginator
     * And add limitPage to select
     *
     * @param Zend_Db_Table_Select $select
     */
    public function setSelectLimit(Zend_Db_Select $select)
    {
        $this->_lastSelect = $select;

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $pageNumber = $request->getParam('page') !== null
                    ? (int)$request->getParam('page')
                    : self::DEFAULT_PAGE_NUMBER;
        $rowCount = $request->getParam('rows') !== null
                  ? (int)$request->getParam('rows')
                  : Zend_Paginator::getDefaultItemCountPerPage();

        $select->limitPage($pageNumber, $rowCount);
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
     */
    protected function _cleanCache($mode, Array $tags)
    {
        $cacheManager = $this->_getCacheManager();
        if ($cacheManager !== false) {
            foreach ($cacheManager->getCaches() as $cache) {
                $cache->clean($mode, $tags);
            }
        }
    }

    /**
     * Save date
     *
     * @param Core_Model_Abstract $data
     * @return int
     */
    public function save(Core_Model_Abstract $data)
    {
        $table = $this->getDbTable();
        return $table->insert($data->toArray());
    }

    /**
     * Set new dbTable
     * @param string $dbTable dbTable name
     * @return Core_Db_Table_Abstract
     * @exception
     */
    public function setDbTable($dbTable = null)
    {
        if ($dbTable === null) {
            $modelClassName = substr(get_class($this), 0, -6);
            $pattern = '~^([\w]+\_[\w]+)\_([\w]+)$~';
            $replace = '$1_DbTable_$2';
            $dbTable = preg_replace($pattern, $replace, $modelClassName);
        }

        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }

        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }

        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Get dbTable object
     * @return \Core_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable();
        }
        return $this->_dbTable;
    }

    /**
     * Get default adapter
     *
     * @return \Zend_Db_Adapter_Abstract
     */
    protected function _dbAdapter()
    {
        return $this->getDbTable()->getDefaultAdapter();
    }

    /**
     * Get current user id
     *
     * @return int
     */
    protected function _getCurrentUserId()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        return (int)$identity->id;
    }

    /**
     * Get cache
     *
     * @return Zend_Cache_Core
     * @throws Core_Model_Mapper_Exception
     */
    public function getCache()
    {
        $cacheManager = $this->_getCacheManager();
        if ($cacheManager->hasCache(self::DEFAULT_CACHE_NAME)) {
            return $cacheManager->getCache(self::DEFAULT_CACHE_NAME);
        } else {
            throw new Core_Model_Mapper_Exception('Don\'t set cache with name: ' . self::DEFAULT_CACHE_NAME);
        }
    }

    /**
     * Isset cache id
     *
     * @param string $cacheId
     * @return bool
     */
    public function isCache($cacheId)
    {
        return $this->getCache()->test($cacheId) ? true : false;
    }

    /**
     * Get data from cache
     *
     * @param string $cacheId
     * @return mixed
     */
    public function loadCache($cacheId)
    {
        if ($this->isCache($cacheId) === true) {
            return $this->getCache()->load($cacheId);
        }
        return false;
    }

    /**
     * Remove cache
     *
     * @param string $cacheId
     * @return boolean
     */
    public function removeCache($cacheId)
    {
        if ($this->isCache($cacheId) === true) {
            return $this->getCache()->remove($cacheId);
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
    public function saveCache($data, $cacheId, $tags = array())
    {
        return $this->getCache()->save($data, $cacheId, $tags);
    }
}
