<?php

/**
 * Create singleton instance Zend_File_transfer
 *
 * @category   Library
 * @package    Core_File
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
final class Core_File_Transfer
{
    static protected $_instance = null;

    /**
     * Constructor
     */
    private function __construct()
    {
    }

    /**
     * Get instance
     *
     * @param string $adapter
     * @param boolean $direction
     * @param array $options
     * @return Zend_File_Transfer
     */
    static public function getInstance($adapter = 'Http', $direction = false, $options = array())
    {
        if (self::$_instance === null) {
            self::$_instance = new Zend_File_Transfer($adapter, $direction, $options);
        }

        return self::$_instance;
    }
}
