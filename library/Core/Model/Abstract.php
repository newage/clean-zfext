<?php
/**
 * Initialize set/get method in model
 *
 * @category Core
 * @package Core_Model
 * @license New BSD
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
abstract class Core_Model_Abstract
{

    /**
     * Constructor
     * @param array $options [optional]
     */
    public function __construct($options = null)
    {
        if (method_exists($this, 'setDefault')) {
            $this->setDefault();
        }
        
        if (null != $options) {
            $this->setOptions($options);
        }
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
        $methodName = 'set' . $this->_createMethodName((string)$optionName);
        
        if (method_exists($this, $methodName)) {
            return $this->$methodName($optionValue);
        }
    }
    
    /**
     * Create method name from sql field name
     * 
     * @param string $name
     * @return string
     */
    protected function _createMethodName($name)
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
    
    public function getMysqlDate()
    {
        return date('Y-m-d');
    }
    
    public function getSqlDateTime()
    {
        return date('Y-m-d H:i:s');
    }
}
