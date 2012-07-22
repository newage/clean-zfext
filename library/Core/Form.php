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
        
        $this->addDecorator(new Zend_Form_Decorator_FormErrors());
        
        $elements = array_keys($this->getElements());
        
        foreach ($elements as $name) {
            $element = $this->getElement($name);

            //registrate Core validators
            $element->addPrefixPath('Core_Validate', 'Core/Validate/', 'validate');
            $this->addElementClassAttrib($element);
        }
        
        Zend_Validate::setMessageLength(70);
    }
    
    /**
     * Return error messages
     * @param type $name
     * @param type $suppressArrayNotation
     * @return type 
     */
    public function getElementErrorMessages($name = null)
    {
        $errors = $this->getErrors($name, true);

        foreach ($errors as $element => $errorTemplate) {
            $errors[$element] = array_values($this->getElement($element)->getMessages());
        }
        return $errors;
    }
    
    /**
     *
     * @param type $element
     * @return type 
     */
    protected function addElementClassAttrib($element)
    {
        if ($element->getAttrib('class')) {
            return;
        }

        $elementIdName = $element->getId() . '-element';

        switch ($element->getType()) {
            case 'Zend_Form_Element_Submit':
                $element->setAttrib('class', 'ui-button ui-widget ui-state-default ui-corner-all ui-submit');
                $element->setDecorators(
                    array(
                        'ViewHelper',
                        'Description',
                        'Errors',
                        array('HtmlTag', array('tag' => 'dd', 'id' => $elementIdName))
                    )
                );
                break;
            case 'Zend_Form_Element_Reset':
                $element->setAttrib('class', 'ui-button ui-widget ui-state-default ui-corner-all ui-cancel');
                $element->setDecorators(
                    array(
                        'ViewHelper',
                        'Description',
                        'Errors',
                        array('HtmlTag', array('tag' => 'dd', 'id' => $elementIdName))
                    )
                );
                break;
            case 'Zend_Form_Element_Button':
                $element->setAttrib('class', 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only');
                $element->setDecorators(
                    array(
                        'ViewHelper',
                        'Description',
                        'Errors',
                        array('HtmlTag', array('tag' => 'dd', 'id' => $elementIdName))
                    )
                );
                break;
            case 'Zend_Form_Element_Checkbox':
                $element->setAttrib('class', 'checkbox-input text ui-widget-content ui-corner-all');
                break;
            case 'Zend_Form_Element_Radio':
                $element->setAttrib('class', 'readio-input text ui-widget-content ui-corner-all');
                break;
            case 'Zend_Form_Element_Text':
            case 'Zend_Form_Element_Select':
            case 'Zend_Form_Element_Textarea':
            case 'Zend_Form_Element_Password':
                $element->setAttrib('class', 'fixedwidth text ui-widget-content ui-corner-all');
                break;
            case 'ZendX_JQuery_Form_Element_DatePicker':
                $element->setAttrib('class', 'datepicker text ui-widget-content ui-corner-all');
                break;
            default:
                $element->setAttrib('class', 'text ui-widget-content ui-corner-all');
                break;
        }
    }
}
