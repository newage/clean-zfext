<?php
/**
 * By extending the Zend_Form class it is possible to create a
 * new form with automatic CSRF protection
 *
 * @category Core
 * @package Core_Form
 * @author V.Leontiev
 */

class Core_Form extends Zend_Form
{
    /**
     * Constructor
     * Call parent constructor and add hash form element
     *
     * @param aray $options [optional]
     */
    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->removeDecorator('HtmlTag');

        $this->addDecorator(new Core_Form_Decorator_TwitterFormErrors(array(
            'placement' => Zend_Form_Decorator_Abstract::PREPEND)));

        $elements = array_keys($this->getElements());

        foreach ($elements as $name) {
            $element = $this->getElement($name);

            //registrate Core validators
            $element->addPrefixPath('Core_Validate', 'Core/Validate/', 'validate');
        }

        Zend_Validate::setMessageLength(70);
    }
}
