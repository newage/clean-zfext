<?php

/**
 * Get role name from loged user
 *
 * @category   Core
 * @package    Core_Auth
 * @subpackage Adapter
 *
 * @version $Id: DbTable.php 87 2010-08-29 10:15:50Z vadim.leontiev $
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
                      ->from('roles', array('role'))
                      ->where('id = ?', $object->role_id);
            $role = $adapter->fetchOne($select);
        }
        $object->role = $role;
        return $object;
    }
}