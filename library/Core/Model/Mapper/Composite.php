<?php

/**
 * Abstract Model mapper
 *
 * @category   Core
 * @package    Core_Model
 * @subpackage Mapper
 */
class Core_Model_Mapper_Composite extends Core_Model_Mapper_Abstract
{

    /**
     * DbTable name
     * @var string
     */
    protected $_dependDbTable = null;

    /**
     * Constructor
     * @throws LogicException
     */
    public function __construct()
    {
        if($this->_dependDbTable === null) {
            throw new Core_Model_Mapper_Exception(get_class($this) . ' must have a $_dependDbTable');
        }
        $this->_setDependDbTable();
        parent::__construct();
    }

    /**
     * Set dependent dbTable
     *
     * @throws Core_Model_Exception
     * @return bool
     */
    protected function _setDependDbTable()
    {
        if ($this->_dependDbTable === null) {
            throw new Core_Model_Exception('Dont set depend dbTable on class: ' . get_class($this));
        }

        $thisModelName = str_replace('_Mapper_', '_', get_class($this));
        $options = array(Zend_Db_Table_Abstract::ROW_CLASS => $thisModelName);
        $this->setDbTable($this->_dependDbTable);
        $this->getDbTable()->setOptions($options);
    }
}