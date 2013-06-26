<?php
/**
 * Initialize set/get method in model
 *
 * @category Core
 * @package Core_Model
 * @license New BSD
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
abstract class Core_Model_Abstract extends Core_Db_Table_Row_Abstract
{

    /**
     * Constructor
     * @param array $options [optional]
     */
    public function __construct($options = array())
    {
        if (isset($options['data'])) {
            $this->setOptions($options['data']);
        } elseif (!empty($options)) {
            $this->setOptions($options);

            if (method_exists($this, 'setDefault')) {
                $this->setDefault();
            }
        }

        parent::__construct($options);
    }

    /**
     * Set options
     *
     * @param array $options
     * @return Core_Model_Abstract
     */
    public function setOptions($options)
    {
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
        return $this;
    }

    /**
     * Set one option
     *
     * @param string $optionName
     * @param mixed $optionValue
     */
    public function setOption($optionName, $optionValue)
    {
        $methodName = 'set' . $this->_createCamelCaseName((string)$optionName);

        if (method_exists($this, $methodName)) {
            return $this->$methodName($optionValue);
        }
    }

    /**
     * Create camelCase name from sql field name
     *
     * @param string $name
     * @return string
     */
    protected function _createCamelCaseName($name)
    {
        if (strstr($name, '_')) {
            $function = function($part) {
                return ucfirst($part);
            };

            $parts = explode('_', $name);
            $name = implode('', array_map($function, $parts));
        }
        return $name;
    }

    /**
     * Create sql field name from camelCase name
     *
     * @param string $name
     * @return string
     */
    protected function _unCreateCamelCaseName($name)
    {
        $matches = array();
        preg_match_all('/[^A-Z]+|[A-Z][^A-Z]+/', $name, $matches);

        if (isset($matches[0]) && !empty($matches[0])) {
            $function = function($part) {
                return strtolower($part);
            };

            $name = implode('_', array_map($function, $matches[0]));
        }
        return $name;
    }

    /**
     * Return array from all properties
     * Convert properties from camelCase name to property_name
     *
     * @return array
     */
    public function toArray()
    {
        $returnArrayVars = array();
        $classVars = (array)$this;

        foreach ($classVars as $name => $value) {
            $methodName = 'get' . ucfirst($name);
            if (method_exists($this, $methodName)) {
                $returnArrayVars[$this->_unCreateCamelCaseName($name)] = $value;
            }
        }
        return $returnArrayVars;
    }

    /**
     * Get current logined user id
     *
     * @return int
     */
    protected function _getCurrentUserId()
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        return (int)$identity->id;
    }

    /**
     * Get dependent model
     *
     * @param string $moduleName Module name
     * @param string $modelName Model name
     * @return object
     */
    protected function _getDependentModel($moduleName, $modelName)
    {
        $dbTableName = ucfirst($moduleName) . '_Model_DbTable_' . ucfirst($modelName);
        $images = $this->findDependentRowset($dbTableName);
        if (($current = $images->current()) === null) {
            $modelName = str_replace('_DbTable', '', $dbTableName);
            $current = new $modelName();
        }
        return $current;
    }
}
