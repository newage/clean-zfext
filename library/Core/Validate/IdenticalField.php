<?php

/**
 * Identical values in two fields in current form
 *
 * @category   Library
 * @package    Core_Validate
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Validate_IdenticalField extends Zend_Validate_Abstract
{
    const NOT_MATCH = 'notMatch';
    const MISSING_FIELD_NAME = 'missingFieldName';
    const INVALID_FIELD_NAME = 'invalidFieldName';

    /**
     * Message templates
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::MISSING_FIELD_NAME => 'Field name to match against was not provided.',
        self::INVALID_FIELD_NAME => 'The field "%fieldName%" was not provided to match against.',
        self::NOT_MATCH => 'Does not match "%fieldTitle%".',
    );

    /**
     * Template variables
     *
     * @var array
     */
    protected $_messageVariables = array(
        'fieldName' => '_fieldName',
        'fieldTitle' => '_titleName'
    );

    protected $_fieldName = null;

    protected $_titleName = null;

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
            $temp['field'] = array_shift($options);
            if (!empty($options)) {
                $temp['title'] = array_shift($options);
            }
            $options = $temp;
        }

        $this->setField($options['field']);
        $this->setTitle($options['title']);
    }

    /**
     * Set field name for identical on current field
     *
     * @param type $name
     * @return Everlution_Validate_IdenticalField
     */
    public function setField($name)
    {
        $this->_fieldName = $name;
        return $this;
    }

    /**
     * Get field name
     *
     * @return type
     */
    public function getField()
    {
        return $this->_fieldName;
    }

    /**
     * Set field title
     *
     * @param type $name
     * @return Everlution_Validate_IdenticalField
     */
    public function setTitle($title = null)
    {
        $this->_titleName = $title ? $title : $this->getField();
        return $this;
    }

    /**
     * Get field title
     *
     * @return type
     */
    public function getTitle()
    {
        return $this->_titleName;
    }

    /**
     * Validate fields is identical
     *
     * @param string $value
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $field = $this->getField();

        if (empty($field)) {
            $this->_error(self::MISSING_FIELD_NAME);
            return false;
        } elseif (!isset($context[$field])) {
            $this->_error(self::INVALID_FIELD_NAME);
            return false;
        } elseif (is_array($context)) {
            if ($value == $context[$field]) {
                return true;
            }
        } elseif (is_string($context) && ($value == $context)) {
            return true;
        }

        $this->_error(self::NOT_MATCH);
        return false;
    }
}

