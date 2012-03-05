<?php
/**
 * CkEditor form helper
 *
 * @category   Core
 * @package    Core_View
 * @subpackage Helper
 *
 * @version  $Id: FormCkEditor.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */

class Core_View_Helper_FormCkEditor extends Zend_View_Helper_FormTextarea
{

    public function FormCkEditor($name, $value = null, $attribs = null)
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable

        $disabled = '';
        if ($disable) {
            $disabled = ' disabled="disabled"';
        }

        $this->view->CkEditor()->setFieldName($name);

        $this->view->CkEditor()->render();

        $xhtml = '<textarea name="' . $this->view->escape($name) . '"'
        . ' id="' . $this->view->escape($name) . '"'
        . $disabled
        . $this->_htmlAttribs($attribs) . '>'
        . $this->view->escape($value) . '</textarea>';

        return $xhtml;
    }
}