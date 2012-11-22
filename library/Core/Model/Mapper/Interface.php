<?php


/**
 * Interface to model mapper
 * 
 * @category   Core
 * @package    Core_Model
 * @subpackage Mapper
 * @author V.Leontiev
 */
interface Core_Model_Maper_Interface
{
    public function save(Core_Model_Abstract $data);
    
    public function delete($id);
    
    public function find($id);
    
    public function fetchAll();
}

