<?php

/**
 * Class extends for Core_Db_Table_Rowset_Abstract
 *
 * @category Core
 * @package Core_Db
 * @subpackage Table
 * @license New BSD
 * @author V.Leontiev <vadim.leontiev@gmail.com>
 */
class Core_Db_Table_Rowset extends Zend_Db_Table_Rowset_Abstract
{
    const DATE_FEATURE = 0;
    const DATE_NOW = 1;
    const DATE_PAST = 2;

    /**
     * Count date for rowset
     *
     * @param string $methodName
     * @param int $type Return type (0-feature, 1-now, 2-past)
     * @return array
     */
    public function dateCount($methodName, $type = self::DATE_FEATURE)
    {
        $result = array();
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
