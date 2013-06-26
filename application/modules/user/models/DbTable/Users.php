<?php

/**
 * DbTable for users table
 *
 * @category Application
 * @package    Application_Modules_User
 * @subpackage Model_DbTable
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Model_DbTable_Users extends Core_Db_Table_Abstract
{

    protected $_rowClass = 'User_Model_Users';

    protected $_name = 'users';
    protected $_dependentTables = array(
        'Application_Model_DbTable_Images'
    );

}

