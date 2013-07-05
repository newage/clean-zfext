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

    /**
     * Set used module name
     *
     * @param atring $moduleName
     * @return \Core_CodeGenerator_DbModel
     */
    public function setModule($moduleName)
    {
        $this->_moduleName = $moduleName;
        return $this;
    }

    /**
     * Get culumn in table and create methods in model
     *
     * @param string $modelName
     * @param string $methods
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

            $class->setMethod(
                $this->_createMethod(
                    $this-> _generateMethodName($fieldName, 'get'),
                    array(),
                    'return $this->get("'.$fieldName.'");'
                )
            );

            $class->setMethod(
                $this->_createMethod(
                    $this-> _generateMethodName($fieldName, 'set'),
                    array(array('name' => 'value')),
                    '$this->set("'.$fieldName.'", $value);' . "\n" . 'return $this;'
                )
            );
        }

        $this->_generateFile($class->generate(), $path);
    }

    /**
     * Generate new model mapper class
     *
     * @param string $modelName
     */
    public function generateMapper($modelName)
    {
        $class = new Zend_CodeGenerator_Php_Class();
        $className = $this->_generateClassName(ucfirst($modelName . 'Mapper'));
        $path = $this->_generatePath($className);

        $class->setName($className)
              ->setExtendedClass('Core_Model_Mapper_Abstract')
              ->setDocblock($this->_generateDocBlock());

        $this->_generateFile($class->generate(), $path);
    }

    /**
     * Generate DbTable class
     *
     * @param string $modelName Model name
     * @parem string $tableName Real table name
     */
    public function generateDbTable($modelName, $tableName)
    {
        $class = new Zend_CodeGenerator_Php_Class();
        $className = $this->_generateClassName('DbTable_' . ucfirst($modelName));
        $path = $this->_generatePath($className);
        $modelClassName = $this->_generateClassName(ucfirst($modelName));

        $class->setName($className)
            ->setProperties(
                array(
                    array(
                        'name' => '_name',
                        'visibility' => 'protected',
                        'defaultValue' => $tableName
                    ),
                    array(
                        'name' => '_rowClass',
                        'visibility' => 'protected',
                        'defaultValue' => $modelClassName
                    ),
                    array(
                        'name' => '_dependentTables',
                        'visibility' => 'protected',
                        'defaultValue' => array()
                    ),
                    array(
                        'name' => '_referenceMap',
                        'visibility' => 'protected',
                        'defaultValue' => array()
                    )
                )
            )
            ->setExtendedClass('Core_Db_Table_Abstract')
            ->setDocblock($this->_generateDocBlock());

        var_dump('path',$path);
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
                DIRECTORY_SEPARATOR . $this->_moduleName : '';
        $classExplode = explode('_', $className);
        $modelPath = strstr($className, 'DbTable') ? 'models/DbTable' : 'models';
        $file = array_pop($classExplode);
        $path = APPLICATION_PATH . $module . DIRECTORY_SEPARATOR . $modelPath
                . DIRECTORY_SEPARATOR . $file . '.php';

        return $path;
    }

    /**
     * Create camelCase name from sql field name
     *
     * @param string $name
     * @return string
     */
    protected function _generateMethodName($name, $prefix = '')
    {
        if (strstr($name, '_')) {
            $function = function($part) {
                return ucfirst($part);
            };

            $parts = explode('_', $name);
            $name = implode('', array_map($function, $parts));
        }
        return $prefix . $name;
    }
}
