<?php

/**
 * Mepper for images in db
 *
 * @category Application
 * @package Application_Model
 * @subpackage Mapper
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.0 or higher
 */
class Application_Model_ImagesMapper extends Core_Model_Mapper_Abstract
{

    /**
     * Model object
     * @var Application_Model_Images
     */
    protected $_model = null;

    /**
     * Constructor
     * Initialize new model and upload file transfer
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Upload and resize images
     *
     * @throws Zend_File_Transfer_Exception
     * @param Zend_File_Transfer_Adapter_Http $upload
     * @return Application_Model_Image
     */
    public function upload()
    {
        $upload = $this->getTransfer();

        $uploadHelper = new Application_Helper_Upload();
        $newPath = $uploadHelper->init();
        $this->getModel()->setPath($newPath);

        if (!$upload->receive()) {
            throw new Zend_File_Transfer_Exception(implode(' ', $upload->getMessages()));
        }

        $imageId = $this->_saveImageToBase();
        $this->getModel()->setId($imageId);

        return $this->getModel();
    }

    /**
     * Resize image
     * If don't set param get first file name
     *
     * @param string $imageName
     * @return \Application_Model_ImagesMapper
     */
    public function resize()
    {
        $upload = $this->getTransfer();

        $options = array(
            'width' => $this->getModel()->getSizeWidth(),
            'height' => $this->getModel()->getSizeHeight(),
            'overwrite' => true,
            'crop' => false
        );

        $image = new Core_Filter_File_ResizeImage($options);
        $upload->addFilter($image);
        return $this;
    }

    /**
     * Copy image file to new
     *
     * @param string $imageName
     */
    public function copy()
    {
        $upload = $this->getTransfer();

        $options = array(
            'suffix' => '_' . $this->getModel()->getSizeWidth() . 'x' . $this->getModel()->getSizeHeight()
        );
        $filter = new Core_Filter_File_Copy($options);
        $upload->addFilter($filter);

        return $this;
    }

    /**
     * Write image path to base
     *
     * @param type $localImagePath
     * @return int
     */
    protected function _saveImageToBase()
    {
        $array = $this->getModel()->toArray();
        return $this->getDbTable()->insert($array);
    }

    /**
     * Get model
     *
     * @throws Zend_File_Transfer_Exception
     * @return Application_Model_Images
     */
    public function getModel()
    {
        if ($this->_model === null) {
            throw new Zend_File_Transfer_Exception('Don\'t set model: Application_Model_Images');
        }
        return $this->_model;
    }

    /**
     * Set new model
     *
     * @param Application_Model_Images $model
     * @return \Application_Model_ImagesMapper
     */
    public function setModel(Application_Model_Images $model = null)
    {
        if ($model !== null) {
            $this->_model = $model;
        } else {
            $this->_model = new Application_Model_Images();
        }
        return $this;
    }

    /**
     * Get setted file transfer
     *
     * @return Zend_File_Transfer
     */
    public function getTransfer()
    {
        return Core_File_Transfer::getInstance();
    }

    /**
     * Read params for image
     *
     * @param int $imageId
     * @return Application_Model_Images
     */
    public function read($imageId)
    {
        return new Application_Model_Images();
    }
}
