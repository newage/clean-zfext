<?php

/**
 * Trim long string
 *
 * @category   Library
 * @package    Core_View
 * @subpackage Helper
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_View_Helper_Short extends Zend_View_Helper_Abstract
{

    /**
     * Trim string
     *
     * @param string $text Original string
     * @param int $length Length string
     * @param bool $fullWords Trin only words
     * @param sting $end String suffix
     * @return string
     */
    public function short($text, $length = 50, $fullWords = false, $end = '')
    {
        if (!is_string($text) || mb_strlen($text) == 0) return null;

        $text = trim(strip_tags($text));

    	if (mb_strlen($text) <= $length) {
            return $text;
    	}

        if ($fullWords) {
            $tmp_text = mb_substr($text, 0, $length);
            $lastpos = mb_strrpos($tmp_text, ' ');
            return mb_substr($text, 0, $lastpos);
        }

        return mb_substr($text, 0, $length) . $end;
    }
}
