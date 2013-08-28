<?php

/**
 * Enable short translate method __ and _e
 *
 * @category Core
 * @package Core_View
 * @author V.Leontiev
 */
class Core_View extends Zend_View
{

    /**
     * Title project
     *
     * @var string
     */
    protected $_projectTitle = null;

    /**
     * __
     *
     * @param  string $messageid Id of the message to be translated
     * @return string Translated message
     */
    public function __($messageid, Array $params = array())
    {
        return $this->translate($messageid, $params);
    }

    /**
     * _e
     *
     * @param  string $messageid Id of the message to be translated
     * @return string Translated message
     */
    public function _e($messageid, Array $params = array())
    {
        echo $this->translate($messageid, $params);
    }

    /**
     * Plural
     *
     * @param string $single
     * @param string $plural
     * @param int $number
     * @return plural string
     */
    public function _n($single, $more, $number)
    {
        return $this->translate(array($single, $more, $number), $number);
    }

    /**
     * Get project title
     *
     * @return string
     */
    public function projectTitle()
    {
        if (func_num_args() == 1) {
            $param = func_get_arg(0);
            $this->_projectTitle = $param;
        }
        return $this->_projectTitle;
    }
}

