<?php

/**
 * DbTable for users table
 *
 * @category Application
 * @package    Application_Model
 * @subpackage DbTable
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_DbTable_User extends Core_Db_Table_Abstract
{
    protected $_name = 'users';

    protected $_rowClass = 'Application_Model_User';

    protected $_referenceMap    = array(
        'Profile' => array(
            'columns'       => 'user_detail_id',
            'refTableClass' => 'Application_Model_DbTable_Profile',
            'refColumns'    => 'id'
        )
    );

}

