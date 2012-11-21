<?php

defined('VENDOR_PATH')
    || define('VENDOR_PATH', realpath(dirname(__FILE__) . '/vendor/'));

$prefixes = require_once VENDOR_PATH . '/autoload.php';

//$paths = array(APPLICATION_PATH);
$paths = array();
foreach ($prefixes->getPrefixes() as $key => $path) {
    $paths[$key] = $path[0];
}

set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $paths));

//require_once 'Core/Tool/Project/Provider/Abstract.php';
//require_once 'Core/Tool/Project/Provider/Migration.php';
//require_once 'Core/Tool/Project/Provider/Schema.php';
//require_once 'Core/Tool/Project/Provider/Fixture.php';
//require_once 'Core/Tool/Project/Provider/DbModel.php';
require_once 'ZFScaffold/Tool/Project/Provider/Scaffold.php';

foreach ($paths as $namespace => $path) {
    if ($namespace == 'Zend' || $namespace == 'ZendX') {
        continue;
    }
    $providersPath = $path . '/' . $namespace . '/Tool/Project/Provider';

    if (file_exists($providersPath) && is_dir($providersPath)) {
        $providers = dir($providersPath);
        while (false !== ($entry = $providers->read())) {
            if ($entry == '..' || $entry == '.') {
                continue;
            }

            echo $entry;
        }
    }
}

class Manifest
    implements Zend_Tool_Framework_Manifest_Interface,
        Zend_Tool_Framework_Manifest_ProviderManifestable
{

    public function getProviders()
    {
        return array(
//            new Core_Tool_Project_Provider_Schema(),
//            new Core_Tool_Project_Provider_Migration(),
//            new Core_Tool_Project_Provider_Fixture(),
//            new Core_Tool_Project_Provider_DbModel(),
            new ZFScaffold_Tool_Project_Provider_Scaffold()
        );
    }
}

