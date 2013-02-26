<?php

/**
 * Create singleton instance Zend_File_transfer
 *
 * @category Library
 * @package Core_File_Transfer
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
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
