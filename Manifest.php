<?php

set_include_path(get_include_path() . PATH_SEPARATOR .
    dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library'
);

require_once 'Core/Tool/Project/Provider/Abstract.php';
require_once 'Core/Tool/Project/Provider/Migration.php';
require_once 'Core/Tool/Project/Provider/Schema.php';
require_once 'Core/Tool/Project/Provider/Fixture.php';

class Manifest
    implements Zend_Tool_Framework_Manifest_Interface,
        Zend_Tool_Framework_Manifest_ProviderManifestable
{

    public function getProviders()
    {

        return array(
            new Core_Tool_Project_Provider_Schema(),
            new Core_Tool_Project_Provider_Migration(),
            new Core_Tool_Project_Provider_Fixture()
        );
    }
}

