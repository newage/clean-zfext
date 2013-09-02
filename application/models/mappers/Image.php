<?php

/**
 * Mepper for images in db
 *
 * @category Application
 * @package Application_Model
 * @subpackage Mapper
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.0 or higher
 */
class Application_Model_Mapper_Image extends Core_Model_Mapper_Abstract
{

    protected $_prefixCache = 'image';

    /**
     * Resize/upload image and save image path to database
     *
     * @param int $width
     * @param int $height
     * @param bool $overwrite
     * @param bool $crop
     * @return Application_Model_Image
     * @throws Zend_File_Transfer_Exception
     */
    public function upload($width, $height, $overwrite = true, $crop = false)
    {
        $upload = $this->getTransfer();

        $options = array(
            'width' => $width,
            'height' => $height,
            'overwrite' => $overwrite,
            'crop' => $crop
        );

        $image = new Core_Filter_File_ResizeImage($options);
        $upload->addFilter($image);

        $uploadHelper = new Application_Helper_Upload();
        $newPath = $uploadHelper->init();

        if (!$upload->receive()) {
            throw new Zend_File_Transfer_Exception(implode(' ', $upload->getMessages()));
        }

        $model = new Application_Model_Image();
        $model->setPath($newPath);
        $model->setSizeWidth($width);
        $model->setSizeHeight($height);

        $imageId = parent::save($model);
        $model->setId($imageId);

        return $model;
    }

    /**
     * Copy image and create thumbnail and save to database
     *
     * @param string $path Base path to image
     * @param int $width
     * @param int $height
     * @param bool $overwrite
     * @param bool $crop
     * @return Application_Model_Mapper_Image
     */
    public function thumbnail($path, $width, $height, $overwrite = true, $crop = false)
    {
        $options = array(
            'suffix' => '_' . $width . 'x' . $height
        );
        $filter = new Core_Filter_File_Copy($options);
        $newPath = $filter->filter($path);

        $options = array(
            'width' => $width,
            'height' => $height,
            'overwrite' => $overwrite,
            'crop' => $crop
        );

        $filter = new Core_Filter_File_ResizeImage($options);
        $filter->filter($newPath);

        $model = new Application_Model_Image();
        $model->setPath(implode('/', array_slice(explode('/', $newPath), -4)));
        $model->setSizeWidth($width);
        $model->setSizeHeight($height);

        $imageId = parent::save($model);
        $model->setId($imageId);

        return $model;
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
}
