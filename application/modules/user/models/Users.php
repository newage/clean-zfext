<?php

/**
 * Model for user table
 * 
 * @package    Application_Model
 * @subpackage User
 * @author V.Leontiev 
 */
class User_Model_Users extends Core_Model_Abstract
{
    const STATUS_ENABLE  = 1;
    const STATUS_DISABLE = 2;

    /**
     * Set default variable
     */
    public function setDefault()
    {
        $this->status = self::STATUS_ENABLE;
        $this->created_at = $this->getSqlDateTime();
        $this->role_id = 2;
    }
    
    /**
     * Set role
     * @param int $value
     * @return \User_Model_Users 
     */
    public function setRole($value)
    {
        $this->role_id = $value;
        return $this;
    }
    
    /**
     * Set status
     * 
     * @param string $value
     * @return \User_Model_Users 
     */
    public function setStatus($value)
    {
        $this->status = $value;
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
        $this->email = $value;
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
            $this->salt = $salt;
            $this->password = md5($salt . $value);
        } else {
            $this->password = $value;
        }
        
        return $this;
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

