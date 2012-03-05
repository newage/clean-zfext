<?php

set_include_path(get_include_path() . PATH_SEPARATOR .
    dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library'
);

require_once 'Core/Tool/Project/Provider/Abstract.php';
require_once 'Core/Tool/MigrationProvider.php';
require_once 'Core/Tool/SchemaProvider.php';
require_once 'Core/Tool/FixtureProvider.php';

class Manifest
    implements Zend_Tool_Framework_Manifest_Interface,
        Zend_Tool_Framework_Manifest_ProviderManifestable
{

    public function getProviders()
    {
        return array(
            new Core_Tool_SchemaProvider(),
            new Core_Tool_MigrationProvider(),
            new Core_Tool_FixtureProvider()
        );
    }
}

