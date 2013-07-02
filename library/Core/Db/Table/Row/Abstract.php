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
}

