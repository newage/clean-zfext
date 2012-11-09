<?php

// Define base path obtainable throughout the whole application
defined('BASE_PATH')
    || define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'application');
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
//defined('VENDOR_PATH')
//    || define('VENDOR_PATH', realpath(dirname(__FILE__) . '/../vendor/'));

//set_include_path(implode(PATH_SEPARATOR, array(
//    APPLICATION_PATH , VENDOR_PATH , get_include_path()
//)));

//require_once 'autoload.php';
//spl_autoload_unregister(array(
//    'Zend_Loader_Autoloader' , 'autoload'
//));

set_include_path(get_include_path() . PATH_SEPARATOR .
    BASE_PATH . DIRECTORY_SEPARATOR . 'library'
);

require_once 'Zend/Application.php';
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Cache.php';

if (APPLICATION_ENV == 'production') {
    $frontendOptions = array('automatic_serialization' => true);
    $backendOptions  = array('cache_dir' => BASE_PATH . '/data/cache');
    $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

    if (!($config = $cache->load('config'))) {
        $config = getConfig();
    }

    $cache->save($config, 'config');
} else {
    $config = getConfig();
}

// Create application
$application = new Zend_Application(APPLICATION_ENV, $config);
$application->bootstrap()->run();

/**
 * Read config options from config file
 * 
 * @return Zend_Config_Ini
 */
function getConfig()
{
    $configPath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs';

    $config = new Zend_Config_Ini($configPath . '/application.ini', 'production', true);
    if ((!defined('APPLICATION_ENV') || 'development' == APPLICATION_ENV)
         && file_exists($configPath . '/application.development.ini')) {
        $configOther = new Zend_Config_Ini($configPath . '/application.development.ini', APPLICATION_ENV);
        $config->merge($configOther);
    }

    return $config;
}