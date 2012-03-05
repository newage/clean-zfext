<?php
/**
 * Logger Application Resources
 *
 * @category   Core
 * @package    Core_Application
 * @subpackage Resource
 *
 * @version  $Id: Log.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */
class Core_Application_Resource_Log extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_Log
     */
    protected $_log = null;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Log
     */
    public function init()
    {
        return $this->getLog();
    }

    /**
     * Attach logger
     * 
     * @param  Zend_Log $log 
     * @return Zend_Application_Resource_Log
     */
    public function setLog(Zend_Log $log)
    {
        $this->_log = $log;
        return $this;
    }

    /**
     * Registration log to Zend_Registry
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        if (null === $this->_log) {
            $options = $this->getOptions();
            $log = Zend_Log::factory($options);
            $this->setLog($log);
        }

        Zend_Registry::set('Zend_Log', $this->_log);

        return $this->_log;
    }
}
