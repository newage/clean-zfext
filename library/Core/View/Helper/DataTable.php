<?php
/**
 * Create html table from this helper
 *
 * @category   Core
 * @package    Core_View
 * @subpackage Helper
 *
 * @version  $Id: DataTable.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */

class Core_View_Helper_DataTable extends Zend_View_Helper_Abstract
{

    protected $_header = array();

    protected $_tableId = null;

    protected $_jsonUrl = null;

    public function DataTable(Array $data = null)
    {
        if (null !== $data) {
            if (isset($data['header'])) {
                $this->setHeader($data['header']);
            }

            if (isset($data['id'])) {
                $this->setId($data['id']);
            }
        }
        return $this;
    }

    public function setId($id)
    {
        $this->_tableId = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_tableId;
    }

    public function setJson($url)
    {
        $this->_jsonUrl = $url;
        return $this;
    }

    public function getJson()
    {
        return $this->_jsonUrl;
    }

    public function setHeader(Array $header)
    {
        if (!empty($header)) {
            $this->_header = $header;
        }
        return $this;
    }

    public function getHeader()
    {
        if (empty($this->_header)) {
            throw new Zend_View_Exception('Dont set table header!');
        }
        return $this->_header;
    }

    /**
     * Create html table
     * @return string
     */
    public function render()
    {
        $this->_setDataTableJs();
        
        $html = '<table cellpadding="0" cellspacing="0" border="0" class="display" id="'.$this->getId().'"><thead><tr>';
        $html .= '<th>' . implode('</th><th>', $this->getHeader()) . '</th>';
        $html .= '</tr></thead>';

        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td colspan="'.count($this->getHeader()).'" class="dataTables_empty">Loading data from server</td>';
        $html .= '</tr>';
        $html .= '</tbody></table>';

        return $html;
    }

    protected function _setDataTableJs()
    {
        $script = '$().ready(function() {
            $("#'.$this->getId().'").dataTable( {
//                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "/'.$this->getJson().'",
                "bJQueryUI": true,
                "sPaginationType": "full_numbers"

            })
        });';
        
        $this->view->jQuery()->addOnload($script);
    }
}
