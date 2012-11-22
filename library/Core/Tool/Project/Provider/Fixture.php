<?php

/**
 * Migration manager tool
 * 
 * @category Core
 * @package Core_Tool
 * @author V.Leontiev
 * @license New BSD License
 *
 * @version  $Id$
 */
class Core_Tool_Project_Provider_Fixture
    extends Core_Tool_Project_Provider_Abstract
        implements Zend_Tool_Framework_Provider_Pretendable
{
    
    protected $_title = '[Records]';
        
    /**
     * Load data from yml fixture or sql fixture
     * 
     * @author V.Leontiev
     * @param type $fixtureName
     */
    public function load($fixtureName = 'all')
    {
        if ($fixtureName == 'all') {
            $fixtureName = null;
        }
        
        $manager = new Core_Migration_Fixture();
        $manager->load($fixtureName);
        
        foreach($manager->getMessages() as $message) {
            $this->_print($message['message'], array('color' => $message['color']));
        }
    }
    
    /**
     * Save database data to yml file
     * 
     * @author V.Leontiev 
     * @param string $tableName
     * @param string $fixtureName 
     */
    public function save($tableName)
    {
        $manager = new Core_Migration_Fixture();
        $manager->save($tableName);
        
        foreach($manager->getMessages() as $message) {
            $this->_print($message['message'], array('color' => $message['color']));
        }
    }
}
