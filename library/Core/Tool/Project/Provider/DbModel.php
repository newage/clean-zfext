<?php

/**
 * Create Model, dbTable, ModeMapper
 *
 * @category   Library
 * @package    Core_Tool
 * @subpackage Project_Provider
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Tool_Project_Provider_DbModel
    extends ZFTool_Tool_Project_Provider_Abstract
        implements Zend_Tool_Framework_Provider_Pretendable
{

    protected $_title = '[DbModel]';

    /**
     * @var Core_Migration_Manager
     */
    protected $_manager = null;

    /**
     * Initialize Core_Migration_Manager
     * Load profile and load development config
     *
     * @author V.Leontiev
     */
    public function initialize()
    {
        parent::initialize();
        $resources = $this->_app->getOption('resources');
        $this->_manager = new Core_Model_Manager($resources);
    }

    /**
     * Create new model
     *
     * @author V.Leontiev
     */
    public function create($name, $actualTableName, $module = null)
    {
        $this->_manager->create($name, $actualTableName, $module);
        $this->_print('Created Model / ModelMapper / DbTable', array('color' => 'green'));
    }
}

