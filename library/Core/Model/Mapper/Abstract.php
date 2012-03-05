<?php
/**
 * Abstract Model mapper
 *
 * @category   Core
 * @package    Core_Model
 * @subpackage Mapper
 *
 * @version  $Id: Abstract.php 103 2010-09-22 15:03:07Z vadim.leontiev $
 */

abstract class Core_Model_Mapper_Abstract
{
    /**
     *
     * @var Zend_Db_Table_Abstract|String
     */
    protected $_dbTable = null;

    /**
     * Name of dbTable
     * @var string
     */
    protected $_dbName = null;

    /**
     * Set new dbTable
     * @param string $dbTable dbTable name
     * @return Zend_Db_Table_Abstract
     */
    public function setDbTable($dbTable)
    {
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
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable($this->_dbName);
        }
        return $this->_dbTable;
    }
}
