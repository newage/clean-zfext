<?php

/**
 * DbTable for user_details table
 *
 * @category Application
 * @package    Application_Model
 * @subpackage DbTable
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_DbTable_Profile extends Core_Db_Table_Abstract
{

    protected $_name = 'users_details';

    protected $_rowClass = 'Application_Model_Profile';

    protected $_dependentTables = array(
        'Application_Model_DbTable_User'
    );
    
    protected $_referenceMap    = array(
        'Image' => array(
            'columns'       => 'image_id',
            'refTableClass' => 'Application_Model_DbTable_Images',
            'refColumns'    => 'id'
        )
    );
}

