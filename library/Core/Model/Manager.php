<?php

/**
 * Core model manager
 *
 * @category Library
 * @package  Core_Model
 * @author   V.Leontiev <vadim.leontiev@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @since    php 5.3 or higher
 * @see      https://github.com/newage/clean-zfext
 */
class Core_Model_Manager
{
    /**
     * CodeGenerator for DbModel
     *
     * @var Core_CodeGenerator_DbModel
     */
    protected $_generator = null;

    /**
     * Array with all resource from config
     *
     * @var array
     */
    protected $_resources = array();

    /**
     * Initialize generator
     */
    public function __construct(array $resources)
    {
        $this->_resources = $resources;
        $this->_generator = new Core_CodeGenerator_DbModel();
    }

    /**
     * Create model, dbTable, mapper
     *
     * @return array
     * @author V.Leonteiv
     */
    public function create($nameClass, $tableName, $moduleName)
    {
        $this->_generator->setModule($moduleName);

        $fieldsName = $this->_getFieldsName($tableName);
        $this->_generator->generateModel($nameClass, $fieldsName);

        $this->_generator->generateMapper($nameClass);

        $this->_generator->generateDbTable($nameClass, $tableName);
    }

    /**
     * Get fields name from table
     *
     * @param type $tableName
     * @return array
     * @author V.Leontiev
     */
    protected function _getFieldsName($tableName)
    {
        $schemaName = $this->_resources['db']['params']['dbname'];

        $sql = 'SELECT `COLUMN_NAME`
            FROM information_schema.`COLUMNS`
            WHERE `TABLE_SCHEMA` = "'.$schemaName.'"
            AND `TABLE_NAME` = "'.$tableName.'"';
        return Zend_Db_Table::getDefaultAdapter()->fetchCol($sql);
    }
}
