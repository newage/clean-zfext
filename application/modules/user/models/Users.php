<?php

/**
 * Model for user table
 *
 * @category Application
 * @package    Application_Modules_User
 * @subpackage Model
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Model_Users extends Core_Model_Abstract
{
    const STATUS_ENABLE  = 'ENABLE';
    const STATUS_DISABLE = 'DISABLE';

    const TABLE_NAME = 'User_Model_DbTable_Users';
//
//    public $id = null;
//    public $status = null;
//    public $createdAt = null;
//    public $roleId = null;
//    public $email = null;
//    public $nick = null;
//    public $password = null;
//    public $salt = null;
//    public $passwordResetHash = null;

    /**
     * Set default variable
     */
    public function setDefault()
    {
        $this->setStatus(self::STATUS_ENABLE);
        $this->setCreatedAt();
        $this->setRoleId(2);
    }

    /**
     * Get user id
     *
     * @return int
     */
    public function getId()
    {
        return (int)$this->get('id');
    }

    /**
     * Set user id
     *
     * @param int $id
     * @return User_Model_Users
     */
    public function setId($value)
    {
        $this->set('id', (int)$value);
        return $this;
    }

    /**
     * Get user role id
     *
     * @return int
     */
    public function getRoleId()
    {
        return (int)$this->get('role_id');
    }

    /**
     * Get user details model
     *
     * @return \User_Model_Profile
     */
    public function getProfile()
    {
        return $this->_getDependentModel('User', 'Profile');
    }

    /**
     * Get created date time
     *
     * @return string | Zend_Date
     */
    public function getCreatedAt()
    {
        $time = $this->get('created_at');
        if (is_string($time)) {
            return new Zend_Date($time, Zend_Date::ISO_8601);
        }
        return $time;
    }

    /**
     * Create or set date and time
     *
     * @param string | Zend_Db_Expr $value
     * @return \User_Model_Users
     */
    public function setCreatedAt($value = null)
    {
        if ($value === null) {
            $value = new Zend_Db_Expr('NOW()');
        }
        $this->set('created_at', $value);
        return $this;
    }

    /**
     * Set user role id
     *
     * @param int $id
     * @return \User_Model_Users
     */
    public function setRoleId($value)
    {
        $this->set('role_id', (int)$value);
        return $this;
    }

    /**
     * Get user status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->get('status');
    }

    /**
     * Set user status
     *
     * @param string $id
     * @return User_Model_Users
     */
    public function setStatus($value)
    {
        $this->set('status', $value);
        return $this;
    }

    /**
     * Set email
     *
     * @param string $value
     * @return \User_Model_Users
     */
    public function setEmail($value)
    {
        $this->set('email', strtolower(trim($value)));
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->get('email');
    }

    /**
     * Set nickname
     *
     * @param string $value
     * @return \User_Model_Users
     */
    public function setNick($value)
    {
        $this->set('nick', $value);
        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNick()
    {
        return $this->get('nick');
    }

    /**
     * Get password hash
     *
     * @return string
     */
    public function getPasswordResetHash()
    {
        return $this->get('password_reset_hash');
    }

    /**
     * Set new hash for pasword restore
     *
     * @param string $value
     * @return \User_Model_Users
     */
    public function setPasswordResetHash($value)
    {
        $this->set('password_reset_hash', $value);
        return $this;
    }

    /**
     * Generate hash to password
     *
     * @param string $value
     * @return User_Model_Users
     * @todo remove strlen and create fixture used model
     */
    public function setPassword($value)
    {
        if (strlen($value) < 32) {
            $salt = $this->_generateSalt();
            $this->set('salt', $salt);
            $this->set('password', md5($salt . $value));
        } else {
            $this->set('password', $value);
        }

        return $this;
    }

    /**
     * Get salt after generate password
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->get('salt');
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->get('password');
    }

    /**
     * Create and set dynamic salt for password
     *
     * @return string
     */
    protected function _generateSalt()
    {
        $salt = null;
        for ($i = 0; $i < 50; $i++) {
            $salt .= chr(rand(33, 126));
        }
        return md5($salt);
    }
}

