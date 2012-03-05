<?php

/**
 * Edit error templetes of Digits
 *
 * @category Core
 * @package Core_Validate
 * @author V.Leontiev
 * 
 * @version $Id$
 */
class Core_Validate_Digits extends Zend_Validate_Digits
{
    protected $_messageTemplates = array(
        self::NOT_DIGITS   => "Value must contain only digits",
        self::STRING_EMPTY => "Value is an empty string",
    );
}
