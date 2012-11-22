<?php
require_once 'Interface.php';

/**
 * Abstract Model mapper
 *
 * @category   Core
 * @package    Core_Model
 * @subpackage Mapper
 *
 * @version  $Id: Abstract.php 103 2010-09-22 15:03:07Z vadim.leontiev $
 */

abstract class Core_Model_Mapper_Abstract implements Core_Model_Maper_Interface
{
    /**
     * @var Zend_Db
     */
    protected $_dbTable = null;

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
     * Save date
     * 
     * @param Core_Model_Abstract $data
     * @return int
     */
    public function save(Core_Model_Abstract $data)
    {
        $table = $this->getDbTable();
        return $table->insert((array)$data);
    }
    
    /**
     * Set new dbTable
     * @param string $dbTable dbTable name
     * @return Zend_Db_Table_Abstract
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
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable();
        }
        return $this->_dbTable;
    }
}
