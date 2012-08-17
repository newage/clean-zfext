<?php

/**
 * DbModel class generator
 * 
 * @category Core
 * @package Core_CodeGenerator
 * @author V.Leontiev
 *
 * @version  $Id$
 */
class Core_CodeGenerator_DbModel extends Core_CodeGenerator_Abstract
{
 
    const PART_DBTABLE = 'DbTable';
    
    protected $_moduleName = null;
    
    public function setModule($moduleName)
    {
        $this->_moduleName = $moduleName;
    }
    
    /**
     * Get culumn in table and create methods in model
     * 
     * @param type $nameClass
     * @param type $tableName
     */
    public function generateModel($modelName, $methods)
    {
        $class = new Zend_CodeGenerator_Php_Class();
        $className = $this->_generateClassName(ucfirst($modelName));

        $classDoc = new Zend_CodeGenerator_Php_Docblock(array(
            'shortDescription' => 'Model class for ' . $className,
            'tags' => array(
                array(
                    'name' => 'category',
                    'description' => 'Application'
                ),
                array(
                    'name' => 'package',
                    'description' => 'Application_Model',
                ),
                array(
                    'name' => 'subpackage',
                    'description' => 'Model',
                ),
                array(
                    'name' => 'author',
                    'description' => 'autogenerate'
                ),
                array(
                    'name' => 'version',
                    'description' => '$Id$'
                )
            )
        ));
        
        $class->setName($className)
              ->setExtendedClass('Core_Model_Abstract')
              ->setDocblock($classDoc);
        
        foreach ($methods as $fieldName) {
            $class->setMethod($this->_generateModelMethod($fieldName, 'set'));
            $class->setMethod($this->_generateModelMethod($fieldName, 'get'));
        }
        
        $file = new Zend_CodeGenerator_Php_File();
        $file->setClass($class)
             ->setFilename($path . DIRECTORY_SEPARATOR . $nameClass . '.php')
             ->write();
    }
    
    /**
     * Generate class name
     * 
     * @param string $modelName
     * @return string
     */
    protected function _generateClassName($modelName)
    {
        $className[] = !is_string($this->_moduleName) ? 'Application' : ucfirst($this->_moduleName);
        $className[] = 'Model';
        $className[] = $modelName;
        
        return implode('_', $className);
    }
    
    public function generateDbTable($nameClass)
    {
        
    }
    
    public function generateMapper($nameClass)
    {
        
    }
}
