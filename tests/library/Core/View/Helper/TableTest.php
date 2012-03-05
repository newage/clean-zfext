<?php
require_once 'Zend/View/Helper/Abstract.php';
require_once 'Core/View/Helper/DataGrid.php';

class Core_View_Helper_DataGridTest extends PHPUnit_Framework_TestCase
{

    protected $_table = null;

    public function setUp()
    {
        $this->_table = new Core_View_Helper_DataGrid();
    }

    public function testSetHeader()
    {
        $data = array('columnName1','columnName2');
        $result = $this->_table->setHeader($data);

        $this->assertTrue(get_class($result) == 'Core_View_Helper_Table');
        $this->assertTrue($this->_table->isHeader());
    }

    public function testSetRows()
    {
        $data = array(
            array('Row1Column1','Row1Column2'),
            array('Row2Column1','Row2Column2')
        );
        $result = $this->_table->setRows($data);

        $this->assertTrue(get_class($result) == 'Core_View_Helper_Table');
        $this->assertTrue($this->_table->isHeader());
    }
}

