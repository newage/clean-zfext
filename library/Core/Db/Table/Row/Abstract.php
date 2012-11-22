<?php

/**
 * 
 * Class definition for the Core_Model_Dto. This represents our data transfer object.
 *
 * @category Core
 * @package Core_Db_Table
 * @subpackage Row
 * @license New BSD
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
class Core_Db_Table_Row_Abstract extends Zend_Db_Table_Row_Abstract
{
    /**
     * Returns the original value of a column
     *
     * @param String $columnName
     * @throws Zend_Db_Table_Row_Exception
     * @return mixed
     */
    public function getClean($columnName){
        if(!isset ($this->_cleanData[$columnName])){
            throw new Zend_Db_Table_Row_Exception('Column '.$columnName.' not found');
        }
        
        return $this->_cleanData[$columnName];
    }
    
    /**
     * Set column value
     * @param type $columnName
     * @param type $value 
     */
    public function __set($columnName, $value)
    {
        $methodName = 'set' . ucfirst($columnName);

        if (method_exists($this, $methodName)) {
            $value = $this->$methodName($value);
        }
        parent::__set($columnName, $value);
    }
    
    /**
     * Get column value
     * @param type $columnName
     * @return string
     */
    public function __get($columnName)
    {
        $methodName = 'get' . ucfirst($columnName);

        if (method_exists($this, $methodName)) {
            return $this->$methodName(parent::__get($columnName));
        }
        return parent::__get($columnName);
    }
    
    /**
     * Return model from DbTable with data from query
     * 
     * @return Core_Model_Abstract
     */
    public function toModel()
    {
        $tableClassName = get_class($this->getTable());
        $modelName = str_replace('DbTable_', '', $tableClassName);
        $model = new $modelName();
        $fields = $this->toArray();
        return $model->setOptions($this->toArray());
    }
    
    /**
     * Return composite model
     * 
     * @return Core_Model_Composite
     */
    public function toCompositeModel()
    {
        $model = new Core_Model_Composite();
        return $model->fromArray($this->toArray());
    }
}

