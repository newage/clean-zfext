<?php


/**
 * Interface to model mapper
 *
 * @category   Library
 * @package    Core_Model
 * @subpackage Mapper
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
interface Core_Model_Maper_Interface
{
    public function save(Core_Model_Abstract $data);

    public function delete($id);

    public function find($id);

    public function fetchAll();
}

