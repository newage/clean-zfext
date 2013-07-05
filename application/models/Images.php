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
    const SIZE_MEDIUM_WIDTH = 80;

    /**
     * Medium image height in px
     * @type int
     */
    const SIZE_MEDIUM_HEIGHT = 80;

    /**
     * Default image
     * @type string
     */
    const DEFAULT_IMAGE = 'img/default_user.png';

    /**
     * Set default data
     */
    public function setDefault()
    {
        $this->setCreatedAt();
    }

    /**
     * Set id
     *
     * @param int $value
     * @return Application_Model_Images
     */
    public function setId($value)
    {
        $this->set('id', (int)$value);
        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return (int)$this->get('id');
    }

    /**
     * Get path to file
     *
     * @return string
     */
    public function getPath()
    {
        return $this->get('path');
    }

    /**
     * Get real path
     *
     * @return string
     */
    public function getRealPath()
    {
        $path = $this->get('path');
        if (empty($path)) {
            $path = self::DEFAULT_IMAGE;
        } else {
            $imageAlias = Zend_Controller_Front::getInstance()->getParam('upload');
            $path = DIRECTORY_SEPARATOR . $imageAlias['alias'] . DIRECTORY_SEPARATOR . $path;
        }
        return $path;
    }

    /**
     * Set path to file
     *
     * @param string $value
     * @return \Application_Model_Images
     */
    public function setPath($value)
    {
        $this->set('path', (string)$value);
        return $this;
    }

    /**
     * Get created date
     *
     * @return string | Zend_Date
     */
    public function getCreatedAt()
    {
        $date = $this->get('created_at');
        if (is_string($date)) {
            return new Zend_Date($date, Zend_Date::ISO_8601);
        }
        return $date;
    }

    /**
     *  Set created date
     *
     * @param string | Zend_Db_Expr $param
     * @return \Application_Model_Images
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
     * Get image width size
     *
     * @return int
     */
    public function getSizeWidth()
    {
        return (int)$this->get('size_width');
    }

    /**
     * Set image width size
     *
     * @param int $value
     * @return Application_Model_Images
     */
    public function setSizeWidth($value)
    {
        $this->set('size_width', (int)$value);
        return $this;
    }

    /**
     * Get image height size
     *
     * @return int
     */
    public function getSizeHeight()
    {
        return (int)$this->get('size_height');
    }

    /**
     * Set image height size
     *
     * @param int $value
     * @return Application_Model_Images
     */
    public function setSizeHeight($value)
    {
        $this->set('size_height', (int)$value);
        return $this;
    }


}
