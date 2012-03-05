<?php
/**
 * Create html table from array
 *
 * array(
 *     'header' => array('columnName','columnName'),
 *     'rows' => array(
 *         array('dataColumn','dataColumn'),
 *         array('dataColumn','dataColumn')
 *     ),
 *     'options' => array(
 *         'id' => 'data_table',
 *         'class' => 'table',
 *         'width' => '100%'
 * );
 *
 * @category   Core
 * @package    Core_View
 * @subpackage Helper
 *
 * @version  $Id: DataGrid.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */

class Core_View_Helper_DataGrid extends Zend_View_Helper_Abstract
{
    /**
     * Data array needed for created html table
     * 
     * @var array
     */
    protected $_data = array();

    /**
     * Data array
     *
     * @param array $data
     * @return Core_View_Helper_Table
     */
    public function DataGrid(Array $data = null)
    {
        if (null !== $data) {
            $this->_data = $data;
        }
        return $this;
    }

    /**
     * Data array for html table heades
     * 
     * @param array $header
     * @return Core_View_Helper_Table
     */
    public function setHeader(Array $header)
    {
        $this->_data['header'] = $header;
        return $this;
    }

    /**
     * Return bool if isset data headers
     * @return bool
     */
    public function isHeader()
    {
        return isset($this->_data['header']) ? true : false;
    }

    /**
     * Set Rows
     * @param array $rows
     * @return Core_View_Helper_Table
     */
    public function setRows(Array $rows)
    {
        $this->_data['rows'] = $rows;
        return $this;
    }

    public function isRows()
    {
        return isset($this->_data['rows']) ? true : false;
    }
}
