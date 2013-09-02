<?php

/**
 * Class extends for Core_Db_Table_Rowset_Abstract
 *
 * @category   Library
 * @package    Core_Db
 * @subpackage Table
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Db_Table_Rowset extends Zend_Db_Table_Rowset_Abstract
{
    const DATE_FEATURE = 'feature';
    const DATE_NOW = 'now';
    const DATE_PAST = 'past';

    /**
     * Count date for rowset
     *
     * @param string $methodName
     * @param int $type Return type [feature, now, past]
     * @return array
     */
    public function dateCount($methodName, $type = self::DATE_FEATURE)
    {
        $result = array(
            self::DATE_FEATURE => 0,
            self::DATE_NOW => 0,
            self::DATE_PAST => 0
        );
        $date = Zend_Date::now();
        foreach ($this as $row) {
            $compare = $date->compareDate($row->{$methodName}());
            switch ($compare) {
                case -1:
                    $result[self::DATE_FEATURE]++;
                    break;
                case 0:
                    $result[self::DATE_NOW]++;
                    break;
                case 1:
                    $result[self::DATE_PAST]++;
                    break;
                default:
                    break;

            }
        }

        return $result[$type];
    }
}
