<?php

namespace App\Config;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{

    private static $instance;
    private Capsule $capsule;

    public function __construct()
    {
        $this->capsule = new Capsule;
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null)
            self::$instance = new Database;

        return self::$instance;
    }


    public function connection(): void
    {
        try {
            $this->capsule->addConnection([
                'driver'    => getenv('DBDRIVER'),
                'host'      => getenv('HOST'),
                'database'  => getenv('DATABASE'),
                'username'  => getenv('USERNAME'),
                'password'  => getenv('PASSWORD'),
                'charset'   => 'utf8',
                'collation' => '',
                'prefix'    => '',
                'schema'    => 'public',
                'sslmode'   => 'prefer',
            ]);

            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();

            $this->addConnection();

        } catch (Exception $e) {
            new Exception($e->getMessage());
        }
    }

    private function addConnection()
    {
        $this->capsule->addConnection([
            'driver'    => getenv('DBDRIVER'),
            'host'      => 'localhost',
            'database'  => 'test',
            'username'  => 'postgres',
            'password'  => 'password',
            'charset'   => 'utf8',
            'port'      => 5431,
            'collation' => '',
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'prefer',
        ], 'second_db');

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }
}
