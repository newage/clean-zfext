<?php
/**
 * Sent message to frontend
 *
 * @category   Core
 * @package    Core_Controller
 * @subpackage Action_Helper_Messenger
 */
class Core_Controller_Action_Helper_Messenger extends Zend_Controller_Action_Helper_Abstract implements Countable
{
    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'error';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';

    /**
     * Messages collector
     *
     * @var array
     */
    protected $_messages = array();

    /**
     * Session resource
     *
     * @var Zend_Session
     */
    static protected $_session = null;

    /**
     * Name for session namespace
     *
     * @var string
     */
    protected $_namespace = 'messenger';

    /**
     * Constructor
     */
    public function  __construct()
    {
        if (!self::$_session instanceof Zend_Session_Namespace) {
            self::$_session = new Zend_Session_Namespace($this->_namespace);
            $this->_messages = self::$_session->messages;
            unset(self::$_session->messages);
        }
    }

    /**
     * Add message to collector
     *
     * @param string $message Message text
     * @param string $type Nitification type
     * @param bool $flash Add message to session
     * @return /Core_Controller_Action_Helper_Messenger
     */
    public function addMessage($message, $type = self::TYPE_INFO, $flash = false)
    {
        $translator = Zend_Registry::get('Zend_Translate');
        $reflection = new Zend_Reflection_Class($this);
        $consts = $reflection->getConstants();

        if (empty($message) || !in_array($type, $consts)) {
            return false;
        }

        if ($flash === true) {
            self::$_session->messages[$type] = $translator->_($message);
        } else {
            $this->_messages[$type] = $translator->_($message);
        }

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
