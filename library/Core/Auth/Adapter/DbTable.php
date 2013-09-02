<?php

/**
 * Get role name from loged user
 *
 * @category   Library
 * @package    Core_Auth
 * @subpackage Adapter
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Auth_Adapter_DbTable extends Zend_Auth_Adapter_DbTable
{

    /**
     * Get role from loged user
     *
     * @see Zend_Auth_Adapter_DbTable
     */
    public function getResultRowObject($returnColumns = null, $omitColumns = null)
    {
        $object = parent::getResultRowObject($returnColumns, $omitColumns);

        $role = false;
        if (is_object($object)) {
            $adapter = Zend_Db_Table::getDefaultAdapter();
            $select = $adapter->select()
                      ->from('roles', array('name'))
                      ->where('id = ?', $object->role_id);
            $role = $adapter->fetchOne($select);
        }
        $object->role = $role;
        return $object;
    }
}