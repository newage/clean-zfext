<?php

/**
 * Model for user table
 *
 * @category Application
 * @package    Application_Modules_User
 * @subpackage Model
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_User extends Core_Model_Abstract
{
    const STATUS_ENABLE  = 'ENABLE';
    const STATUS_DISABLE = 'DISABLE';

    protected $_imagesModels = 'Storage_Model_Image';
    
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
     * Get user details id
     *
     * @return int
     */
    public function getUserDetailsId()
    {
        return (int)$this->get('user_details_id');
    }

    /**
     * Set user details id
     *
     * @param int $id
     * @return \Application_Model_User
     */
    public function setUserDetailsId($value)
    {
        $this->set('user_details_id', (int)$value);
        return $this;
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
    
    /**
     * Get user details model
     *
     * @return Application_Model_Profile
     */
    public function getProfileModel()
    {
        return $this->getDependModel('Application_Model_Profile');
    }

    /**
     * Set profile model
     *
     * @param Application_Model_Profile $value
     * @return Application_Model_Profile
     */
    public function setProfileModel(Application_Model_Profile $value)
    {
        $this->addDependModel($value);
        return $value;
    }
    
    /**
     * Get one image model
     *
     * @return Application_Model_Image
     */
    public function getImageModel($width, $height)
    {
        $images = $this->getDependModel($this->_imagesModels);
        $last = array(
            'image' => null,
            'rate' => 0
        );

        $getRate = function($one, $two) {
            $result = ($one > $two) ? $one - $two : $two - $one;
            return $result;
        };

        foreach ($images as $image) {
            $rate = $getRate($image->getSizeWidth() + $image->getSizeHeight(), $width + $height);
            if ($rate < $last['rate'] || $last['image'] === null) {
                $last['rate'] = $rate;
                $last['image'] = $image;
            }
        }

        return $last['image'];
    }

    /**
     * Get all images models for user
     *
     * @return Core_Storage
     */
    public function getImagesModel()
    {
        return $this->getDependModel($this->_imagesModels);
    }

    /**
     * Set images models for user
     *
     * @param Core_Storage $value
     * @return Core_Storage
     */
    public function setImagesModel($value)
    {
        $this->addDependModel($value, $this->_imagesModels);
        return $value;
    }
}

