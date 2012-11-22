<?php

defined('VENDOR_PATH')
    || define('VENDOR_PATH', realpath(dirname(__FILE__) . '/vendor/'));

require_once VENDOR_PATH . '/autoload.php';
Zend_Loader_Autoloader::getInstance();

class Manifest
    implements Zend_Tool_Framework_Manifest_Interface,
        Zend_Tool_Framework_Manifest_ProviderManifestable
{

    public function getProviders()
    {
        return array(
            new ZFTool_Tool_Project_Provider_Scaffold(),
            new ZFTool_Tool_Project_Provider_Schema(),
            new ZFTool_Tool_Project_Provider_DbModel(),
            new ZFTool_Tool_Project_Provider_Migration(),
            new ZFTool_Tool_Project_Provider_Fixture()
        );
    }
}

