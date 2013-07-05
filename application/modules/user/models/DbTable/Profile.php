<?php

/**
 * DbTable for user_details table
 *
 * @category Application
 * @package    Application_Modules_User
 * @subpackage Model_DbTable
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Model_DbTable_Profile extends Core_Db_Table_Abstract
{

    protected $_name = 'users_details';

    protected $_rowClass = 'User_Model_Profile';

    protected $_referenceMap    = array(
        'User' => array(
            'columns'       => 'user_id',
            'refTableClass' => 'User_Model_DbTable_Users',
            'refColumns'    => 'id'
        ),
        'Image' => array(
            'columns'       => 'image_id',
            'refTableClass' => 'Application_Model_DbTable_Images',
            'refColumns'    => 'id'
        )
    );
}

