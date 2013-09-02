<?php
require_once 'Interface.php';

/**
 * Abstract Model mapper
 *
 * @category   Core
 * @package    Core_Model
 * @subpackage Mapper
 * @author V.Leontiev
 */
class Core_Model_Mapper_Abstract extends Core_Model_Mapper_Cache implements Core_Model_Maper_Interface
{

    /**
     * Paginatro object
     * @var type
     */
    protected $_paginator = null;

    /**
     * @var Zend_Db
     */
    protected $_dbTable = null;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create paginator
     *
     * @param Zend_Db_Select $select
     */
    public function createPaginator(Zend_Db_Select $select)
    {
        $this->_paginator = new Core_Paginator($select);
    }

    /**
     * Get paginator object
     *
     * @return Zend_Paginator
     */
    public function getPaginator()
    {
        return $this->_paginator->get();
    }

    /**
     * Save date
     *
     * @param Core_Model_Abstract $data
     * @return int
     */
    public function save($data)
    {
        $table = $this->getDbTable();

        if ($data instanceof Core_Model_Abstract) {
            $data = $data->toArray();
        }

        return $table->insert($data);
    }

    public function delete($id)
    {

    }

    public function fetchAll($options)
    {
        $table = $this->getDbTable();
        return $table->fetchAll();
    }

    public function find($id)
    {

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
            $dbTable = str_replace('_Mapper_', '_DbTable_', get_class($this));
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
}