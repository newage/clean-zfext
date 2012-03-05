<?php
/**
 *
 * @category   Core
 * @package    Core_Controller
 * @subpackage Action_Helper_Messenger
 * @version    $Id: Messenger.php 87 2010-08-29 10:15:50Z vadim.leontiev $
 */
class Core_Controller_Action_Helper_Messenger extends Zend_Controller_Action_Helper_Abstract implements Countable
{
    /**
     * Messages collector
     * 
     * @var array
     */
    protected $_messages = array();

    /**
     * Constructor
     */
    public function  __construct($message = null)
    {
        if (null !== $message) {
            $this->setMessage($message);
        }
    }

    /**
     * Add message to collector
     *
     * @param string $message
     * @return bool
     */
    public function setMessage($message)
    {
        if (empty($message)) {
            return false;
        }
        $this->_messages[] = $message;
        return $this;
    }

    /**
     * Get messages from collector
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Count elements from collector
     *
     * @return integer
     */
    public function count()
    {
        return count($this->_messages);
    }
}
