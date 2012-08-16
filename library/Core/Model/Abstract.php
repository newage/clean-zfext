<?php
/**
 * Initialize set/get method in model
 *
 * @category   Core
 * @package    Core_Model
 *
 * @version  $Id: Abstract.php 103 2010-09-22 15:03:07Z vadim.leontiev $
 */
abstract class Core_Model_Abstract
{

    /**
     * Constructor
     * @param array $options [optional]
     */
    public function __construct($options = null)
    {
        $this->setDefault();
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
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
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
