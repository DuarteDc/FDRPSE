<?php

namespace App\infrastructure\database;

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
            new Exception($e->getMessage(), 500);
        }
    }

    private function addConnection()
    {
        $this->capsule->addConnection([
            'driver'    => getenv('DBDRIVER'),                        
            'host'      => getenv('USER_HOST'),
            'database'  => getenv('USER_DATABASE'),
            'username'  => getenv('USER_USERNAME'),
            'password'  => getenv('USER_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => '',        
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'prefer',
        ], 'user_db');

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }
}
