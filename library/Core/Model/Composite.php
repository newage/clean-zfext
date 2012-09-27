<?php

/**
 * Extend object for stdClass
 * Call of methods
 *
 * @category Core
 * @package Core_Model
 * @license New BSD
 * @author V.Leontiev <vadim.leontiev@gmail.com>
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

