<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Define config path
defined('CONFIG_PATH')
    || define('CONFIG_PATH', APPLICATION_PATH . '/configs/application.ini');

// Define config path
defined('TEST_PATH')
    || define('TEST_PATH', realpath(dirname(__FILE__)));

defined('BASE_PATH')
    || define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();
Zend_Session::$_unitTestEnabled = true;
require_once 'Core/Test/DatabaseTestCase.php';
require_once 'Core/Test/ControllerTestCase.php';
require_once TEST_PATH . '/application/Authenticate.php';

//Get config
function getConfig()
{
    $configPath = APPLICATION_PATH . '/configs';

    $config = new Zend_Config_Ini(CONFIG_PATH, 'testing', true);
    if (file_exists($configPath . '/application.development.ini')) {
        $configOther = new Zend_Config_Ini($configPath . '/application.development.ini', 'testing');
        $config->merge($configOther);
    }
    return $config;
}

function createTestDB()
{
    $config = getConfig();
    $schemaName = $config->resources->db->params->dbname;
    
    $db = Zend_Db::factory($config->resources->db);
    $sql = 'DROP SCHEMA `' . $schemaName . '`';
    $db->query($sql);
    $sql = 'CREATE SCHEMA `' . $schemaName . '`';
    $db->query($sql);
    $sql = 'USE `' . $schemaName . '`';
    $db->query($sql);
    
    $pathToFile = APPLICATION_PATH . '/configs/sql/test_base.sql';

    if (file_exists($pathToFile)) {

        $sqlFileContent = explode(';', file_get_contents($pathToFile));
        $sqlArrayCount = count($sqlFileContent);

        for ($i = 0; $i < $sqlArrayCount; $i++) {
            $sql = trim($sqlFileContent[$i]);
            if (empty ($sql)) {
                continue;
            }
            $db->query($sql);
        }
    }
}

createTestDB();
