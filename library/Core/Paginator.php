<?php

/**
 * Extends standard Zend_Paginator
 *
 * @category Core
 * @author V.Leonitev <vadim.leontiev@gmail.com>
 * @since php 5.1 or higher
 */
class Core_Paginator
{

    /**
     * Default page number
     *
     */
    const DEFAULT_PAGE_NUMBER = 1;

    /**
     * Last select object
     * @var Zend_Db_Select
     */
    protected $_lastSelect = null;

    /**
     * Constructor
     *
     * @param Zend_Db_Select $select
     */
    public function __construct(Zend_Db_Select $select)
    {
        $this->setSelect($select);
    }

    /**
     * Set last select
     *
     * @param Zend_Db_Select $select
     * @return \Core_Paginator
     */
    public function setSelect(Zend_Db_Select $select)
    {
        $this->_lastSelect = $select;
        return $this;
    }

    /**
     * Set select for paginator
     * And add limitPage to select
     *
     * @param Zend_Db_Table_Select $select
     */
    public function setLimit()
    {
        $this->_checkSelect();
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $pageNumber = $request->getParam('page') !== null
                    ? (int)$request->getParam('page')
                    : self::DEFAULT_PAGE_NUMBER;
        $rowCount = $request->getParam('rows') !== null
                  ? (int)$request->getParam('rows')
                  : Zend_Paginator::getDefaultItemCountPerPage();

        $this->_lastSelect->limitPage($pageNumber, $rowCount);
        return $this;
    }

    /**
     * Get select object for paginator
     *
     * @return Zend_Db_Select
     */
    public function setSelectForPaginator()
    {
        $select = Zend_Db_Table::getDefaultAdapter()->select()->from(array('u' => 'users'), array());
        $select->columns(array(Zend_Paginator_Adapter_DbSelect::ROW_COUNT_COLUMN => 'id'));
        foreach ($this->_lastSelect->getPart('where') as $where) {
            $select->where($where);
        }
        return $select;
    }

    /**
     * Set \Zend_Paginator_Adapter_DbSelect
     * And initialize Zend_Paginator
     *
     * @return \Zend_Paginator
     */
    public function get()
    {
        if ($this->_lastSelect === null) {
            throw new Core_Exception('Don\'t set last select to paginator, use method "_setSelectForPaginator"');
        }

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $currentPage = $request->getParam('page') ? (int)$request->getParam('page') : self::DEFAULT_PAGE_NUMBER;

        $adapter = new Zend_Paginator_Adapter_DbSelect($this->_lastSelect);

        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);
        
        return $paginator;
    }

    /**
     * Is set select object
     *
     * @return boolean
     * @throws Core_Exception
     */
    protected function _checkSelect()
    {
        if ($this->_lastSelect === null) {
            throw new Core_Exception('Don\'t set select object');
        } else {
            return true;
        }
    }
}
