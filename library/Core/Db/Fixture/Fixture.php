<?php

/**
 * Load and save for fixtures files
 *
 * @category   Library
 * @package    Core_Db
 * @subpackage Fixture
 * @author     V.Leontiev <vadim.leontiev@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT
 * @since      php 5.3 or higher
 * @see        https://github.com/newage/clean-zfext
 */
class Core_Migration_Fixture
{

    protected $_fixtures = array();

    protected $_tables = array();

    /**
     * Add all fixtures file
     *
     * @author V.Leontiev
     */
    protected function _setFixtures()
    {
        $filesDirty = scandir($this->getFixturesDirectoryPath());

        for ($i=0; $i<count($filesDirty); $i++) {
            if (substr($filesDirty[$i], 0, 1) != '.') {
                $this->addFixture(substr($filesDirty[$i], 0, -4));
            }
        }
    }

    /**
     * Set all tables name from current schema
     *
     * @author V.Leontiev
     */
    protected function _setTables()
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = 'SELECT `TABLE_NAME` FROM `TABLES` T WHERE `TABLE_SCHEMA` = \'' .
               $a . '\'';

        $result = $db->query($sql)->fetchAll();

        foreach ($result as $tableName) {
            $this->addTable($tableName);
        }
    }

    /**
     * Initialise file
     *
     * @param string $fixtureName
     * @author V.Leontiev
     */
    public function import($fixtureName = null)
    {
        if (null !== $fixtureName) {
            $this->addFixture($fixtureName);
        } else {
            $this->_setFixtures();
        }

        foreach ($this->_fixtures as $fixtureName) {
            $pathToFile = $this->getFixturesDirectoryPath() . '/' .
                          $fixtureName . '.yml';

            if (file_exists($pathToFile)) {
                $fixture = new Core_Migration_Reader_Yaml($pathToFile);

                foreach ($fixture as $table => $rowset) {
                    $this->_insertDataToTable($table, $rowset);
                }
                $this->addMessage('Add data from fixture: ' . $fixtureName, 'green');
            } else {
                $this->addMessage('Dont exists file: ' . $pathToFile, 'red');
            }
        }
    }

    /**
     * Export data from database to file
     *
     * @author V.Leontiev
     * @param string $schemaName
     * @param string $tableName
     * @param string $fixtureName
     */
    public function export($schemaName, $tableName, $fixtureName)
    {
        if (null === $fixtureName) {
            $fixtureName = '_' . uniqid();
        }

        if (null === $tableName) {
            $this->_setTables();
        } else {
            $this->addTable($tableName);
        }

        foreach ($this->_tables as $tableName) {

        }
    }

    /**
     * Add data to table
     *
     * @param string $tableName
     * @param string $data
     */
    protected function _insertDataToTable($tableName, $data)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        foreach ($data as $row) {
            $db->insert($tableName, $row->toArray());
        }
    }

    protected function _getDataFromTable()
    {

    }

    public function addTable($tableName)
    {
        $this->_tables[] = $tableName;
    }


    /**
     * Add fixture file to collection
     *
     * @author V.Leontiev
     * @param string $fixtureName
     * @return Core_Migration_Fixture
     */
    public function addFixture($fixtureName)
    {
        $this->_fixtures[] = $fixtureName;
        return $this;
    }

    /**
     * Method returns path to fixtures directory
     *
     * @return string
     */
    public function getFixturesDirectoryPath()
    {
        $path = APPLICATION_PATH . '/configs/fixtures';
        return $path;
    }

    /**
     * Add new message
     *
     * @param string $message
     * @param array $color
     */
    public function addMessage($message, $color = null)
    {
        $this->_messages[] = array(
            'message' => $message,
            'color' => $color
        );
    }

    /**
     * Method returns stack of messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->_messages;
    }
}

