<?php

/**
 * Interface for all adapters
 *
 * @category   Library
 * @package    Core_Acl
 * @subpackage Adapter
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
interface Core_Acl_Adapter_Abstract
{
    /**
     * Get options
     *
     * @return array
     */
    public function getOptions();
}

