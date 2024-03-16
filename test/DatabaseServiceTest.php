<?php

namespace Test;

use App\infrastructure\database\Database;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class DatabaseServiceTest extends TestCase
{
    public function __construct()
    {

        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
        $dotenv->safeLoad();

        Database::getInstance()->connection();
    }
}
