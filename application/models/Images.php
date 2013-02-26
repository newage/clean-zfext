<?php

/**
 * Model for job with upload images
 *
 * @category Application
 * @package Application_Model
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_Images extends Core_Model_Abstract
{
    /**
     * Small image widht in px
     * @type int
     */
    const SIZE_SMALL_WIDTH = 30;

    /**
     * Small image height in px
     * @type int
     */
    const SIZE_SMALL_HEIGHT = 30;

    /**
     * Medium image width in px
     * @type int
     */
    const SIZE_MEDIUM_WIDTH = 120;

    /**
     * Medium image height in px
     * @type int
     */
    const SIZE_MEDIUM_HEIGHT = 120;

    public $id = null;
    public $path = null;
    public $createdAt = null;
    public $userId = null;
    public $sizeWidth = null;
    public $sizeHeight = null;

    /**
     * Set default data
     */
    public function setDefault()
    {
        $this->setCreatedAt($this->_getMysqlDateTime());
        $this->setUserId($this->_getCurrentUserId());
    }

    /**
     * Set id
     *
     * @param int $value
     * @return Application_Model_Images
     */
    public function setId($value)
    {
        $this->id = (int)$value;
        return $this;
    }

    /**
     * Get id
     * 
     * @return int
     */
    public function getId()
    {
        return (int)$this->id;
    }

    /**
     * Get path to file
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path to file
     *
     * @param string $value
     * @return Application_Model_Images
     */
    public function setPath($value)
    {
        $this->path = (string)$value;
        return $this;
    }

    /**
     * Get created date
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *  Set created date
     *
     * @param string $value
     * @return Application_Model_Images
     */
    public function setCreatedAt($value)
    {
        $this->createdAt = $value;
        return $this;
    }

    /**
     * Set creator id
     *
     * @return int
     */
    public function getUserId()
    {
        return (int)$this->userId;
    }

    /**
     * Set creator id
     *
     * @param int $value
     * @return Application_Model_Images
     */
    public function setUserId($value)
    {
        $this->userId = (int)$value;
        return $this;
    }

    /**
     * Get image width size
     *
     * @return int
     */
    public function getSizeWidth()
    {
        return (int)$this->sizeWidth;
    }

    /**
     * Set image width size
     *
     * @param int $value
     * @return Application_Model_Images
     */
    public function setSizeWidth($value)
    {
        $this->sizeWidth = (int)$value;
        return $this;
    }

    /**
     * Get image height size
     *
     * @return int
     */
    public function getSizeHeight()
    {
        return (int)$this->sizeHeight;
    }

    /**
     * Set image height size
     *
     * @param int $value
     * @return Application_Model_Images
     */
    public function setSizeHeight($value)
    {
        $this->sizeHeight = (int)$value;
        return $this;
    }


}
