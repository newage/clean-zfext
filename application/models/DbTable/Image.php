<?php

/**
 * DbTable for images table
 *
 * @category Application
 * @package Application_Model
 * @subpackage DbTable
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_DbTable_Image extends Core_Db_Table_Abstract
{
    protected $_name = 'images';

    protected $_rowClass = 'Application_Model_Image';

    protected $_referenceMap    = array(
        'Creator' => array(
            'columns'           => 'creator_id',
            'refTableClass'     => 'Application_Model_DbTable_User',
            'refColumns'        => 'id'
        )
    );

}
