<?php 

namespace Test\Persistence;

use App\infrastructure\database\Database;
use PHPUnit_Extensions_Database_TestCase;

abstract class DatabaseTestCase extends PHPUnit_Extensions_Database_TestCase
{
    static private $adapter = null;

    final public function getAdapter()
    {
        if (self::$adapter == null) {
            self::$adapter = Database::getInstance();
        }

        return self::$adapter;
    }

    final public function getConnection () 
    {
        return self::$adapter->connection();
    }

    final public function getDataSet()
    {

    }

}