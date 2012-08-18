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
        $path = $this->_generatePath($className);

        $class->setName($className)
              ->setExtendedClass('Core_Model_Abstract')
              ->setDocblock($this->_generateDocBlock());
        
        foreach ($methods as $fieldName) {
            $class->setMethod($this->_createMethod('get' . ucfirst($fieldName)));
            $class->setMethod($this->_createMethod('set' . ucfirst($fieldName)));
        }
        
        $this->_generateFile($class->generate(), $path);
    }
    
    /**
     * Generate class name
     * 
     * @param string $modelName
     * @return string
     */
    protected function _generateClassName($modelName)
    {
        $className = array();
        $className[] = !is_string($this->_moduleName) ? 'Application' : ucfirst($this->_moduleName);
        $className[] = 'Model';
        $className[] = $modelName;
        
        return implode('_', $className);
    }
    
    /**
     * Generate path to file
     * 
     * @param string $className
     * @return string 
     */
    protected function _generatePath($className)
    {
        $module = $this->_moduleName !== null ? DIRECTORY_SEPARATOR . 'modules' .
                DIRECTORY_SEPARATOR .$this->_moduleName : '';
        $classExplode = explode('_', $className);
        $file = array_pop($classExplode);
        $path = APPLICATION_PATH . $module . DIRECTORY_SEPARATOR . 'models'
                . DIRECTORY_SEPARATOR . $file . '.php';
        
        return $path;
    }
    
    public function generateMapper($modelName)
    {
        $class = new Zend_CodeGenerator_Php_Class();
        $className = $this->_generateClassName(ucfirst($modelName . 'Mapper'));
        $path = $this->_generatePath($className);

        $class->setName($className)
              ->setExtendedClass('Core_Model_Mapper_Abstract')
              ->setDocblock($this->_generateDocBlock());
        
//        $class->setMethod($this->_createMethod('get' . ucfirst($fieldName)));
//        $class->setMethod($this->_createMethod('set' . ucfirst($fieldName)));
        
        $this->_generateFile($class->generate(), $path);
    }
}
