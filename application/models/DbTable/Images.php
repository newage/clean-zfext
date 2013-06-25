<?php

/**
 * DbTable for images table
 *
 * @category Application
 * @package Application_Model
 * @subpackage DbTable
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_DbTable_Images extends Core_Db_Table_Abstract
{
    protected $_rowClass = 'Application_Model_Images';

    protected $_name = 'images';

    protected $_referenceMap    = array(
        'User' => array(
            'columns'           => 'user_id',
            'refTableClass'     => 'User_Model_DbTable_Users',
            'refColumns'        => 'id'
        )
    );
}
