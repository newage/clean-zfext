<?php

/**
 * Extend object for stdClass
 * Call of methods
 *
 * @category Library
 * @package  Core_Model
 * @author   V.Leontiev <vadim.leontiev@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @since    php 5.3 or higher
 * @see      https://github.com/newage/clean-zfext
 */
class Core_Model_Composite extends stdClass
{
    public function fromArray(Array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }
}

