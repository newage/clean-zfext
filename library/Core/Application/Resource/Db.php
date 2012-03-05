<?php
/**
 * Set Db metadata cache
 *
 * @category   Core
 * @package    Core_Application
 * @subpackage Resource
 *
 * @version  $Id: Db.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */
class Core_Application_Resource_Db extends Zend_Application_Resource_Db
{

    /**
     * Get metadata cache from cachemanager
     * @return Zend_Cache_Abstract
     */
    public function getMetadataCache()
    {
        if (Zend_Registry::isRegistered('Zend_Cache_Manager') &&
            Zend_Registry::get('Zend_Cache_Manager')->hasCache('metadata')) {
            $cache = Zend_Registry::get('Zend_Cache_Manager')->getCache('metadata');
            return $cache;
        } else {
            return false;
        }
    }

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Db_Adapter_Abstract|null
     */
    public function init()
    {
        if (null !== ($db = $this->getDbAdapter())) {
            if ($this->isDefaultTableAdapter()) {
                Zend_Db_Table::setDefaultAdapter($db);
                $options = $this->getOptions();
                if ((bool)$options['DefaultMetadataCache'] === true &&
                    ($cache = $this->getMetadataCache()) !== false) {
                    Zend_Db_Table::setDefaultMetadataCache($cache);
                }
            }
            return $db;
        }
    }
}
