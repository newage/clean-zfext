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

    const CACHE_NAME = 'paginator';

    /**
     * Default start page number
     */
    const DEFAULT_PAGE_NUMBER = 1;

    /**
     * @var Zend_Db
     */
    protected $_dbTable = null;

    /**
     * Cache name for database caching
     *
     * @var string
     */
    protected $_cacheName = 'database';

    /**
     * Last wheres on last Zend_Db_Select query
     *
     * @var array
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
     * Set \Zend_Paginator_Adapter_DbSelect
     * And initialize Zend_Paginator
     *
     * @return \Zend_Paginator
     */
    public function getPaginator()
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;

        $select = $this->_lastSelect;
        $select->columns(array(Zend_Paginator_Adapter_DbSelect::ROW_COUNT_COLUMN => 'id'));

        $adapter = new Zend_Paginator_Adapter_DbSelect($select);

        $this->_setCacheToPaginator();

        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);

        return $paginator;
    }

    /**
     * Set cache to Paginator
     *
     */
    protected function _setCacheToPaginator()
    {
        $cacheManager = $this->_getCacheManager();
        if ($cacheManager && $cacheManager->hasCache(self::CACHE_NAME)) {
            $cache = $cacheManager->getCache(self::CACHE_NAME);
            Zend_Paginator::setCache($cache);
        }
    }

    /**
     * Set select for paginator
     * And set limitPage to select
     *
     * @param Zend_Db_Table_Select $select
     */
    public function setPaginatorSelect(Zend_Db_Select $select)
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
            foreach ($this->getCaches() as $cache) {
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
        if (Zend_Registry::get('Zend_Cache_Manager')->hasCache($this->_cacheName)) {
            return Zend_Registry::get('Zend_Cache_Manager')->getCache($this->_cacheName);
        } else {
            throw new Core_Model_Mapper_Exception('Didn\'t set cache to manager with name: ' . $this->_cacheName);
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
