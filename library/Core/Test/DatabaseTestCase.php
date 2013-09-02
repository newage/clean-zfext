<?php

/**
 * DbTestCase
 * Loader fixtures for model
 *
 * @category   Library
 * @package    Core_Text
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
abstract class Core_Test_DatabaseTestCase extends Zend_Test_PHPUnit_DatabaseTestCase
{
    protected $_db;
    protected $_fixturesDir;
    protected $_fixtureFile = 'init';

    public function setUp()
    {
        $this->_fixturesDir = TEST_PATH . '/application/fixtures/';
        parent::setUp();
    }

    /**
     * Delete all
     *
     * @author V.Leontiev
     * @return PHPUnit_Extensions_Database_Operation_IDatabaseOperation
     */
    protected function getTearDownOperation()
    {
        return PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL();
    }

    /**
     * Get db connection
     *
     * @author V.Leontiev
     * @return Zend_Test_PHPUnit_Db_Connection
     */
    protected function getConnection()
    {
        if (empty($this->_db)) {
            $configPath = APPLICATION_PATH . '/configs';

            $config = new Zend_Config_Ini(CONFIG_PATH, 'testing', true);
            if (file_exists($configPath . '/application.development.ini')) {
                $configOther = new Zend_Config_Ini($configPath . '/application.development.ini', 'testing');
                $config->merge($configOther);
            }

            $application = new Zend_Application(APPLICATION_ENV, $config);
            $application->bootstrap();

            $dbname = $config->resources->db->params->dbname;

            $db = $application->getBootstrap()->getPluginResource('db')->getDbAdapter();
            $this->_db = $this->createZendDbConnection($db, $dbname);
        }
        return $this->_db;
    }

    /**
     * Get dataSet
     *
     * @author V.Leontiev
     * @param string $fileName Only file name, without extension
     * @return type
     */
    protected function getDataSet()
    {
        $fileName = $this->_fixturesDir . $this->_fixtureFile . '.xml';
        return $this->createFlatXmlDataSet($fileName);
    }
}
