<?php

/**
 * Check Birth Date
 *
 * @category Core
 * @package Core_Validate
 * @author V.Leontiev
 * 
 * @version $Id$
 */
class Core_Validate_DateBirth extends Zend_Validate_Abstract
{
    
    const INVALID_DATE = 'dateInvalidDate';
    const MIN_DATE     = 'dateMinimumDate';
    const MAX_DATE     = 'dateMaximumDate';
    
    /**
     * Message templates
     * 
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID_DATE => "Value does not appear to be a valid date",
        self::MAX_DATE => "Value is less than %max% date",
        self::MIN_DATE => "Value is more than %min% date"
    );

    protected $_messageVariables = array(
        'format'  => '_format',
        'min' => '_min',
        'max' => '_max'
    );
    
    /**
     * Optional format
     *
     * @var string|null
     */
    protected $_format;

    /**
     * Optional locale
     *
     * @var string|Zend_Locale|null
     */
    protected $_locale;
    
    /**
     * Minimum date
     * 
     * @var Zend_Date
     */
    protected $_min = null;
    
    /**
     * Maximum date
     * 
     * @var Zend_Date
     */
    protected $_max = null;
    
    /**
     * Constructor
     * <code>
     * Core_Validate_DateBirth($format, $min, $max, $locale)
     * <code>
     * 
     * @param string|Zend_Config $options 
     */
    public function __construct($options = array())
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        } else if (!is_array($options)) {
            $options = func_get_args();
            $temp['format'] = array_shift($options);
            if (!empty($options)) {
                $temp['min'] = array_shift($options);
            }
            if (!empty($options)) {
                $temp['max'] = array_shift($options);
            }
            if (!empty($options)) {
                $temp['locale'] = array_shift($options);
            }

            $options = $temp;
        }

        if (array_key_exists('format', $options)) {
            $this->setFormat($options['format']);
        }

        if (!array_key_exists('locale', $options)) {
            if (Zend_Registry::isRegistered('Zend_Locale')) {
                $options['locale'] = Zend_Registry::get('Zend_Locale');
            }
        }

        if (array_key_exists('locale', $options)) {
            $this->setLocale($options['locale']);
        }
        
        if (array_key_exists('min', $options)) {
            $this->setMin($options['min']);
        }
        
        if (array_key_exists('max', $options)) {
            $this->setMax($options['max']);
        }
    }
    
    /**
     * Returns the locale option
     *
     * @return string|Zend_Locale|null
     */
    public function getLocale()
    {
        return $this->_locale;
    }

    /**
     * Sets the locale option
     *
     * @param  string|Zend_Locale $locale
     * @return Zend_Validate_Date provides a fluent interface
     */
    public function setLocale($locale = null)
    {
        $this->_locale = Zend_Locale::findLocale($locale);
        return $this;
    }

    /**
     * Returns the locale option
     *
     * @return string|null
     */
    public function getFormat()
    {
        if ($this->_format === null) {
            $this->_format = 'YYYY-MM-dd';
        }
        return $this->_format;
    }

    /**
     * Sets the format option
     *
     * @param  string $format
     * @return Zend_Validate_Date provides a fluent interface
     */
    public function setFormat($format = null)
    {
        $this->_format = $format;
        return $this;
    }
    
    /**
     * Return mininum date
     * 
     * @author V.Leontiev
     * @return Zend_Date
     */
    public function getMin()
    {
        return $this->_min;
    }
    
    /**
     * Set minimum date
     * Date format string in strtotime()
     * 
     * @author V.Leontiev
     * @param string $min
     * @return Core_Validate_Date 
     */
    public function setMin($min)
    {
        $date = new Zend_Date();
        $date->setTimestamp(strtotime($min));
        $this->_min = $date;
        return $this;
    }
    
    /**
     * Return mininum date
     * 
     * @author V.Leontiev
     * @return Zend_Date
     */
    public function getMax()
    {
        return $this->_max;
    }
    
    /**
     * Set maximum date
     * 
     * @author V.Leontiev
     * @param string $max
     * @return Core_Validate_Date 
     */
    public function setMax($max)
    {
        $date = new Zend_Date();
        $date->setTimestamp(strtotime($max));
        $this->_max = $date;
        return $this;
    }
    
    /**
     * Validate
     * 
     * @param Zend_Date $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value) && !($value instanceof Zend_Date)) {
            $this->_error(self::INVALID_DATE);
            return false;
        }
        
        $date = new Zend_Date($value, $this->getFormat());
        
        if ($this->getMin() !== null && !$date->isLater($this->getMin())) {
            $this->_min = $this->getMin()->toString($this->getFormat());
            $this->_error(self::MIN_DATE);
            $this->_format = null;
            return false;
        }

        if ($this->getMax() !== null && !$date->isEarlier($this->getMax())) {
            $this->_max = $this->getMax()->toString($this->getFormat());
            $this->_error(self::MAX_DATE);
            $this->_format = null;
            return false;
        }
        
        return true;
    }
}
