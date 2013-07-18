<?php
/**
 * Initialize set/get method in model
 *
 * @category Core
 * @package Core_Model
 * @license New BSD
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
abstract class Core_Model_Abstract extends Zend_Db_Table_Row_Abstract
{

    /**
     * Data from forms or another area
     *
     * @var array
     */
    protected $_originalData = array();

    /**
     * Dependent objects
     * @var array
     */
    protected $_depend = array();

    /**
     * Constructor
     * @param array $options [optional]
     */
    public function __construct($options = array())
    {
        if (!empty($options) && !isset($options['data'])) {
            $this->setOptions($options);
        }

        if (method_exists($this, 'setDefault')) {
            $this->setDefault();
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
     * Set property to _data or _originalData
     *
     * @param string $propertyName
     * @param string $propertyValue
     */
    public function set($propertyName, $propertyValue)
    {
        if (array_key_exists($propertyName, $this->_data)) {
            parent::__set($propertyName, $propertyValue);
        } else {
            $this->_originalData[$propertyName] = $propertyValue;
        }
    }

    /**
     * Get property from _data or _originalData
     *
     * @param string $propertyName
     * @return string
     */
    public function get($propertyName)
    {
        if (array_key_exists($propertyName, $this->_data)) {
            return parent::__get($propertyName);
        } elseif (array_key_exists($propertyName, $this->_originalData)) {
            return $this->_originalData[$propertyName];
        } else {
            //TODO: need create exception
            return null;
        }

    }

    /**
     * Set depend model
     *
     * @param string $modelName
     * @param object $value
     * @return object
     */
    public function addDependModel(Core_Model_Abstract $value)
    {
        $className = get_class($value);
        $this->_depend[$className] = $value;
        return $value;
    }

    /**
     * Get depend model
     *
     * @param string $modelName
     * @return object
     */
    public function getDependModel($modelName)
    {
        if (!isset($this->_depend[$modelName])) {
            throw new Core_Model_Exception('Don\'t set depend model: ' . $modelName);
        }
        return $this->_depend[$modelName];
    }

    /**
     * Return array from all properties
     *
     * @return array
     */
    public function toArray()
    {
        $returnArrayVars = array();

        if (!empty($this->_data)) {
            $returnArrayVars = $this->_data;
        } else {
            $returnArrayVars = $this->_originalData;
        }

        return $returnArrayVars;
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
     * Added to serialize string variable _depend
     *
     * @return array
     */
    public function __sleep()
    {
        return array_merge(parent::__sleep(), array('_depend'));
    }
}
