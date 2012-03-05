<?php
/**
 * Cache Manager resource
 *
 * @category   Core
 * @package    Core_Application
 * @subpackage Resource
 *
 * @version  $Id: Cachemanager.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */
class Core_Application_Resource_Cachemanager extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Initialize Cache_Manager
     *
     * @return Zend_Cache_Manager
     */
    public function init()
    {
        return $this->getCacheManager();
    }

    /**
     * Retrieve Zend_Cache_Manager instance
     *
     * @return Zend_Cache_Manager
     */
    public function getCacheManager()
    {
        if (Zend_Registry::isRegistered('Zend_Cache_Manager')) {
            $manager = Zend_Registry::get('Zend_Cache_Manager');
        }
        
        if (!isset($manager)) {
            $manager = new Zend_Cache_Manager;
        }
        
        $options = $this->getOptions();
        foreach ($options as $key => $value) {
            if (isset($value['disable'])) {
                continue;
            }

            if ($manager->hasCacheTemplate($key)) {
                $manager->setTemplateOptions($key, $value);
            } else {
                $manager->setCacheTemplate($key, $value);
            }
        }
        
        Zend_Registry::set('Zend_Cache_Manager', $manager);

        return $manager;
    }
}
