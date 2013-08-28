<?php

/**
 * Model for users_details table
 *
 * @category Application
 * @package    Application
 * @subpackage Model
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_Profile extends Core_Model_Abstract
{

    /**
     * Set default variables
     */
    public function setDefault()
    {
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
     * @return User_Model_UsersDetails
     */
    public function setId($value)
    {
        $this->set('id', (int)$value);
        return $this;
    }

    /**
     * Get user id
     *
     * @return int
     */
    public function getUserId()
    {
        return (int)$this->get('user_id');
    }

    /**
     * Set user id
     *
     * @param int $id
     * @return User_Model_UsersDetails
     */
    public function setUserId($value)
    {
        $this->set('user_id', (int)$value);
        return $this;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * Set user fname
     *
     * @param string $id
     * @return \User_Model_UsersDetails
     */
    public function setName($value)
    {
        $this->set('name', $value);
        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->get('location');
    }

    /**
     * Set location
     *
     * @param string $value
     * @return \User_Model_UsersDetails
     */
    public function setLocation($value)
    {
        $this->set('location', $value);
        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->get('gender');
    }

    /**
     * Set gender
     *
     * @param string $value
     * @return \User_Model_UsersDetails
     */
    public function setGender($value)
    {
        $this->set('gender', strtoupper($value));
        return $this;
    }

    /**
     * Set birthday
     *
     * @param string $value
     * @return \User_Model_UsersDetails
     */
    public function setBirthday($value)
    {
        $this->set('birthday', $value);
        return $this;
    }

    /**
     * Get birthday
     *
     * @return string
     */
    public function getBirthday()
    {
        return $this->get('birthday');
    }

    /**
     * Get about text
     *
     * @return string
     */
    public function getAbout() {
        return $this->get('about');
    }

    /**
     * Set about text
     *
     * @param string $value
     * @return \User_Model_Profile
     */
    public function setAbout($value) {
        $this->set('about', $value);
        return $this;
    }

    /**
     * Get image id
     *
     * @return int
     */
    public function getImageId() {
        return (int)$this->get('image_id');
    }

    /**
     * Set image id
     *
     * @param int $value
     * @return \User_Model_Profile
     */
    public function setImageId($value) {
        $this->set('image_id', (int)$value);
        return $this;
    }

    /**
     * Get images object
     *
     * @return \Application_Model_Images
     */
    public function getAvatar()
    {
        return $this->_depend['image'];
    }

    /**
     * Set image object
     *
     * @param Application_Model_Images $value
     * @return \Application_Model_Images
     */
    public function setAvatar($value)
    {
        if (!$value instanceof Application_Model_Images) {
            $value = new Application_Model_Images();
        }
        $this->_depend['image'] = $value;
        return $value;
    }
}

