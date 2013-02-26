<?php

/**
 * Copy aploaded file
 *
 * @category Library
 * @package Core_Filter_File
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Core_Filter_File_Copy implements Zend_Filter_Interface
{

    /**
     * Options for resize image
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Constructor
     *
     * <code>
     *   array(
     *     prefix = ''
     *     suffix = '_copy'
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
            'prefix' => '',
            'suffix' => '_copy'
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
        $destinationPath = $this->_createNewFileName($value);

        if (!copy($value, $destinationPath)) {
            throw new Zend_File_Transfer_Exception('Not create copy to a file');
        }

        return $destinationPath;
    }

    /**
     * Create new file name with suffix and prefix
     *
     * @param string $oldFilePath
     * @return string
     */
    protected function _createNewFileName($oldFilePath)
    {
        $pathinfo = pathinfo($oldFilePath);

        $newFilePath = $pathinfo['dirname']
            . DIRECTORY_SEPARATOR
            . $this->_options['prefix']
            . $pathinfo['filename']
            . $this->_options['suffix']
            . '.' . $pathinfo['extension'];

        return $newFilePath;
    }
}
