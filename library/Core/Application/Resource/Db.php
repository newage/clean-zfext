<?php

/**
 * Set Db metadata cache
 *
 * @category   Library
 * @package    Core_Application
 * @subpackage Resource
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
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
                if ((bool)$options['setMetadataCache'] === true &&
                    ($cache = $this->getMetadataCache()) !== false) {
                    Zend_Db_Table::setDefaultMetadataCache($cache);
                }
            }
            return $db;
        }
    }
}
