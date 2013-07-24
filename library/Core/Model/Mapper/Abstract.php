<?php
require_once 'Interface.php';

/**
 * Abstract Model mapper
 *
 * @category   Library
 * @package    Core_Model
 * @subpackage Mapper
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */

abstract class Core_Model_Mapper_Abstract implements Core_Model_Maper_Interface
{
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
        if (empty($this->_lastSelectWhere) || $this->_lastSelectWhere === null) {
            throw new Core_Model_Mapper_Exception('Need set select object use method "setPaginatorSelect"');
        }
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : 1;

        $select = $this->getDbTable()->select();
        $select->from('users', array(Zend_Paginator_Adapter_DbSelect::ROW_COUNT_COLUMN => 'id'));

        foreach ($this->_lastSelectWhere as $part) {
            $select->where($part);
        }

        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        $adapter->setRowCount($select);

        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);

        return $paginator;
    }

    /**
     * Set select for paginator
     * And set limitPage to select
     *
     * @param Zend_Db_Table_Select $select
     */
    public function setPaginatorSelect(Zend_Db_Table_Select $select)
    {
        $this->_lastSelectWhere = $select->getPart('where');

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
