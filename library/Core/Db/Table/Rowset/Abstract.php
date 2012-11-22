<?php

/**
 * 
 * Class definition for the Core_Model_Dto. This represents our data transfer object.
 *
 * @category Core
 * @package Core_Db_Table
 * @subpackage Rowset
 * @license New BSD
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
class Core_Db_Table_Rowset_Abstract extends Zend_Db_Table_Rowset_Abstract
{
    
    /**
     * Return model from DbTable with data from query
     * 
     * @return Core_Model_Abstract
     */
    public function toModel()
    {
        $collection = new Core_Collection();
        
        $tableClassName = get_class($this->getTable());
        $modelName = str_replace('DbTable_', '', $tableClassName);
        $model = new $modelName();
        return $model->setOptions($this->toArray());
    }
}

