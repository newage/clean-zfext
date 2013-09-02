<?php

/**
 *
 * Class definition for the Core_Model_Dto. This represents our data transfer object.
 *
 * @category   Library
 * @package    Core_Db
 * @subpackage Table_Row
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
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

