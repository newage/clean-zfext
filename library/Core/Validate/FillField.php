<?php

/**
 * Filled two or more fields
 *
 * <code>
 * new FillFields(array('field1', 'field2'));
 * <code>
 *
 * @category   Library
 * @package    Core_Validate
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Validate_FillField extends Zend_Validate_Abstract
{
    const NOT_FILL = 'notFill';
    const MISSING_FIELDS_NAME = 'missingFieldsName';

    /**
     * Message templates
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_FILL => 'One field must be filled',
        self::MISSING_FIELDS_NAME => 'Fields name to match against was not provided.',
    );

    /**
     *
     * @var array
     */
    protected $_fields = array();

    /**
     * Constructor
     *
     * @author V.Leontiev
     * @param type $options
     */
    public function __construct($options = array())
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        } else if (!is_array($options)) {
            $options = func_get_args();
            $temp['fields'] = array_shift($options);
            $options = $temp;
        }

        $this->setFields($options['fields']);

    }

    /**
     * Set fields name and title
     *
     * @param type $name
     * @return Everlution_Validate_IdenticalField
     */
    public function setFields(array $fields)
    {
        $this->_fields = $fields;
        return $this;
    }

    /**
     * Get fields name
     *
     * @return type
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * Validate fields
     *
     * @param string $value
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $fields = $this->getFields();

        if (empty($fields)) {
            $this->_error(self::MISSING_FIELD_NAME);
            return false;
        }

        foreach ($fields as $name) {
            if (!empty($context[$name])) {
                return true;
            }
        }

        $this->_error(self::NOT_FILL);
        return false;
    }
}

