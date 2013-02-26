<?php

/**
 * Helper for create upload file name and directory structure
 *
 * @category Application
 * @package Application_Helper
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://bitbucket.org/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Helper_Upload implements Application_Helper_Interface
{

    /**
     * Generate new directory structure and file name
     *
     * @return string
     */
    public function init()
    {
        $newFolderName = $this->_createNewFolderName();
        $newFileName = $this->_createNewFileName();
        $newFile = $newFolderName . DIRECTORY_SEPARATOR . $newFileName;

        return $newFile;
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
     * Get first file from upload array
     *
     * @return string
     */
    protected function _getFirsUploadedFileName()
    {
        $upload = $this->getTransfer();
        $files = $upload->getFileInfo();

        $keys = array_keys($files);
        if (empty($keys) || !isset($keys[0])) {
            throw new Zend_File_Transfer_Exception('No file uploaded');
        }
        $imageName = $keys[0];

        return $imageName;
    }

    /**
     * Get first upload file info
     *
     * @return array
     */
    protected function _getFirstUploadFileInfo()
    {
        $upload = $this->getTransfer();
        $files = $upload->getFileInfo();

        $fileName = $this->_getFirsUploadedFileName();

        return $files[$fileName];
    }

    /**
     * Create bew file name used current time and tmp file name
     *
     * @param string $oldFileName
     * @return string
     */
    protected function _createNewFileName()
    {
        $upload = $this->getTransfer();

        $uploadFileInfo = $this->_getFirstUploadFileInfo();
        $fileInfo = pathinfo($uploadFileInfo['name']);
        $newFileName = substr(md5(time() . $uploadFileInfo['name']), 1, 3) . '.' . $fileInfo['extension'];

        $upload->addFilter(
            'Rename',
            array('target' => $newFileName)
        );

        return $newFileName;
    }

    /**
     * Create new folder name for uploaded image
     * Get firs 4 chars of decode image name to crc32
     *
     * @param string $oldFileName
     * @return string
     */
    protected function _createNewFolderName()
    {
        $upload = $this->getTransfer();

        $paramUpload = Zend_Controller_Front::getInstance()->getParam('upload');
        $uploadPath = $paramUpload['path'];
        if ($uploadPath === null) {
            throw new Zend_Config_Exception('Don\'t set param "upload_path"');
        }

        $newFoldersName = substr(md5(time() . rand(1, 100)), 1, 3);
        $newFoldersPath = implode(DIRECTORY_SEPARATOR, str_split($newFoldersName));
        $newDestination = $uploadPath . DIRECTORY_SEPARATOR . $newFoldersPath;

        if (!is_dir($newDestination)) {
            mkdir($newDestination, 0777, true);
        }

        $upload->setDestination(
            $newDestination
        );

        return $newFoldersPath;
    }

    /**
     * Get alias upload folder
     *
     * @return string
     */
    static public function getAlias()
    {
        $paramUpload = Zend_Controller_Front::getInstance()->getParam('upload');
        return $paramUpload['alias'];
    }

}
