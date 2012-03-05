<?php

/**
 * Extended float validator
 *
 * @category Core
 * @package Core_Validate
 * @author V.Leontiev
 * 
 * @version $Id$
 */
class Core_Validate_Float extends Zend_Validate_Float
{
    
    const TOO_POSITIVE = 'stringLengthTooPositive';
    const TOO_LONG_MAX = 'stringLengthTooLong';
    const TOO_LONG_DECIMAL = 'stringLengthTooLongDecimal';
    
    /**
     * @var array
     */
    protected $_messageVariables = array(
        'decimal' => '_decimal',
        'max' => '_max'
    );

    /**
     * Maximum decimal length
     *
     * @var integer
     */
    protected $_decimal;

    /**
     * Maximum length
     *
     * If null, there is no maximum length
     *
     * @var integer|null
     */
    protected $_max;
    
    /**
     * Unsigned
     * 
     * @var bool
     */
    protected $_positive;
    
    /**
     * Sets validator options
     *
     * @param  integer|array|Zend_Config $options
     * @return void
     */
    public function __construct($options = array())
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        } else if (!is_array($options)) {
            $options     = func_get_args();
            $temp['max'] = array_shift($options);
            if (!empty($options)) {
                $temp['decimal'] = array_shift($options);
            }
            if (!empty($options)) {
                $temp['positive'] = array_shift($options);
            }

            $options = $temp;
        }


        if (array_key_exists('max', $options)) {
            $this->setMax($options['max']);
        }
        
        if (array_key_exists('decimal', $options)) {
            $this->setDecimal($options['decimal']);
        }
        
        if (array_key_exists('positive', $options)) {
            $this->setPositive($options['positive']);
        }
        
        $this->_messageTemplates = array_merge($this->_messageTemplates, array(
            self::TOO_LONG_MAX   => "Ceil value is more than %max% character long",
            self::TOO_LONG_DECIMAL => "Decimal value is more than %decimal% characters long",
            self::TOO_POSITIVE => "This value should be a positive number",
            self::NOT_FLOAT => "This value should be is float"
        ));
        
        if (!isset($options['locale'])) {
            $options['locale'] = null;
        }
        
        parent::__construct($options['locale']);
    }
    
    /**
     * Set maximal numeric
     * 
     * @param int $max 
     */
    public function setMax($max)
    {
        $this->_max = (integer)$max;
    }
    
    /**
     * Set decimal char number
     * 
     * @param int $decimal 
     */
    public function setDecimal($decimal)
    {
        $this->_decimal = (integer)$decimal;
    }
    
    /**
     * Set positive or negative value
     * 
     * @param bool $positive 
     */
    public function setPositive($positive)
    {
        $this->_positive = $positive;
    }
    
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is a floating-point value
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (!is_string($value) && !is_int($value) && !is_float($value)) {
            $this->_error(self::INVALID);
            return false;
        }
        
        if ($this->_positive && $value < 0) {
            $this->_error(self::TOO_POSITIVE);
            return false;
        }
        
        if (strstr($value, '.')) {
            list($ceil, $decimal) = explode('.', $value);
        } else {
            $ceil = $value;
            $decimal = 0;
        }

        if (strlen($ceil) > $this->_max) {
            $this->_error(self::TOO_LONG_MAX);
            return false;
        }

        if (strlen($decimal) > $this->_decimal) {
            $this->_error(self::TOO_LONG_DECIMAL);
            return false;
        }
         
        if (is_float($value)) {
            return true;
        }

        $this->_setValue($value);
        try {
            if (!Zend_Locale_Format::isFloat($value, array('locale' => $this->_locale))) {
                $this->_error(self::NOT_FLOAT);
                return false;
            }
        } catch (Zend_Locale_Exception $e) {
            $this->_error(self::NOT_FLOAT);
            return false;
        }

        return true;
    }
}
