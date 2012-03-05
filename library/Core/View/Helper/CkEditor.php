<?php
/**
 * CKEditor view helper
 *
 * @category   Core
 * @package    Core_View
 * @subpackage Helper
 *
 * @version  $Id: CkEditor.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */
class Core_View_Helper_CkEditor extends Zend_View_Helper_Abstract
{
    
    protected $_enabled = false;
    protected $_fieldName = null;
    protected $_defaultScript = '/js/ckeditor/ckeditor.js';
    protected $_config = array();

    protected $_render = array();

    protected $_scriptPath;
    protected $_scriptFile;

    /**
     * Add new property
     * @param string $name      Name property
     * @param string $value     Value property
     */
    public function __set($name, $value)
    {
        $this->_render[$name] = $value;
    }

    /**
     * Get property
     * @param string  $name     Property name
     * @param integer $variable Property type
     * @return string
     */
    public function __get($name)
    {
        if (!isset($this->_render[$name])) {
            throw new Zend_Exception('Invalid CKeditor property');
        }
        return $this->_render[$name];
    }

    /**
     * Set field name
     * @param string $name Field name
     * @return CkEditor
     */
    public function setFieldName($name)
    {
        if (!empty($name)) {
            $this->_fieldName = $name;
        } else {
            throw new Zend_Exception('Not empty field name!');
        }
        return $this;
    }

    /**
     * Get fielf name
     * @return string
     */
    public function getFieldName()
    {
        if (null === $this->_fieldName) {
            throw new Zend_Exception('Not empty field name!');
        } else {
            return $this->_fieldName;
        }
    }

    /**
     * Return this object
     * @return CkEditor
     */
    public function CkEditor ()
    {
        return $this;
    }

    /**
     * Set script path
     * @param string $path Script path
     * @return CkEditor
     */
    public function setScriptPath ($path)
    {
        $this->_scriptPath = rtrim($path,'/');
        return $this;
    }

    /**
     * Set script file
     * @param string $file File name
     */
    public function setScriptFile ($file)
    {
        $this->_scriptFile = (string)$file;
    }

    /**
     * Render CkEditor scripts
     */
    public function render()
    {
        if (false === $this->_enabled) {
            $this->_renderScript();
            $this->_renderConfig();
        }
        $this->_renderEditor();
        $this->_enabled = true;
    }

    /**
     * Append script file CkEditor
     * @return CkEditor
     */
    protected function _renderScript ()
    {
        if (null === $this->_scriptFile) {
            $script = $this->_defaultScript;
        } else {
            $script = $this->_scriptPath . DIRECTORY_SEPARATOR . $this->_scriptFile;
        }

        $this->view->headScript()->appendFile($script);
        return $this;
    }

    /**
     * Render config CkEditor
     * @return CkEditor
     */
    protected function _renderConfig()
    {
        $script = 'CKEDITOR.editorConfig = function(config) {' . PHP_EOL;

        foreach ($this->_config as $name => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            if (!is_bool($value)) {
                $value = "'" . $value . "'";
            }
            $params[] = $name . ': ' . $value;
        }

        if (isset($params)) {
            $script .= implode(',', $params);
        }
        $script .= '};';

        $this->view->headScript()->appendScript($script);
        return $this;
    }

    /**
     * Render CkEditor script
     * @return CkEditor
     */
    protected function _renderEditor ()
    {
        $script = 'CKEDITOR.replace("' . $this->getFieldName() . '", {' . PHP_EOL;

        foreach ($this->_render as $name => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            if (!is_bool($value)) {
                $value = "'" . $value . "'";
            }
            $params[] = $name . ': ' . $value;
        }

        if (isset($params)) {
            $script .= implode(',', $params);
        }
        $script .= '});';

        $this->view->headScript()->appendScript($script);
        return $this;
    }
}