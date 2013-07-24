<?php

/**
 * jQuery Form validator
 *
 * @category   Library
 * @package    Core_View
 * @subpackage Helper
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 * @link       http://docs.jquery.com/Plugins/Validation
 */
class Core_View_Helper_JsValidate extends Zend_View_Helper_Abstract
{
    /**
     * New js validators
     * @var array
     */
    protected $_validators = array();

    /**
     * @var Zend_Form
     */
    protected $_form = null;

    /**
     * Path to js file
     * @var string
     */
    protected $_script = '/core/js/jquery/jquery.validate.min.js';

    /**
     * Rules for validators
     * @var array
     */
    protected $_rules = array();

    /**
     * Is append js file
     * @var bool
     */
    protected $_enabled = false;

    /**
     * Form id
     * @var string
     */
    protected $_formId = null;

    /**
     * Ratio of JS validator and Zend validators
     *
     * @var array
     */
    protected $_ratio = array(
        'Date' => 'dateDE: true',
        'Digits' => 'digits: true',
        'Float' => 'number: true',
        'EmailAddresses' => 'email: true',
        'StringLength' => 'rangelength: [%min%, %max%]',
        'Between' => 'range: [%min%, %max%]'
    );

    /**
     * Exclude fields of validating
     *
     * @var array
     */
    protected $_excludeFields = array();

    /**
     * Set form for validation
     *
     * @param Zend_Form $form [optionaly]
     * @return Core_View_Helper_JsValidate
     */
    public function JsValidate(Zend_Form $form)
    {
        if (null !== $form) {
            $this->setForm($form);
        }
        return $this;
    }

    /**
     * Exclude fields of validating
     *
     * @param array $fields
     * @return Core_View_Helper_JsValidate
     */
    public function excludeFields(array $fields)
    {
        foreach ($fields as $fieldName) {
            $this->excludeField($fieldName);
        }
        return $this;
    }

    /**
     * Exclude field of validating
     *
     * @param string $fieldName
     * @return Core_View_Helper_JsValidate
     */
    public function excludeField($fieldName)
    {
        $this->_excludeFields[] = $fieldName;
        return $this;
    }

    /**
     * Set form for validation
     * @param Zend_Form $form
     * @return Core_View_Helper_JsValidate
     */
    public function setForm(Zend_Form $form)
    {
        $this->_form = $form;
        return $this;
    }

    /**
     * Get registered form
     *
     * @return Zend_Form
     */
    public function getForm()
    {
        return $this->_form;
    }

    /**
     * Add other validate rules
     *
     * @param array $rules
     * @return Core_View_Helper_JsValidate
     */
    public function addRules(Array $rules)
    {
        $this->_rules = $rules;
        return $this;
    }

    /**
     * Render js scripts
     */
    public function render()
    {
        if (false === $this->_enabled) {
            $this->_appendScript();
            $this->_addValidateRules();
            $this->_enabled = true;
        }
    }

    /**
     * Append js Script
     *
     * @return Core_View_Helper_JsValidate
     */
    protected function _appendScript()
    {
        $this->view->headScript()->appendFile($this->_script);
        return $this;
    }

    /**
     * Get rules from registered Zend_From
     *
     * @return array
     */
    protected function _getRulesFromForm()
    {
        foreach ($this->getForm()->getElements() as $fieldId => $element) {
            if ($element instanceof Zend_Form_Element_Submit) {
                continue;
            }

            if (in_array($fieldId, $this->_excludeFields)) {
                continue;
            }

            if (true === $element->isRequired()){
                $rules['rules'][$fieldId][] = 'required: true';
            }

            foreach ($element->getValidators() as $name => $validator) {
                $name = explode('_', $name);
                $name = array_pop($name);

                if (!in_array($name, array_keys($this->_ratio))) {
                    continue;
                }

                $jsValidator = $this->_ratio[$name];
                if (strstr($jsValidator, '%')) {
                    $jsValidator = str_replace('%min%', $validator->getMin(), $jsValidator);
                    $jsValidator = str_replace('%max%', $validator->getMax(), $jsValidator);
                }

                $rules['rules'][$fieldId][] = $jsValidator;
            }
        }
        return $rules;
    }

    /**
     * Set form id
     *
     * @param string $id
     * @return Core_View_Helper_JsValidate
     */
    public function setId($id)
    {
        $this->_formId = $id;
        return $this;
    }

    /**
     * Get form id
     * @return type
     */
    public function getId()
    {
        if (null === $this->_formId) {
            $this->setId($this->getForm()->getId());
        }
        return $this->_formId;
    }

    /**
     * Create js validate script
     *
     * @return string
     */
    protected function _addValidateRules()
    {
        $formId = $this->getId();
        $rules = $this->_getRulesFromForm();

        $script = '$("#'.$formId.'").validate({
            wrapper: "div class=\"errors\"",
            rules: {';
            foreach ($rules['rules'] as $name => $rule) {
                foreach ($rule as $value) {
                    $values[] = $value;
                }
                $field[] = $name . ': {' . implode(',', $values) . '}';
                $values = array();
            }
            $script .= implode(',', $field);
            $script .= '}
        });';

        $this->view->jQuery()->addOnload($script);
        return $this;
    }
}