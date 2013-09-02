<?php

/**
 * Resize images and/or create copy file
 *
 * @category   Library
 * @package    Core_Filter
 * @subpackage File
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Filter_File_ResizeImage implements Zend_Filter_Interface
{

    /**
     * Options for resize image
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Info for current image
     *
     * @var array
     */
    protected $_imageInfo = array();

    /**
     * Constructor
     *
     * <code>
     *   array(
     *     width = 80
     *     height = 80
     *     overwrite = true
     *     crop = false
     *   )
     * <code>
     * @param array $options
     */
    public function __construct($options)
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        } elseif (!is_array($options)) {
            throw new Zend_Filter_Exception('Invalid options argument provided to filter');
        }

        $this->_options = array_merge($this->_initDefaultOptions(), $options);
    }

    /**
     * Set default options params
     *
     * @return array
     */
    protected function _initDefaultOptions()
    {
        return array(
            'width' => 80,
            'height' => 80,
            'crop' => false
        );
    }

    /**
     * Resize image
     *
     * @param string $value File name and destination
     * @return string
     */
    public function filter($value)
    {
        $this->_imageInfo = getimagesize($value);

        $imageOriginal = $this->_readImage($value);
        $resizeResource = $this->_resizeImage($imageOriginal);

        return $this->_saveImage($resizeResource, $value);
    }

    /**
     * Resize image and return new image
     *
     * @param resource $imageOriginal
     * @return resource
     */
    protected function _resizeImage($imageOriginal)
    {
        $imageNew = imagecreatetruecolor($this->_options['width'], $this->_options['height']);

        imagecopyresampled(
            $imageNew,
            $imageOriginal,
            0, 0, 0, 0,
            $this->_options['width'], $this->_options['height'],
            $this->_imageInfo[0], $this->_imageInfo[1]
        );

        return $imageNew;
    }

    /**
     * Save image to disk
     *
     * @param resource $imageNewResource
     * @param string $imageOldPath
     * @return bool
     * @throws Zend_File_Transfer_Exception
     */
    protected function _saveImage($imageNewResource, $imageOldPath)
    {
        $imageType = $this->_imageInfo[2];

        switch ($imageType) {
            case IMAGETYPE_PNG:
                $result = imagepng($imageNewResource, $imageOldPath);
                break;
            case IMAGETYPE_GIF:
                $result = imagegif($imageNewResource, $imageOldPath);
                break;
            case IMAGETYPE_JPEG:
                $result = imagejpeg($imageNewResource, $imageOldPath);
                break;
            default:
                throw new Zend_File_Transfer_Exception('Don\t support file type: '.$imageType);
        }

        return $result;
    }

    /**
     * Read image
     *
     * @param string $imagePath
     * @return resource
     */
    protected function _readImage($imagePath)
    {
        $imageType = $this->_imageInfo[2];

        switch ($imageType) {
            case IMAGETYPE_PNG:
                $imageResource = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_GIF:
                $imageResource = imagecreatefromgif($imagePath);
                break;
            case IMAGETYPE_JPEG:
                $imageResource = imagecreatefromjpeg($imagePath);
                break;
            default:
                throw new Zend_File_Transfer_Exception('Don\t support file type: ' . $imageType);
        }

        return $imageResource;
    }

}
