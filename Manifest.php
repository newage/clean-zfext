<?php

defined('VENDOR_PATH')
    || define('VENDOR_PATH', realpath(dirname(__FILE__) . '/vendor/'));

$prefixes = require_once VENDOR_PATH . '/autoload.php';

$paths = array(get_include_path());
foreach ($prefixes->getPrefixes() as $path) {
    $paths[] = $path[0];
}

set_include_path(implode(PATH_SEPARATOR, $paths));

$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Core');

class Manifest
    implements Zend_Tool_Framework_Manifest_Interface,
        Zend_Tool_Framework_Manifest_ProviderManifestable
{

    public function getProviders()
    {
        return array(
            new ZFTool_Tool_Project_Provider_Scaffold(),
            new ZFTool_Tool_Project_Provider_Schema(),
            new ZFTool_Tool_Project_Provider_Migration(),
            new ZFTool_Tool_Project_Provider_Fixture(),
            new Core_Tool_Project_Provider_DbModel()
        );
    }
}

